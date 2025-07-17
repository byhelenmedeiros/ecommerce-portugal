<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import HeroSection from '@/Components/HeroSection.vue'
import Category from '@/Components/Category.vue'
import Bestselling from '@/Components/Bestselling.vue'
import Cta_home from '@/Components/Cta_home.vue'
import InfoBanner from '@/Components/InfoBanner.vue'
</script>

<template>
  
  <GuestLayout>
    <HeroSection />
    <Category />
       <InfoBanner />
    <Bestselling />
    <Cta_home />
 
  </GuestLayout>
</template>
