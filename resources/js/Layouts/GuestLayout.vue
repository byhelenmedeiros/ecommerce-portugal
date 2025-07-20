<template>
  <div class="bg-white text-neutral-900">
    <Head title="Alma Minhota - A sua loja de produtos portugueses" />

    <Navbar />

    <main class="w-full max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8">
      <slot />
    </main>

    <Footer />
  </div>
</template>

<script setup>
import Footer from '@/Components/Footer.vue';
import Navbar from '@/Components/Navbar.vue';
</script>
