<template>
  <div class="min-h-screen bg-white text-neutral-900 bg-neutral-900 text-white">
    <Navbar />

    <main class="max-w-7xl mx-auto px-4 py-6">
      <slot />
    </main>
  </div>
</template>

<script setup>
import Navbar from '@/Components/Navbar.vue'
</script>
