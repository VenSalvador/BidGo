<template>
  <div>
    <!-- Carrier Navbar -->
    <nav v-if="userRole === 'Carrier'" class="fixed bottom-0 left-0 w-full bg-orange-500 text-white flex justify-around py-2 shadow-lg">
      <button class="flex-1 text-center py-2 flex flex-col items-center" @click="navigateTo('CarrierDashboard')">
        <span class="icon-circle">
          <img src="../../assets/home-nav.svg" alt="Home Icon" class="icon" />
        </span>
        <span class="label">Home</span>
      </button>
      <button class="flex-1 text-center py-2 flex flex-col items-center" @click="navigateTo('mySale')">
        <span class="icon-circle">
          <img src="../../assets/currency-nav.svg" alt="My Sale Icon" class="icon" />
        </span>
        <span class="label">My Sale</span>
      </button>
      <button class="flex-1 text-center py-2 flex flex-col items-center" @click="navigateTo('AddItem2')">
        <span class="icon-circle">
          <img src="../../assets/plus-nav.svg" alt="Add Icon" class="icon" />
        </span>
        <span class="label">Add</span>
      </button>
      <button class="flex-1 text-center py-2 flex flex-col items-center" @click="navigateTo('my-bid')">
        <span class="icon-circle">
          <img src="../../assets/package-nav.svg" alt="My Bids Icon" class="icon" />
        </span>
        <span class="label">My Bids</span>
      </button>
      <button class="flex-1 text-center py-2 flex flex-col items-center" @click="navigateTo('profile')">
        <span class="icon-circle">
          <img src="../../assets/account-nav.svg" alt="Profile Icon" class="icon" />
        </span>
        <span class="label">Profile</span>
      </button>
    </nav>

    <!-- Client Navbar -->
    <nav v-else-if="userRole === 'Client'" class="fixed bottom-0 left-0 w-full bg-blue-500 text-white flex justify-around py-2 shadow-lg">
      <button class="flex-1 text-center py-2 flex flex-col items-center" @click="navigateTo('ClientDashboard')">
        <span class="icon-circle">
          <img src="../../assets/home-nav.svg" alt="Home Icon" class="icon" />
        </span>
        <span class="label">Home</span>
      </button>
      <button class="flex-1 text-center py-2 flex flex-col items-center" @click="navigateTo('browse')">
        <span class="icon-circle">
          <img src="../../assets/browse-nav.svg" alt="Browse Icon" class="icon" />
        </span>
        <span class="label">Browse</span>
      </button>
      <button class="flex-1 text-center py-2 flex flex-col items-center" @click="navigateTo('favorites')">
        <span class="icon-circle">
          <img src="../../assets/favorites-nav.svg" alt="Favorites Icon" class="icon" />
        </span>
        <span class="label">Favorites</span>
      </button>
      <button class="flex-1 text-center py-2 flex flex-col items-center" @click="navigateTo('orders')">
        <span class="icon-circle">
          <img src="../../assets/orders-nav.svg" alt="Orders Icon" class="icon" />
        </span>
        <span class="label">Orders</span>
      </button>
      <button class="flex-1 text-center py-2 flex flex-col items-center" @click="navigateTo('profile')">
        <span class="icon-circle">
          <img src="../../assets/account-nav.svg" alt="Profile Icon" class="icon" />
        </span>
        <span class="label">Profile</span>
      </button>
    </nav>
  </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';

export default {
  props: {
    userRole: {
      type: String,    
      required: true
    }
  },
  methods: {
    navigateTo(page) {
      Inertia.visit(route(page)); // Use the Inertia visit method for navigation
    },
  },
};
</script>

<style scoped>
button {
  transition: background-color 0.3s ease;
}
button:hover {
  background-color: #ffff; /* Hover effect */
}
nav {
  height: 5rem; /* Adjust the height of the navbar */
}
.icon {
  height: 1.5rem; /* Adjust the height of the icons */
  margin-bottom: 0.25rem; /* Space between icon and label */
}
.icon-circle {
  display: inline-block;
  width: 2rem;
  height: 2rem;
  border-radius: 50%;
  background-color: #fff;
  text-align: center;
  padding: 0.25rem;
}
.label {
  font-size: 0.75rem; /* Smaller text size */
  margin-top: 0.25rem; /* Space between icon and label */
}
</style>
