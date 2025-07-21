<template>
  <AdminLayout title="Clientes">
    <Head title="Gerir Clientes" />

    <!-- Cabeçalho -->
    <template #header>
      <h2 class="text-base font-semibold text-gray-800">Gestão de Clientes</h2>
    </template>

    <div class="py-2">
      <div class="mx-auto">
        <h3 class="text-md font-semibold text-gray-700 p-3">Lista de Clientes</h3>
        <div class="bg-white border rounded shadow-sm">

          <!-- Tabela com EasyDataTable -->
          <EasyDataTable
            :headers="headers"
             :items="props.clientes"
            :search-field="'name'"
            :rows-per-page="10"
            show-index
            show-checkbox
            alternating
            border-cell
            theme-color="green"
            table-class="min-w-full text-xs text-left divide-y"
            header-text-direction="left"
          >
            <!-- Coluna de Ações -->
            <template #item-actions="{ id }">
              <div class="flex gap-2 justify-end">
                <Link
                  :href="`/admin/users/${id}`"
                  class="text-blue-600 hover:underline text-xs inline-flex items-center gap-1"
                  title="Ver detalhes"
                >
                  <font-awesome-icon icon="fa-solid fa-eye" />
                  Ver
                </Link>

                <Link
                  :href="`/admin/users/${id}/orders`"
                  class="text-green-600 hover:underline text-xs inline-flex items-center gap-1"
                  title="Ver pedidos"
                >
                  <font-awesome-icon icon="fa-solid fa-box-open" />
                  Pedidos
                </Link>
              </div>
            </template>
          </EasyDataTable>

        </div>
      </div>
    </div>
  </AdminLayout>
</template>
<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, Head } from '@inertiajs/vue3'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

const props = defineProps({
  clientes: {
    type: Array,
    default: () => []
  }
})

console.log('Clientes:', props.clientes)

const headers = [
  { text: "ID", value: "id", sortable: true },
  { text: "Nome", value: "name", sortable: true },
  { text: "Email", value: "email" },
  { text: "Telefone", value: "phone" },
  { text: "Criado em", value: "created_at" },
  { text: "Ações", value: "actions", sortable: false },
]
</script>
