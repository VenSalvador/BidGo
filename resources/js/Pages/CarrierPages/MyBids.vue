<template>
    <AuthenticatedLayout>
    <div class="MyBids-Page pb-16" ref="MyBidsPage">
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
                        <img src="../../assets/package-alt.png" alt="Image" class="w-full h-48 object-cover mt-2">
                    </div>
                    <div class="absolute inset-x-0 bottom-0 bg-gray-800 bg-opacity-75 p-4 text-white flex flex-col space-y-2">
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
                                        <span class="text-xs text-gray-300">Lowest Bid: ₱{{ getLowestBid(bid.item_id) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button @click.stop="openBidModal(bid)" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 w-full rounded-full">
                            BID
                        </button>
                        <button @click.stop="openDeleteModal(bid.id)" class="mt-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 w-full rounded-full">
                            Remove
                        </button>
                    </div>
                </div>
            </transition-group>
            <navbar-alternate />
        </div>
        <navbar-alternate />

        <!-- Update Bid Modal -->
        <transition name="fade">
            <div v-if="updateBidModalVisible" class="fixed inset-0 flex items-center justify-center z-50 bg-gray-800 bg-opacity-75">
                <div class="bg-white p-6 rounded-lg w-full max-w-sm max-h-screen overflow-auto">
                    <div class="text-xl font-semibold mb-2">Update Bid</div>
                    <form class="space-y-4">
                        <div class="flex flex-col">
                            <label for="bidAmount" class="text-lg">Bid Amount</label>
                            <input
                                id="bidAmount"
                                v-model.number="updateBidAmount"
                                type="number"
                                required
                                class="border border-gray-300 rounded-lg p-2"
                            />
                        </div>
                    </form>
                    <div class="flex justify-end space-x-2 mt-4">
                        <button class="bg-green-500 text-white py-2 px-4 rounded-lg shadow-md hover:bg-green-700" @click="confirmUpdateBid">
                            Update Bid
                        </button>
                        <button class="bg-red-500 text-white py-2 px-4 rounded-lg shadow-md hover:bg-red-700" @click="cancelUpdateBid">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </transition>

        <!-- Delete Confirmation Modal -->
        <transition name="fade">
            <div v-if="deleteModalVisible" class="fixed inset-0 flex items-center justify-center z-50 bg-gray-800 bg-opacity-75">
                <div class="bg-white p-6 rounded-lg w-full max-w-sm max-h-screen overflow-auto">
                    <div class="text-xl font-semibold mb-2">Delete Bid</div>
                    <p>Are you sure you want to delete this bid?</p>
                    <div class="flex justify-end space-x-2 mt-4">
                        <button class="bg-red-500 text-white py-2 px-4 rounded-lg shadow-md hover:bg-red-700" @click="confirmDeleteBid">
                            Yes
                        </button>
                        <button class="bg-gray-500 text-white py-2 px-4 rounded-lg shadow-md hover:bg-gray-700" @click="cancelDeleteBid">
                            No
                        </button>
                    </div>
                </div>
            </div>
        </transition>

        <!-- Item Shipping/Item Information Modal -->
        <transition name="fade">
            <div v-if="modalVisible" class="fixed inset-0 flex items-center justify-center z-50 bg-gray-800 bg-opacity-75">
                <div class="bg-white p-6 rounded-lg w-full max-w-sm max-h-screen overflow-auto">
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
                        <div class="mt-4 flex justify-center space-x-4">
                            <template v-if="!bidPlaced">
                                <button class="bg-orange-400 text-white py-2 px-4 rounded-lg" @click="cancel">Back</button>
                            </template>
                            <template v-else>
                                <div class="text-center text-lg font-bold text-green-500">Bid has been placed</div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import navbarAlternate from '@/Components/NavbarAlternate.vue';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import moment from 'moment';

const bids = ref([]);
const lowestBids = ref([]);
const updateBidModalVisible = ref(false);
const updateBidAmount = ref(0);
const updateBidId = ref(null);

const deleteModalVisible = ref(false);
const deleteBidId = ref(null);

const modalVisible = ref(false);
const selectedItem = ref(null);
const showItemInfo = ref(false);

const getFormattedBids = () => {
  return bids.value.map(bid => {
    return {
      ...bid,
      formattedPickupTime: moment(bid.pickup_time).format('MMM D, YYYY')
    };
  });
};

const formattedBids = computed(() => getFormattedBids());

const showModal = (bid) => {
  selectedItem.value = bid;
  modalVisible.value = true;
};

const hideModal = () => {
  selectedItem.value = null;
  modalVisible.value = false;
};

const openBidModal = (bid) => {
  updateBidId.value = bid.id;
  updateBidAmount.value = bid.bid_amount;
  updateBidModalVisible.value = true;
};

const confirmUpdateBid = () => {
  axios.put(`/bids/${updateBidId.value}`, {
    bid_amount: updateBidAmount.value
  })
  .then(response => {
    const index = bids.value.findIndex(bid => bid.id === updateBidId.value);
    if (index !== -1) {
      bids.value[index] = response.data;
    }
    updateBidModalVisible.value = false;
  })
  .catch(error => {
    console.error(error);
  });
};

const cancelUpdateBid = () => {
  updateBidModalVisible.value = false;
};

const openDeleteModal = (bidId) => {
  deleteBidId.value = bidId;
  deleteModalVisible.value = true;
};

const confirmDeleteBid = () => {
  axios.delete(`/bids/${deleteBidId.value}`)
  .then(() => {
    const index = bids.value.findIndex(bid => bid.id === deleteBidId.value);
    if (index !== -1) {
      bids.value.splice(index, 1);
    }
    deleteModalVisible.value = false;
  })
  .catch(error => {
    console.error(error);
  });
};

const cancelDeleteBid = () => {
  deleteModalVisible.value = false;
};

const getLowestBid = (itemId) => {
  const bid = lowestBids.value.find(bid => bid.item_id === itemId);
  return bid ? bid.amount : 'N/A';
};

onMounted(() => {
  axios.get('/bids')
  .then(response => {
    bids.value = response.data;
  })
  .catch(error => {
    console.error(error);
  });

  axios.get('/bids/lowest')
  .then(response => {
    lowestBids.value = response.data;
  })
  .catch(error => {
    console.error(error);
  });
});
</script>

<style scoped>
.MyBids-Page {
  background-color: #EEF4ED;
}

.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}
</style>
