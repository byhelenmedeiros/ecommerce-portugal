<template>
  <input
    type="checkbox"
    :checked="checked"
    @change="$emit('update:checked', $event.target.checked)"
    class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-600"
  />
</template>

<script setup>
defineProps({ checked: Boolean });
</script>
