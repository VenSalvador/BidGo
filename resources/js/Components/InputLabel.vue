<script setup>
const props = defineProps({
    value: {
        type: String,
        required: false
    },
    class: {
        type: String,
        default: ''
    }
});
</script>

<template>
    <label :class="`block font-medium text-sm text-gray-700 ${props.class}`">
        <span v-if="props.value">{{ props.value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
