<template>
    <AuthenticatedLayout>
      <div class="my-items-page pb-16" ref="MyItemsPage">
        <div class="container mx-auto px-3 py-5">
          <h1 class="text-2xl font-bold mb-5">My Posted Items</h1>
          <div v-if="items.length">
            <div v-for="item in items" :key="item.id" class="bg-white shadow-md rounded-lg p-4 mb-4">
              <h2 class="text-xl font-semibold">{{ item.item_name }}</h2>
              <p>{{ item.description }}</p>
              <p class="text-gray-600">Price: ${{ item.item_quote }}</p>
              <p class="text-gray-600">Posted on: {{ new Date(item.created_at).toLocaleDateString() }}</p>
            </div>
          </div>
          <div v-else>
            <p>You have not posted any items yet.</p>
          </div>
        </div>
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
    }
  };
  </script>

  <style scoped>
  .my-items-page {
    background-color: #EEF4ED;
  }
  </style>
