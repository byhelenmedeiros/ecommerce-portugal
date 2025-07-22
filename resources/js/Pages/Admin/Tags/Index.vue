<template>
  <AdminLayout title="Etiquetas">
    <Head title="Gestão de Etiquetas" />

    <div class="max-w-6xl mx-auto py-6 space-y-6">
      <!-- Cabeçalho -->
      <div class="flex justify-between items-center">
        <h1 class="text-xl font-bold text-gray-800">Etiquetas</h1>
        <Link
          :href="route('admin.tags.create')"
          class="inline-flex items-center px-4 py-2 text-sm font-medium bg-green-600 text-white rounded hover:bg-green-700 gap-2"
        >
          <font-awesome-icon icon="fa-solid fa-plus" />
          Nova Etiqueta
        </Link>
      </div>

      <!-- Tabela -->
      <EasyDataTable
        :headers="headers"
        :items="tags"
        :rows-per-page="10"
        show-index
        alternating
        border-cell
        theme-color="green"
        table-class="rounded shadow-sm text-sm"
        header-text-direction="left"
      >
        <!-- Cor -->
        <template #item-color="{ color }">
          <span
            class="inline-block w-4 h-4 rounded-full"
            :style="{ backgroundColor: color || '#ccc' }"
            :title="color"
          ></span>
        </template>

        <!-- Ações -->
       <!-- Nome (com edição inline) -->
<template #item-name="{ id, name }">
  <div v-if="editingId === id">
    <input
      v-model="editName"
      @blur="saveEdit(id)"
      @keyup.enter="saveEdit(id)"
      class="border rounded px-2 py-1 text-sm w-full"
      autofocus
    />
  </div>
  <div v-else @click="startEdit(id, name)" class="cursor-pointer hover:text-green-700">
    {{ name }}
  </div>
</template>

      </EasyDataTable>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { ref } from 'vue'

const props = defineProps({
  tags: Array
})

const headers = [
  { text: 'ID', value: 'id' },
  { text: 'Nome', value: 'name', sortable: true },
  { text: 'Cor', value: 'color', sortable: false },
  { text: 'Ações', value: 'actions', sortable: false },
]

function confirmDelete(id) {
  if (confirm('Tem certeza que deseja remover esta etiqueta?')) {
    router.delete(route('admin.tags.destroy', id))
  }
}

const editingId = ref(null)
const editName = ref('')

function startEdit(id, currentName) {
  editingId.value = id
  editName.value = currentName
}

function saveEdit(id) {
  const tag = props.tags.find(t => t.id === id)
  if (!tag || tag.name === editName.value.trim()) {
    editingId.value = null
    return
  }

  router.put(route('admin.tags.update', id), {
    name: editName.value,
    color: tag.color,
  }, {
    preserveScroll: true,
    onSuccess: () => {
      editingId.value = null
    },
  })
}

</script>
