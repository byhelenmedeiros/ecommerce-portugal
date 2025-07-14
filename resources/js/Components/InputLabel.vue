<template>
  <label :for="for" class="block text-gray-700 text-xs font-semibold mb-1">
    <slot>{{ value }}</slot>
  </label>
</template>

<script setup>
defineProps({
  for: String,
  value: String,
});
</script>
