<template>
  <div>
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Morada</h1>
    <p><strong>Morada:</strong> {{ profile?.address }}</p>
    <p><strong>Cidade:</strong> {{ profile?.city }}</p>
    <p><strong>Código Postal:</strong> {{ profile?.postal_code }}</p>
    <p><strong>País:</strong> {{ profile?.country }}</p>
  </div>
</template>

<script setup>
const props = defineProps({
  profile: Object
})
</script>
