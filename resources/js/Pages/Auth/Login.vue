<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

import { EyeIcon, EyeSlashIcon } from "@heroicons/vue/24/solid";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link } from "@inertiajs/vue3";

const showPassword = ref(false);
const form = useForm({
  email: "",
  password: "",
  remember: false,
});

const togglePasswordVisibility = () => {
  showPassword.value = !showPassword.value;
};

const submit = () => {
  form.post(route("login"), {
    onSuccess: () => {
      // Determine the redirection based on user role
      if (form.user.role === 'Client') {
        route('client-dashboard').visit(); // Replace with your user dashboard route
      } else if (form.user.role === 'Carrier') {
        route('carrier-dashboard').visit(); // Replace with your carrier dashboard route
      } else {
        route('register').visit(); // Default dashboard route if role is unknown
      }
    },
    onFinish: () => form.reset("password"),
  });
};

const props = defineProps({
  canResetPassword: Boolean,
  status: String,
});
</script>

<template>
  <GuestLayout>
    <Head title="Log in" />

    <div
      v-if="props.status"
      class="flex flex-col items-center justify-center min-h-screen bg-gray-100"
    >
      {{ props.status }}
    </div>

    <form @submit.prevent="submit">
      <div>
        <InputLabel for="email" value="Email" class="text-xl" />

        <TextInput
          id="email"
          type="email"
          class="mt-1 block w-full"
          v-model="form.email"
          required
          autofocus
          autocomplete="username"
        />

        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <div class="mt-4">
        <InputLabel for="password" value="Password" class="text-xl"/>

        <div class="relative">
          <TextInput
            id="password"
            :type="showPassword ? 'text' : 'password'"
            class="mt-1 block w-full pr-10"
            v-model="form.password"
            required
            autocomplete="current-password"
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

      <div class="flex items-center justify-end mb-4 mt-2 text-xl">
        <Link
          v-if="props.canResetPassword"
          :href="route('password.request')"
          class="text-md text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
          Forgot password?
        </Link>
      </div>
      <div>
        <PrimaryButton
          class="h-14 w-full"
          :style="{
            borderRadius: '1.2rem',
            fontSize: '1.75rem',
            padding: '0.75rem 1.5rem',
          }"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Sign in
        </PrimaryButton>
      </div>
      <div class="relative my-4">
        <div class="absolute inset-0 flex items-center">
          <div class="w-full border-t border-gray-300"></div>
        </div>
        <div class="relative flex justify-center text-sm">
          <span class="px-2 text-gray-500">OR</span>
        </div>
      </div>
      <div class="flex justify-center space-x-4 mt-4">
        <div class="shrink-0 flex items-center">
          <Link :href="route('dashboard')">
            <img
              src="../../../assets/google-logo.png"
              alt="Google"
              class="w-10 h-10"
            />
          </Link>
        </div>
        <div class="shrink-0 flex items-center">
          <Link :href="route('dashboard')">
            <img
              src="../../../assets/fb-logo.png"
              alt="Facebook"
              class="w-10 h-10"
            />
          </Link>
        </div>
      </div>
      <div class="flex items-center justify-center mb-4 pt-5">
        <InputLabel class="text-xl">
          Don't have an account yet?
          <Link :href="route('register')" class="underline">SIGN UP</Link>
        </InputLabel>
      </div>
    </form>
  </GuestLayout>
</template>
