<template>
  <label class="block font-medium text-sm text-gray-700" :for="for">
    <slot />
  </label>
</template>

<script setup>
defineProps({ for: String });
</script>
