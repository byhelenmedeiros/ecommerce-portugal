<template>
  <input
    class="border-gray-300 focus:border-green-600 focus:ring-green-600 rounded-md shadow-sm text-gray-900"
    v-bind="$attrs"
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
  />
</template>

<script setup>
defineProps(['modelValue']);
</script>
