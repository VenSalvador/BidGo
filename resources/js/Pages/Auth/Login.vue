<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

defineProps({
  canResetPassword: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});

const form = useForm({
  email: "",
  password: "",
  remember: false,
});

const submit = () => {
  form.post(route("login"), {
    onFinish: () => form.reset("password"),
  });
};
</script>

<template>
  <GuestLayout>
    <Head title="Log in" />

    <div
      v-if="status"
      class="flex flex-col items-center justify-center min-h-screen bg-gray-100"
    >
      {{ status }}
    </div>

    <form @submit.prevent="submit">
      <div>
        <InputLabel for="email" value="Email" />

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
        <InputLabel for="password" value="Password" />

        <TextInput
          id="password"
          type="password"
          class="mt-1 block w-full"
          v-model="form.password"
          required
          autocomplete="current-password"
        />

        <InputError class="mt-2" :message="form.errors.password" />
      </div>

      <div class="flex items-center justify-end mb-4">
        <Link
          v-if="canResetPassword"
          :href="route('password.request')"
          class="text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
          Forgot password?
        </Link>
      </div>
      <div>
        <PrimaryButton
          class="h-14 w-full"
          :style="{
            borderRadius: '1.2rem',
            fontSize: '2rem',
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
          <Link :href="route('carrier-dashboard-page')">
            <img src="../../../assets/google-logo.png" alt="Google" class="w-10 h-10"/>
          </Link>
        </div>
        <div class="shrink-0 flex items-center">
          <Link :href="route('dashboard')">
            <img src="../../../assets/fb-logo.png" alt="Facebook" class="w-10 h-10"/>
          </Link>
        </div>
      </div>
    </form>
  </GuestLayout>
</template>
