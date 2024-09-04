<template>
    <AuthenticatedLayout>
      <div class="my-bids-page pb-16" ref="MyBidsPage">
        <div class="container mx-auto px-3 py-5">
          <h1 class="text-2xl font-bold mb-5">My Bids</h1>
          <transition-group
            name="fade"
            tag="div"
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5"
          >
            <div
              v-for="bid in formattedBids"
              :key="bid.id"
              class="item-card relative flex flex-col border border-gray-300 rounded-lg overflow-hidden transition-transform duration-200 ease-in-out hover:transform hover:scale-105"
              @click="showModal(bid)"
            >
              <div class="p-4">
                <div class="text-lg font-bold">{{ bid.formattedPickupTime }}</div>
                <img
                  src="https://res.cloudinary.com/dmebtqdqc/image/upload/v1725431783/irlxmviv8snyfnx4bufd.png"
                  alt="Image"
                  class="w-full h-48 object-cover mt-2"
                />
              </div>
              <div
                class="absolute inset-x-0 bottom-0 bg-gray-800 bg-opacity-75 p-4 text-white flex flex-col space-y-2"
              >
                <div class="flex justify-between items-start">
                  <div class="flex flex-col">
                    <div class="text-lg font-bold">₱{{ bid.item.item_quote }}</div>
                    <div class="text-sm">{{ bid.item.item_name }}</div>
                  </div>
                  <div class="flex flex-col items-end">
                    <div class="flex items-center space-x-2">
                      <div class="flex flex-col items-end">
                        <span class="text-xs text-gray-300">My Bid</span>
                        <div class="text-xl font-bold">₱{{ bid.bid_amount }}</div>
                        <span class="text-xs text-gray-300">
                          Lowest Bid: ₱{{ getLowestBid(bid.item_id) }}
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
                <button
                  @click.stop="openBidModal(bid)"
                  class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 w-full rounded-full"
                >
                  BID
                </button>
                <button
                  @click.stop="openDeleteModal(bid.id)"
                  class="mt-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 w-full rounded-full"
                >
                  Remove
                </button>
              </div>
            </div>
          </transition-group>
        </div>

        <!-- Confirmation Modal for Deleting a Bid -->
        <transition name="fade">
          <div
            v-if="deleteModalVisible"
            class="fixed inset-0 flex items-center justify-center z-50 bg-gray-800 bg-opacity-75"
          >
            <div class="bg-white p-6 rounded-lg w-full max-w-sm">
              <div class="text-center text-xl font-semibold mb-4">
                Confirm Deletion
              </div>
              <p class="text-center mb-4">
                Are you sure you want to delete this bid?
              </p>
              <div class="flex justify-center space-x-4">
                <button
                  @click="confirmDeleteBid"
                  class="bg-red-500 text-white py-2 px-4 rounded-lg"
                >
                  Yes, Delete
                </button>
                <button
                  @click="cancelDeleteBid"
                  class="bg-gray-300 py-2 px-4 rounded-lg"
                >
                  Cancel
                </button>
              </div>
            </div>
          </div>
        </transition>

        <!-- Item Shipping/Item Information Modal -->
        <transition name="fade">
          <div
            v-if="modalVisible"
            class="fixed inset-0 flex items-center justify-center z-50 bg-gray-800 bg-opacity-75"
          >
            <div
              class="bg-white p-6 rounded-lg w-full max-w-sm max-h-screen overflow-auto"
            >
              <div class="bg-orange-400 rounded-t-lg p-3">
                <div class="text-center text-lg mb-4">Shipping Information</div>
              </div>
              <div class="space-y-4">
                <div class="flex justify-between border-b pb-2">
                  <label class="font-bold">Order from:</label>
                  <span>{{ selectedItem.client }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                  <label class="font-bold">Ship Out Date:</label>
                  <span>{{ selectedItem.formattedPickupTime }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                  <label class="font-bold">Vehicle: </label>
                  <span>{{ selectedItem.vehicle_type }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                  <label class="font-bold">Destination: </label>
                  <span>{{ selectedItem.destination }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                  <label class="font-bold">Current Bids:</label>
                  <span>{{ selectedItem.currentBids }}</span>
                </div>
                <div class="flex justify-between border-b pb-2">
                  <label class="font-bold">Quote/Pricing:</label>
                  <span>{{ selectedItem.quote }}</span>
                </div>
                <button
                  @click="showItemInfo = !showItemInfo"
                  class="w-full mt-4 bg-blue-500 text-white py-2 rounded-lg"
                >
                  Show Item Information
                </button>
                <transition name="fade">
                  <div
                    v-if="showItemInfo"
                    class="border border-gray-300 rounded-lg p-4 mt-4 bg-white space-y-2"
                  >
                    <div class="flex justify-between border-b pb-2">
                      <label class="font-bold">Description:</label>
                      <span>{{ selectedItem.itemName }}</span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                      <label class="font-bold">Length:</label>
                      <span>{{ selectedItem.length }} cm</span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                      <label class="font-bold">Width:</label>
                      <span>{{ selectedItem.width }} cm</span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                      <label class="font-bold">Height:</label>
                      <span>{{ selectedItem.height }} cm</span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                      <label class="font-bold">Weight:</label>
                      <span>{{ selectedItem.weight }} kg</span>
                    </div>
                  </div>
                </transition>
                <div class="mt-4 flex justify-center space-x-4">
                  <template v-if="!bidPlaced">
                    <button
                      class="bg-orange-400 text-white py-2 px-4 rounded-lg"
                      @click="cancel"
                    >
                      Back
                    </button>
                  </template>
                  <template v-else>
                    <div
                      class="text-center text-lg font-bold text-green-500"
                    >
                      Bid has been placed
                    </div>
                  </template>
                </div>
              </div>
            </div>
          </div>
        </transition>

        <!-- Update Bid Modal -->
        <transition name="fade">
          <div
            v-if="updateBidModalVisible"
            class="fixed inset-0 flex items-center justify-center z-50 bg-gray-800 bg-opacity-75"
          >
            <div class="bg-white p-6 rounded-lg w-full max-w-sm">
              <div class="text-xl font-semibold mb-2">Update Bid</div>
              <form class="space-y-4">
                <input
                  type="number"
                  v-model.number="updateBidAmount"
                  placeholder="Bid Amount"
                  class="w-full p-2 border border-gray-300 rounded-lg"
                  required
                />
              </form>
              <div class="flex justify-end space-x-2 mt-4">
                <button
                  class="bg-green-500 text-white py-2 px-4 rounded-lg shadow-md hover:bg-green-700"
                  @click="confirmUpdateBid"
                >
                  Update Bid
                </button>
                <button
                  class="bg-red-500 text-white py-2 px-4 rounded-lg shadow-md hover:bg-red-700"
                  @click="cancelUpdateBid"
                >
                  Cancel
                </button>
              </div>
            </div>
          </div>
        </transition>
      </div>
    </AuthenticatedLayout>
  </template>

  <script>
  import axios from "axios";
  import moment from "moment";
  import Swal from "sweetalert2";
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

  export default {
    components: {
      AuthenticatedLayout,
    },
    data() {
      return {
        bids: [],
        lowestBids: [],
        modalVisible: false,
        showItemInfo: false,
        updateBidModalVisible: false,
        updateBidAmount: null,
        selectedBidId: null,
        deleteModalVisible: false,
        selectedItem: {
          client: "",
          formattedPickupTime: "",
          vehicle_type: "",
          destination: "",
          currentBids: 0,
          quote: 0,
          description: "",
          itemName: "",
          length: 0,
          width: 0,
          height: 0,
          weight: 0,
        },
      };
    },
    computed: {
      formattedBids() {
        return this.bids.map((bid) => ({
          ...bid,
          formattedPickupTime: moment(bid.item.item_pickup_time).format(
            "MMMM Do YYYY, h:mm:ss a"
          ),
        }));
      },
    },
    mounted() {
      this.fetchBids();
    },
    methods: {
      fetchBids() {
        axios
          .get("/my-bids")
          .then((response) => {
            this.bids = response.data;
            this.fetchLowestBids();
          })
          .catch((error) => {
            console.error("Error fetching bids:", error);
          });
      },
      fetchLowestBids() {
        axios
          .get("/lowest-bids")
          .then((response) => {
            this.lowestBids = response.data;
          })
          .catch((error) => {
            console.error("Error fetching lowest bids:", error);
          });
      },
      getLowestBid(itemId) {
   // alert("Item ID:", itemId);
    //alert("Lowest Bids:", this.lowestBids);

    const bid = this.lowestBids.find(
        (lowestBid) => lowestBid.item_id === itemId
    );

    if (bid) {
        //alert("Found Bid:", bid.lowest_bid);
        return bid.lowest_bid;
    } else {
        //alert("No bid found for this item");
        return "N/A";
    }
},
      openDeleteModal(bidId) {
        this.selectedBidId = bidId;
        this.deleteModalVisible = true;
      },
      confirmDeleteBid() {
        axios
          .delete(`/bids/${this.selectedBidId}`)
          .then(() => {
            this.bids = this.bids.filter(
              (bid) => bid.id !== this.selectedBidId
            );
            this.deleteModalVisible = false;
            Swal.fire("Deleted!", "Your bid has been deleted.", "success");
          })
          .catch((error) => {
            console.error("Error deleting bid:", error);
            Swal.fire("Error!", "Failed to delete bid.", "error");
          });
      },
      cancelDeleteBid() {
        this.selectedBidId = null;
        this.deleteModalVisible = false;
      },
      showModal(bid) {
        this.selectedItem = {
          client: bid.item.item_client,
          formattedPickupTime: moment(bid.item.item_pickup_time).format(
            "MMMM Do YYYY, h:mm:ss a"
          ),
          vehicle_type: bid.item.vehicle_type,
          destination: bid.item.item_destination,
          currentBids: bid.item.item_current_bids,
          quote: bid.item.item_quote,
          description: bid.item.description,
          itemName: bid.item.item_name,
          length: bid.item.item_length,
          width: bid.item.item_width,
          height: bid.item.item_height,
          weight: bid.item.item_weight,
        };
        this.modalVisible = true;
      },
      openBidModal(bid) {
        this.updateBidAmount = bid.bid_amount;
        this.updateBidModalVisible = true;
        this.selectedBidId = bid.id;
      },
      confirmUpdateBid() {
        axios
          .put(`/bids/${this.selectedBidId}`, {
            bid_amount: this.updateBidAmount,
          })
          .then(() => {
            const bid = this.bids.find(
              (bid) => bid.id === this.selectedBidId
            );
            if (bid) {
              bid.bid_amount = this.updateBidAmount;
            }
            this.updateBidModalVisible = false;
            Swal.fire("Updated!", "Your bid has been updated.", "success");
          })
          .catch((error) => {
            console.error("Error updating bid:", error);
            Swal.fire("Error!", "Failed to update bid.", "error");
          });
      },
      cancelUpdateBid() {
        this.updateBidModalVisible = false;
      },
      cancel() {
        this.modalVisible = false;
      },
    },
  };
  </script>

  <style scoped>
  /* Add your styles here */
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.5s;
  }
  .fade-enter,
  .fade-leave-to {
    opacity: 0;
  }
  .my-bids-page {
    background-color: #EEF4ED;
    min-height: 100vh;
  }
  </style>
