<template>
  <AdminLayout title="Detalhes do Pedido">
    <Head :title="`Pedido #${order.id}`" />

    <section class="space-y-6 py-6">
      <!-- Cabeçalho -->
      <header class="border-b pb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <div>
          <h1 class="text-xl font-bold text-gray-800">Pedido #{{ order.id }}</h1>
          <p class="text-sm text-gray-500">Criado em {{ new Date(order.created_at).toLocaleString() }}</p>
        </div>
        <p class="text-sm">
          Status:
          <span :class="statusClass(order.status)" class="font-semibold">{{ order.status }}</span>
        </p>
      </header>

      <!-- Info + Status -->
      <section class="bg-white rounded shadow-sm border p-4 space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
          <div>
            <p class="text-gray-500">Cliente</p>
            <p class="text-gray-800 font-medium">{{ user?.name ?? '—' }}</p>
          </div>
          <div>
            <p class="text-gray-500">E-mail</p>
            <p class="text-gray-800 font-medium">{{ user?.email ?? '—' }}</p>
          </div>
          <div>
            <p class="text-gray-500">Total</p>
            <p class="text-gray-800 font-medium">€ {{ Number(order.total ?? 0).toFixed(2) }}</p>
          </div>
        </div>

        <!-- Status Editável -->
        <div class="flex flex-wrap items-center gap-3">
          <label class="text-sm font-medium text-gray-700">Alterar Status:</label>
          <select v-model="newStatus" class="text-sm border-gray-300 rounded w-40">
            <option v-for="status in statusOptions" :key="status" :value="status">{{ status }}</option>
          </select>
          <button
            type="button"
            @click="updateStatus"
            class="text-sm px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition"
          >
            Atualizar
          </button>
        </div>
      </section>

      <!-- Moradas -->
      <section v-if="fiscalAddress || entregaAddress" class="bg-white border rounded shadow-sm p-4 text-sm">
        <h2 class="text-base font-semibold text-gray-700 mb-3">Moradas do Cliente</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div v-if="fiscalAddress">
            <h3 class="text-sm font-semibold text-gray-600 mb-1">Morada Fiscal</h3>
            <ul class="text-gray-800 space-y-1">
              <li><strong class="text-gray-500">Nome:</strong> {{ fiscalAddress.name ?? '—' }}</li>
              <li><strong class="text-gray-500">Endereço:</strong> {{ fiscalAddress.address ?? '—' }}</li>
              <li><strong class="text-gray-500">Código Postal:</strong> {{ fiscalAddress.zip ?? '—' }}</li>
              <li><strong class="text-gray-500">Cidade:</strong> {{ fiscalAddress.city ?? '—' }}</li>
              <li><strong class="text-gray-500">País:</strong> {{ fiscalAddress.country ?? '—' }}</li>
              <li v-if="fiscalAddress.phone"><strong class="text-gray-500">Telefone:</strong> {{ fiscalAddress.phone }}</li>
            </ul>
          </div>
          <div v-if="entregaAddress">
            <h3 class="text-sm font-semibold text-gray-600 mb-1">Morada de Entrega</h3>
            <ul class="text-gray-800 space-y-1">
              <li><strong class="text-gray-500">Nome:</strong> {{ entregaAddress.name ?? '—' }}</li>
              <li><strong class="text-gray-500">Endereço:</strong> {{ entregaAddress.address ?? '—' }}</li>
              <li><strong class="text-gray-500">Código Postal:</strong> {{ entregaAddress.zip ?? '—' }}</li>
              <li><strong class="text-gray-500">Cidade:</strong> {{ entregaAddress.city ?? '—' }}</li>
              <li><strong class="text-gray-500">País:</strong> {{ entregaAddress.country ?? '—' }}</li>
              <li v-if="entregaAddress.phone"><strong class="text-gray-500">Telefone:</strong> {{ entregaAddress.phone }}</li>
            </ul>
          </div>
        </div>
      </section>

      <!-- Itens -->
      <section class="bg-white rounded shadow-sm border p-4">
        <h2 class="text-base font-semibold text-gray-700 mb-4">Itens do Pedido</h2>
        <div class="overflow-x-auto">
          <table class="w-full text-sm text-left border">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
              <tr>
                <th class="p-2">ID</th>
                <th class="p-2">Produto</th>
                <th class="p-2 text-right">Preço</th>
                <th class="p-2 text-right">Qtd</th>
                <th class="p-2 text-right">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in items" :key="item.id" class="hover:bg-gray-50">
                <td class="p-2">{{ item.id }}</td>
                <td class="p-2">
                  {{ products.find(p => p.id === item.product_id)?.name ?? 'Produto não encontrado' }}
                </td>
                <td class="p-2 text-right">€ {{ Number(item.price ?? 0).toFixed(2) }}</td>
                <td class="p-2 text-right">{{ item.quantity }}</td>
                <td class="p-2 text-right">€ {{ (item.quantity * item.price).toFixed(2) }}</td>
              </tr>
              <tr v-if="!items.length">
                <td colspan="5" class="text-center p-4 text-gray-500">Nenhum item encontrado.</td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>

      <!-- Notas e comprovativo -->
      <section v-if="adminNote || paymentProof" class="bg-white border rounded shadow-sm p-4 text-sm space-y-4">
        <div v-if="adminNote">
          <h2 class="font-medium text-gray-700">Nota do Administrador:</h2>
          <p class="text-gray-800">{{ adminNote }}</p>
        </div>
        <div v-if="paymentProof">
          <h2 class="font-medium text-gray-700">Comprovativo de Pagamento:</h2>
          <a :href="paymentProof" target="_blank" class="text-blue-600 underline">Ver comprovativo</a>
        </div>
      </section>

      <!-- Voltar -->
      <div class="text-right">
        <Link :href="route('admin.orders.index')" class="text-sm text-blue-600 hover:underline">
          &larr; Voltar para a lista
        </Link>
      </div>
    </section>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
  order: Object,
  fiscalAddress: Object,
  entregaAddress: Object,
  items: Array,
  products: Array,
  user: Object,
  statusOptions: Array,
  shippingMethods: Array,
  paymentMethods: Array,
  adminNote: String,
  paymentProof: String,
})

const newStatus = ref(props.order.status)

const updateStatus = () => {
  router.put(route('orders.update-status', { order: props.order.id }), {
    status: newStatus.value,
  })
}

const statusClass = (status) => {
  switch (status) {
    case 'pago': return 'text-green-600'
    case 'pendente': return 'text-yellow-600'
    case 'cancelado': return 'text-red-600'
    default: return 'text-gray-600'
  }
}
</script>
