<template>
  <GuestLayout>
    <section class="max-w-4xl mx-auto px-4 py-10 space-y-8">
      <h1 class="text-2xl font-bold text-gray-800 mb-4">Finalizar Compra</h1>

      <!-- Formulário -->
      <form @submit.prevent="submit" class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-white p-6 rounded shadow">
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Nome completo</label>
            <input v-model="form.name" type="text" required class="input input-bordered w-full mt-1" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Telefone</label>
            <input v-model="form.telefone" type="text" required class="input input-bordered w-full mt-1" />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Morada de entrega</label>
            <input v-model="form.address" type="text" required class="input input-bordered w-full mt-1" />
          </div>
        </div>

        <!-- Resumo do carrinho -->
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
          <button type="submit" class="btn btn-primary w-full mt-4">Confirmar Pedido</button>
        </div>
      </form>
    </section>
  </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { useForm, router } from '@inertiajs/vue3'
import { useCart } from '@/stores/cart'
import { computed } from 'vue'

const { cart } = useCart()

const total = computed(() =>
  cart.value.reduce((sum, item) => sum + item.price * item.quantity, 0)
)

const form = useForm({
  name: '',
  telefone: '',
  address: '',
  items: cart.value.map(item => ({
    id: item.id,
    quantity: item.quantity,
    price: item.price
  }))
})

const submit = () => {
  form.post(route('checkout.store'), {
    onSuccess: () => {
      localStorage.removeItem('cart')
    }
  })
}
</script>
