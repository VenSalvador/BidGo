<template>
    <div
      class="item-card relative flex flex-col py-1 px-4 border border-gray-300 rounded-lg overflow-hidden transition-transform duration-200 ease-in-out"
      :class="{ 'hover:transform hover:scale-105': !isClicked }"
      @click="$emit('click', itemName)"
    >
      <img src="../../assets/Package-alt.png" alt="Image" class="w-full h-48 object-cover">
      <div class="absolute inset-x-0 bottom-0 bg-gray-800 bg-opacity-75 p-4 text-white">
        <div class="flex justify-between items-start">
          <div class="flex flex-col">
            <div class="text-lg font-bold"><b></b> ₱{{ quote }}</div>
            <div class="text-sm">{{ itemName }}</div>
          </div>
          <div class="flex flex-col items-end">
            <div class="text-sm"><b></b> {{ formattedPickupTime }}</div>
            <button @click.stop="openBidModal" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded-full">
              BID
            </button>
          </div>
        </div>
      </div>
    </div>
  </template>


  <script>
  import moment from 'moment';

  export default {
    props: {
      id: {
        type: Number,
        required: true
      },
      itemName: {
        type: String,
        required: true
      },
      itemImage: {
        type: String,
        required: true
      },
      client: {
        type: String,
        required: true
      },
      weight: {
        type: Number,
        required: true
      },
      from: {
        type: String,
        required: true
      },
      to: {
        type: String,
        required: true
      },
      pickupTime: {
        type: String,
        required: true
      },
      dropOffTime: {
        type: String,
        required: true
      },
      quote: {
        type: Number,
        required: true
      },
      vehicle_type: {
        type: String,
        required: true
      },
      isClicked: {
        type: Boolean,
        default: false
      }
    },
    setup(props, { emit }) {
      const openBidModal = () => {
        emit('openBidModal');
      };

      const formattedPickupTime = moment(props.pickupTime).fromNow();

      return {
        openBidModal,
        formattedPickupTime
      };
    }
  };
  </script>
