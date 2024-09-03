<template>
  <Head title="Profile" />
  <AuthenticatedLayout>
    <div class="container mx-auto p-4">

      <div class="bg-white p-6 rounded-lg shadow-md">
        <div>
          <label class="block font-medium text-gray-700">Name</label>
          <p class="text-lg">{{ $page.props.auth.user.name }}</p>
        </div>
        <div class="mt-4">
          <label class="block font-medium text-gray-700">Email</label>
          <p class="text-lg">{{ $page.props.auth.user.email }}</p>
        </div>
        <div class="mt-4">
          <label class="block font-medium text-gray-700">Province</label>
          <p class="text-lg">{{ $page.props.auth.user.province }}</p>
        </div>
        <div class="mt-4">
          <label class="block font-medium text-gray-700">Mobile</label>
          <p class="text-lg">{{ $page.props.auth.user.mobile }}</p>
        </div>
        <div class="mt-4">
          <label class="block font-medium text-gray-700">Postalcode</label>
          <p class="text-lg">{{ $page.props.auth.user.postalcode }}</p>
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
