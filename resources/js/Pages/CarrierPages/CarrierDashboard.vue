<template>
  <AuthenticatedLayout>
    <Head title="Dashboard" />
    <div class="carrier-dashboard-page pb-20" ref="CarrierDashboard">
      <div class="top-right-icons">
        <img src="../../../assets/bell.svg" alt="Notification Icon" class="icon w-6 h-6" />
        <img src="../../../assets/magnify.svg" alt="Search Icon" class="icon w-6 h-6" />
      </div>

      <div class="dashboard">
        <div v-show="step === 1">
          <div class="ongoing-text flex items-center space-x-2 text-sm font-semibold text-left mb-4">
            <span>Choose What to Browse</span>
            <img src="../../../assets/help-circle.svg" alt="An example icon" class="help-icon w-4 h-4 cursor-pointer" @click="showHelpModal('vehicle')" />
          </div>

          <div class="button-group flex justify-center p-1 space-x-4">
            <button class="vehicle-button flex-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-2 rounded text-center" @click="filterItems('Motorcycle')">Motorcycle</button>
            <button class="vehicle-button flex-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-2 rounded text-center" @click="filterItems('Van')">Van</button>
            <button class="vehicle-button flex-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-2 rounded text-center" @click="filterItems('Pickup')">Pickup</button>
            <button class="vehicle-button flex-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-2 rounded text-center" @click="filterItems('Truck')">Truck</button>
          </div>

          <div class="ongoing-text flex items-center p-5 space-x-2 text-sm font-semibold text-left mb-4">
            <span>All Products</span>
            <img src="../../../assets/help-circle.svg" alt="An example icon" class="help-icon w-4 h-4 cursor-pointer" @click="showHelpModal('ongoing')" />
          </div>

          <transition-group name="fade" tag="div" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <ItemCard
              v-for="item in items"
              :key="item.id"
              :item-name="item.item_name"
              :item-image="item.item_image"
              :client="item.item_client"
              :weight="item.item_weight"
              :from="item.item_from"
              :to="item.item_destination"
              :pickup-time="item.item_pickup_time"
              :drop-off-time="item.item_dropoff_time"
              :quote="item.item_quote"
              :vehicle_type="item.vehicle_type"
              @click="showModal(item)"
              @openBidModal="openBidModal(item)"
            />
          </transition-group>

          <!-- Dialogs and Modals -->
          <transition name="fade">
            <div v-if="bidModalVisible" class="fixed inset-0 flex items-center justify-center z-50 bg-gray-800 bg-opacity-75">
              <div class="bg-white p-6 rounded-lg w-full max-w-sm">
                <h2 class="text-xl font-bold mb-4">Bid Confirmation</h2>
                <form>
                  <label for="bidAmount" class="block text-sm font-medium text-gray-700">Bid Amount</label>
                  <input
                    type="number"
                    v-model.number="bidAmount"
                    :class="bidRules"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-4 py-2"
                    required
                  />
                </form>
                <div class="mt-4 flex justify-end space-x-2">
                  <button class="bg-green-500 text-white px-4 py-2 rounded" @click="confirmBid">Confirm Bid</button>
                  <button class="bg-red-500 text-white px-4 py-2 rounded" @click="cancelBid">Cancel</button>
                </div>
              </div>
            </div>
          </transition>

          <transition name="fade">
            <div v-if="confirmDialog" class="fixed inset-0 flex items-center justify-center z-50 bg-gray-800 bg-opacity-75">
              <div class="bg-white p-6 rounded-lg w-full max-w-sm">
                <h2 class="text-xl font-bold mb-4">Confirm Vehicle Selection</h2>
                <p>Are you sure you want to select this vehicle?</p>
                <div class="mt-4 flex justify-end space-x-2">
                  <button class="bg-green-500 text-white px-4 py-2 rounded" @click="confirmSelection">Confirm</button>
                  <button class="bg-red-500 text-white px-4 py-2 rounded" @click="confirmDialog = false">Cancel</button>
                </div>
              </div>
            </div>
          </transition>

          <transition name="fade">
              <div v-if="modalVisible" class="fixed inset-0 flex items-center justify-center z-50 bg-gray-800 bg-opacity-75">
                <div class="bg-white p-6 rounded-lg w-full max-w-sm max-h-screen overflow-auto">
                  <div class="bg-orange-400 rounded-t-lg p-3">
                    <div class="text-center text-lg mb-4">Shipping Information</div>
                  </div>
                  <div class="space-y-4">
                    <div class="flex justify-between border-b pb-2">
                      <label class="font-bold">Order from:</label>
                      <span>{{ selectedItem.item_client }}</span>
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
                      <span>{{ selectedItem.item_destination }}</span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                      <label class="font-bold">Current Bids:</label>
                      <span>{{ selectedItem.item_current_bids }}</span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                      <label class="font-bold">Quote/Pricing:</label>
                      <span>{{ selectedItem.item_quote }}</span>
                    </div>
                    <button @click="showItemInfo = !showItemInfo" class="w-full mt-4 bg-blue-500 text-white py-2 rounded-lg">
                      Show Item Information
                    </button>
                    <transition name="fade">
                      <div v-if="showItemInfo" class="border border-gray-300 rounded-lg p-4 mt-4 bg-white space-y-2">
                        <div class="flex justify-between border-b pb-2">
                          <label class="font-bold">Description:</label>
                          <span>{{ selectedItem.item_name }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                          <label class="font-bold">Length:</label>
                          <span>{{ selectedItem.item_length }} cm</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                          <label class="font-bold">Width:</label>
                          <span>{{ selectedItem.item_width }} cm</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                          <label class="font-bold">Height:</label>
                          <span>{{ selectedItem.item_height }} cm</span>
                        </div>
                      </div>
                    </transition>
                  </div>
                  <button @click="cancel" class="mt-6 w-full bg-red-500 text-white py-2 rounded-lg">Close</button>
                </div>
              </div>
            </transition>

          <transition name="fade">
            <div v-if="helpModalVisible" class="fixed inset-0 flex items-center justify-center z-50 bg-gray-800 bg-opacity-75">
              <div class="bg-white p-6 rounded-lg w-full max-w-sm">
                <h2 class="text-xl font-bold mb-4">Help</h2>
                <p>{{ helpModalText }}</p>
                <div class="mt-4 flex justify-end">
                  <button class="bg-blue-500 text-white px-4 py-2 rounded" @click="helpModalVisible = false">Close</button>
                </div>
              </div>
            </div>
          </transition>
        </div>

        <div v-show="step === 2">
          <ReviewAndConfirm :selected-item="selectedItem" :bid-amount="bidAmount" />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { usePage, Head } from '@inertiajs/inertia-vue3';
import axios from 'axios';
import moment from 'moment';
import ItemCard from '../../Components/ItemCard.vue';
import ReviewAndConfirm from '../../Components/ReviewAndConfirm.vue'; // Correct casing
import { useWindowScroll } from '@vueuse/core';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const { props } = usePage();
const step = ref(1);
const items = ref([]);
const modalVisible = ref(false);
const bidModalVisible = ref(false);
const confirmDialog = ref(false);
const bidAmount = ref(null);
const helpModalVisible = ref(false);
const helpModalText = ref('');
const bidPlaced = ref(false);
const showItemInfo = ref(false);
const { y } = useWindowScroll();
const selectedItem = ref({
  id: null,
  itemName: '',
  itemImage: '',
  client: '',
  weight: '',
  from: '',
  destination: '',
  pickupTime: '',
  dropoffTime: '',
  quote: '',
  vehicle_type: '',
  length: '',
  width: '',
  height: '',
  currentBids: '',
  formattedPickupTime: ''
});

const fetchItems = async () => {
  try {
    const response = await axios.get('/items');
    items.value = response.data;
  } catch (error) {
    console.error('Error fetching items:', error);
  }8
};

const bidRules = [
  v => !!v || 'Bid amount is required',
  v => (v && v > 0) || 'Bid amount must be greater than zero'
];

const filterItems = async (vehicleType) => {
  try {
    const response = await axios.post('/filter-by-vehicle-type', { vehicle_type: vehicleType });
    items.value = response.data;
  } catch (error) {
    console.error('Error filtering items by vehicle type:', error);
  }
};

const showModal = (item) => {
  selectedItem.value = { ...item, formattedPickupTime: moment(item.item_pickup_time).format('MMM D, YYYY h:mm A') };
  modalVisible.value = true;
};

const openBidModal = (item) => {
  selectedItem.value = { ...item, formattedPickupTime: moment(item.item_pickup_time).format('MMM D, YYYY h:mm A') };
  bidModalVisible.value = true;
};

const cancelBid = () => {
  bidModalVisible.value = false;
  bidAmount.value = null;
};

const confirmBid = async () => {
  if (
    bidAmount.value < 0 ||
    bidAmount.value == 0 ||
    bidAmount.value > selectedItem.value.quote
  ) {
    alert('Invalid bid amount. Please check the values.');
    return;
  }

  try {
    bidPlaced.value = true;
    bidModalVisible.value = false;
    selectedItem.value.currentBids++;

    // Navigate to the ReviewAndConfirm component
    step.value = 2;
  } catch (error) {
    console.error('Error submitting bid:', error);
  }
};

const cancel = () => {
  modalVisible.value = false;
};

const showHelpModal = (type) => {
  switch (type) {
    case 'vehicle':
      helpModalText.value = 'Choose a vehicle type to browse items available for that vehicle.';
      break;
    case 'ongoing':
      helpModalText.value = 'This section displays all ongoing items available for bidding.';
      break;
  }
  helpModalVisible.value = true;
};

onMounted(() => {
  fetchItems();
});
</script>

<style scoped>
.carrier-dashboard-page {
  background-color: #eef4ed;
  min-height: 100vh;
}
.icon {
  position: absolute;
  top: 16px;
  right: 16px;
  cursor: pointer;
}
.dashboard {
  padding: 20px;
}
.help-icon {
  cursor: pointer;
}
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}
.top-right-icons {
  display: flex;
  gap: 16px;
  position: absolute;
  top: 16px;
  right: 16px;
}
</style>

