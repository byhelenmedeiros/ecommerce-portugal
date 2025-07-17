<template>
  <GuestLayout>
    <template #default>
      <!-- Breadcrumb -->
      <nav class="text-sm text-gray-500 mb-4 max-w-7xl mx-auto px-4">
        <Link href="/" class="hover:underline text-green-700">Início</Link> /
        <span class="text-gray-600">Produtos</span>
      </nav>

      <section class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        <div class="md:col-span-3">
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <div
      v-for="product in products.data"
      :key="product.id"
      class="bg-white border border-gray-200 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 relative flex flex-col group overflow-hidden"
    >
      <div class="relative">
        <img
          :src="product.image_url"
          alt="Imagem do produto"
          class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
        />

        <!-- Selo Esgotado -->
        <span
          v-if="product.status !== 'disponivel'"
          class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded shadow"
        >
          ESGOTADO
        </span>

        <!-- Selo Promo -->
        <span
          v-if="product.is_promotional"
          class="absolute top-2 right-2 bg-yellow-400 text-white text-xs font-bold px-2 py-0.5 rounded shadow"
        >
          PROMO
        </span>

        <!-- Selo Destaque -->
        <span
          v-else-if="product.is_featured"
          class="absolute top-2 right-2 bg-green-600 text-white text-xs font-bold px-2 py-0.5 rounded shadow"
        >
          Destaque
        </span>
      </div>

      <div class="p-4 flex flex-col justify-between flex-grow">
        <div>
          <h2 class="text-base font-semibold text-gray-800 mb-1 truncate">{{ product.name }}</h2>
          <p class="text-xs text-gray-500 mb-1">{{ product.category?.name }}</p>
          <p class="text-sm text-green-700 font-extrabold">
            €{{ product.final_price ? product.final_price.toFixed(2) : '0.00' }}
          </p>
        </div>

        <div class="mt-4 flex justify-between gap-1">
         
          <button class="btn btn-xs btn-success w-full text-md text-white rounded px-2 py-1  bg-green-600 hover:bg-green-700">
            <font-awesome-icon icon="fa-cart-plus" /> Adicionar ao carrinho
          </button>
          <button
              class="btn btn-xs w-full text-xs"
              :class="isInWishlist(product.id) ? 'bg-red-500 text-white border-red-500' : 'btn-outline text-red-500 border-red-300'"
              @click="toggleWishlist(product)"
            >
              <font-awesome-icon :icon="isInWishlist(product.id) ? 'fa-heart' : ['far', 'heart']" />
            </button>
    </div>
      </div>
    </div>
  </div>

  <!-- Paginação -->
  <div class="mt-10 flex justify-center">
    <Pagination :links="products.links" />
  </div>
</div>

          <!-- Sidebar Filtros -->
          <aside class="md:col-span-1 bg-gray-50 border border-gray-200 p-4 rounded-md sticky top-4 h-fit text-sm shadow-sm">
            <h2 class="text-lg font-semibold text-gray-800 mb-3">Filtrar</h2>

            <form @submit.prevent="applyFilters" class="space-y-4">
              <div>
                <label class="block text-gray-600 mb-1">Nome</label>
                <input v-model="form.name" type="text" class="input input-sm input-bordered w-full" />
              </div>

              <div>
                <label class="block text-gray-600 mb-1">Categoria</label>
                <select v-model="form.category" class="select select-sm select-bordered w-full">
                  <option value="">Todas</option>
                  <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                </select>
              </div>

              <div class="grid grid-cols-2 gap-2">
                <div>
                  <label class="block text-gray-600 mb-1">Preço mín.</label>
                  <input v-model="form.min_price" type="number" min="0" class="input input-sm input-bordered w-full" />
                </div>
                <div>
                  <label class="block text-gray-600 mb-1">Preço máx.</label>
                  <input v-model="form.max_price" type="number" min="0" class="input input-sm input-bordered w-full" />
                </div>
              </div>

              <div>
                <label class="block text-gray-600 mb-1">Ordenar</label>
                <select v-model="form.sort" class="select select-sm select-bordered w-full">
                  <option value="">Padrão</option>
                  <option value="price_asc">Preço: menor → maior</option>
                  <option value="price_desc">Preço: maior → menor</option>
                  <option value="name_asc">Nome: A–Z</option>
                  <option value="name_desc">Nome: Z–A</option>
                </select>
              </div>

              <div class="flex justify-between gap-2 pt-2">
                <button type="button" @click="clearFilters" class="btn btn-sm btn-outline text-xs w-1/2">
                  Limpar
                </button>
                <button type="submit" class="btn btn-sm btn-primary text-xs w-1/2">
                  Filtrar
                </button>
              </div>
            </form>
          </aside>

          <!-- Produtos -->
         
        </div>
      </section>
    </template>
  </GuestLayout>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import Pagination from '@/Shared/Pagination.vue'
import { useWishlist } from '@/stores/cart'
const { toggleWishlist, isInWishlist, wishlist } = useWishlist()
const wishlistCount = wishlist.value.length

const props = defineProps({
  products: Object,
  filters: Object,
  categories: Array
})

const form = useForm({
  name: props.filters.name || '',
  category: props.filters.category || '',
  min_price: props.filters.min_price || '',
  max_price: props.filters.max_price || '',
  sort: props.filters.sort || ''
})

function applyFilters() {
  form.get(route('shop.index'), {
    preserveScroll: true,
    preserveState: true,
  })
}

function clearFilters() {
  form.name = ''
  form.category = ''
  form.min_price = ''
  form.max_price = ''
  form.sort = ''
  applyFilters()
}
</script>
