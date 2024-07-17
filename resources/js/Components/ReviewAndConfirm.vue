<template>
    <div class="max-w-xl mx-auto mt-6 p-6 bg-white shadow-lg rounded-lg">
      <h2 class="text-2xl font-semibold mb-6 text-center">Review and Confirm Transaction</h2>
      <div class="flex flex-col items-center mb-6">
        <div class="mb-6 w-full">
          <h3 class="text-xl font-medium mb-4">Selected Item:</h3>
          <p><b>Item Name: </b>{{ selectedItem.itemName }}</p>
          <p><b>Client: </b>{{ selectedItem.client }}</p>
          <p><b>Pick-up time: </b>{{ selectedItem.pickupTime }}</p>
          <p><b>Destination: </b>{{ selectedItem.destination }}</p>
          <p><b>Current Bids: </b>{{ selectedItem.currentBids }}</p>
          <p><strong>Vehicle:</strong> {{ selectedItem.vehicle_type }}</p>
          <p><b>Delivery Quote/Price: </b>{{ selectedItem.quote }}</p>
          <p><strong>Bid Amount:</strong> {{ bidAmount }}</p>
        </div>
      </div>

      <div class="flex justify-center mt-6">
        <button
          class="bg-green-500 text-white font-semibold py-2 px-4 rounded transition duration-400 hover:bg-gray-500 hover:text-black hover:border-green-500 hover:border-2"
          @click="confirm"
        >
          Confirm
        </button>
      </div>
    </div>
  </template>

  <script>
  import axios from 'axios';

  export default {
    props: {
      selectedItem: {
        type: Object,
        required: true,
      },
      bidAmount: {
      type: Number,
      required: true
    },
    },
    methods: {
      confirm() {
        const bidData = {
          item_id: this.selectedItem.id,
          bid_amount: this.bidAmount, // or another field if you have a specific bid amount
        };

        axios.post('/submit-bid', bidData)
          .then(response => {
            console.log('Bid submitted successfully:', response.data);
            alert(`Bid Successfully Submitted!`);

            // Handle success (e.g., show a success message, navigate to another page, etc.)
          })
          .catch(error => {
            if (error.response) {
              console.error('Error submitting bid:', error.response.data);
              alert(`Error submitting bid: ${JSON.stringify(error.response.data)}`);
            } else {
              console.error('Error submitting bid:', error.message);
              alert(`Error submitting bid: ${error.message}`);
            }
          });
      },
    },
  };
  </script>


  <style scoped>
  .custom-btn {
    transition-duration: 0.4s;
  }

  .custom-btn:hover {
    background-color: white;
    color: black !important;
    border: 2px solid #4CAF50;
  }
  </style>
