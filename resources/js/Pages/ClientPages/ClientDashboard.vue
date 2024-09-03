<template>
        <Head title="Dashboard client" />
        <component :is="AddItemComponent" />
</template>
<script setup>
import { defineAsyncComponent } from 'vue'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

const AddItemComponent = defineAsyncComponent(() =>
  import('../CarrierPages/AddItem2.vue')
)
</script>
