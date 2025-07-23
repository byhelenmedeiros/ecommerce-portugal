<template>
  <GuestLayout>
    <section class="max-w-4xl mx-auto px-4 py-10 space-y-8">
      <h1 class="text-2xl font-bold text-gray-800 mb-4">Finalizar Compra</h1>

      <p v-if="!isLoggedIn" class="text-sm text-gray-500">
        Já tem conta? <Link href="/login" class="text-green-700 underline">Inicie sessão</Link> ou preencha os dados abaixo para finalizar a sua compra.
      </p>

      <form @submit.prevent="submit" class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-white p-6 rounded shadow">
        <!-- Dados do Cliente -->
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Nome completo</label>
            <input v-model="form.name" type="text" readonly class="input input-bordered w-full mt-1 bg-gray-100 cursor-not-allowed" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input v-model="form.email" type="email" readonly class="input input-bordered w-full mt-1 bg-gray-100 cursor-not-allowed" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Telefone</label>
            <input v-model="form.telefone" type="text" required class="input input-bordered w-full mt-1" />
          </div>

          <!-- Morada de Entrega -->
          <div>
            <label class="block text-sm font-medium text-gray-700">Morada de Entrega</label>
            <template v-if="user?.address">
              <input v-model="form.address" type="text" class="input input-bordered w-full mt-1" />
            </template>
            <template v-else>
              <input v-model="form.address" type="text" required class="input input-bordered w-full mt-1" />
            </template>
          </div>

          <!-- Morada Fiscal -->
          <div>
            <label class="block text-sm font-medium text-gray-700">Morada Fiscal</label>
            <template v-if="user?.billing_address">
              <input v-model="form.billing_address" type="text" class="input input-bordered w-full mt-1" />
            </template>
            <template v-else>
              <input v-model="form.billing_address" type="text" required class="input input-bordered w-full mt-1" />
            </template>
          </div>

          <div v-if="!isLoggedIn">
            <label class="flex items-center gap-2 mt-4 text-sm">
              <input type="checkbox" v-model="form.criarConta" />
              Desejo criar uma conta com estes dados
            </label>
          </div>
        </div>

        <!-- Resumo do Carrinho -->
        <div class="space-y-3 border-l pl-6">
          <h2 class="text-lg font-semibold text-gray-800">Resumo do Pedido</h2>
          <ul class="divide-y divide-gray-200 text-sm">
            <li v-for="item in cart" :key="item.id" class="py-2 flex justify-between">
              <span>{{ item.name }} x{{ item.quantity }}</span>
              <span class="text-green-700 font-semibold">€{{ (item.price * item.quantity).toFixed(2) }}</span>
            </li>
          </ul>
          <div class="pt-4 border-t font-bold text-right">
            Total: <span class="text-green-700">€{{ total.toFixed(2) }}</span>
          </div>
          <p class="text-sm text-gray-600 mt-6">
            Crie uma conta para acompanhar os seus pedidos, guardar moradas e receber ofertas exclusivas.
          </p>
          <button type="submit" class="btn btn-primary w-full mt-4">Confirmar Pedido</button>
        </div>
      </form>
    </section>
  </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { useForm, usePage, Link, router } from '@inertiajs/vue3'
import { useCart } from '@/stores/cart'
import { computed, onMounted } from 'vue'

const page = usePage()
const user = page.props.auth?.user
const isLoggedIn = computed(() => !!user)

const cartStore = useCart()
const cart = computed(() => cartStore.cart ?? [])

onMounted(() => {
  cartStore.loadCartFromStorage()
})

const total = computed(() =>
  cart.value.reduce((sum, item) => sum + item.price * item.quantity, 0)
)

const form = useForm({
  name: user?.name || '',
  email: user?.email || '',
  telefone: user?.telefone || '',
  address: user?.address || '',
  billing_address: user?.billing_address || '',
  criarConta: false,
  items: computed(() =>
    cart.value.map(item => ({
      id: item.id,
      quantity: item.quantity,
      price: item.price
    }))
  ).value
})

const submit = () => {
  form.post(route('checkout.store'), {
    onSuccess: () => {
      localStorage.removeItem('cart')
    }
  })
}
</script>

<style scoped>
.input {
  @apply border-gray-300 focus:ring-green-600 focus:border-green-600;
}
</style>
