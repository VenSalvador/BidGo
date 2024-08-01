<template>
    <div class="bg-white rounded-lg overflow-hidden shadow-lg border border-gray-200 mt-4">
      <div
        class="flex items-center justify-between px-4 py-2 bg-gray-100 border-b border-gray-200 cursor-pointer"
        :class="{ 'border-blue-500': isSelected }"
        @click="selectVehicle"
      >
        <div class="flex items-center">
          <img :src="image" alt="Vehicle Image" class="rounded-full h-16 w-16 object-contain mr-4">
          <div class="text-lg font-semibold text-gray-800">
            {{ vehicle.vehicle_name }}
          </div>
        </div>
        <div class="text-sm text-gray-500">
          {{ availabilityText }}
        </div>
      </div>
      <div class="p-4">
        <div class="text-gray-600 text-sm mb-2">
          Type: {{ vehicle.vehicle_type }}
        </div>
        <div class="text-gray-600 text-sm mb-2">
          Capacity: {{ vehicle.capacity }}kg
        </div>
        <transition name="fade">
          <div v-if="isSelected" class="mt-4 text-gray-700">
            <p>{{ vehicle.description }}</p>
          </div>
        </transition>
      </div>
    </div>
  </template>

  <script setup>
  import { computed, defineProps, defineEmits } from 'vue';

  const props = defineProps({
    vehicle: {
      type: Object,
      required: true,
    },
    image: {
      type: String,
      required: true,
    },
    selectedVehicle: {
      type: Object,
      required: true,
    },
  });

  const emit = defineEmits(['select-vehicle']);

  const isSelected = computed(() => props.selectedVehicle === props.vehicle);

  const availabilityText = computed(() =>
    props.vehicle.availability === 1 ? 'Available' : 'Unavailable'
  );

  const selectVehicle = () => {
    emit('select-vehicle', props.vehicle);
  };
  </script>

  <style scoped>
  .fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s;
  }
  .fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
    opacity: 0;
  }
  </style>
