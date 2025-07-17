<template>
  <AdminLayout title="Pedidos">
    <Head title="Gerir Pedidos" />

    <template #header>
      <h2 class="text-base font-semibold text-gray-800">Gestão de Pedidos</h2>
    </template>

    <div class="py-2">
      <div class="mx-auto sm:px-4 lg:px-6">
        <div class="bg-white border rounded shadow-sm">
          <div class="p-4 border-b flex items-center justify-between">
            <h3 class="text-sm font-semibold text-gray-700">Lista de Pedidos</h3>
          </div>

          <div class="overflow-x-auto">
            <table class="min-w-full text-xs text-left border divide-y">
              <thead class="bg-gray-50 text-gray-600">
                <tr>
                  <th class="p-2">#</th>
                  <th class="p-2">Cliente</th>
                  <th class="p-2">Total</th>
                  <th class="p-2">Status</th>
                  <th class="p-2">Criado em</th>
                  <th class="p-2 text-right">Ações</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="order in orders" :key="order?.id ?? `null-${Math.random()}`" v-if="order && order.id" class="hover:bg-gray-50 border-b">
                  <td class="p-2 text-gray-700">#{{ order.id }}</td>
                  <td class="p-2">{{ order.user?.name ?? '—' }}</td>
                  <td class="p-2 font-medium">€ {{ Number(order.total ?? 0).toFixed(2) }}</td>
                  <td class="p-2">
                    <span :class="statusClass(order.status)">{{ order.status }}</span>
                  </td>
                  <td class="p-2 text-gray-500">{{ new Date(order.created_at).toLocaleDateString() }}</td>
                  <td class="p-2 text-right space-x-2">
                    <Link :href="route('admin.orders.show', { order: order.id })" class="text-blue-600 hover:underline">Ver</Link>
                    <button class="text-red-600 hover:underline">Cancelar</button>
                  </td>
                </tr>

                <tr v-if="!orders || !orders.length">
                  <td colspan="6" class="text-center p-4 text-gray-500">Nenhum pedido encontrado.</td>
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
  orders: Array
});

const statusClass = (status) => {
  switch (status) {
    case 'pago':
      return 'text-green-600 font-semibold';
    case 'pendente':
      return 'text-yellow-600 font-semibold';
    case 'cancelado':
      return 'text-red-600 font-semibold';
    default:
      return 'text-gray-600';
  }
};
</script>
