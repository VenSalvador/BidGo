<template>
  <Head title="Profile" />
  <AuthenticatedLayout>
    <div class="container mx-auto p-4">
      <div class="bg-white p-6 rounded-lg shadow-md">
        <div>
          <label class="block font-medium text-gray-700">Name</label>
          <div class="flex items-center">
            <p class="text-lg">{{ $page.props.auth.user.name }}</p>
            <button class="ml-2 text-blue-500 hover:text-blue-700">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.625 2.625 0 113.712 3.712l-11.25 11.25a4.125 4.125 0 01-1.742 1.034l-4.125 1.031 1.031-4.125a4.125 4.125 0 011.034-1.742l11.25-11.25z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25L15.75 4.5" />
              </svg>
            </button>
          </div>
        </div>

        <div class="mt-4">
          <label class="block font-medium text-gray-700">Email</label>
          <div class="flex items-center">
            <p class="text-lg">{{ $page.props.auth.user.email }}</p>
            <button class="ml-2 text-blue-500 hover:text-blue-700">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.625 2.625 0 113.712 3.712l-11.25 11.25a4.125 4.125 0 01-1.742 1.034l-4.125 1.031 1.031-4.125a4.125 4.125 0 011.034-1.742l11.25-11.25z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25L15.75 4.5" />
              </svg>
            </button>
          </div>
        </div>

        <div class="mt-4">
          <label class="block font-medium text-gray-700">Province</label>
          <div class="flex items-center">
            <p class="text-lg">{{ $page.props.auth.user.province }}</p>
            <button class="ml-2 text-blue-500 hover:text-blue-700">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.625 2.625 0 113.712 3.712l-11.25 11.25a4.125 4.125 0 01-1.742 1.034l-4.125 1.031 1.031-4.125a4.125 4.125 0 011.034-1.742l11.25-11.25z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25L15.75 4.5" />
              </svg>
            </button>
          </div>
        </div>

        <div class="mt-4">
          <label class="block font-medium text-gray-700">Mobile</label>
          <div class="flex items-center">
            <p class="text-lg">{{ $page.props.auth.user.mobile }}</p>
            <button class="ml-2 text-blue-500 hover:text-blue-700">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.625 2.625 0 113.712 3.712l-11.25 11.25a4.125 4.125 0 01-1.742 1.034l-4.125 1.031 1.031-4.125a4.125 4.125 0 011.034-1.742l11.25-11.25z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25L15.75 4.5" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const page = usePage();
</script>

<style scoped>
.container {
  max-width: 600px;
}
</style>
