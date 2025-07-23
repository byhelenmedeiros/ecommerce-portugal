<template>
  <GuestLayout>
    <section class="max-w-xl mx-auto text-center px-4 py-16">
      <h1 class="text-3xl font-bold text-green-700 mb-4">Pedido Confirmado!</h1>
      <p class="text-gray-600 mb-6">
        Obrigado pela sua compra. Em breve receberá um e-mail com os detalhes do pedido.
      </p>
      <Link href="/shop" class="btn btn-outline">Continuar Comprando</Link>
    </section>
  </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { Link } from '@inertiajs/vue3'
</script>
