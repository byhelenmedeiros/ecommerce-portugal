<template>
  <AdminLayout title="Pré-visualização da Importação">
    <template #header>
      <h2 class="text-base font-semibold text-gray-800">Pré-visualizar Produtos</h2>
    </template>

    <div class="py-6">
      <div class="max-w-7xl mx-auto sm:px-4 lg:px-6 space-y-4">
        <div class="bg-white border rounded shadow-sm p-4">
          <h3 class="text-sm font-semibold text-gray-700 mb-4">Verifique os produtos antes de confirmar</h3>

          <div class="overflow-x-auto">
            <table class="w-full text-xs border divide-y">
              <thead class="bg-gray-50 text-gray-600">
                <tr>
                  <th class="p-2">Nome</th>
                  <th class="p-2">Slug</th>
                  <th class="p-2">Preço</th>
                  <th class="p-2">Categoria</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in products" :key="index" class="hover:bg-gray-50 border-b">
                  <td class="p-2">{{ item.name }}</td>
                  <td class="p-2">{{ item.slug }}</td>
                  <td class="p-2">€ {{ Number(item.price).toFixed(2) }}</td>
                  <td class="p-2">{{ item.category }}</td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="text-right mt-4">
            <PrimaryButton @click="confirmImport" :disabled="processing" class="px-4 py-1.5 text-xs">
              Confirmar Importação
            </PrimaryButton>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
  products: Array, // Dados parseados do Excel
});

const processing = ref(false);

const confirmImport = () => {
  processing.value = true;
  router.post(route('admin.products.import.confirm'), {
    products: props.products,
  }, {
    onFinish: () => processing.value = false,
  });
};
</script>
