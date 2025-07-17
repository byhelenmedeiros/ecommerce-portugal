<template>
  <AdminLayout title="Importar Produtos">
    <template #header>
      <h2 class="text-base font-semibold text-gray-800">Importar Produtos</h2>
    </template>

    <div class="py-6">
      <div class="max-w-xl mx-auto bg-white border rounded shadow p-6 space-y-4">
        <h3 class="text-sm font-semibold text-gray-700">Passo 1: Carregar Ficheiro Excel</h3>

        <form @submit.prevent="submit" enctype="multipart/form-data">
          <div>
            <label for="file" class="block text-xs font-medium text-gray-600 mb-1">Ficheiro Excel (.xlsx)</label>
            <input
              type="file"
              id="file"
              accept=".xlsx"
              @change="handleFileUpload"
              class="block w-full text-sm text-gray-700 border rounded p-2"
            />
            <p v-if="error" class="text-red-600 text-xs mt-1">{{ error }}</p>
          </div>

          <div class="text-right pt-4">
            <PrimaryButton :disabled="processing || !file" class="text-xs px-4 py-1.5">
              Pré-visualizar
            </PrimaryButton>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const file = ref(null);
const error = ref('');
const processing = ref(false);

const handleFileUpload = (e) => {
  file.value = e.target.files[0];
  error.value = '';
};

const submit = () => {
  if (!file.value) {
    error.value = 'Por favor, selecione um ficheiro.';
    return;
  }

  processing.value = true;

  const formData = new FormData();
  formData.append('file', file.value);

  router.post(route('admin.products.import.preview'), formData, {
    forceFormData: true,
    onFinish: () => processing.value = false,
    onError: (e) => error.value = e.file || 'Erro ao importar o ficheiro.'
  });
};
</script>
