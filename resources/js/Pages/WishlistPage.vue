<template>
  <GuestLayout>
    <section class="max-w-7xl mx-auto px-4 py-10">
      <h1 class="text-2xl font-bold mb-6 flex items-center gap-2">
        <font-awesome-icon icon="fa-heart" class="text-red-500" />
        Meus Favoritos
      </h1>

      <div v-if="wishlist.length === 0" class="text-gray-500 text-center">
        Nenhum produto adicionado à sua lista de desejos.
      </div>

      <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="product in wishlist"
          :key="product.id"
          class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition relative flex flex-col"
        >
          <img :src="product.image_url" alt="" class="w-full h-44 object-cover rounded-t-md" />

          <div class="p-4 flex flex-col justify-between flex-grow">
            <div>
              <h2 class="text-base font-semibold text-black mb-1 truncate">{{ product.name }}</h2>
              <p class="text-xs text-black mb-1">{{ product.category?.name }}</p>
              <p class="text-sm text-green-700 font-extrabold">
                €{{ product.final_price ? product.final_price.toFixed(2) : '0.00' }}
              </p>
            </div>

            <div class="mt-4 flex justify-between gap-1">
              <Link :href="`/products/${product.slug}`" class="btn btn-xs btn-outline w-full text-xs">
                <font-awesome-icon icon="fa-eye" class="mr-1" /> Ver
              </Link>
              <button class="btn btn-xs btn-success w-full text-xs">
                <font-awesome-icon icon="fa-cart-plus" />
              </button>
              <button
                class="btn btn-xs btn-outline w-full text-xs text-red-500 border-red-300"
                @click="toggleWishlist(product)"
              >
                <font-awesome-icon icon="fa-trash" class="mr-1" /> Remover
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>
  </GuestLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { useWishlist } from '@/stores/cart'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

const { wishlist, toggleWishlist } = useWishlist()
</script>
