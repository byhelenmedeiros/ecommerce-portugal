<template>
  <div class="bg-green-50">
    <!-- Barra principal -->
    <nav class="mx-auto px-4 sm:px-6 lg:px-8 py-2">
      <div class="flex justify-between items-center h-16">
        <!-- Logo + Tagline -->
<div>
  <a href="/" class="flex flex-col leading-none">
    <div class="text-3xl font-extrabold text-red-600 tracking-tight">AlmaMinhota</div>
    <small class="text-xs text-gray-500 -mt-1">Produtos únicos do Norte de Portugal</small>
  </a>
</div>

<!-- Menu principal -->
<div class="hidden md:flex items-center space-x-6">
  <a href="/" class="text-gray-800 hover:text-green-600 transition hover:scale-105 duration-200">
    Início
  </a>
  <a href="/about" class="text-gray-800 hover:text-green-600 transition hover:scale-105 duration-200">
    Sobre Nós
  </a>
  <a href="/contact" class="text-gray-800 hover:text-green-600 transition hover:scale-105 duration-200">
    Contacto
  </a>
</div>

<!-- Ações rápidas com ícones -->
<div class="flex items-center space-x-4 ml-4 text-gray-600">
  <!-- Wishlist -->
  <div class="relative flex items-center">
    <a href="/wishlist" class="hover:text-green-600 transition hover:scale-110">
      <font-awesome-icon :icon="['fas', 'heart']" class="text-lg" />
    </a>
    <span
      v-if="wishlistCount > 0"
      class="absolute -top-1 -right-2 bg-red-600 text-white text-xs font-bold rounded-full px-1.5 py-0.5 shadow"
    >
      {{ wishlistCount }}
    </span>
  </div>

  <!-- Divisor -->
  <div class="w-px h-5 bg-gray-300 opacity-50"></div>

  <!-- Carrinho -->
  <a href="/cart" class="hover:text-green-600 transition hover:scale-110 flex items-center">
    <font-awesome-icon :icon="['fas', 'shopping-cart']" class="text-lg" />
  </a>

  <!-- Divisor -->
  <div class="w-px h-5 bg-gray-300 opacity-50"></div>

  <!-- Login ou Conta -->
  <a
    :href="user ? '/minha-conta' : '/login'"
    class="hover:text-green-600 transition hover:scale-110 flex items-center gap-1"
  >
    <font-awesome-icon :icon="['fas', 'user']" class="text-lg" />
    <span class="text-[11px] text-gray-700 font-medium leading-snug whitespace-nowrap">
      {{ user ? 'Minha conta' : 'Entrar / Registar' }}
    </span>
  </a>
</div>

</div>
    </nav>

    <!-- Barra de categorias + pesquisa -->
    <div class="bg-green-600 text-white">
      <div class=" mx-auto px-6 sm:px-6 lg:px-8 flex justify-between items-center">
        <!-- Menu lateral de categorias -->
      <div class="flex space-x-4 py-3 overflow-x-auto text-sm font-semibold uppercase tracking-wide text-white">
  <a
    href="/shop?cat=vinhos"
    class="px-4 py-2 bg-green-700 hover:bg-red-600 rounded-md shadow-sm transition duration-200 whitespace-nowrap"
  >
    Vinhos
  </a>
  <a
    href="/shop?cat=queijos"
    class="px-4 py-2 bg-green-700 hover:bg-red-600 rounded-md shadow-sm transition duration-200 whitespace-nowrap"
  >
    Queijos
  </a>
  <a
    href="/shop?cat=azeites"
    class="px-4 py-2 bg-green-700 hover:bg-red-600 rounded-md shadow-sm transition duration-200 whitespace-nowrap"
  >
    Azeites
  </a>
  <a
    href="/shop?cat=doces"
    class="px-4 py-2 bg-green-700 hover:bg-red-600 rounded-md shadow-sm transition duration-200 whitespace-nowrap"
  >
    Doces
  </a>
  <a
    href="/shop?cat=artesanato"
    class="px-4 py-2 bg-green-700 hover:bg-red-600 rounded-md shadow-sm transition duration-200 whitespace-nowrap"
  >
    Artesanato
  </a>
</div>


        <!-- Componente de busca (separado) -->
        <SearchBar />
      </div>
    </div>
  </div>
</template>

<script setup>
import SearchBar from '@/Components/SearchBar.vue'
import { usePage } from '@inertiajs/vue3'
import { computed, ref, onMounted } from 'vue'

const user = computed(() => usePage().props.auth?.user)
const wishlistCount = ref(0)

if (user.value) {
  wishlistCount.value = user.value.wishlist_count ?? 0
} else {
  const key = 'wishlist_cache'
  const cached = localStorage.getItem(key)


if (cached) {
  const parsed = JSON.parse(cached)
  const now = Date.now()
  const validade = 4 * 24 * 60 * 60 * 1000

  if (now - parsed.timestamp < validade) {
    wishlistCount.value = parsed.items?.length || 0
  } else {
    localStorage.removeItem(key)
  }
}
  }


</script>
