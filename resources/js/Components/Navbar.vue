<template>
  <div class="bg-white">
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
          <a v-for="cat in menuCategories" :key="cat.id" :href="`/shop?cat=${cat.slug}`"
            class="text-gray-800 hover:text-green-600 transition hover:scale-105 duration-200">
            {{ cat.name }}
          </a>
        </div>

        <!-- Ações rápidas com ícones -->
        <div class="flex items-center space-x-2 sm:space-x-3 md:space-x-4 ml-2 sm:ml-3 md:ml-4 text-gray-600">
          <!-- Wishlist -->
          <div class="relative flex items-center">
            <a href="/wishlist" class="hover:text-green-600 transition hover:scale-105 sm:hover:scale-110">
              <font-awesome-icon :icon="['fas', 'heart']" class="text-base sm:text-lg" />
            </a>
            <span v-if="wishlistCount > 0"
              class="absolute -top-1 -right-2 bg-red-600 text-white text-[10px] sm:text-xs font-bold rounded-full px-1 py-0.5 shadow">
              {{ wishlistCount }}
            </span>
          </div>

          <!-- Divisor -->
          <div class="w-px h-4 sm:h-5 bg-gray-300 opacity-50"></div>

          <!-- Carrinho -->
          <div class="relative flex items-center">
            <Link href="/cart" class="hover:text-green-600 transition hover:scale-105 sm:hover:scale-110">
    <font-awesome-icon :icon="['fas', 'shopping-cart']" class="text-4xl text-green-600" />
            </Link>

            <!-- Badge de contador -->
            <span v-if="cartCount > 0"
              class="absolute -top-1 -right-2 w-5 h-5 bg-green-600 text-white text-[10px] sm:text-xs font-bold rounded-full flex items-center justify-center shadow">
              {{ cartCount }}
            </span>
          </div>


          <!-- Divisor -->
          <div class="w-px h-4 sm:h-5 bg-gray-300 opacity-50"></div>

          <!-- Login / Conta -->
          <a :href="user ? '/account' : '/login'"
            class="hover:text-green-600 transition hover:scale-105 sm:hover:scale-110 flex items-center gap-1">
            <font-awesome-icon :icon="['fas', 'user']" class="text-base sm:text-lg" />
            <span class="text-[10px] sm:text-[11px] text-gray-700 font-medium leading-snug whitespace-nowrap">
              {{ user ? 'Minha conta' : 'Entrar / Registar' }}
            </span>
          </a>
        </div>

      </div>
    </nav>

    <!-- Barra de categorias + pesquisa -->
    <div class="bg-green-600 text-white w-full relative">
      <div class="mx-auto px-4 sm:px-6 lg:px-8 py-2">
        <!-- Wrapper principal flexível -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
          <!-- Menu de categorias com fade lateral no mobile -->
          <div class="relative md:flex-1">
            <!-- Fade lateral direita (só no mobile) -->
            <div
              class="absolute right-0 top-0 bottom-0 w-6 bg-gradient-to-l from-green-600 to-transparent z-10 pointer-events-none md:hidden">
            </div>

            <!-- Lista de categorias com scroll horizontal no mobile -->
            <div
              class="flex overflow-x-auto gap-2 py-2 text-sm font-semibold uppercase tracking-wide whitespace-nowrap scroll-smooth">
              <a v-for="cat in categorias" :key="cat.slug" :href="`/shop?cat=${cat.slug}`"
                class="px-4 py-2 bg-green-700 hover:bg-red-600 rounded-md shadow-sm transition duration-200">
                {{ cat.nome }}
              </a>
            </div>
          </div>

          <!-- Barra de pesquisa centralizada no mobile, alinhada à direita no desktop -->
          <div class="w-full md:w-auto md:flex-shrink-0">
            <SearchBar class="w-full md:w-[320px] lg:w-[400px]" />
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script setup>
import SearchBar from '@/Components/SearchBar.vue'
import { usePage } from '@inertiajs/vue3'
import { computed, ref, onMounted } from 'vue'
import { useCart } from '@/stores/cart'
const { cart } = useCart()
const cartCount = computed(() => (Array.isArray(cart.value) ? cart.value.reduce((sum, p) => sum + p.quantity, 0) : 0))


// Usuário logado
const user = computed(() => usePage().props.auth?.user)

// Contador da wishlist
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

// Categorias dinâmicas do menu (ex: vindas de props)
const menuCategories = usePage().props.menuCategories ?? []

// Categorias fixas para a barra verde
const categorias = [
  { nome: 'Vinhos', slug: 'vinhos' },
  { nome: 'Queijos', slug: 'queijos' },
  { nome: 'Azeites', slug: 'azeites' },
  { nome: 'Doces', slug: 'doces' },
  { nome: 'Artesanato', slug: 'artesanato' },
]
</script>
