<template>
  <AdminLayout title="Nova Etiqueta">
    <Head title="Nova Etiqueta" />

    <div class="max-w-xl mx-auto py-6 space-y-6">
      <h1 class="text-xl font-bold text-gray-800">Criar Nova Etiqueta</h1>

      <form @submit.prevent="submit" class="bg-white border rounded shadow-sm p-6 space-y-4">
        <!-- Nome -->
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
          <input
            type="text"
            id="name"
            v-model="form.name"
            required
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm text-sm px-3 py-2"
          />
        </div>

        <!-- Cor -->
        <div>
          <label for="color" class="block text-sm font-medium text-gray-700">Cor</label>
          <input
            type="color"
            id="color"
            v-model="form.color"
            class="mt-1 h-10 w-20 cursor-pointer border rounded"
          />
        </div>

        <!-- Botões -->
        <div class="flex justify-between items-center">
          <Link
            :href="route('admin.tags.index')"
            class="text-sm text-gray-600 hover:underline"
          >
            Cancelar
          </Link>

          <button
            type="submit"
            class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm"
          >
            <font-awesome-icon icon="fa-solid fa-check" />
            Criar
          </button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

const form = useForm({
  name: '',
  color: '#28a745' // cor padrão (verde)
})

function submit() {
  form.post(route('admin.tags.store'), {
    preserveScroll: true,
  })
}
</script>
