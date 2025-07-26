<template>
  <Head />
  <slot />
  <GuestLayout>
    <section class="max-w-6xl mx-auto px-6 py-10 space-y-10">
      <h1 class="text-3xl font-bold text-gray-800 mb-4">Finalizar Compra</h1>

      <!-- Breadcrumbs -->
      <nav class="text-sm text-gray-500 mb-6">
        <ol class="flex space-x-2">
          <li><Link :href="route('cart')" class="text-green-700 hover:underline">Carrinho</Link></li>
          <li>/</li>
          <li :class="step >= 1 ? 'text-green-700 font-semibold' : 'text-gray-400'">Checkout</li>
          <li>/</li>
          <li :class="step === 2 ? 'text-green-700 font-semibold' : 'text-gray-400'">Pagamento</li>
        </ol>
      </nav>

      <!-- Conteúdo -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 bg-white p-8 rounded shadow">
        <!-- Formulário -->
        <div>
          <!-- Etapa 1: Morada -->
          <div v-if="step === 1">
            <h2 class="text-xl font-semibold mb-4">Morada de Entrega</h2>
            <form @submit.prevent="salvarMoradas" class="space-y-4">
              <div>
                <label class="block text-sm font-medium">Rua</label>
                <input v-model="form.address" type="text" required class="input w-full" />
              </div>
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium">Código Postal</label>
                  <input v-model="form.postal_code" type="text" required class="input w-full" />
                </div>
                <div>
                  <label class="block text-sm font-medium">Cidade</label>
                  <input v-model="form.city" type="text" required class="input w-full" />
                </div>
              </div>
              <div class="flex justify-end pt-6">
                <button type="submit" class="btn bg-green-600 text-white w-full rounded-full">Guardar e Continuar</button>
              </div>
            </form>
          </div>

          <!-- Etapa 2: Stripe Elements -->
          <div v-else-if="step === 2">
            <h2 class="text-xl font-semibold mb-4">Pagamento</h2>
            <!-- Sempre renderiza o container para Stripe -->
            <div ref="cardEl" class="border p-4 rounded mb-4">
              <div v-if="!stripeLoaded" class="text-gray-500">Carregando pagamento seguro...</div>
            </div>
            <!-- Botão após carregar Stripe -->
            <button
    class="btn bg-green-700 hover:bg-green-800 text-white w-full rounded-full mt-4"
    :disabled="!stripeLoaded || loading"
    @click="handlePayment"
  >
    <span v-if="!loading">Pagar €{{ total.toFixed(2) }}</span>
    <span v-else>Processando…</span>
  </button>
          </div>
        </div>

        <!-- Resumo do Pedido -->
        <div>
          <h2 class="text-xl font-semibold mb-4">Resumo do Pedido</h2>
          <ul class="divide-y divide-gray-200 text-sm">
            <li v-for="item in cart" :key="item.id" class="py-3 flex justify-between">
              <span>{{ item.name }} x{{ item.quantity }}</span>
              <span class="text-green-700">€{{ (item.price * item.quantity).toFixed(2) }}</span>
            </li>
          </ul>
          <div class="pt-6 border-t font-bold text-right">Total: €{{ total.toFixed(2) }}</div>
        </div>
      </div>
    </section>
  </GuestLayout>
</template>
 
<script setup>
import { Link, useForm, usePage, router, Head } from '@inertiajs/vue3'
import { ref, computed, watch, nextTick } from 'vue'
import { useCart } from '@/stores/cart'
import { loadStripe } from '@stripe/stripe-js'
import axios from 'axios'
import GuestLayout from '@/Layouts/GuestLayout.vue'

// Props
const { auth, order } = usePage().props

// Cart
const cartStore = useCart()
cartStore.loadCartFromStorage()
const cart = computed(() => cartStore.cart)
const total = computed(() => cart.value.reduce((sum, i) => sum + i.price * i.quantity, 0))

// Step control
const step = ref(order ? 2 : 1)

// Address form data
const form = useForm({
  address: auth.user?.morada_entrega || '',
  postal_code: auth.user?.postal_code || '',
  city: auth.user?.city || '',
  items: cart.value.map(i => ({ id: i.id, quantity: i.quantity, price: i.price }))
})
function salvarMoradas() {
  step.value = 2
}

// Stripe state
const stripeLoaded = ref(false)
const stripe = ref(null)
const elements = ref(null)
const cardElement = ref(null)
const clientSecret = ref(null)
const loading = ref(false)
const cardEl = ref(null)

// Initialize Stripe after step=2 and DOM update
async function initStripe() {
  console.log('🔄 Iniciando Stripe e criando pedido')
  const key = import.meta.env.VITE_STRIPE_KEY
  console.log('📥 Publishable Key:', key)
  stripe.value = await loadStripe(key)
  elements.value = stripe.value.elements()
  cardElement.value = elements.value.create('card', { style: { base: { fontSize: '16px' } } })
  console.log('🔧 cardEl ref:', cardEl.value)
  cardElement.value.mount(cardEl.value)
  console.log('✅ Stripe Elements montado')

  try {
    // Cria o pedido e o PaymentIntent em um único endpoint
    const payload = {
      address: form.address,
      postal_code: form.postal_code,
      city: form.city,
      items: form.items
    }
    console.log('📡 Criando pedido e PaymentIntent, payload:', payload)
    const { data } = await axios.post('/checkout/create-payment-intent', payload)
    clientSecret.value = data.client_secret
    console.log('✅ client_secret recebido:', clientSecret.value)
    stripeLoaded.value = true
  } catch (err) {
    console.error('❌ Erro ao criar PaymentIntent:', err)
  }
}

watch(step, async val => {
  if (val === 2) {
    await nextTick()
    await nextTick()
    console.log('👀 step=2, DOM ready')
    initStripe()
  }
})

// Payment handler
async function handlePayment() {
  loading.value = true
  console.log('▶️ handlePayment, clientSecret:', clientSecret.value)
  try {
    const { error, paymentIntent } = await stripe.value.confirmCardPayment(clientSecret.value, {
      payment_method: { card: cardElement.value }
    })
    if (error) {
      console.error('❌ confirmCardPayment error:', error)
      alert(error.message)
      loading.value = false
    } else {
      console.log('✅ Pagamento concluído:', paymentIntent)
      cartStore.clearCart()
      window.location.href = router.visit(route('checkout.success'))
    }
  } catch (err) {
    console.error('❌ handlePayment exception:', err)
    loading.value = false
  }
}
</script>

<style scoped>
.input { @apply border-gray-300 focus:ring-green-600 focus:border-green-600 rounded-full }
.btn { @apply py-2 px-4 font-semibold rounded-full transition-all }
</style>
