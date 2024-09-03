
<!--BUG
 I am storing the items but there is no image being uploaded to Cloudinary
-->
<template>
    <AuthenticatedLayout>
      <div class="bg-[#EEF4ED] min-h-screen p-8">
        <transition name="fade">
          <div v-if="currentWindow === 1">
            <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-md">
              <h2 class="text-2xl font-semibold mb-4">Add New Item</h2>
              <div class="mb-4">
                <label for="vehicleType" class="block text-gray-700 font-semibold">Vehicle Type</label>
                <select v-model="form.vehicle_type" id="vehicleType" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                  <option disabled value="">Select a vehicle</option>
                  <option value="Truck">Truck</option>
                  <option value="Van">Van</option>
                  <option value="Motorcycle">Motorcycle</option>
                  <!-- Add more options as necessary -->
                </select>
              </div>
              <div class="flex justify-between">
                <button type="button" class="mt-4 bg-orange-500 text-white py-2 px-4 rounded-lg" @click="goToNextWindow">Next</button>
              </div>
            </div>
          </div>
        </transition>

        <transition name="fade">
          <div v-if="currentWindow === 2">
            <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-md">
              <h2 class="text-2xl font-semibold mb-4">Shipping Information</h2>
              <input v-model="form.item_quote" type="number" step="0.01" placeholder="Quote" required class="mb-4 w-full py-2 px-3 border border-gray-300 rounded-md">
              <input v-model="form.item_pickup_time" type="datetime-local" placeholder="Pickup Time" required class="mb-4 w-full py-2 px-3 border border-gray-300 rounded-md">
              <input v-model="form.item_dropoff_time" type="datetime-local" placeholder="Dropoff Time" class="mb-4 w-full py-2 px-3 border border-gray-300 rounded-md">
              <input v-model="form.item_from" type="text" placeholder="From" required class="mb-4 w-full py-2 px-3 border border-gray-300 rounded-md">
              <input v-model="form.item_destination" type="text" placeholder="Destination" required class="mb-4 w-full py-2 px-3 border border-gray-300 rounded-md">
              <div class="flex justify-between">
                <button type="button" class="mt-4 bg-orange-500 text-white py-2 px-4 rounded-lg" @click="goBackToWindow(1)">Back</button>
                <button type="button" class="mt-4 bg-orange-500 text-white py-2 px-4 rounded-lg" @click="goToNextWindow">Next</button>
              </div>
            </div>
          </div>
        </transition>

        <transition name="fade">
            <div v-if="currentWindow === 3">
              <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-md">
                <h2 class="text-2xl font-semibold mb-4">Item Information</h2>
                <input v-model="form.item_name" type="text" placeholder="Item Name" required class="mb-4 w-full py-2 px-3 border border-gray-300 rounded-md">
                <input v-model="form.item_client" type="text" placeholder="Client" required class="mb-4 w-full py-2 px-3 border border-gray-300 rounded-md">
                <input v-model="form.item_weight" type="number" placeholder="Weight (kg)" required class="mb-4 w-full py-2 px-3 border border-gray-300 rounded-md">
                <input v-model="form.item_length" type="number" placeholder="Length (cm)" required class="mb-4 w-full py-2 px-3 border border-gray-300 rounded-md">
                <input v-model="form.item_width" type="number" placeholder="Width (cm)" required class="mb-4 w-full py-2 px-3 border border-gray-300 rounded-md">
                <input v-model="form.item_height" type="number" placeholder="Height (cm)" required class="mb-4 w-full py-2 px-3 border border-gray-300 rounded-md">
                <input v-model="form.item_status" type="text" placeholder="Status" required class="mb-4 w-full py-2 px-3 border border-gray-300 rounded-md">
                <textarea v-model="form.description" placeholder="Description" class="mb-4 w-full py-2 px-3 border border-gray-300 rounded-md"></textarea>
                <label for="itemImage" class="block text-gray-700 font-semibold">Item Image</label>
                <input
                  type="file"
                  @change="handleImageUpload"
                  class="mb-4 w-full py-2 px-3 border border-gray-300 rounded-md"
                >
                <input
                  v-model="form.item_image"
                  type="text"
                  placeholder="Image URL"
                  class="mb-4 w-full py-2 px-3 border border-gray-300 rounded-md"
                  readonly
                >
                <div class="flex justify-between">
                  <button type="button" class="mt-4 bg-orange-500 text-white py-2 px-4 rounded-lg" @click="goBackToWindow(2)">Back</button>
                  <button type="button" class="mt-4 bg-orange-500 text-white py-2 px-4 rounded-lg" @click="goToNextWindow">Next</button>
                </div>
              </div>
            </div>
          </transition>
          <transition name="fade">
            <div v-if="currentWindow === 4">
              <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-md">
                <h2 class="text-2xl font-semibold mb-4">Summary</h2>
                <div class="space-y-4">
                  <div>
                    <h3 class="text-xl font-semibold">Vehicle Information</h3>
                    <p>Vehicle Type: {{ form.vehicle_type }}</p>
                  </div>
                  <div>
                    <h3 class="text-xl font-semibold">Shipping Information</h3>
                    <p>Quote: {{ form.item_quote }}</p>
                    <p>Pickup Time: {{ form.item_pickup_time }}</p>
                    <p>Dropoff Time: {{ form.item_dropoff_time }}</p>
                    <p>From: {{ form.item_from }}</p>
                    <p>Destination: {{ form.item_destination }}</p>
                  </div>
                  <div>
                    <h3 class="text-xl font-semibold">Item Information</h3>
                    <p>Item Name: {{ form.item_name }}</p>
                    <p>Client: {{ form.item_client }}</p>
                    <p>Weight: {{ form.item_weight }} kg</p>
                    <p>Dimensions: {{ form.item_length }} x {{ form.item_width }} x {{ form.item_height }} cm</p>
                    <p>Status: {{ form.item_status }}</p>
                    <p>Description: {{ form.description }}</p>
                    <p>Image URL: {{ form.item_image }}</p>
                  </div>
                </div>
              <div class="flex justify-between">
                <button type="button" class="mt-4 bg-orange-500 text-white py-2 px-4 rounded-lg" @click="goBackToWindow(3)">Back</button>
                <button type="button" class="mt-4 bg-orange-500 text-white py-2 px-4 rounded-lg" @click="submitForm">Submit</button>
              </div>
            </div>
          </div>
        </transition>
      </div>
    </AuthenticatedLayout>
  </template>

  <script setup>
  import { ref } from 'vue'
  import { Inertia } from '@inertiajs/inertia'
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";


  const currentWindow = ref(1)

  const form = ref({
    item_name: '',
    item_client: '',
    item_weight: '',
    item_from: '',
    item_destination: '',
    item_pickup_time: '',
    item_dropoff_time: '',
    item_quote: '',
    item_image: '',
    item_length: '',
    item_width: '',
    item_height: '',
    item_status: '',
    vehicle_type: '',
    description: '',
  })

  const handleImageUpload = (event) => {
  const file = event.target.files[0];
  if (file) {
    const formData = new FormData();
    formData.append("file", file);
    formData.append("upload_preset", "axi8zrvx"); // Replace with your upload preset name

    fetch(`https://api.cloudinary.com/v1_1/dmebtqdqc/image/upload`, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        form.value.item_image = data.secure_url; // Store the uploaded image URL in the form
      })
      .catch((error) => {
        console.error("Error uploading image:", error);
      });
  }
};


  // Methods
  const goToNextWindow = () => {
    if (currentWindow.value < 4) {
      currentWindow.value += 1
    }
  }

  const goBackToWindow = (windowNumber) => {
    if (windowNumber > 0 && windowNumber < currentWindow.value) {
      currentWindow.value = windowNumber
    }
  }

  const submitForm = async () => {
  try {
    await Inertia.post('/add-item2', form.value);
    alert('Item added successfully!');
  } catch (error) {
    console.error('Error adding item:', error);
    alert('Failed to add item. Please check your input and try again.');
  }
};
  </script>
