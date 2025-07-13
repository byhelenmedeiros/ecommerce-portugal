<template>
  <div class="bg-white text-neutral-900 bg-neutral-900 text-white">
    <Navbar />

    <main class=" mx-auto ">
      <slot />
    </main>
  </div>
</template>

<script setup>
import Navbar from '@/Components/Navbar.vue'
</script>
