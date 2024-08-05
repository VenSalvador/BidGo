<template>
    <AuthenticatedLayout>
      <transition name="fade">
        <div class="bg-eeF4ED min-h-screen relative">
          <div class="absolute top-0 right-0 cursor-pointer">
            <img src="../../../assets/exit.svg" alt="An example icon" class="ml-2 w-10 h-10 cursor-pointer" @click="navigateToDashboard" />
          </div>
          <div class="container mx-auto px-3 py-5">
            <div v-if="currentWindow === 1" class="min-h-screen">
              <div class="container mx-auto px-4 py-8 pb-16">
                <h2 class="text-2xl font-bold mb-4 flex items-center">Vehicle Selection</h2>
                <div class="flex flex-wrap gap-4 justify-center">
                  <transition-group name="fade" tag="div" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                    <VehicleCard
                      v-for="(vehicle, index) in vehicles"
                      :key="index"
                      :vehicle="vehicle"
                      :image="getVehicleImage(vehicle.vehicle_type)"
                      :selected-vehicle="selectedVehicle"
                      @select-vehicle="handleSelectVehicle"
                      class="w-full"
                    />
                  </transition-group>
                </div>
              </div>
            </div>

            <transition name="fade">
              <div v-if="currentWindow === 2" class="min-h-screen">
                <div class="container mx-auto px-4 py-8 pb-16">
                  <h2 class="text-2xl font-bold mb-4">Shipping Information</h2>
                  <form @submit.prevent="submitForm" class="space-y-4">
                    <div>
                      <label for="itemQuote" class="block text-sm font-medium text-gray-700">Quote/Pricing</label>
                      <input v-model="itemQuote" type="number" id="itemQuote" class="mt-1 block w-full bg-white rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                      <div>
                        <label for="itemPickupTime" class="block text-sm font-medium text-gray-700">Pickup Time</label>
                        <input v-model="itemPickupTime" type="datetime-local" id="itemPickupTime" class="mt-1 block w-full bg-white rounded-md border-gray-300 shadow-sm" required>
                      </div>
                      <div>
                        <label for="itemDropoffTime" class="block text-sm font-medium text-gray-700">Dropoff Time</label>
                        <input v-model="itemDropoffTime" type="datetime-local" id="itemDropoffTime" class="mt-1 block w-full bg-white rounded-md border-gray-300 shadow-sm" required>
                      </div>
                    </div>
                    <div>
                      <label for="itemPickupLocation" class="block text-sm font-medium text-gray-700">Pickup Location</label>
                      <input v-model="itemPickupLocation" type="text" id="itemPickupLocation" class="mt-1 block w-full bg-white rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    <div>
                      <label for="itemDestination" class="block text-sm font-medium text-gray-700">Destination</label>
                      <input v-model="itemDestination" type="text" id="itemDestination" class="mt-1 block w-full bg-white rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    <div class="flex space-x-4">
                      <button type="button" class="mt-4 bg-orange-500 text-white py-2 px-4 rounded-lg" @click="goBackToVehicleSelection">Back</button>
                      <button type="button" class="mt-4 bg-orange-500 text-white py-2 px-4 rounded-lg" @click="goToNextWindow">Next</button>
                    </div>
                  </form>
                </div>
              </div>
            </transition>

            <transition name="fade">
              <div v-if="currentWindow === 3" class="min-h-screen">
                <div class="container mx-auto px-4 py-8 pb-16">
                  <h2 class="text-2xl font-bold mb-4">Item Information</h2>
                  <form @submit.prevent="submitForm" class="space-y-4">
                    <div>
                      <label for="itemName" class="block text-sm font-medium text-gray-700">Item Name</label>
                      <input v-model="itemName" type="text" id="itemName" class="mt-1 block w-full bg-white rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    <div>
                      <label for="itemWeight" class="block text-sm font-medium text-gray-700">Weight</label>
                      <input v-model="itemWeight" type="number" id="itemWeight" class="mt-1 block w-full bg-white rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    <div>
                      <label for="itemHeight" class="block text-sm font-medium text-gray-700">Height</label>
                      <input v-model="itemHeight" type="number" id="itemHeight" class="mt-1 block w-full bg-white rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    <div>
                      <label for="itemWidth" class="block text-sm font-medium text-gray-700">Width</label>
                      <input v-model="itemWidth" type="number" id="itemWidth" class="mt-1 block w-full bg-white rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    <div>
                      <label for="itemLength" class="block text-sm font-medium text-gray-700">Length</label>
                      <input v-model="itemLength" type="number" id="itemLength" class="mt-1 block w-full bg-white rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    <div>
                      <label for="itemDescription" class="block text-sm font-medium text-gray-700">Description</label>
                      <textarea v-model="itemDescription" id="itemDescription" class="mt-1 block w-full bg-white rounded-md border-gray-300 shadow-sm" required></textarea>
                    </div>
                    <div class="flex space-x-4">
                      <button type="button" class="mt-4 bg-orange-500 text-white py-2 px-4 rounded-lg" @click="goBackToShippingInformation">Back</button>
                      <button type="button" class="mt-4 bg-orange-500 text-white py-2 px-4 rounded-lg" @click="goToNextWindow">Next</button>
                    </div>
                  </form>
                </div>
              </div>
            </transition>

            <transition name="fade">
              <div v-if="currentWindow === 4" class="min-h-screen">
                <div class="container mx-auto px-4 py-8 pb-16">
                  <h2 class="text-2xl font-bold mb-4">Summary</h2>
                  <div class="space-y-4">
                    <div>
                        <h3 class="text-xl font-semibold flex items-center">
                            Vehicle Selection
                            <img src="../../../assets/pencil-circle.svg" alt="Edit icon" class="ml-2 w-8 h-8 cursor-pointer" @click="goToWindow(1)" />
                          </h3>
                      <p>Selected Vehicle: {{ selectedVehicle?.vehicle_type }}</p>
                      <span @click="goToWindow(1)">Edit</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold flex items-center">
                            Shipping Information
                            <img src="../../../assets/pencil-circle.svg" alt="Edit icon" class="ml-2 w-8 h-8 cursor-pointer" @click="goToWindow(2)" />
                          </h3>
                      <p>Quote/Pricing: {{ itemQuote }}</p>
                      <p>Pickup Time: {{ itemPickupTime }}</p>
                      <p>Dropoff Time: {{ itemDropoffTime }}</p>
                      <p>Pickup Location: {{ itemPickupLocation }}</p>
                      <p>Destination: {{ itemDestination }}</p>
                      <span @click="goToWindow(2)">Edit</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold flex items-center">
                            Item Information
                            <img src="../../../assets/pencil-circle.svg" alt="Edit icon" class="ml-2 w-8 h-8 cursor-pointer" @click="goToWindow(3)" />
                          </h3>                      <p>Item Name: {{ itemName }}</p>
                      <p>Weight: {{ itemWeight }}</p>
                      <p>Height: {{ itemHeight }}</p>
                      <p>Width: {{ itemWidth }}</p>
                      <p>Length: {{ itemLength }}</p>
                      <p>Description: {{ itemDescription }}</p>
                      <span @click="goToWindow(3)">Edit</span>
                    </div>
                  </div>
                  <div class="flex space-x-4">
                    <button type="button" class="mt-4 bg-orange-500 text-white py-2 px-4 rounded-lg" @click="goBackToItemInformation">Back</button>
                    <button type="button" class="mt-4 bg-orange-500 text-white py-2 px-4 rounded-lg" @click="submitForm">Submit</button>
                  </div>
                </div>
              </div>
            </transition>
          </div>
        </div>
      </transition>
    </AuthenticatedLayout>
  </template>

  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import VehicleCard from '../../Components/VehicleCard.vue';
  import scooterDelivery from '../../../assets/scooter.png';
  import vanDelivery from '../../../assets/van.png';
  import pickupDelivery from '../../../assets/pickup.png';
  import truckDelivery from '../../../assets/truck.png';
  import editIcon from '../../../assets/pencil-circle.svg';
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

  const vehicles = ref([]);
  const selectedVehicle = ref(null);
  const helpModalVisible = ref(false);
  const helpModalText = ref('');
  const confirmDialog = ref(false);
  const currentWindow = ref(1);

  const itemName = ref('');
  const itemQuote = ref('');
  const itemPickupTime = ref('');
  const itemDropoffTime = ref('');
  const itemPickupLocation = ref('');
  const itemDestination = ref('');
  const itemWeight = ref('');
  const itemHeight = ref('');
  const itemWidth = ref('');
  const itemLength = ref('');
  const itemDescription = ref('');

  const fetchVehicles = async () => {
    try {
      const response = await axios.get('/vehicles');
      vehicles.value = response.data;
      console.log('Fetched vehicles:', vehicles.value);
    } catch (error) {
      console.error('Error fetching vehicles:', error);
    }
  };

  onMounted(() => {
    fetchVehicles();
  });

  const showHelpModal = (type) => {
    helpModalVisible.value = true;
    if (type === 'vehicleSelect') {
      helpModalText.value = 'This is where you can view your available vehicles. Select which vehicle will handle the delivery.';
    }
  };

  const handleSelectVehicle = (vehicle) => {
    selectedVehicle.value = vehicle;
    currentWindow.value = 2;
  };


  const goBackToVehicleSelection = () => {
    currentWindow.value = 1;
  };

  const goBackToShippingInformation = () => {
    currentWindow.value = 2;
  };

  const goBackToItemInformation = () => {
    currentWindow.value = 3;
  };


  const goToWindow = (windowNumber) => {
    currentWindow.value = windowNumber;
  };

  const getVehicleImage = (vehicleType) => {
    if (vehicleType === 'Motorcycle') {
      return scooterDelivery;
    } else if (vehicleType === 'Van') {
      return vanDelivery;
    } else if (vehicleType === 'Pickup') {
      return pickupDelivery;
    } else if (vehicleType === 'Truck') {
      return truckDelivery;
    }
  };

  const submitForm = () => {
    // Handle form submission
    console.log('Form Submitted:', {
      itemName: itemName.value,
      itemQuote: itemQuote.value,
      itemPickupTime: itemPickupTime.value,
      itemDropoffTime: itemDropoffTime.value,
      itemPickupLocation: itemPickupLocation.value,
      itemDestination: itemDestination.value,
      itemWeight: itemWeight.value,
      itemHeight: itemHeight.value,
      itemWidth: itemWidth.value,
      itemLength: itemLength.value,
      itemDescription: itemDescription.value,
    });
  };

  const goToNextWindow = () => {
    if (currentWindow.value === 1) {
      currentWindow.value = 2;
    } else if (currentWindow.value === 2) {
      currentWindow.value = 3;
    } else if (currentWindow.value === 3) {
      currentWindow.value = 4;
    }
  };


  const navigateToDashboard = () => {
    router.push('/CarrierDashboard');
  };
  </script>

  <style scoped>
  .bg-eeF4ED {
    background-color: #EEF4ED;
  }
  .help-icon {
    cursor: pointer;
  }
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.5s ease;
  }

  .fade-enter-from,
  .fade-leave-to {
    opacity: 0;
  }
  </style>
