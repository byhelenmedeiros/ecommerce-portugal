<template>
  <div class="bg-white border-b border-gray-200 shadow-sm">
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
<div class="flex items-center space-x-4 ml-4">
  <!-- Wishlist -->
  <div class="relative">
    <a href="/wishlist" class="text-gray-600 hover:text-green-600 transition hover:scale-110">
      <font-awesome-icon :icon="['fas', 'heart']" class="text-lg" />
    </a>

    <!-- Badge vermelha -->
    <span
      v-if="wishlistCount > 0"
      class="absolute -top-1 -right-2 bg-red-600 text-white text-xs font-bold rounded-full px-1.5 py-0.5 shadow"
    >
      {{ wishlistCount }}
    </span>
  </div>

  <!-- Carrinho -->
  <a href="/cart" class="text-gray-600 hover:text-green-600 transition hover:scale-110">
    <font-awesome-icon :icon="['fas', 'shopping-cart']" class="text-lg" />
  </a>
<a
  :href="user ? '/minha-conta' : '/login'"
  class="flex items-center gap-1 text-gray-600 hover:text-green-600 transition hover:scale-110"
>
  <font-awesome-icon :icon="['fas', 'user']" class="text-lg" />
  <span class="text-[11px] font-medium">
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
        <div class="flex space-x-4 py-2 overflow-x-auto text-sm font-medium">
          <a href="/shop?cat=vinhos" class="px-3 py-1 hover:bg-red-600 transition">Vinhos</a>
          <a href="/shop?cat=queijos" class="px-3 py-1 hover:bg-red-600 transition">Queijos</a>
          <a href="/shop?cat=azeites" class="px-3 py-1 hover:bg-red-600 transition">Azeites</a>
          <a href="/shop?cat=doces" class="px-3 py-1 hover:bg-red-600 transition">Doces</a>
          <a href="/shop?cat=artesanato" class="px-3 py-1 hover:bg-red-600 transition">Artesanato</a>
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

    // Validade: 4 dias
    const validade = 4 * 24 * 60 * 60 * 1000

    if (now - parsed.timestamp < validade) {
      wishlistCount.value = parsed.items?.length || 0
    } else {
      localStorage.removeItem(key)
    }
  }
}

</script>
