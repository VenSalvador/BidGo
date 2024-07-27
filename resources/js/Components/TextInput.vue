<script setup>
import { ref, defineProps, defineEmits, onMounted } from 'vue';

// Define props, allowing modelValue to be of any type but using String internally
const props = defineProps({
  modelValue: {
    type: [String, Number],
    required: true,
  },
});

const emit = defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
  if (input.value && input.value.hasAttribute('autofocus')) {
    input.value.focus();
  }
});

function updateValue(event) {
  emit('update:modelValue', event.target.value);
}

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
  <input
    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
    :value="modelValue"
    @input="updateValue"
    ref="input"
  />
</template>
