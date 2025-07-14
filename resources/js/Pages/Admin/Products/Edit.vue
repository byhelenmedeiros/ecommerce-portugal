<template>
  <AdminLayout>
    <Head title="Editar Produto" />
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
      <h2 class="text-xl font-bold text-green-700 mb-6">Editar Produto</h2>
      <ProductForm :product="product" :categories="categories" :regions="regions" />
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import ProductForm from './Partials/ProductForm.vue';
defineProps(['product', 'categories', 'regions']);
</script>
