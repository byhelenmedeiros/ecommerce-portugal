<template>
  <div class="bg-white">
    <!-- Nav principal -->
    <nav class="w-full max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 py-2">
      <div class="flex justify-between items-center h-16">
        <div>
          <a href="/" class="flex flex-col leading-none">
            <div class="text-3xl font-extrabold text-red-600 tracking-tight">AlmaMinhota</div>
            <small class="text-xs text-gray-500 -mt-1">Produtos únicos do Norte de Portugal</small>
          </a>
        </div>

        <div class="hidden md:flex items-center space-x-6">
          <a
            v-for="cat in menuCategories"
            :key="cat.id"
            :href="`/shop?cat=${cat.slug}`"
            class="text-gray-800 hover:text-red-600 hover:underline underline-offset-4 transition duration-200 uppercase font-bold text-xs tracking-wide"
          >
            {{ cat.name }}
          </a>
        </div>

        <div class="flex items-center gap-6 text-gray-700 text-sm">
          <!-- Wishlist -->
          <div class="relative group">
            <a
              :href="user ? '/wishlist' : '/login'"
              class="relative flex flex-col items-center justify-center hover:text-pink-600 transition-transform duration-200 transform hover:scale-110"
            >
              <FontAwesomeIcon :icon="['fas', 'heart']" class="text-2xl sm:text-2xl drop-shadow-sm" />
              <span class="text-[10px] sm:text-xs mt-1 font-medium">
                {{ user ? 'Wishlist' : 'Login' }}
              </span>
              <span
                v-if="user && wishlistCount > 0"
                class="absolute -top-2 -right-2 w-5 h-5 bg-pink-600 text-white text-[10px] sm:text-xs font-bold rounded-full flex items-center justify-center shadow-md"
              >
                {{ wishlistCount }}
              </span>
            </a>
          </div>

          <!-- Carrinho -->
          <div class="relative group">
            <Link
              :href="user ? '/cart' : '/login'"
              class="relative flex flex-col items-center justify-center hover:text-green-600 transition-transform duration-200 transform hover:scale-110"
            >
              <FontAwesomeIcon :icon="['fas', 'shopping-cart']" class="text-2xl sm:text-2xl drop-shadow-sm" />
              <span class="text-[10px] sm:text-xs mt-1 font-medium">
                {{ user ? 'Carrinho' : 'Login' }}
              </span>
              <span
                v-if="user && cartCount > 0"
                class="absolute -top-2 -right-2 w-5 h-5 bg-green-600 text-white text-[10px] sm:text-xs font-bold rounded-full flex items-center justify-center shadow-md"
              >
                {{ cartCount }}
              </span>
            </Link>
          </div>

          <!-- Conta -->
          <div class="relative group">
            <a
              :href="user ? '/account' : '/login'"
              class="relative flex flex-col items-center justify-center hover:text-blue-600 transition-transform duration-200 transform hover:scale-110"
            >
              <FontAwesomeIcon :icon="['fas', 'user']" class="text-2xl sm:text-2xl drop-shadow-sm" />
              <span class="text-[10px] sm:text-xs mt-1 font-medium">
                {{ user ? 'Conta' : 'Login' }}
              </span>
            </a>
          </div>
        </div>
      </div>
    </nav>

    <!-- Subcategorias + pesquisa -->
    <div class="w-full border-t border-b border-gray-200 bg-white">
      <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 py-1">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
          <div class="relative md:flex-1">
            <div class="absolute right-0 top-0 bottom-0 w-6 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none md:hidden"></div>

            <div class="flex overflow-x-auto gap-1.5 sm:gap-2 py-1 text-[11px] sm:text-xs font-bold tracking-wide uppercase whitespace-nowrap scroll-smooth no-scrollbar">
              <a
                v-for="sub in subcategories.slice(0, 7)"
                :key="sub.slug"
                :href="`/shop?cat=${sub.slug}`"
                class="px-2 py-1.5 sm:px-3 sm:py-1.5 text-gray-700 hover:text-red-600 hover:underline underline-offset-4 rounded transition-all duration-200 hover:scale-[1.02] active:scale-[0.96]"
              >
                {{ sub.name }}
              </a>
            </div>
          </div>

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
import { computed, ref } from 'vue'
import { useCart } from '@/stores/cart'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const subcategories = page.props.subcategories ?? []
const menuCategories = page.props.menuCategories ?? []
const user = page.props.auth?.user ?? null

const { cart } = useCart()
const cartCount = computed(() =>
  Array.isArray(cart.value)
    ? cart.value.reduce((sum, p) => sum + p.quantity, 0)
    : 0
)

const wishlistCount = ref(0)
if (user) {
  wishlistCount.value = user.wishlist_count ?? 0
} else {
  const cached = localStorage.getItem('wishlist_cache')
  if (cached) {
    const parsed = JSON.parse(cached)
    const now = Date.now()
    const validade = 4 * 24 * 60 * 60 * 1000
    if (now - parsed.timestamp < validade) {
      wishlistCount.value = parsed.items?.length || 0
    } else {
      localStorage.removeItem('wishlist_cache')
    }
  }
}
</script>
