<template>
    <AuthenticatedLayout>
      <div class="my-items-page pb-16" ref="MyItemsPage">
        <div class="container mx-auto px-3 py-5">
          <h1 class="text-2xl font-bold mb-5">My Sale</h1>
          <div v-if="items.length">
            <div v-for="item in items" :key="item.id" class="bg-white shadow-md rounded-lg p-4 mb-4" @click="showModal(item)">
              <h2 class="text-xl font-semibold">{{ item.item_name }}</h2>
              <p>{{ item.description }}</p>
              <p class="text-gray-600">Price: ₱{{ item.item_quote }}</p>
              <p class="text-gray-600">Posted on: {{ new Date(item.created_at).toLocaleDateString() }}</p>
            </div>
          </div>
          <div v-else>
            <p>You have not posted any items yet.</p>
          </div>
        </div>

        <transition name="fade">
          <div v-if="modalVisible" class="fixed inset-0 flex items-center justify-center z-50 bg-gray-800 bg-opacity-75">
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
              <button @click="cancel" class="mt-6 w-full bg-red-500 text-white py-2 rounded-lg">Close</button>
            </div>
          </div>
        </transition>
      </div>
    </AuthenticatedLayout>
  </template>

  <script>
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
  import moment from 'moment';

  export default {
    components: {
      AuthenticatedLayout
    },
    props: {
      items: Array
    },
    data() {
      return {
        modalVisible: false,
        showItemInfo: false,
        selectedItem: {
          formattedPickupTime: '',
          vehicle_type: '',
          destination: '',
          currentBids: '',
          quote: '',
          itemName: '',
          length: '',
          width: '',
          height: '',
          weight: ''
        }
      };
    },
    methods: {
      showModal(item) {
        this.selectedItem = {
          formattedPickupTime: moment(item.item_pickup_time).format('MMMM Do YYYY'),
          vehicle_type: item.vehicle_type,
          destination: item.item_destination,
          currentBids: item.item_current_bids,
          quote: item.item_quote,
          itemName: item.item_name,
          length: item.item_length,
          width: item.item_width,
          height: item.item_height,
          weight: item.item_weight
        };
        this.modalVisible = true;
      },
      cancel() {
        this.modalVisible = false;
      }
    }
  };
  </script>

  <style scoped>
  .my-items-page {
    background-color: #EEF4ED;
  }
  </style>
