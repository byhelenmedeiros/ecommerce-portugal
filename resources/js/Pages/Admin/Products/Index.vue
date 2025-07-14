<template>
  <AdminLayout>
    <Head title="Gestão de Produtos" />

    <div class="flex justify-between items-center mb-4">
      <h1 class="text-md font-bold text-gray-700">Produtos</h1>
      <Link :href="route('admin.products.create')" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800">
        <font-awesome-icon icon="fa-solid fa-plus" class="mr-2" />
        Novo Produto
      </Link>
    </div>

    <!-- Barra de Filtros -->
    <form @submit.prevent="filterProducts" class="flex flex-wrap items-end gap-2 mb-4 text-sm">
      <input
        v-model="filters.search"
        type="text"
        placeholder="Pesquisar por nome"
        class="border rounded p-2 w-full md:w-1/3"
      />

      <select v-model="filters.category_id" class="border rounded p-2 w-full md:w-1/4">
        <option value="">Todas as Categorias</option>
        <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
      </select>

      <select v-model="filters.region_id" class="border rounded p-2 w-full md:w-1/4">
        <option value="">Todas as Regiões</option>
        <option v-for="reg in regions" :key="reg.id" :value="reg.id">{{ reg.name }}</option>
      </select>

      <button type="submit" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800">
        <font-awesome-icon icon="fa-solid fa-filter" class="mr-1" />
        Filtrar
      </button>
    </form>

    <!-- Tabela -->
    <div class="overflow-x-auto bg-white p-4 rounded shadow text-sm">
      <table class="min-w-full text-left">
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
              <Link :href="route('admin.products.edit', product.id)" class="text-green-700 hover:underline">
                <font-awesome-icon icon="fa-solid fa-pen" />
              </Link>
              <button @click="destroy(product.id)" class="text-red-600 hover:underline">
                <font-awesome-icon icon="fa-solid fa-trash" />
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Paginação -->
 <div v-if="products?.meta?.links?.length" class="mt-4 flex justify-center text-sm space-x-2">
  <button
    v-for="link in products.meta.links"
    :key="link.label"
    v-html="link.label"
    :disabled="!link.url"
    @click="goToPage(link.url)"
    :class="[
      'px-3 py-1 border rounded',
      link.active ? 'bg-green-700 text-white' : 'bg-white text-gray-700 hover:bg-gray-100'
    ]"
  />
</div>

  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

const props = defineProps({
  products: Object,
  filters: Object,
  categories: Array,
  regions: Array
});

const filters = ref({
  search: props.filters.search || '',
  category_id: props.filters.category_id || '',
  region_id: props.filters.region_id || '',
});

const filterProducts = () => {
  router.get(route('admin.products.index'), filters.value, { preserveState: true });
};

const destroy = (id) => {
  if (confirm('Deseja remover este produto?')) {
    router.delete(route('admin.products.destroy', id));
  }
};

const goToPage = (url) => {
  router.visit(url, { preserveState: true });
};
</script>
