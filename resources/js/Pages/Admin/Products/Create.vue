<template>
  <AdminLayout title="Criar Produto">
    <h1 class="text-md font-bold mb-4 text-black ">Criar Novo Produto</h1>
    
    <ProductForm :categories="categories" :regions="regions" />

  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ProductForm from '@/Pages/Admin/Products/Partials/ProductForm.vue';

defineProps({
  categories: Array,
  regions: Array,
});
</script>
