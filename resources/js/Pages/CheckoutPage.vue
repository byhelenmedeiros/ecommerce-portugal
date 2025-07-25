<template>
  <GuestLayout>
    <section class="max-w-9xl mx-auto px-6 py-10 space-y-10">
      <h1 class="text-3xl font-bold text-gray-800 mb-4">Finalizar Compra</h1>

      <!-- Breadcrumbs estilo WooCommerce -->
      <nav class="text-sm text-gray-500 mb-6">
        <ol class="flex space-x-2">
          <li><Link :href="route('cart')" class="text-green-700 hover:underline">Carrinho</Link></li>
          <li>/</li>
          <li :class="step >= 1 ? 'text-green-700 font-semibold' : 'text-gray-400'">Checkout</li>
          <li>/</li>
          <li :class="step === 2 ? 'text-green-700 font-semibold' : 'text-gray-400'">Pagamento</li>
        </ol>
      </nav>

      <p v-if="!isLoggedIn" class="text-sm text-gray-500">
        Já tem conta? <Link href="/login" class="text-green-700 underline">Inicie sessão</Link> ou preencha os dados abaixo para finalizar a sua compra.
      </p>

      <!-- Conteúdo principal -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 bg-white p-8 rounded shadow">

        <!-- Etapas -->
        <div>
          <!-- Etapa 1: Moradas -->
          <div v-if="step === 1">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Morada de Entrega</h2>
            <form @submit.prevent="salvarMoradas" class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-700">Rua</label>
                <input v-model="form.address" type="text" required class="input input-bordered w-full mt-1" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700">Porta</label>
                <input v-model="form.door" type="text" class="input input-bordered w-full mt-1" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700">Andar</label>
                <input v-model="form.floor" type="text" class="input input-bordered w-full mt-1" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700">Localidade</label>
                <input v-model="form.location" type="text" required class="input input-bordered w-full mt-1" />
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700">Código Postal</label>
                  <input v-model="form.postal_code" type="text" required class="input input-bordered w-full mt-1" />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700">Cidade</label>
                  <input v-model="form.city" type="text" required class="input input-bordered w-full mt-1" />
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700">Distrito</label>
                  <input v-model="form.district" type="text" required class="input input-bordered w-full mt-1" />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700">País</label>
                  <input v-model="form.country" type="text" required class="input input-bordered w-full mt-1" />
                </div>
              </div>

              <div>
                <label class="flex items-center gap-2 text-sm">
                  <input type="checkbox" v-model="usarMesmaMorada" /> Usar esta mesma morada como fiscal
                </label>
              </div>

              <div v-if="!usarMesmaMorada" class="pt-4">
                <h3 class="font-medium text-gray-700 mb-2">Morada Fiscal</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Rua</label>
                    <input v-model="form.billing_address" type="text" class="input input-bordered w-full mt-1" />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Localidade</label>
                    <input v-model="form.billing_location" type="text" class="input input-bordered w-full mt-1" />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Código Postal</label>
                    <input v-model="form.billing_postal_code" type="text" class="input input-bordered w-full mt-1" />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Cidade</label>
                    <input v-model="form.billing_city" type="text" class="input input-bordered w-full mt-1" />
                  </div>
                </div>
              </div>

              <div class="flex justify-between gap-2 pt-6">
                <button type="button" disabled class="btn bg-gray-200 text-gray-500 w-1/2 rounded-full">Voltar</button>
                <button type="submit" class="btn bg-green-600 hover:bg-green-700 text-white w-1/2 rounded-full">Guardar e Continuar</button>
              </div>
            </form>
          </div>

          <!-- Etapa 2: Pagamento -->
          <div v-else-if="step === 2">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Pagamento</h2>
            <form @submit.prevent="confirmarPedido" class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-700">Método de Pagamento</label>
                <select v-model="form.payment_method" required class="input input-bordered w-full mt-1">
                  <option disabled value="">Escolha o método de pagamento</option>
                  <option value="mbway">MB Way</option>
                  <option value="multibanco">Multibanco</option>
                  <option value="visa">Cartão Visa</option>
                  <option value="paypal">PayPal</option>
                </select>
              </div>
              <div class="text-right pt-4">
                <button type="submit" class="btn bg-green-700 hover:bg-green-800 text-white w-full rounded-full">
                  Confirmar Pedido e Pagar
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- Resumo do Pedido -->
        <div>
          <h2 class="text-xl font-semibold text-gray-800 mb-4">Resumo do Pedido</h2>
          <ul class="divide-y divide-gray-200 text-sm">
            <li v-for="item in cart" :key="item.id" class="py-3 flex justify-between">
              <span>{{ item.name }} x{{ item.quantity }}</span>
              <span class="text-green-700 font-semibold">€{{ (item.price * item.quantity).toFixed(2) }}</span>
            </li>
          </ul>
          <div class="pt-6 border-t mt-4 text-right font-bold text-lg">
            Total: <span class="text-green-700">€{{ total.toFixed(2) }}</span>
          </div>
        </div>
      </div>
    </section>
  </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { useForm, usePage, Link } from '@inertiajs/vue3'
import { computed, onMounted, ref, watch } from 'vue'
import { useCart } from '@/stores/cart'

const page = usePage()
const user = page.props.auth?.user
const isLoggedIn = computed(() => !!user)

const cartStore = useCart()
const cart = computed(() => cartStore.cart ?? [])

onMounted(() => {
  cartStore.loadCartFromStorage()
})

const total = computed(() => cart.value.reduce((sum, item) => sum + item.price * item.quantity, 0))

const temMoradas = ref(!!(user?.morada_entrega || user?.morada_fiscal))
const usarMesmaMorada = ref(true)
const step = ref(temMoradas.value ? 2 : 1)

const form = useForm({
  address: user?.morada_entrega || '',
  door: '',
  floor: '',
  location: '',
  postal_code: '',
  city: '',
  district: '',
  country: '',
  billing_address: user?.morada_fiscal || '',
  billing_location: '',
  billing_postal_code: '',
  billing_city: '',
  payment_method: '',
  items: computed(() => cart.value.map(item => ({
    id: item.id,
    quantity: item.quantity,
    price: item.price
  }))).value,
})

watch(usarMesmaMorada, (val) => {
  if (val) form.billing_address = form.address
})

const salvarMoradas = () => {
  if (form.address && (usarMesmaMorada.value || form.billing_address)) {
    if (usarMesmaMorada.value) {
      form.billing_address = form.address
    }
    step.value = 2
  }
}

const confirmarPedido = () => {
  form.post(route('checkout.store'), {
    onSuccess: () => {
      localStorage.removeItem('cart')
      window.location.href = route('checkout.success')
    }
  })
}
</script>

<style scoped>
.input {
  @apply border-gray-300 focus:ring-green-600 focus:border-green-600 rounded-full;
}
.btn {
  @apply py-2 px-4 font-semibold rounded-full transition-all;
}
</style>
