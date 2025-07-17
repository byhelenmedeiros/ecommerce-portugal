<template>
  <AdminLayout title="Detalhes do Pedido">
    <Head :title="`Pedido #${order.id}`" />

    <template #header>
      <h2 class="text-base font-semibold text-gray-800">Pedido #{{ order.id }}</h2>
    </template>

    <div class="py-6">
      <div class="max-w-5xl mx-auto sm:px-4 lg:px-6 space-y-6">
        <!-- Informações do Pedido -->
        <div class="bg-white border rounded shadow-sm p-4">
          <h3 class="text-sm font-semibold text-gray-700 mb-4">Informações do Pedido</h3>
          <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
            <div>
              <dt class="font-medium text-gray-600">Cliente</dt>
              <dd class="text-gray-800">{{ order.user?.name ?? '—' }}</dd>
            </div>
            <div>
              <dt class="font-medium text-gray-600">E-mail</dt>
              <dd class="text-gray-800">{{ order.user?.email ?? '—' }}</dd>
            </div>
            <div>
              <dt class="font-medium text-gray-600">Status</dt>
              <dd :class="statusClass(order.status)">{{ order.status }}</dd>
            </div>
            <div>
              <dt class="font-medium text-gray-600">Total</dt>
              <dd class="text-gray-800">€ {{ Number(order.total ?? 0).toFixed(2) }}</dd>
            </div>
            <div>
              <dt class="font-medium text-gray-600">Criado em</dt>
              <dd class="text-gray-800">{{ new Date(order.created_at).toLocaleString() }}</dd>
            </div>
          </dl>
        </div>

        <!-- Itens do Pedido -->
        <div class="bg-white border rounded shadow-sm p-4">
          <h3 class="text-sm font-semibold text-gray-700 mb-4">Itens do Pedido</h3>
          <table class="w-full text-xs border divide-y">
            <thead class="bg-gray-50 text-gray-600">
              <tr>
                <th class="p-2 text-left">Produto</th>
                <th class="p-2 text-right">Preço</th>
                <th class="p-2 text-right">Quantidade</th>
                <th class="p-2 text-right">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in order.items" :key="item.id" class="hover:bg-gray-50">
                <td class="p-2">{{ item.product_name }}</td>
                <td class="p-2 text-right">€ {{ Number(item.price ?? 0).toFixed(2) }}</td>
                <td class="p-2 text-right">{{ item.quantity }}</td>
                <td class="p-2 text-right">€ {{ (item.quantity * item.price).toFixed(2) }}</td>
              </tr>
              <tr v-if="!order.items.length">
                <td colspan="4" class="text-center p-4 text-gray-500">Nenhum item encontrado.</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="text-right">
          <Link :href="route('admin.orders.index')" class="text-sm text-blue-600 hover:underline">&larr; Voltar para a lista</Link>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
  order: Object
});

const statusClass = (status) => {
  switch (status) {
    case 'pago': return 'text-green-600 font-semibold';
    case 'pendente': return 'text-yellow-600 font-semibold';
    case 'cancelado': return 'text-red-600 font-semibold';
    default: return 'text-gray-600';
  }
};
</script>
