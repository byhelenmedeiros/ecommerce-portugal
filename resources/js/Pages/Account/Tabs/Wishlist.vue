<template>
  <div class="max-w-6xl mx-auto px-2 ">
    <h1 class="text-xl font-bold text-gray-800 mb-4">Minha Wishlist</h1>

    <div v-if="wishlist.length > 0" class="grid grid-cols-4 sm:grid-cols-4 lg:grid-cols-4 gap-4">
      <div
        v-for="item in wishlist"
        :key="item.id"
        class="bg-white shadow rounded-md overflow-hidden hover:shadow-md transition-all text-sm"
      >
        <img :src="item.image" :alt="item.name" class="w-full h-36 object-cover" />

        <div class="p-3 space-y-1">
          <h2 class="font-semibold text-gray-800 truncate">{{ item.name }}</h2>

          <div v-if="item.out_of_stock" class="text-red-500 font-medium">Esgotado</div>
          <div v-else>
            <p class="font-bold text-green-700">
              € {{ item.price.toFixed(2) }}
              <span
                v-if="item.old_price"
                class="line-through text-gray-400 text-xs ml-1"
              >€ {{ item.old_price.toFixed(2) }}</span>
            </p>
          </div>

          <div class="flex justify-between gap-2 mt-3">
            <button
              @click="addToCart(item)"
              :disabled="item.out_of_stock"
              class="flex-1 py-1 px-2 text-xs rounded bg-green-600 text-white hover:bg-green-700 disabled:opacity-50"
            >
              Carrinho
            </button>
            <button
              @click="removeFromWishlist(item.id)"
              class="flex-1 py-1 px-2 text-xs border border-red-600 text-red-600 rounded hover:bg-red-50"
            >
              Remover
            </button>
          </div>
        </div>
      </div>
    </div>

    <p v-else class="text-gray-500">Ainda não adicionaste produtos à Wishlist.</p>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const wishlist = ref([
  {
    id: 1,
    name: 'Vinho Tinto do Douro',
    price: 19.99,
    old_price: 24.99,
    out_of_stock: false,
    image: 'https://via.placeholder.com/400x300?text=Vinho',
  },
  {
    id: 2,
    name: 'Azeite Biológico Premium',
    price: 11.49,
    old_price: null,
    out_of_stock: true,
    image: 'https://via.placeholder.com/400x300?text=Azeite',
  },
])

const addToCart = (item) => {
  if (item.out_of_stock) return
  alert(`Produto "${item.name}" adicionado ao carrinho.`)
}

const removeFromWishlist = (id) => {
  wishlist.value = wishlist.value.filter((item) => item.id !== id)
}
</script>
