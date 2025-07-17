<template>
  <div class="bg-white text-neutral-900 bg-neutral-900 text-white">
    <Head title="Alma Minhota - A sua loja de produtos portugueses" />

    <Navbar />
   

    <main class=" mx-auto ">
      <slot />
    </main>
  </div>
   <Footer />
</template>

<script setup>
import Footer from '@/Components/Footer.vue';
import Navbar from '@/Components/Navbar.vue'
</script>
