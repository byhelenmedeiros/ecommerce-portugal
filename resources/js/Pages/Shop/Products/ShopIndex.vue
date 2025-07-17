<template>
  <section class="max-w-7xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold mb-6">Todos os Produtos</h1>

    <!-- Filtros -->
    <form class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8" @submit.prevent="applyFilters">
      <input v-model="form.name" type="text" placeholder="Pesquisar por nome" class="input input-bordered w-full" />

      <select v-model="form.category" class="select select-bordered w-full">
        <option value="">Todas as categorias</option>
        <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
      </select>

      <select v-model="form.region" class="select select-bordered w-full">
        <option value="">Todas as regiões</option>
        <option v-for="reg in regions" :key="reg.id" :value="reg.id">{{ reg.name }}</option>
      </select>

      <button class="btn btn-primary w-full" type="submit">Filtrar</button>
    </form>

    <!-- Produtos -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      <div v-for="product in products.data" :key="product.id" class="border p-4 rounded shadow hover:shadow-md transition">
        <img :src="product.image_url" alt="" class="w-full h-48 object-cover mb-2 rounded" />
        <h2 class="text-lg font-semibold mb-1">{{ product.name }}</h2>
        <p class="text-gray-500 text-sm mb-1">{{ product.category?.name }} · {{ product.region?.name }}</p>
        <p class="text-green-700 font-bold mb-2">€{{ product.final_price.toFixed(2) }}</p>
        <Link :href="`/products/${product.slug}`" class="text-sm text-blue-600 hover:underline">Ver detalhes</Link>
      </div>
    </div>

    <!-- Paginação -->
    <div class="mt-8 flex justify-center">
      <Pagination :links="products.links" />
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'
import { Link, useForm } from '@inertiajs/vue3'
import Pagination from '@/Shared/Pagination.vue'

const props = defineProps({
  products: Object,
  filters: Object,
  categories: Array,
  regions: Array
})

const form = useForm({
  name: props.filters.name || '',
  category: props.filters.category || '',
  region: props.filters.region || ''
})

function applyFilters() {
  form.get(route('shop.index'), {
    preserveScroll: true,
    preserveState: true,
  })
}
</script>
