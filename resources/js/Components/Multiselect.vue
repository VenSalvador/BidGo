<template>
    <div>
      <label for="province" class="block text-sm font-medium text-gray-700">Province</label>
      <Multiselect
        id="province"
        v-model="selectedProvince"
        :options="provinces"
        placeholder="Select or search for a province"
        label="name"
        track-by="id"
        :searchable="true"
        required
        class="mt-1 block w-full"
      />
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import Multiselect from '@vueform/multiselect';
  import '@vueform/multiselect/themes/default.css';
  import { usePage } from '@inertiajs/vue3';
  
  const { props } = usePage();
  const provinces = ref(props.provinces || []);
  const selectedProvince = ref(null);
  </script>
  
  <style scoped>
  .multiselect {
    position: relative !important;
    z-index: 10 !important;
  }
  
  .multiselect__input {
    position: relative !important;
    z-index: 10 !important;
    display: block !important;
    width: 100% !important;
    height: auto !important;
  }
  </style>
  