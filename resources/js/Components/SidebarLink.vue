<template>
  <button
    @click="$emit('select')"
    class="flex items-center px-3 py-2 rounded w-full text-left transition-all duration-200 ease-in-out group"
    :class="[
      active
        ? 'bg-green-600 text-white shadow-sm'
        : 'text-gray-700 hover:bg-gray-100 hover:text-green-700'
    ]"
  >
    <font-awesome-icon
      :icon="['fas', icon]"
      class="mr-2 w-4 h-4 group-hover:scale-110 group-hover:text-green-700 transition-transform duration-200"
    />
    <span class="transition-all duration-200 group-hover:pl-1">{{ label }}</span>
  </button>
</template>

<script setup>
defineProps({
  icon: String,
  label: String,
  active: Boolean,
})
defineEmits(['select'])
</script>
