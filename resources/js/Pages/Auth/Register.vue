<template>
  <GuestLayout>
    <Head title="Register" />

    <form @submit.prevent="submit">
      <div>
        <InputLabel for="name" value="Name" />
        <TextInput
          id="name"
          type="text"
          placeholder="Full Name"
          class="mt-1 block w-full"
          v-model="form.name"
          required
          autofocus
          autocomplete="name"
        />
        <InputError class="mt-2" :message="form.errors.name" />
      </div>

      <div class="mt-4">
        <InputLabel for="email" value="Email" />
        <TextInput
          id="email"
          type="email"
          placeholder="Email"
          class="mt-1 block w-full"
          v-model="form.email"
          required
          autocomplete="username"
        />
        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <div class="mt-4">
        <InputLabel for="number" value="Mobile Number" />
        <TextInput
          id="number"
          type="number"
          placeholder="Mobile Number"
          class="mt-1 block w-full"
          v-model="form.mobile"
          required
        />
        <InputError class="mt-2" :message="form.errors.mobile" />
      </div>

      <div class="mt-4">
        <InputLabel for="province" value="Province" />
        <Multiselect
          id="province"
          v-model="selectedProvince"
          :options="provinces"
          placeholder="Province"
          label="name"
          track-by="id"
          class="mt-1 block w-full"
          required
        />
        <InputError class="mt-2" :message="form.errors.province" />
      </div>

      <div class="mt-4">
        <InputLabel for="postalcode" value="Postal Code" />
        <TextInput
          id="postalcode"
          type="text"
          placeholder="Postal Code"
          class="mt-1 block w-full"
          v-model="form.postalcode"
          required
        />
        <InputError class="mt-2" :message="form.errors.postalcode" />
      </div>

      <div class="mt-4">
        <InputLabel for="password" value="Password" />
        <div class="relative">
          <TextInput
            id="password"
            :type="showPassword ? 'text' : 'password'"
            placeholder="Password"
            class="mt-1 block w-full pr-10"
            v-model="form.password"
            required
            autocomplete="new-password"
          />
          <span
            @click="togglePasswordVisibility"
            class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer"
          >
            <component
              :is="showPassword ? EyeSlashIcon : EyeIcon"
              class="h-5 w-5 text-gray-500"
            />
          </span>
        </div>
        <InputError class="mt-2" :message="form.errors.password" />
      </div>

      <div class="mt-4">
        <InputLabel
          for="password_confirmation"
          value="Confirm Password"
        />
        <div class="relative">
          <TextInput
            id="password_confirmation"
            :type="showPasswordConfirmation ? 'text' : 'password'"
            placeholder="Confirm Password"
            class="mt-1 block w-full pr-10"
            v-model="form.password_confirmation"
            required
            autocomplete="new-password"
          />
          <span
            @click="togglePasswordConfirmationVisibility"
            class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer"
          >
            <component
              :is="showPasswordConfirmation ? EyeSlashIcon : EyeIcon"
              class="h-5 w-5 text-gray-500"
            />
          </span>
        </div>
        <InputError class="mt-2" :message="form.errors.password_confirmation" />
      </div>

      <div class="mt-4">
        <InputLabel for="role" value="Role" />
        <div class="mt-1">
          <label class="inline-flex items-center">
            <input
              type="radio"
              class="form-radio"
              name="role"
              value="Client"
              v-model="form.role"
            />
            <span class="ml-2">Client</span>
          </label>
          <label class="inline-flex items-center ml-4">
            <input
              type="radio"
              class="form-radio"
              name="role"
              value="Carrier"
              v-model="form.role"
            />
            <span class="ml-2">Carrier</span>
          </label>
        </div>
        <InputError class="mt-2" :message="form.errors.role" />
      </div>

      <div class="mt-4">
        <label class="inline-flex items-center">
          <input
            type="checkbox"
            class="form-checkbox"
            id="terms"
            v-model="form.terms"
            required
          />
          <span class="ml-2">
            I agree to the
            <a href="/terms-and-conditions" target="_blank" class="text-blue-600 hover:underline">
              terms and conditions
            </a>.
          </span>
        </label>
        <InputError class="mt-2" :message="form.errors.terms" />
      </div>

      <div class="flex items-center justify-end mt-4">
        <Link
          :href="route('login')"
          class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
          Already have an account?
        </Link>
        <PrimaryButton
          class="ms-4"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Register
        </PrimaryButton>
      </div>
    </form>
  </GuestLayout>
</template>

<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import { ref, onMounted } from "vue";
import { EyeIcon, EyeSlashIcon } from "@heroicons/vue/24/solid";
import Multiselect from "vue-multiselect";

const showPassword = ref(false);
const showPasswordConfirmation = ref(false);

const form = useForm({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
  role: "",
  province: "",
  mobile: "",
  postalcode: "",
  terms: false
});

const togglePasswordVisibility = () => {
  showPassword.value = !showPassword.value;
};

const togglePasswordConfirmationVisibility = () => {
  showPasswordConfirmation.value = !showPasswordConfirmation.value;
};

const provinces = ref([]);
const selectedProvince = ref(null);

const fetchProvinces = async () => {
  try {
    const response = await fetch("/provinces");
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    const data = await response.json();
    provinces.value = data.provinces;
  } catch (error) {
    console.error("Error fetching provinces:", error);
  }
};

onMounted(async () => {
  await fetchProvinces();
});

const submit = () => {
  if (!form.terms) {
    console.error('You must agree to the terms and conditions.');
    return;
  }
  if (selectedProvince.value) {
    form.province = selectedProvince.value.name;  // Set province name
  }
  form.post(route('register'), {
    onSuccess: () => {
      form.reset('password', 'password_confirmation');
    },
    onError: (errors) => {
      console.error('Form submission failed:', errors);
    },
  });
};

</script>

<style>
@import "vue-multiselect/dist/vue-multiselect.css";

.custom-multiselect .multiselect {
  border: 1px solid #d1d5db; /* Tailwind's border-gray-300 */
  border-radius: 0.375rem; /* Tailwind's rounded-md */
  padding: 0.5rem 1rem; /* Tailwind's py-2 px-4 */
  background-color: #ffffff; /* Tailwind's bg-white */
}

.custom-multiselect .multiselect__option--highlight {
  background-color: #f3f4f6; /* Tailwind's bg-gray-100 */
}

.custom-multiselect .multiselect__option--selected {
  background-color: #e5e7eb; /* Tailwind's bg-gray-200 */
}
</style>