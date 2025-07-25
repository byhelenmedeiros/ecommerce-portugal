<template>
  <GuestLayout>
    <section class="max-w-xl mx-auto px-4 py-20 text-center space-y-6">
      <div class="bg-white rounded shadow p-8">
        <svg
          class="mx-auto mb-4 w-16 h-16 text-green-600"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M9 12l2 2 4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z"
          ></path>
        </svg>

        <h1 class="text-2xl font-bold text-gray-800 mb-2">Pedido Confirmado!</h1>
        <p class="text-gray-600">Obrigado pela sua compra. Um email de confirmação foi enviado e em breve receberá o seu pedido.</p>

        <div class="mt-6 flex flex-col sm:flex-row justify-center gap-4">
          <Link href="/shop" class="btn btn-outline">Voltar para Loja</Link>
          <Link href="/account/orders" class="btn btn-primary">Ver os Meus Pedidos</Link>
        </div>
      </div>
    </section>
  </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { Link } from '@inertiajs/vue3'
</script>

<style scoped>
.btn {
  @apply px-4 py-2 rounded font-medium transition;
}
.btn-outline {
  @apply border border-green-700 text-green-700 hover:bg-green-100;
}
.btn-primary {
  @apply bg-green-700 text-white hover:bg-green-800;
}
</style>
