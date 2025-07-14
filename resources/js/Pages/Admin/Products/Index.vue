<template>
  <AdminLayout>
    <Head title="Produtos" />

    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold text-green-700">Produtos</h1>
      <Link :href="route('admin.products.create')" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800">
        Novo Produto
      </Link>
    </div>

    <div class="overflow-x-auto bg-white p-4 rounded shadow">
      <table class="min-w-full text-sm text-left">
        <thead>
          <tr class="bg-gray-100 text-gray-700">
            <th class="px-4 py-2">Nome</th>
            <th class="px-4 py-2">Categoria</th>
            <th class="px-4 py-2">Região</th>
            <th class="px-4 py-2">Preço</th>
            <th class="px-4 py-2">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in products.data" :key="product.id" class="border-t">
            <td class="px-4 py-2">{{ product.name }}</td>
            <td class="px-4 py-2">{{ product.category?.name ?? '-' }}</td>
            <td class="px-4 py-2">{{ product.region?.name ?? '-' }}</td>
            <td class="px-4 py-2">€{{ product.price }}</td>
            <td class="px-4 py-2 space-x-2">
              <Link :href="route('admin.products.edit', product.id)" class="text-green-700 hover:underline">Editar</Link>
              <button @click="destroy(product.id)" class="text-red-600 hover:underline">Remover</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
defineProps({ products: Object });

const destroy = (id) => {
  if (confirm('Deseja remover este produto?')) {
    router.delete(route('admin.products.destroy', id));
  }
};
</script>
