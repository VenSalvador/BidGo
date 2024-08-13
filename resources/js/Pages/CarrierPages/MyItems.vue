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
              <button @click="showBids(item)" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-lg">Show Bids</button>
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
                <div class="text-center text-lg mb-4">Bids for {{ selectedItem.itemName }}</div>
              </div>
              <div class="space-y-4">
                <div v-for="bid in bids" :key="bid.id" class="flex justify-between border-b pb-2">
                  <span>₱{{ bid.bid_amount }}</span>
                  <span>{{ bid.user.name }}</span>
                </div>
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
        selectedItem: {},
        bids: []
      };
    },
    methods: {
      async showBids(item) {
        this.selectedItem = {
          itemName: item.item_name,
        };

        // Fetch the bids for the selected item
        const response = await axios.get(`/items/${item.id}/bids`);
        this.bids = response.data;

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
