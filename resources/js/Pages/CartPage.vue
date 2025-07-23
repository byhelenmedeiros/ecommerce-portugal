<template>
  <GuestLayout>
    <section class="max-w-6xl mx-auto px-4 py-10">
      <h1 class="text-2xl font-bold text-gray-800 mb-6">Carrinho de Compras</h1>

      <div v-if="cartCount > 0" class="overflow-x-auto">
        <table class="w-full text-sm text-left border border-gray-200 rounded shadow-sm">
          <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
            <tr>
              <th class="px-4 py-3">Produto</th>
              <th class="px-4 py-3 text-center">Preço</th>
              <th class="px-4 py-3 text-center">Quantidade</th>
              <th class="px-4 py-3 text-center">Subtotal</th>
              <th class="px-4 py-3 text-center">Remover</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in cartStore.cart" :key="item.id">
              <td class="px-4 py-3 flex items-center gap-3">
                <img :src="item.image_url" class="w-12 h-12 object-cover rounded" />
                <span class="font-medium text-gray-800">{{ item.name }}</span>
              </td>
              <td class="px-4 py-3 text-center text-green-700 font-semibold">
                €{{ Number(item.price).toFixed(2) }}
              </td>
              <td class="px-4 py-3 text-center">
                <div class="flex justify-center items-center gap-1">
                  <button @click="decreaseQty(item.id)">−</button>
                  <span class="px-2">{{ item.quantity }}</span>
                  <button @click="increaseQty(item.id)">+</button>
                </div>
              </td>
              <td class="px-4 py-3 text-center font-semibold text-gray-700">
                €{{ (Number(item.price) * item.quantity).toFixed(2) }}
              </td>
              <td class="px-4 py-3 text-center">
                <button @click="removeFromCart(item.id)" class="text-red-500 hover:text-red-700">
                  <font-awesome-icon icon="trash" />
                </button>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Totais -->
        <div class="mt-6 text-right space-y-1">
          <p class="text-sm text-gray-600">
            Produtos no carrinho: <strong>{{ cartCount }}</strong>
          </p>
          <p class="text-lg font-semibold text-gray-800">
            Total: <strong>€{{ cartTotal.toFixed(2) }}</strong>
          </p>
        </div>

        <!-- Ações -->
        <div class="mt-6 flex justify-between items-center">
   <Link
    href="/shop"
    class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded transition duration-200"
  >
    Continuar Comprando
  </Link>

   <Link
    href="/checkout"
    class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded transition duration-200"
  >
    Finalizar Compra
  </Link>
</div>

      </div>

      <div v-else class="text-center text-gray-500">
        <p>O seu carrinho está vazio.</p>
        <Link href="/shop" class="mt-4 inline-block text-green-600 underline">Ir para a loja</Link>
      </div>
    </section>
  </GuestLayout>
</template>
<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { useCart } from '@/stores/cart'
import { computed, onMounted } from 'vue'
import { Link } from '@inertiajs/vue3'

const cartStore = useCart()

const increaseQty = (id) => cartStore.increaseQty(id)
const decreaseQty = (id) => cartStore.decreaseQty(id)
const removeFromCart = (id) => cartStore.removeFromCart(id)

onMounted(() => {
  cartStore.loadCartFromStorage()
})

const cartCount = computed(() =>
  cartStore.cart?.length
    ? cartStore.cart.reduce((sum, item) => sum + Number(item.quantity || 0), 0)
    : 0
)

const cartTotal = computed(() =>
  cartStore.cart?.length
    ? cartStore.cart.reduce((sum, item) => {
      const price = Number(item.price || 0)
      const qty = Number(item.quantity || 0)
      return sum + price * qty
    }, 0)
    : 0
)
</script>
