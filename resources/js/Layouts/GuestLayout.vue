<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link, Head } from '@inertiajs/vue3';
</script>

<template>
    <Head>
      <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
      <!-- Other meta tags -->
    </Head>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0" :style="{ backgroundColor: '#EEF4ED' }">
        <div>
            <Link href="/">
                <ApplicationLogo class="w-40 h-40 fill-current text-gray-500" :style="{ backgroundColor: '#EEF4ED' }"/>
            </Link>
        </div>


            <slot />

    </div>
</template>
