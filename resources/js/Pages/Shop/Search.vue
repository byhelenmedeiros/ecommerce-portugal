<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { Head } from '@inertiajs/vue3'

const props = defineProps({
  products: {
    type: Object,
    default: () => ({ data: [] })
  },
  query: {
    type: String,
    default: ''
  }
})

 </script>

<template>
  <GuestLayout>
    <Head :title="`Resultados para: ${query}`" />

    <div class="max-w-7xl mx-auto py-10 px-4">
      <h2 class="text-2xl sm:text-3xl font-bold text-green-700 mb-4">
        Resultados para: <span class="text-red-600">"{{ query }}"</span>
      </h2>

      <p class="text-gray-600 text-sm mb-8">
        {{ (products?.data?.length ?? 0) > 0 ? 'Mostrando produtos encontrados:' : 'Nenhum produto encontrado.' }}
      </p>

      <div v-if="products?.data?.length" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <div
          v-for="product in products.data"
          :key="product.id"
          class="group bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition"
        >
          <img
            :src="product.image_url || `https://source.unsplash.com/random/300x200?sig=${product.id}`"
            class="w-full h-40 object-cover"
            :alt="product.name"
          />
          <div class="p-4">
            <h3 class="text-sm font-semibold text-gray-800 group-hover:text-red-600 transition">
              {{ product.name }}
            </h3>
            <p class="text-xs text-gray-500 mt-1">{{ product.category?.name || 'Sem categoria' }}</p>
            <p class="text-green-700 font-bold mt-2">€{{ product.final_price?.toFixed(2) || '0.00' }}</p>
          </div>
        </div>
      </div>

      <div v-else class="text-center text-gray-500 mt-10">
        <p class="text-lg mb-1">Nenhum produto encontrado para <strong>"{{ query }}"</strong>.</p>
        <p class="text-sm">Tente utilizar outras palavras-chave.</p>
      </div>
    </div>
  </GuestLayout>
</template>
