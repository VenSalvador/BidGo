<template>
    <AuthenticatedLayout>
      <div class="my-items-page pb-16" ref="MyItemsPage">
        <div class="container mx-auto px-3 py-5">
          <h1 class="text-2xl font-bold mb-5">My Sale</h1>
          <div v-if="items.length">
            <div v-for="item in items" :key="item.id" class="bg-white shadow-md rounded-lg p-4 mb-4">
              <h2 class="text-xl font-semibold">{{ item.item_name }}</h2>
              <p>{{ item.description }}</p>
              <p class="text-gray-600">Price: ₱{{ item.item_quote }}</p>
              <p class="text-gray-600">Posted on: {{ new Date(item.created_at).toLocaleDateString() }}</p>
              <div class="flex space-x-2 mt-4">
                <button @click="showItemInfoModal(item)" class="bg-blue-500 text-white py-2 px-4 rounded-lg">Item & Shipping Info</button>
                <button @click="showBidsModal(item)" class="bg-green-500 text-white py-2 px-4 rounded-lg">Show Bids</button>
                <button @click="confirmRemoveItem(item)" class="bg-red-500 text-white py-2 px-4 rounded-lg">Remove Item</button>
              </div>
            </div>
          </div>
          <div v-else>
            <p>You have not posted any items yet.</p>
          </div>
        </div>

        <!-- Item and Shipping Information Modal -->
        <transition name="fade">
          <div v-if="itemInfoModalVisible" class="fixed inset-0 flex items-center justify-center z-50 bg-gray-800 bg-opacity-75">
            <div class="bg-white p-6 rounded-lg w-full max-w-sm max-h-screen overflow-auto">
              <div class="bg-orange-400 rounded-t-lg p-3">
                <div class="text-center text-lg mb-4">Shipping Information</div>
              </div>
              <div class="space-y-4">
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
                <button @click="showItemInfo = !showItemInfo" class="w-full mt-4 bg-blue-500 text-white py-2 rounded-lg">
                  Show Item Information
                </button>
                <transition name="fade">
                  <div v-if="showItemInfo" class="border border-gray-300 rounded-lg p-4 mt-4 bg-white space-y-2">
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
              </div>
              <button @click="cancelItemInfoModal" class="mt-6 w-full bg-red-500 text-white py-2 rounded-lg">Close</button>
            </div>
          </div>
        </transition>
<!-- Show Bids Modal -->
<transition name="fade">
    <div v-if="bidsModalVisible" class="fixed inset-0 flex items-center justify-center z-50 bg-gray-800 bg-opacity-75">
      <div class="bg-white p-6 rounded-lg w-full max-w-sm max-h-screen overflow-auto">
        <div class="bg-orange-400 rounded-t-lg p-3">
          <div class="text-center text-lg mb-4">Bids for {{ selectedItem.itemName }}</div>
        </div>
        <div class="space-y-4">
          <div v-if="sortedBids.length > 0">
            <div
              v-for="bid in sortedBids"
              :key="bid.id"
              :class="{
                'bg-green-100': bid === sortedBids[0],  // Lowest bid
                'bg-red-100': bid === sortedBids[sortedBids.length - 1] // Highest bid
              }"
              class="flex justify-between items-center border-b pb-2"
            >
              <span>₱{{ bid.bid_amount }}</span>
              <div class="flex items-center space-x-2">
                <span>{{ bid.user.name }}</span>
                <!-- Placeholder View button -->
                <button class="text-blue-500 underline">View</button>
              </div>
            </div>
          </div>
          <div v-else>
            <p class="text-center text-gray-600">No Bids Placed Yet.</p>
          </div>
        </div>
        <!-- Bottom part of the modal -->
        <div class="mt-6 w-full bg-red-500 text-white py-2 rounded-lg">
          <button @click="cancelBidsModal" class="w-full">Close</button>
        </div>
      </div>
    </div>
  </transition>
</div>
</AuthenticatedLayout>
</template>


<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import moment from 'moment';
import axios from 'axios';

export default {
  components: {
    AuthenticatedLayout
  },
  props: {
    items: Array
  },
  data() {
    return {
      itemInfoModalVisible: false,
      bidsModalVisible: false,
      showItemInfo: false,
      selectedItem: {},
      bids: []
    };
  },
  computed: {
    sortedBids() {
      return this.bids.slice().sort((a, b) => a.bid_amount - b.bid_amount);
    }
  },
  methods: {
    async showItemInfoModal(item) {
    // Fetch the number of bids for the selected item
    const response = await axios.get(`/items/${item.id}/bids`);
    const bidsCount = response.data.length;

    this.selectedItem = {
      formattedPickupTime: moment(item.item_pickup_time).format('MMMM Do YYYY'),
      vehicle_type: item.vehicle_type,
      destination: item.item_destination,
      currentBids: bidsCount, // Set the current bids count
      quote: item.item_quote,
      itemName: item.item_name,
      length: item.item_length,
      width: item.item_width,
      height: item.item_height,
      weight: item.item_weight
    };
    this.itemInfoModalVisible = true;
  },
    cancelItemInfoModal() {
      this.itemInfoModalVisible = false;
    },
    async showBidsModal(item) {
      this.selectedItem = {
        itemName: item.item_name,
      };

      // Fetch the bids for the selected item
      const response = await axios.get(`/items/${item.id}/bids`);
      this.bids = response.data;

      this.bidsModalVisible = true;
    },
    cancelBidsModal() {
      this.bidsModalVisible = false;
    },

    confirmRemoveItem(item) {
      // Show a confirmation modal
      if (confirm(`Are you sure you want to remove item ${item.item_name}?`)) {
        this.removeItem(item);
      }
    },
    async removeItem(item) {
  try {
    // Make a DELETE request to your API to delete the item
    await axios.delete(`/items/${item.id}`);

    // Remove the item from the local state
    this.items = this.items.filter(i => i.id !== item.id);
  } catch (error) {
    console.error('Error deleting item:', error);
  }
}

  }
};
</script>

<style scoped>
.my-items-page {
  background-color: #EEF4ED;
}
</style>
