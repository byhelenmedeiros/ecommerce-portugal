<template>
  <div class="max-w-6xl mx-auto px-2 py-6">
    <h1 class="text-xl font-bold text-gray-800 mb-4">Minha Wishlist</h1>

    <div v-if="wishlist.length > 0" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
      <div
        v-for="item in wishlist"
        :key="item.id"
        class="bg-white shadow rounded-md overflow-hidden hover:shadow-md transition-all text-sm"
      >
        <img :src="item.image_url" :alt="item.name" class="w-full h-36 object-cover" />

        <div class="p-3 space-y-1">
          <h2 class="font-semibold text-gray-800 truncate">{{ item.name }}</h2>

          <div v-if="item.stock === 0" class="text-red-500 font-medium">Esgotado</div>
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
              :disabled="item.stock === 0"
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
import { onMounted, computed } from 'vue'
import { useWishlistStore } from '@/stores/useWishlistStore'

const wishlistStore = useWishlistStore()
const wishlist = computed(() => wishlistStore.wishlist) 

const addToCart = (item) => {
  alert(`Produto "${item.name}" adicionado ao carrinho.`)
}

const removeFromWishlist = async (id) => {
  await wishlistStore.remove(id)
}

// Carregar wishlist ao abrir
onMounted(() => {
  wishlistStore.loadWishlist()
    console.log('wishlist recebida:', wishlist.value)
})
</script>
