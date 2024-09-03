<template>
    <GuestLayout>
      <Head title="BidGo" />

      <Link
        :href="route('login')"
        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
      >
        Temporary Log in
      </Link>
      <Link
        :href="route('register')"
        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
      >
        Temporary Register
      </Link>
      <div class="landing-page pb-10 container mx-auto px-4">
        <div
          class="relative bg-white rounded-lg overflow-hidden w-full p-3 mx-auto lg:max-w-screen-lg shadow-lg cursor-pointer hover:transform hover:scale-105 transition-transform duration-300 ease-in-out"
          @click="toggleContentCard1"
        >
          <div class="bg-orange-500 p-3 rounded-t-lg">
            <div class="block sm:hidden w-full mb-3 text-center">
              <img
              src="https://res.cloudinary.com/dmebtqdqc/image/upload/v1725349509/z0fggbkffdoccmaxyofl.jpg"
              alt="Image"
                class="w-3/4 h-auto rounded-md mx-auto"
              />
            </div>
            <h2 class="text-lg md:text-xl mb-2 text-white">Want to move something?</h2>
            <h3 class="text-md md:text-lg font-bold text-white">Use BidGo!</h3>
          </div>
          <section class="relative flex flex-wrap p-3 pb-12 rounded-b-lg">
            <div v-if="!showCarousel" class="w-full sm:w-7/12 md:w-1/2 sm:pr-3">
              <hr class="border-t-2 border-gray-400 my-3" />
              <p class="text-sm md:text-base text-black mb-3">
                BidGo is your ultimate solution for moving items. Our platform connects users with drivers who bid for their cargo, ensuring you find the perfect carrier at the best price. Whether you're moving household items, office supplies, or anything in between, BidGo makes it easy and cost-effective.
              </p>
              <transition name="fade">
                <div
                  v-if="showMoreCard1 || isLargeScreen"
                  class="text-sm md:text-base text-black mb-3"
                >
                  Our mission is to simplify the logistics of moving items, offering you a seamless experience from start to finish. With BidGo, you can browse bids from multiple drivers and choose the one that best fits your needs and budget.
                  <button
                  class="continue-btn btn-primary absolute bottom-3 left-3 px-3 py-1 bg-orange-500 text-white hover:bg-orange-700 rounded"
                  @click.stop="goToLogin"
                >
                  Continue
                </button>
                </div>
              </transition>
            </div>
            <div
              v-if="!showCarousel"
              class="hidden sm:block sm:w-5/12 md:w-1/2 text-center relative"
            >
              <div
                class="absolute inset-0 bg-gradient-to-l from-transparent to-white rounded-md"
              ></div>
              <img
                src="https://res.cloudinary.com/dmebtqdqc/image/upload/v1725349509/z0fggbkffdoccmaxyofl.jpg"
                alt="Image"
                class="w-full h-32 md:h-full object-cover rounded-md"
              />
            </div>
          </section>
          <div v-if="showCarousel" ref="carouselRef" class="custom-carousel">
            <div
              v-for="(item, index) in carouselItems"
              :key="index"
              class="carousel-item-custom p-4 bg-orange-500 text-white rounded-lg"
            >
              <div class="text-center">
                <h2 class="text-xl font-bold">{{ item.title }}</h2>
                <p>{{ item.content }}</p>
              </div>
            </div>
          </div>
        </div>

        <div
          class="relative bg-white rounded-lg overflow-hidden w-full p-3 mx-auto lg:max-w-screen-lg shadow-lg cursor-pointer hover:transform hover:scale-105 transition-transform duration-300 ease-in-out mt-4"
          @click="toggleContentCard2"
        >
          <div class="bg-orange-500 p-3 rounded-t-lg">
            <div class="block sm:hidden w-full mb-3 text-center">
              <img
                src="https://res.cloudinary.com/dmebtqdqc/image/upload/v1725349517/r4qkf6teartbb7jadiia.jpg"
                alt="Image"
                class="w-3/4 h-auto rounded-md mx-auto"
              />
            </div>
            <h2 class="text-lg md:text-xl mb-2 text-white font-bold">
              Want to earn extra income while driving?
            </h2>
            <h3 class="text-md md:text-lg text-white">
              Be a BidGo Carrier!
            </h3>
          </div>
          <section class="relative flex flex-wrap p-3 pb-12 rounded-b-lg">
            <div class="w-full sm:w-7/12 md:w-1/2 sm:pr-3">
              <hr class="border-t-2 border-gray-400 my-3" />
              <p class="text-sm md:text-base text-black mb-3">
                A revolutionary platform designed to simplify the process of cargo
                bidding and connect carriers, truckers, and delivery riders with
                lucrative contracts and clients.
              </p>
              <transition name="fade">
                <div
                  v-if="showMoreCard2 || isLargeScreen"
                  class="text-sm md:text-base text-black mb-3"
                >
                  Cargo bidding is a dynamic concept that empowers logistics
                  professionals to compete for contracts by submitting competitive
                  bids or even purchasing available contracts outright. It's a
                  game-changing approach that enables carriers and drivers to
                  maximize their earning potential while offering clients
                  unparalleled flexibility and choice.
                  <div v-if="showMoreCard2 || isLargeScreen">
                    <div>
                        <button
                        class="continue-btn btn-primary absolute bottom-3 left-3 px-3 py-1 bg-orange-500 text-white hover:bg-orange-700 rounded"
                        @click.stop="goToLogin"
                      >
                        Continue
                      </button>
                    </div>
                  </div>
                </div>
              </transition>
            </div>
            <div class="hidden sm:block sm:w-5/12 md:w-1/2 text-center relative">
              <div
                class="absolute inset-0 bg-gradient-to-l from-transparent to-white rounded-md"
              ></div>
              <img
                src="https://res.cloudinary.com/dmebtqdqc/image/upload/v1725349517/r4qkf6teartbb7jadiia.jpg"
                alt="Image"
                class="w-full h-32 md:h-full object-cover rounded-md"
              />
            </div>
          </section>
        </div>
      </div>
    </GuestLayout>
  </template>

  <script setup>
  import { ref, onMounted, onBeforeUnmount} from "vue";
  import GuestLayout from "@/Layouts/GuestLayout.vue";
  import { Head, Link } from "@inertiajs/inertia-vue3";
  import { Inertia } from '@inertiajs/inertia';


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

  const goToLogin = () => {
  Inertia.visit(route('login'));
};

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

  // Define the fetchItems function to fetch data
  const fetchItems = async () => {
    try {
      const response = await fetch("/items"); // Adjust URL based on your route
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      const contentType = response.headers.get("content-type");
      if (contentType && contentType.includes("application/json")) {
        items.value = await response.json();
      } else {
        throw new Error("Response is not JSON");
      }
    } catch (error) {
      console.error("Error fetching items:", error);
    }
  };

  // On mounted hook to initialize actions
  onMounted(async () => {
    // Initial animation after DOM is settled
    if (landingPage.value) {
      setTimeout(() => {
        landingPage.value.classList.add("animate-drop-down");
      }, 0); // Delay slightly to allow rendering
    }

    // Fetch items from the server
    await fetchItems();

    // Check screen size on mount
    checkScreenSize();

    // Add event listener to handle screen resize
    window.addEventListener("resize", checkScreenSize);

    // Remove event listener when component is unmounted
    onBeforeUnmount(() => {
      window.removeEventListener("resize", checkScreenSize);
    });
  });
  </script>

  <style scoped>
  .landing-page {
    padding: 1rem;
  }

  .container {
    max-width: 1200px;
    margin: 0 auto;
  }

  .shadow-lg {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1),
      0 4px 6px -2px rgba(0, 0, 0, 0.05);
  }

  .transition-transform {
    transition: transform 0.3s;
  }

  .transform {
    transform: scale(1);
  }

  .bg-orange-500 {
    background-color: #ed8936;
  }

  .bg-orange-700 {
    background-color: #dd6b20;
  }

  .hover\:bg-orange-700:hover {
    background-color: #dd6b20;
  }

  .hover\:scale-105:hover {
    transform: scale(1.05);
  }

  .bg-gradient-to-l {
    background: linear-gradient(to left, transparent, white);
  }

  .carousel-item-custom {
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .custom-carousel {
    display: flex;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
  }

  .custom-carousel > .carousel-item-custom {
    flex: 0 0 100%;
    scroll-snap-align: start;
  }

  button.continue-btn {
    background-color: #ed8936;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0.25rem;
  }

  button.continue-btn:hover {
    background-color: #dd6b20;
  }
  </style>
