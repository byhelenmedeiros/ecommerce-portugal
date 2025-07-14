<template>
  <AdminLayout>
    <Head title="Dashboard Admin" />

    <div class="px-4 sm:px-6 lg:px-8 py-8">
      <h1 class="text-2xl font-bold text-green-800 mb-6">Bem-vindo(a), Admin!</h1>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white shadow rounded-lg p-6 text-center">
          <p class="text-sm text-gray-500">Total de Produtos</p>
          <p class="text-2xl font-bold text-green-700">128</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6 text-center">
          <p class="text-sm text-gray-500">Novos Pedidos</p>
          <p class="text-2xl font-bold text-green-700">6</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6 text-center">
          <p class="text-sm text-gray-500">Usuários</p>
          <p class="text-2xl font-bold text-green-700">87</p>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>
