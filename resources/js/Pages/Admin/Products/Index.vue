<template>
    <AdminLayout>

        <Head title="Gestão de Produtos" />

        <!-- Cabeçalho -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-base font-bold text-gray-700">Produtos</h1>
            <Link :href="route('admin.products.create')"
                class="bg-green-700 text-white px-3 py-1.5 rounded hover:bg-green-800 text-xs">
            <font-awesome-icon icon="fa-solid fa-plus" class="mr-1" />
            Novo Produto
            </Link>
        </div>

        <!-- Filtros -->
        <div class="grid md:grid-cols-4 gap-2 mb-4 text-xs">
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

            <button @click="filterProducts" class="bg-green-700 text-white rounded px-2 py-1 hover:bg-green-800">
                <font-awesome-icon icon="fa-solid fa-filter" class="mr-1" />
                Filtrar
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

                        <th class="px-3 py-2 text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="product in products.data" :key="product.id" class="border-t hover:bg-gray-50">
                        <td class="px-3 py-2">{{ product.name }}</td>
                        <td class="px-3 py-2">{{ product.category?.name ?? '-' }}</td>
                        <td class="px-3 py-2">{{ product.region?.name ?? '-' }}</td>
                        <td class="px-3 py-2">€{{ product.price }}</td>
                        <td class="px-3 py-2 text-center space-x-2">
                            <Link :href="route('admin.products.show', product.id)"
                                class="text-blue-600 hover:underline">
                            <font-awesome-icon icon="fa-solid fa-eye" />
                            </Link>
                            <Link :href="route('admin.products.edit', product.id)"
                                class="text-green-700 hover:underline">
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
            <button v-for="link in products.meta.links" :key="link.label" v-html="link.label" :disabled="!link.url"
                @click="goToPage(link.url)" :class="[
                    'px-2 py-1 border rounded',
                    link.active ? 'bg-green-700 text-white' : 'bg-white text-gray-700 hover:bg-gray-100'
                ]" />
        </div>
    </AdminLayout>
</template>
<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';

const props = defineProps({
    products: Object,
    filters: Object,
    categories: Array,
    regions: Array,
    sortField: String,
    sortDirection: String,
});

const filters = ref({
    search: props.filters.search || '',
    category_id: props.filters.category_id || '',
    region_id: props.filters.region_id || '',
});

const sortField = ref(props.sortField || 'name');
const sortDirection = ref(props.sortDirection || 'asc');

const filterProducts = () => {
    router.get(route('admin.products.index'), {
        ...filters.value,
        sort: sortField.value,
        direction: sortDirection.value
    }, { preserveState: true, replace: true });
};

const toggleSort = (field) => {
    if (sortField.value === field) {
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortField.value = field;
        sortDirection.value = 'asc';
    }
    filterProducts();
};

// Modal de confirmação
const showModal = ref(false);
const productToDelete = ref(null);

const confirmDelete = (id) => {
    productToDelete.value = id;
    showModal.value = true;
};

const destroy = () => {
    router.delete(route('admin.products.destroy', productToDelete.value));
    showModal.value = false;
};
</script>
