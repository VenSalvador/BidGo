<template>
  <div>
    <!-- Carrier Navbar -->
    <nav v-if="userRole === 'Carrier'" class="fixed bottom-0 left-0 w-full bg-orange-500 text-white flex justify-around py-2 shadow-lg">
      <button class="flex-1 text-center py-2 flex flex-col items-center" @click="navigateTo('CarrierDashboard')">
        <span class="icon-circle">
          <img src="https://res.cloudinary.com/dmebtqdqc/image/upload/v1725434792/svg-files/wgdtfq8cxlspqggvpdi6.svg" alt="Home Icon" class="icon" />
        </span>
        <span class="label">Home</span>
      </button>
      <button class="flex-1 text-center py-2 flex flex-col items-center" @click="navigateTo('MyBids')">
        <span class="icon-circle">
          <img src="https://res.cloudinary.com/dmebtqdqc/image/upload/v1725434800/svg-files/nhc3weabsfh44fckzfix.svg" alt="My Bids Icon" class="icon" />
        </span>
        <span class="label">My Bids</span>
      </button>
      <button class="flex-1 text-center py-2 flex flex-col items-center" @click="navigateTo('profile.edit')">
        <span class="icon-circle">
          <img src="https://res.cloudinary.com/dmebtqdqc/image/upload/v1725434746/svg-files/lf6buruz8ubsuyquqpyr.svg" alt="Profile Icon" class="icon" />
        </span>
        <span class="label">Profile</span>
      </button>
    </nav>

    <!-- Client Navbar -->
    <nav v-else-if="userRole === 'Client'" class="fixed bottom-0 left-0 w-full bg-orange-500 text-white flex justify-around py-2 shadow-lg">
      <button class="flex-1 text-center py-2 flex flex-col items-center" @click="navigateTo('AddItem2')">
        <span class="icon-circle">
          <img src="https://res.cloudinary.com/dmebtqdqc/image/upload/v1725434792/svg-files/wgdtfq8cxlspqggvpdi6.svg" alt="Home Icon" class="icon" />
        </span>
        <span class="label">Home</span>
      </button>
      <button class="flex-1 text-center py-2 flex flex-col items-center" @click="navigateTo('AddItem2')">
        <span class="icon-circle">
          <img src="https://res.cloudinary.com/dmebtqdqc/image/upload/v1725434806/svg-files/obs6rjbff2okpf6ayfyl.svg" alt="Add Icon" class="icon" />
        </span>
        <span class="label">Add</span>
      </button>
      <button class="flex-1 text-center py-2 flex flex-col items-center" @click="navigateTo('MyItems')">
        <span class="icon-circle">
          <img src="https://res.cloudinary.com/dmebtqdqc/image/upload/v1725434760/svg-files/yy90njeibeuikm0bc79f.svg" alt="My Sale Icon" class="icon" />
        </span>
        <span class="label">My Sale</span>
      </button>
      <button class="flex-1 text-center py-2 flex flex-col items-center" @click="navigateTo('profile.edit')">
        <span class="icon-circle">
          <img src="https://res.cloudinary.com/dmebtqdqc/image/upload/v1725434746/svg-files/lf6buruz8ubsuyquqpyr.svg" alt="Profile Icon" class="icon" />
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
      Inertia.visit(route(page));
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
