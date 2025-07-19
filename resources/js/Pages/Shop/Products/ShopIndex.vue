<template>
  <GuestLayout>
    <template #default>
      <!-- Breadcrumb -->
      <nav class="text-sm text-gray-500  max-w-7xl mx-auto py-3 px-4">
        <Link href="/" class="hover:underline text-green-700">Início</Link> /
        <span class="text-gray-600">Produtos</span>
      </nav>

      <section class="max-w-7xl mx-auto px-2">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

       <div class="md:col-span-3">
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <div
      v-for="product in products.data"
      :key="product.id"
      class="bg-white border border-gray-200 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 relative flex flex-col group overflow-hidden"
    >
      <!-- Imagem do produto com Wishlist no topo -->
      <div class="relative">
        <img
          :src="product.image_url"
          alt="Imagem do produto"
          class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
        />

        <!-- Wishlist no canto superior direito -->
        <button
          @click="toggleWishlist(product)"
          class="absolute top-2 right-2 bg-white rounded-full p-1 shadow-sm hover:shadow-md transition z-10"
        >
          <font-awesome-icon
            :icon="isInWishlist(product.id) ? 'fa-heart' : ['far', 'heart']"
            class="text-red-500 text-sm"
          />
        </button>

        <!-- Badge da categoria -->
        <span
          class="absolute top-2 left-2 bg-gray-100 text-gray-800 text-[10px] font-semibold px-2 py-0.5 rounded shadow-sm uppercase tracking-wide"
        >
          {{ product.category?.name || 'Sem categoria' }}
        </span>
      </div>

      <!-- Conteúdo do card -->
      <div class="p-3 flex flex-col justify-between flex-grow">
        <div>
          <h2 class="text-sm font-semibold text-gray-800 mb-1 truncate">{{ product.name }}</h2>
          <p class="text-sm text-green-700 font-bold">
            €{{ product.final_price ? product.final_price.toFixed(2) : '0.00' }}
          </p>
        </div>

     <!-- Quantidade + Comprar -->
<div class="mt-3 flex items-center gap-2">
  <!-- Contador horizontal elegante -->
  <div class="flex items-center border border-gray-300 rounded-md px-1">
    <button
      type="button"
      @click="decreaseQty(product.id)"
      class="px-1 py-1 text-gray-500 hover:text-green-600 text-[10px]"
    >
      <font-awesome-icon icon="minus" />
    </button>

    <span class="px-2 text-xs text-gray-700 w-6 text-center font-medium select-none">
      {{ getLocalQuantity(product.id) }}
    </span>

    <button
      type="button"
      @click="increaseQty(product.id)"
      class="px-1 text-gray-500 hover:text-green-600 text-[10px]"
    >
      <font-awesome-icon icon="plus" />
    </button>
  </div>

  <!-- Botão Comprar mais discreto -->
  <button
    class="btn btn-xs flex-1 text-white bg-green-600 hover:bg-green-700 text-xs rounded-md h-8 flex items-center justify-center gap-1"
    @click="addToCart(product, getLocalQuantity(product.id))"
  >
    <font-awesome-icon icon="fa-cart-plus" />
    Comprar
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

          <aside class="md:col-span-1  sticky top-4  overflow-x shadow-sm">
            <h2 class="text-sm font-semibold text-gray-800 mb-2">Filtrar</h2>

            <!-- Scroll interno -->
            <div class="overflow-y-auto h-full pr-1 text-xs space-y-3">
              <form @submit.prevent="applyFilters" class="space-y-3 pb-4">
                <!-- Nome -->
                <div>
                  <label class="block text-gray-600 mb-1">Nome</label>
                  <input v-model="form.name" type="text"
                    class="w-full px-2 py-1 rounded-md border border-gray-300 text-xs focus:ring-green-500 focus:border-green-500" />
                </div>

                <!-- Categoria -->
                <div>
                  <label class="block text-gray-600 mb-1">Categoria</label>
                  <div class="divide-y divide-gray-200 border rounded-md  ">
                    <button type="button" @click="form.category = ''" :class="[
                      'w-full text-left px-3 py-1 text-xs hover:bg-green-50 transition',
                      form.category === '' ? 'bg-green-100 font-semibold text-green-800' : 'text-gray-700'
                    ]">
                      Todas
                    </button>
                    <button v-for="cat in categories" :key="cat.id" type="button" @click="form.category = cat.id"
                      :class="[
                        'w-full text-left px-3 py-1 text-xs hover:bg-green-50 transition',
                        form.category === cat.id ? 'bg-green-100 font-semibold text-green-800' : 'text-gray-700'
                      ]">
                      {{ cat.name }}
                    </button>
                  </div>
                </div>


                <!-- Preço -->
                <div>
                  <label class="block text-gray-600 mb-1">Filtrar por Preço</label>
                  <div class="grid grid-cols-2 gap-1">
                    <div>
                      <label class="block text-gray-500 text-[10px] mb-0.5">Mínimo</label>
                      <input v-model="form.min_price" type="number" min="0"
                        class="w-full px-2 py-1 rounded-md border border-gray-300 text-xs" />
                    </div>
                    <div>
                      <label class="block text-gray-500 text-[10px] mb-0.5">Máximo</label>
                      <input v-model="form.max_price" type="number" min="0"
                        class="w-full px-2 py-1 rounded-md border border-gray-300 text-xs" />
                    </div>
                  </div>
                </div>

                <!-- Estoque -->
                <div>
                  <label class="block text-gray-600 mb-1">Estoque</label>
                  <div class="space-y-1">
                    <label class="flex items-center gap-2 text-gray-700 text-[11px]">
                      <input type="checkbox" v-model="form.in_stock" class="checkbox checkbox-xs" />
                      Com estoque
                    </label>
                    <label class="flex items-center gap-2 text-gray-700 text-[11px]">
                      <input type="checkbox" v-model="form.out_of_stock" class="checkbox checkbox-xs" />
                      Sem estoque
                    </label>
                  </div>
                </div>

                <!-- Ordenar -->
                <div>
                  <label class="block text-gray-600 mb-1">Ordenar</label>
                  <select v-model="form.sort"
                    class="w-full px-2 py-1 rounded-md border border-gray-300 text-xs text-gray-700 bg-white">
                    <option value="">Padrão</option>
                    <option value="price_asc">Preço: menor → maior</option>
                    <option value="price_desc">Preço: maior → menor</option>
                    <option value="name_asc">Nome: A–Z</option>
                    <option value="name_desc">Nome: Z–A</option>
                  </select>

                </div>

                <!-- Botões -->
                <div class="flex justify-between gap-2 pt-1">
                  <button type="button" @click="clearFilters" class="btn btn-xs btn-outline w-1/2">
                    Limpar
                  </button>
                  <button type="submit" class="btn btn-xs btn-primary w-1/2">
                    Filtrar
                  </button>
                </div>
              </form>
            </div>
          </aside>



          <!-- Produtos -->

        </div>
      </section>
    </template>
  </GuestLayout>
</template>
<script setup>
import { reactive } from 'vue'
import { Link, useForm } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import Pagination from '@/Shared/Pagination.vue'

// Props
const props = defineProps({
  products: Object,
  filters: Object,
  categories: Array,
  auth: Object // ← usado para verificar se o utilizador está autenticado
})

// Stores
import { useCart } from '@/stores/cart'
import { useWishlistStore } from '@/stores/useWishlistStore'

const { addToCart } = useCart()
const wishlistStore = useWishlistStore()

const { wishlist, add, remove, has } = wishlistStore

// Quantidades locais
const quantities = reactive({})
const getLocalQuantity = (id) => quantities[id] ?? 1
const increaseQty = (id) => quantities[id] = getLocalQuantity(id) + 1
const decreaseQty = (id) => { if (getLocalQuantity(id) > 1) quantities[id] -= 1 }

// Wishlist toggle com verificação de login
const toggleWishlist = async (product) => {
  if (!props.auth?.user) {
    alert('Precisas de iniciar sessão para usar a lista de favoritos.')
    return
  }

  if (has(product.id)) {
    await remove(product.id)
  } else {
    await add(product)
  }
}

const isInWishlist = (id) => has(id)

// Filtros
const form = useForm({
  name: '',
  category: '',
  min_price: '',
  max_price: '',
  sort: '',
  in_stock: false,
  out_of_stock: false,
})

const applyFilters = () => {
  form.get(route('shop.index'), {
    preserveScroll: true,
    preserveState: true,
  })
}

const clearFilters = () => {
  Object.assign(form, {
    name: '',
    category: '',
    min_price: '',
    max_price: '',
    sort: '',
    in_stock: false,
    out_of_stock: false,
  })
  applyFilters()
}
</script>
