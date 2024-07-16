<template>
    <v-main>
      <div class="landing-page pb-10 container-fluid" ref="landingPage">
        <!-- Logo at the top -->
        <div class="logo-container text-center mb-4">
          <img src="../../assets/business-logo.png" alt="Business Logo" class="logo">
        </div>
        <v-row>
            <v-col cols="12">
              <div class="container mx-auto px-3 py-4">
                <div
                  class="relative bg-white rounded-lg overflow-hidden w-full p-3 mx-auto lg:max-w-screen-lg shadow-lg cursor-pointer hover:transform hover:scale-105 transition-transform duration-300 ease-in-out"
                  @click="toggleContentCard1"
                >
                  <div class="bg-orange-500 p-3 rounded-t-lg">
                    <div class="block sm:hidden w-full mb-3 text-center">
                      <img src="../../assets/programmer.jpg" alt="Image" class="w-3/4 h-auto rounded-md mx-auto">
                    </div>
                    <h2 class="text-lg md:text-xl mb-2 text-white">About Us</h2>
                    <h3 class="text-md md:text-lg font-bold text-white">Shiftminds</h3>
                  </div>
                  <section class="relative flex flex-wrap p-3 pb-12 rounded-b-lg"> <!-- Add padding-bottom -->
                    <div v-if="!showCarousel" class="w-full sm:w-7/12 md:w-1/2 sm:pr-3">
                      <hr class="border-t-2 border-gray-400 my-3">
                      <p class="text-sm md:text-base text-black mb-3">
                        Welcome to ShiftMinds, where innovation meets efficiency to revolutionize the way businesses operate. At ShiftMinds, we're on a mission to empower organizations with cutting-edge technology solutions tailored to streamline workflows and elevate productivity...
                      </p>
                      <transition name="fade">
                        <div v-if="showMoreCard1 || isLargeScreen" class="text-sm md:text-base text-black mb-3">
                          At the core of our ethos lies a commitment to harnessing the power of technology to simplify complexities and drive tangible results. Whether you're a budding startup or an established enterprise, our suite of services is designed to cater to your unique needs, paving the way for seamless operations and unparalleled growth.
                          <v-btn v-if="!showCarousel" class="continue-btn btn-primary absolute bottom-3 left-3 px-3 py-1 bg-orange-500 text-white hover:bg-orange-700 rounded" color="primary" @click.stop="showCarousel = true">Continue</v-btn>
                        </div>
                      </transition>
                    </div>
                    <div v-if="!showCarousel" class="hidden sm:block sm:w-5/12 md:w-1/2 text-center relative">
                      <div class="absolute inset-0 bg-gradient-to-l from-transparent to-white rounded-md"></div>
                      <img src="../../assets/programmer.jpg" alt="Image" class="w-full h-32 md:h-full object-cover rounded-md">
                    </div>
                  </section>
                  <v-carousel v-if="showCarousel" ref="carouselRef" class="custom-carousel">
                    <v-carousel-item v-for="(item, index) in carouselItems" :key="index" class="carousel-item-custom">
                      <div class="text-center">
                        <h2>{{ item.title }}</h2>
                        <p>{{ item.content }}</p>
                      </div>
                    </v-carousel-item>
                  </v-carousel>
                </div>
              </div>
            <div class="container mx-auto px-3 py-4">
              <div
                class="relative bg-white rounded-lg overflow-hidden w-full p-3 mx-auto lg:max-w-screen-lg shadow-lg cursor-pointer hover:transform hover:scale-105 transition-transform duration-300 ease-in-out"
                @click="toggleContentCard2"
              >
                <!-- Top part with orange background -->
                <div class="bg-orange-500 p-3 rounded-t-lg">
                  <div class="block sm:hidden w-full mb-3 text-center">
                    <img src="../../assets/delivery.jpg" alt="Image" class="w-3/4 h-auto rounded-md mx-auto">
                  </div>
                  <h2 class="text-lg md:text-xl mb-2 text-white font-bold">Introducing: CargoBid</h2>
                  <h3 class="text-md md:text-lg text-white">Your Gateway to Seamless Cargo Bidding and Beyond</h3>
                </div>
                <!-- Content section -->
                <section class="relative flex flex-wrap p-3 pb-12 rounded-b-lg"> <!-- Add padding-bottom -->
                  <!-- Text content -->
                  <div class="w-full sm:w-7/12 md:w-1/2 sm:pr-3">
                    <hr class="border-t-2 border-gray-400 my-3">
                    <p class="text-sm md:text-base text-black mb-3">
                      A revolutionary platform designed to simplify the process of cargo bidding and connect carriers, truckers, and delivery riders with lucrative contracts and clients.
                    </p>
                    <transition name="fade">
                      <div v-if="showMoreCard2 || isLargeScreen" class="text-sm md:text-base text-black mb-3">
                        Cargo bidding is a dynamic concept that empowers logistics professionals to compete for contracts by submitting competitive bids or even purchasing available contracts outright. It's a game-changing approach that enables carriers and drivers to maximize their earning potential while offering clients unparalleled flexibility and choice.
                             <router-link v-if="showMoreCard2 || isLargeScreen" to="/carrier-tutorial">
                    <v-btn class="continue-btn btn-primary absolute bottom-3 left-3 px-3 py-1 bg-orange-500 text-white hover:bg-orange-700 rounded" color="primary">Continue</v-btn>
                  </router-link>
                      </div>
                    </transition>
                  </div>
                  <!-- Image block -->
                  <div class="hidden sm:block sm:w-5/12 md:w-1/2 text-center relative">
                    <div class="absolute inset-0 bg-gradient-to-l from-transparent to-white rounded-md"></div>
                    <img src="../../assets/delivery.jpg" alt="Image" class="w-full h-32 md:h-full object-cover rounded-md">
                  </div>
                </section>
              </div>
            </div>
          </v-col>
        </v-row>
      </div>
    </v-main>
    <NavBar/>
  </template>

  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import NavBar from '../Components/NavBar.vue';

  const landingPage = ref(null);
  const items = ref([]);
  const dialog = ref(false); // State for dialog visibility
  const carouselRef = ref(null);

  const showMoreCard1 = ref(false);
  const showMoreCard2 = ref(false);
  const isLargeScreen = ref(false);
  const showCarousel = ref(false); // New state for showing the carousel

  const carouselItems = ref([
    { title: "Step 1", content: "Step 1: Register on our website" },
    { title: "Step 2", content: "Step 2: Complete your profile" },
    { title: "Step 3", content: "Step 3: Start using our services" },
    // Add more items as needed
  ]);

  // Function to toggle content visibility for Card 1
  const toggleContentCard1 = () => {
    showMoreCard1.value = !showMoreCard1.value;
  };

  // Function to toggle content visibility for Card 2
  const toggleContentCard2 = () => {
    showMoreCard2.value = !showMoreCard2.value;
  };

  // Function to check screen size
  const checkScreenSize = () => {
    isLargeScreen.value = window.innerWidth >= 640;
  };

  // On mounted hook to initialize actions
  onMounted(async () => {
    // Initial animation after DOM is settled
    setTimeout(() => {
      landingPage.value.classList.add('animate-drop-down');
    }, 100);

    // Fetch items from API
    await fetchItems();

    // Check initial screen size
    checkScreenSize();
    window.addEventListener('resize', checkScreenSize);
  });
  </script>

<style scoped>
/* Add any additional custom styles here */
body, html {
  margin: 0;
  padding: 0;
}

.landing-page {
  margin-top: 0; /* Ensure there's no extra margin at the top */
}

.animate-drop-down {
  animation: dropDown 1s ease-out;
}

@keyframes dropDown {
  from {
    transform: translateY(-20px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

.custom-carousel {
  margin-bottom: 2rem;
}

.custom-carousel .carousel-item-custom {
  background-color: transparent; /* Set background color to transparent */
  border: none; /* Remove border */
  box-shadow: none; /* Remove box shadow */
}

.custom-carousel .carousel-item-custom > div {
  max-width: 344px;
  background-color: #FFA726;
  margin: auto;
}

.custom-carousel .w-64 {
  width: 260px; /* Adjust width as needed */
  height: auto; /* Maintain aspect ratio */
  display: block;
  margin: 0 auto 10px auto; /* Center the image and add some margin at the bottom */
}

.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
  opacity: 0;
}

.btn-primary {
  position: absolute;
  bottom: 10px;
  left: 10px;
  padding: 0.5rem 1rem;
  background-color: #FFA726;
  color: #fff;
  border: none;
  border-radius: 0.375rem;
  cursor: pointer;
}

.btn-primary:hover {
  background-color: #FF9800;
}

.hover\:transform:hover {
  transform: translateY(-5px);
}

.logo-container {
  padding: 0;
  margin: 0;
}

.logo-container img {
  max-width: 150px; /* Adjust size as needed */
  height: auto;
  margin: 0; /* Remove any unintended margin */
}
</style>
