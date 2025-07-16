<template>
  <div class="mb-2">
    <p class="text-gray-500 text-xs mb-0.5">{{ label }}</p>
    <div class="text-sm text-gray-800">
      <slot>
        {{ value || '—' }}
      </slot>
    </div>
  </div>
</template>

<script setup>
defineProps({
  label: String,
  value: [String, Number, Boolean]
})
</script>
