<template>
    <div class="carrier-dashboard-page pb-20" ref="carrierDashboardPage">
      <!-- Your existing template content -->
      <div class="top-right-icons">
        <img src="/assets/bell.svg" alt="Notification Icon" class="icon w-6 h-6" />
        <img src="/assets/magnify.svg" alt="Search Icon" class="icon w-6 h-6" />
      </div>

      <div class="dashboard">
        <v-window v-model="step">
          <v-window-item :value="1">
            <v-main>
              <div class="ongoing-text flex items-center space-x-2 text-sm font-semibold text-left mb-4">
                <span>Choose What to Browse</span>
                <img src="/assets/help-circle.svg" alt="An example icon" class="help-icon w-4 h-4 cursor-pointer" @click="showHelpModal('vehicle')" />
              </div>

              <div class="button-group flex justify-center p-1 space-x-4">
                <button class="vehicle-button flex-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-2 rounded text-center" @click="filterItems('Motorcycle')">Motorcycle</button>
                <button class="vehicle-button flex-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-2 rounded text-center" @click="filterItems('Van')">Van</button>
                <button class="vehicle-button flex-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-2 rounded text-center" @click="filterItems('Pickup')">Pickup</button>
                <button class="vehicle-button flex-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-2 rounded text-center" @click="filterItems('Truck')">Truck</button>
              </div>

              <div class="ongoing-text flex items-center space-x-2 text-sm font-semibold text-left mb-4">
                <span>All Product</span>
                <img src="/assets/help-circle.svg" alt="An example icon" class="help-icon w-4 h-4 cursor-pointer" @click="showHelpModal('ongoing')" />
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
                  @openBidModal="openBidModal"
                />
              </transition-group>

              <!-- Dialogs and Modals -->
              <v-dialog v-model="bidModalVisible" max-width="400">
                <v-card>
                  <v-card-title>Bid Confirmation</v-card-title>
                  <v-card-text>
                    <form>
                      <v-text-field
                        label="Bid Amount"
                        v-model.number="bidAmount"
                        :rules="bidRules"
                        type="number"
                        required
                      />
                    </form>
                  </v-card-text>
                  <v-card-actions>
                    <v-btn class="custom-btn green" color="green" @click="confirmBid">Confirm Bid</v-btn>
                    <v-btn class="custom-btn red" color="red" @click="cancelBid">Cancel</v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>

              <v-dialog v-model="confirmDialog" max-width="400">
                <v-card>
                  <v-card-title>Confirm Vehicle Selection</v-card-title>
                  <v-card-text>Are you sure you want to select this vehicle?</v-card-text>
                  <v-card-actions>
                    <v-btn class="custom-btn green" color="green" @click="confirmSelection">Confirm</v-btn>
                    <v-btn class="custom-btn red" color="red" @click="confirmDialog = false">Cancel</v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>

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
                        </div>
                      </transition>
                    </div>
                    <button @click="cancel" class="mt-6 w-full bg-red-500 text-white py-2 rounded-lg">Close</button>
                  </div>
                </div>
              </transition>
            </v-main>
          </v-window-item>
        </v-window>
      </div>
    </div>
  </template>

  <script setup>
  import { ref, onMounted, computed } from 'vue';
  import { usePage } from '@inertiajs/inertia-vue3';
  import axios from 'axios';
  import moment from 'moment';
  import ItemCard from '../Components/ItemCard.vue';
  import { useWindowScroll } from '@vueuse/core';

  const { props } = usePage();
  const step = ref(1);
  const items = computed(() => props.value.items);
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

  const showBidModal = () => {
      bidModalVisible.value = true;
  };

  const cancelBid = () => {
      bidModalVisible.value = false;
      bidAmount.value = null;
  };

  const confirmBid = async () => {
      try {
          await axios.post('/submit-bid', {
              item_id: selectedItem.value.id,
              bid_amount: bidAmount.value
          });
          bidPlaced.value = true;
          bidModalVisible.value = false;
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
