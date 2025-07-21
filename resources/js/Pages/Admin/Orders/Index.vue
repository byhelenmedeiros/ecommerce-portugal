<template>
  <AdminLayout title="Pedidos">
    <Head title="Gerir Pedidos" />

    <template #header>
      <h2 class="text-base font-semibold text-gray-800">Gestão de Pedidos</h2>
    </template>

    <div class="py-2">
      <div class="mx-auto ">
         <h3 class="text-md font-semibold text-gray-700 p-3">Lista de Pedidos</h3>
        <div class="bg-white border rounded shadow-sm">
         

          <div class="overflow-x-auto">
        <table class="min-w-full text-xs text-left border divide-y">
  <thead class="bg-gray-50 text-gray-600 uppercase tracking-wide">
    <tr>
      <th class="p-2">#ID</th>
      <th class="p-2">Cliente</th>
      <th class="p-2">Email</th>
      <th class="p-2 text-right">Total</th>
      <th class="p-2">Pagamento</th>
      <th class="p-2">Status</th>
      <th class="p-2">Data</th>
      <th class="p-2 text-right">Ações</th>
    </tr>
  </thead>
  <tbody>
<tr v-for="order in props.orders.data" :key="order.id">


      <td class="p-2 font-medium">#{{ order.id }}</td>
      <td class="p-2">{{ order.user?.name ?? '—' }}</td>
      <td class="p-2 text-gray-500">{{ order.user?.email ?? '—' }}</td>
      <td class="p-2 text-right font-semibold">€ {{ Number(order.total ?? 0).toFixed(2) }}</td>
      <td class="p-2">{{ order.payment_method ?? '—' }}</td>
      <td class="p-2">
        <span :class="statusClass(order.status)">
          {{ order.status }}
        </span>
      </td>
      <td class="p-2 text-gray-500">
        {{ new Date(order.created_at).toLocaleDateString() }}
      </td>
      <td class="p-2 text-right space-x-2">
<Link
  v-if="order && order.id"
  :href="route('orders.show', { order: order.id })"
  class="text-blue-600 hover:underline"
>
  Ver
</Link>
        <button class="text-red-600 hover:underline">Cancelar</button>
      </td>
    </tr>

   
  </tbody>
</table>

          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';
const props = defineProps({
  orders: Object
});
console.log('Orders recebidos:', props.orders);



const statusClass = (status) => {
  switch (status) {
    case 'pago':
      return 'bg-green-100 text-green-700 font-semibold px-2 py-1 rounded text-xs';
    case 'pendente':
      return 'bg-yellow-100 text-yellow-700 font-semibold px-2 py-1 rounded text-xs';
    case 'cancelado':
      return 'bg-red-100 text-red-700 font-semibold px-2 py-1 rounded text-xs';
    default:
      return 'bg-gray-100 text-gray-700 font-medium px-2 py-1 rounded text-xs';
  }
};


</script>
