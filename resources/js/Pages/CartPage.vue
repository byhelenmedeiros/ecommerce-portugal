<template>
  <section class="max-w-6xl mx-auto px-4 py-10">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Carrinho de Compras</h1>

    <div v-if="cart.length > 0" class="overflow-x-auto">
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
          <tr v-for="item in cart" :key="item.id" class="border-t">
            <td class="flex items-center gap-4 px-4 py-3">
              <img :src="item.image_url" alt="" class="w-16 h-16 object-cover rounded" />
              <div>
                <p class="font-semibold text-black">{{ item.name }}</p>
                <p class="text-xs text-gray-500">{{ item.category?.name }}</p>
              </div>
            </td>
            <td class="text-center text-black font-medium">€{{ item.final_price.toFixed(2) }}</td>
            <td class="text-center">
              <input
                v-model.number="item.quantity"
                type="number"
                min="1"
                class="input input-sm input-bordered w-16 text-center"
              />
            </td>
            <td class="text-center text-black font-semibold">
              €{{ (item.quantity * item.final_price).toFixed(2) }}
            </td>
            <td class="text-center">
              <button @click="removeFromCart(item.id)" class="btn btn-xs btn-error text-white">
                <font-awesome-icon icon="fa-trash" />
              </button>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Totais -->
      <div class="flex justify-end mt-6">
        <div class="w-full max-w-sm bg-gray-50 border rounded p-4 shadow">
          <h2 class="text-lg font-bold text-gray-800 mb-3">Resumo</h2>
          <div class="flex justify-between text-sm mb-2">
            <span class="text-gray-600">Subtotal</span>
            <span class="text-black font-semibold">€{{ total.toFixed(2) }}</span>
          </div>
          <div class="flex justify-end gap-3 mt-4">
            <Link href="/shop" class="btn btn-outline btn-sm">Continuar comprando</Link>
            <button class="btn btn-primary btn-sm">Finalizar compra</button>
          </div>
        </div>
      </div>
    </div>

    <div v-else class="text-center py-16">
      <font-awesome-icon icon="fa-cart-shopping" class="text-4xl text-gray-400 mb-4" />
      <p class="text-gray-500">O seu carrinho está vazio.</p>
      <Link href="/shop" class="mt-4 inline-block text-sm btn btn-outline">
        Voltar para a loja
      </Link>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import { useCart } from '@/stores/cart'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

const { cart, removeFromCart } = useCart()

const total = computed(() =>
  cart.value.reduce((sum, item) => sum + item.final_price * item.quantity, 0)
)
</script>

