<template>
  <GuestLayout>
    <section class="max-w-2xl mx-auto px-4 py-10 space-y-6">
      <h1 class="text-2xl font-bold text-gray-800">Pagamento</h1>

      <div class="bg-white rounded shadow p-6 space-y-6">
        <div>
          <h2 class="text-lg font-semibold mb-2">Resumo do Pedido</h2>
          <ul class="divide-y divide-gray-200 text-sm">
            <li v-for="item in cart" :key="item.id" class="py-2 flex justify-between">
              <span>{{ item.name }} x{{ item.quantity }}</span>
              <span class="text-green-700 font-semibold">€{{ (item.price * item.quantity).toFixed(2) }}</span>
            </li>
          </ul>
          <div class="pt-4 border-t font-bold text-right">
            Total: <span class="text-green-700">€{{ total.toFixed(2) }}</span>
          </div>
        </div>

        <form @submit.prevent="submitPayment" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Método de Pagamento</label>
            <select v-model="paymentMethod" required class="input input-bordered w-full mt-1">
              <option disabled value="">Escolha um método</option>
              <option value="mbway">MB Way</option>
              <option value="multibanco">Multibanco</option>
              <option value="visa">Cartão Visa</option>
              <option value="paypal">PayPal</option>
            </select>
          </div>
          <button type="submit" class="btn bg-green-700 hover:bg-green-800 text-white w-full">
            Confirmar e Pagar
          </button>
        </form>
      </div>
    </section>
  </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { computed, ref } from 'vue'
import { useCart } from '@/stores/cart'
import axios from 'axios'

const { cart } = useCart()
const paymentMethod = ref('')

const total = computed(() =>
  cart.value.reduce((sum, item) => sum + item.price * item.quantity, 0)
)

const submitPayment = () => {
  axios.post('/orders/payment', {
    items: cart.value,
    payment_method: paymentMethod.value,
    total: total.value,
  }).then(() => {
    localStorage.removeItem('cart')
    window.location.href = '/payment/success'
  }).catch(() => {
    alert('Erro no pagamento. Tente novamente.')
  })
}
</script>

<style scoped>
.input {
  @apply border-gray-300 focus:ring-green-600 focus:border-green-600;
}
</style>
