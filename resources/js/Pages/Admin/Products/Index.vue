<template>
  <AdminLayout>
    <Head title="Gestão de Produtos" />
    <h1 class="text-base font-bold text-gray-700">Produtos</h1>
    <!-- Cabeçalho -->
    <div class="flex justify-end items-right space-x-6 mb-4">
      
      <Link :href="route('admin.products.create')"
        class="bg-green-700 text-white px-3 py-1.5 rounded hover:bg-green-800 text-xs">
        <font-awesome-icon icon="fa-solid fa-plus" class="mr-1" />
        Novo Produto
      </Link>
      <Link :href="route('admin.products.import')" class="bg-blue-700 text-white px-3 py-1.5 rounded hover:bg-blue-800 text-xs">
        <font-awesome-icon icon="fa-solid fa-file-import" class="mr-1" />
        Importar Produtos
      </Link>
    </div>

    <!-- Filtros -->
    <div class="grid md:grid-cols-6 gap-2 mb-4 text-xs">
      <input v-model="filters.search" type="text" placeholder="Pesquisar nome"
        class="border border-gray-300 rounded px-2 py-1 w-full" />

      <select v-model="filters.category_id" class="border border-gray-300 rounded px-2 py-1 w-full">
        <option value="">Todas as Categorias</option>
        <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
      </select>

      <select v-model="filters.region_id" class="border border-gray-300 rounded px-2 py-1 w-full">
        <option value="">Todas as Regiões</option>
        <option v-for="reg in regions" :key="reg.id" :value="reg.id">{{ reg.name }}</option>
      </select>

      <select v-model="filters.status" class="border border-gray-300 rounded px-2 py-1 w-full">
        <option value="">Todos os Status</option>
        <option value="rascunho">Rascunho</option>
        <option value="publicado">Publicado</option>
        <option value="esgotado">Esgotado</option>
      </select>

      <input v-model="filters.price_min" type="number" placeholder="Preço mín €"
        class="border border-gray-300 rounded px-2 py-1 w-full" />

      <input v-model="filters.price_max" type="number" placeholder="Preço máx €"
        class="border border-gray-300 rounded px-2 py-1 w-full" />
    </div>

    <!-- Botões -->
    <div class="mb-4 flex items-center gap-2">
      <button @click="filterProducts"
        class="bg-green-700 text-white rounded px-4 py-1.5 text-xs hover:bg-green-800">
        <font-awesome-icon icon="fa-solid fa-filter" class="mr-1" />
        Filtrar
      </button>
      <button @click="clearFilters"
        class="bg-gray-200 text-gray-700 rounded px-4 py-1.5 text-xs hover:bg-gray-300">
        Limpar Filtros
      </button>
    </div>

    <!-- Tabela -->
    <div class="overflow-x-auto bg-white p-3 rounded shadow text-xs">
      <table class="min-w-full text-left">
        <thead>
          <tr class="bg-gray-100 text-gray-700">
            <th class="px-4 py-2 cursor-pointer" @click="toggleSort('name')">Nome</th>
            <th class="px-4 py-2 cursor-pointer" @click="toggleSort('category_id')">Categoria</th>
            <th class="px-4 py-2 cursor-pointer" @click="toggleSort('region_id')">Região</th>
            <th class="px-4 py-2 cursor-pointer" @click="toggleSort('price')">Preço</th>
            <th class="px-4 py-2 cursor-pointer" @click="toggleSort('status')">Status</th>
            <th class="px-4 py-2 cursor-pointer" @click="toggleSort('created_at')">Criado em</th>
            <th class="px-3 py-2 text-center">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in products.data" :key="product.id" class="border-t hover:bg-gray-50">
            <td class="px-3 py-2">{{ product.name }}</td>
            <td class="px-3 py-2">{{ product.category?.name ?? '-' }}</td>
            <td class="px-3 py-2">{{ product.region?.name ?? '-' }}</td>
            <td class="px-3 py-2">€{{ product.price }}</td>
            <td class="px-3 py-2 capitalize">{{ product.status }}</td>
            <td class="px-3 py-2">{{ new Date(product.created_at).toLocaleDateString('pt-PT') }}</td>
            <td class="px-3 py-2 text-center space-x-2">
              <Link :href="route('admin.products.show', product.id)" class="text-blue-600 hover:underline">
                <font-awesome-icon icon="fa-solid fa-eye" />
              </Link>
              <Link :href="route('admin.products.edit', product.id)" class="text-green-700 hover:underline">
                <font-awesome-icon icon="fa-solid fa-pen" />
              </Link>
              <button @click="confirmDelete(product.id)" class="text-red-600 hover:underline">
                <font-awesome-icon icon="fa-solid fa-trash" />
              </button>
              <ConfirmationModal :show="showModal" @cancel="showModal = false" @confirm="destroy" />
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Paginação -->
    <div v-if="products?.meta?.links?.length" class="mt-4 flex justify-center text-xs space-x-1">
      <button v-for="link in products.meta.links" :key="link.label" :disabled="!link.url"
        @click="goToPage(link.url)" v-text="link.label" :class="[
          'px-2 py-1 border rounded',
          link.active ? 'bg-green-700 text-white' : 'bg-white text-gray-700 hover:bg-gray-100'
        ]" />
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, watch } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import debounce from 'lodash.debounce'

const props = defineProps({
  products: Object,
  filters: Object,
  categories: Array,
  regions: Array,
  sortField: String,
  sortDirection: String,
})

const filters = ref({
  search: props.filters?.search ?? '',
  category_id: props.filters?.category_id ?? '',
  region_id: props.filters?.region_id ?? '',
  status: props.filters?.status ?? '',
  price_min: props.filters?.price_min ?? '',
  price_max: props.filters?.price_max ?? ''
})

const sortField = ref(props.sortField || 'name')
const sortDirection = ref(props.sortDirection || 'asc')

const filterProducts = () => {
  router.get(route('admin.products.index'), {
    ...filters.value,
    sort: sortField.value,
    direction: sortDirection.value,
  }, { preserveState: true, replace: true })
}

// Reativo com debounce
const debouncedFilter = debounce(filterProducts, 500)

watch(() => filters.value.search, debouncedFilter)
watch(() => filters.value.price_min, debouncedFilter)
watch(() => filters.value.price_max, debouncedFilter)
watch(() => filters.value.category_id, filterProducts)
watch(() => filters.value.region_id, filterProducts)
watch(() => filters.value.status, filterProducts)

const clearFilters = () => {
  filters.value = {
    search: '',
    category_id: '',
    region_id: '',
    status: '',
    price_min: '',
    price_max: ''
  }
  filterProducts()
}

const toggleSort = (field) => {
  if (sortField.value === field) {
    sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc'
  } else {
    sortField.value = field
    sortDirection.value = 'asc'
  }
  filterProducts()
}

const showModal = ref(false)
const productToDelete = ref(null)

const confirmDelete = (id) => {
  productToDelete.value = id
  showModal.value = true
}

const destroy = () => {
  router.delete(route('admin.products.destroy', productToDelete.value))
  showModal.value = false
}

const goToPage = (url) => {
  router.visit(url, { preserveState: true })
}
</script>
