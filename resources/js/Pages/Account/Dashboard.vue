<script setup>
import { ref, onMounted } from 'vue'

const stats = ref({
  totalSales: 13240.75,
  totalOrders: 145,
  newOrders: 5,
  newCustomers: 3,
  avgOrderValue: 91.24,
  lowStock: 2,
  topProduct: 'Vinho do Porto 750ml',
})

const recentOrders = ref([
  { id: '#1001', customer: 'João Silva', total: 59.90, date: '2025-07-19' },
  { id: '#1002', customer: 'Ana Costa', total: 42.50, date: '2025-07-18' },
  { id: '#1003', customer: 'Miguel Rocha', total: 103.00, date: '2025-07-18' },
])
</script>

<template>
  <div class="p-6 space-y-8 animate-fade-in">
    <h1 class="text-xl font-semibold text-gray-800">Dashboard do Administrador</h1>

    <!-- Resumo -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 text-white">
      <div class="bg-green-600 p-4 rounded shadow">
        <p class="text-sm">Total de Vendas</p>
        <h2 class="text-2xl font-bold">€{{ stats.totalSales.toFixed(2) }}</h2>
      </div>
      <div class="bg-blue-600 p-4 rounded shadow">
        <p class="text-sm">Total de Pedidos</p>
        <h2 class="text-2xl font-bold">{{ stats.totalOrders }}</h2>
      </div>
      <div class="bg-yellow-500 p-4 rounded shadow">
        <p class="text-sm">Novos Pedidos Hoje</p>
        <h2 class="text-2xl font-bold">{{ stats.newOrders }}</h2>
      </div>
      <div class="bg-indigo-500 p-4 rounded shadow">
        <p class="text-sm">Novos Clientes</p>
        <h2 class="text-2xl font-bold">{{ stats.newCustomers }}</h2>
      </div>
      <div class="bg-pink-500 p-4 rounded shadow">
        <p class="text-sm">Valor Médio do Pedido</p>
        <h2 class="text-2xl font-bold">€{{ stats.avgOrderValue.toFixed(2) }}</h2>
      </div>
      <div class="bg-red-600 p-4 rounded shadow">
        <p class="text-sm">Produtos com Stock Baixo</p>
        <h2 class="text-2xl font-bold">{{ stats.lowStock }}</h2>
      </div>
    </div>

    <!-- Encomendas Recentes -->
    <div class="bg-white p-6 rounded shadow">
      <h2 class="text-lg font-semibold text-gray-800 mb-4">Últimas Encomendas</h2>
      <table class="w-full text-sm text-left border border-gray-200">
        <thead class="bg-gray-100 text-gray-600 uppercase">
          <tr>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">Cliente</th>
            <th class="px-4 py-2">Total</th>
            <th class="px-4 py-2">Data</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="order in recentOrders" :key="order.id" class="hover:bg-gray-50">
            <td class="px-4 py-2">{{ order.id }}</td>
            <td class="px-4 py-2">{{ order.customer }}</td>
            <td class="px-4 py-2">€{{ order.total.toFixed(2) }}</td>
            <td class="px-4 py-2">{{ order.date }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Destaque -->
    <div class="bg-white p-6 rounded shadow">
      <h2 class="text-lg font-semibold text-gray-800 mb-2">Produto em Destaque</h2>
      <p class="text-green-700 font-bold text-xl">{{ stats.topProduct }}</p>
    </div>
  </div>
</template>

<style scoped>
@keyframes fade-in {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
.animate-fade-in {
  animation: fade-in 0.4s ease-in-out;
}
</style>
