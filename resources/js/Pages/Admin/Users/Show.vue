<template>
  <AdminLayout :title="`Cliente: ${cliente.name}`">

    <Head :title="`Cliente ${cliente.name}`" />

    <div class="max-w-7xl mx-auto py-6 space-y-6">

      <!-- Estatísticas do cliente -->
      <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border rounded shadow-sm p-4">
          <p class="text-sm text-gray-500">Total de Pedidos</p>
          <p class="text-xl font-bold text-green-700">{{ props.stats.total_pedidos }}</p>
        </div>

        <div class="bg-white border rounded shadow-sm p-4">
          <p class="text-sm text-gray-500">Valor Total Gasto</p>
          <p class="text-xl font-bold text-green-700">€ {{ Number(props.stats.valor_total).toFixed(2) }}</p>
        </div>

        <div class="bg-white border rounded shadow-sm p-4">
          <p class="text-sm text-gray-500">Ticket Médio</p>
          <p class="text-xl font-bold text-green-700">€ {{ Number(props.stats.ticket_medio).toFixed(2) }}</p>
        </div>

        <div class="bg-white border rounded shadow-sm p-4">
          <p class="text-sm text-gray-500">Último Pedido</p>
          <p class="text-xl font-bold text-green-700">
            {{ props.stats.ultimo_pedido ? new Date(props.stats.ultimo_pedido).toLocaleDateString() : '—' }}
          </p>
        </div>
      </section>


      <!-- Navegação de abas -->
      <div class="flex border-b space-x-2 text-sm font-medium">
        <button v-for="tab in tabs" :key="tab" @click="activeTab = tab" :class="[
          'px-3 py-2 border-b-2',
          activeTab === tab
            ? 'border-green-600 text-green-700'
            : 'border-transparent text-gray-500 hover:text-green-600'
        ]">
          {{ tab }}
        </button>
      </div>

   <!-- Aba: Dados Pessoais -->
<div v-if="activeTab === 'Dados Pessoais'" class="bg-white border rounded shadow-sm p-6 space-y-4">
  <div class="flex justify-between items-center">
    <h2 class="text-lg font-semibold text-gray-800">Dados do Cliente</h2>
  </div>
  <div class="grid grid-cols-1 md:grid-cols-4 gap-2 text-sm">
    <div><strong>Nome:</strong> {{ cliente.name }}</div>
    <div><strong>Email:</strong> {{ cliente.email }}</div>
    <div><strong>Telefone:</strong> {{ cliente.phone ?? '—' }}</div>
    <div><strong>Desde:</strong> {{ new Date(cliente.created_at).toLocaleDateString() }}</div>

    <div><strong>Recebe Newsletter:</strong>
      <span :class="cliente.newsletter ? 'text-green-700' : 'text-gray-500'">
        {{ cliente.newsletter ? 'Sim' : 'Não' }}
      </span>
    </div>
    <div><strong>Consentimento LGPD:</strong>
      <span :class="cliente.lgpd_consent ? 'text-green-700' : 'text-gray-500'">
        {{ cliente.lgpd_consent ? 'Sim' : 'Não' }}
      </span>
    </div>
  </div>
</div>

<!-- Aba: Etiquetas -->
<div v-if="activeTab === 'Etiquetas'" class="bg-white border rounded shadow-sm p-6 space-y-4">
  <h2 class="text-lg font-semibold text-gray-800">Etiquetas do Cliente</h2>

  <!-- Lista de etiquetas aplicadas -->
  <div v-if="cliente.tags && cliente.tags.length" class="flex flex-wrap gap-2">
    <span
      v-for="tag in cliente.tags"
      :key="tag.id"
      class="inline-flex items-center gap-1 px-2 py-1 text-xs rounded text-white"
      :style="{ backgroundColor: tag.color }"
    >
      {{ tag.name }}
      <button
        @click="removeTag(tag.id)"
        class="text-white/80 hover:text-white"
        title="Remover"
      >
        &times;
      </button>
    </span>
  </div>
  <div v-else class="text-sm text-gray-500">Sem etiquetas atribuídas.</div>

  <!-- Adicionar nova etiqueta -->
  <form @submit.prevent="addTag" class="mt-4 flex gap-2 items-center">
    <select v-model="newTagId" class="border rounded text-sm px-2 py-1">
      <option disabled value="">Selecione uma etiqueta</option>
      <option v-for="tag in allTags" :key="tag.id" :value="tag.id">
        {{ tag.name }}
      </option>
    </select>
    <button
      type="submit"
      class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700"
    >
      Adicionar
    </button>
  </form>
</div>


      <!-- Aba: Moradas -->
      <div v-if="activeTab === 'Moradas'" class="bg-white border rounded shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Moradas</h2>
        <div v-if="cliente.addresses?.length">
          <div v-for="address in cliente.addresses" :key="address.id" class="border p-3 rounded mb-2 text-sm">
            <p><strong>{{ address.type === 'billing' ? 'Faturação' : 'Entrega' }}</strong></p>
            <p>{{ address.line1 }}</p>
            <p v-if="address.line2">{{ address.line2 }}</p>
            <p>{{ address.postal_code }} {{ address.city }}</p>
            <p>{{ address.country }}</p>
          </div>
        </div>
        <div v-else class="text-gray-500 text-sm">Sem moradas registadas.</div>
      </div>

      <!-- Aba: Histórico de Pedidos -->
      <div v-if="activeTab === 'Histórico de Pedidos'" class="bg-white border rounded shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Histórico de Pedidos</h2>
        <EasyDataTable :headers="orderHeaders" :items="cliente.orders || []" :rows-per-page="10" show-index alternating
          border-cell table-class="rounded shadow-sm" header-text-direction="left" theme-color="green">
          <template #item-total="{ total }">
            € {{ Number(total).toFixed(2) }}
          </template>

          <template #item-created_at="{ created_at }">
            {{ new Date(created_at).toLocaleDateString() }}
          </template>

          <template #item-status="{ status }">
            <span :class="statusClass(status)">
              {{ status }}
            </span>
          </template>

          <template #item-actions="{ id }">
            <Link :href="route('orders.show', { order: id })" class="text-blue-600 hover:underline text-xs">
            Ver
            </Link>
          </template>
        </EasyDataTable>
      </div>

      <!-- Aba: Notas Internas -->
   <div v-if="activeTab === 'Notas Internas'" class="bg-white border rounded shadow-sm p-6 space-y-4">
  <h2 class="text-lg font-semibold text-gray-800">Notas Internas</h2>

  <textarea
    v-model="internalNotes"
    @blur="saveNotes"
    rows="5"
    class="w-full border rounded px-3 py-2 text-sm"
    placeholder="Escreva aqui observações confidenciais sobre o cliente..."
  ></textarea>

  <p v-if="saving" class="text-sm text-gray-400">A guardar...</p>
</div>


    </div>
  </AdminLayout>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { ref } from 'vue'


const props = defineProps({
  cliente: Object,
  stats: Object,
  allTags: Array
})
const cliente = props.cliente
const allTags = ref(props.allTags)


// Tabs disponíveis
const tabs = ['Dados Pessoais', 'Moradas', 'Histórico de Pedidos', 'Etiquetas', 'Notas Internas']
const activeTab = ref(tabs[0])

const newTagId = ref('')
 
function addTag() {
  if (!newTagId.value) return

  router.post(route('admin.users.tags.attach', cliente.id), {
    tag_id: newTagId.value
  }, {
    preserveScroll: true
  })

  newTagId.value = ''
}

function removeTag(tagId) {
  router.delete(route('admin.users.tags.detach', { user: cliente.id, tag: tagId }), {
    preserveScroll: true
  })
}

const internalNotes = ref(props.cliente.internal_notes ?? '')
const saving = ref(false)

function saveNotes() {
  saving.value = true
  router.put(route('admin.users.notes.update', props.cliente.id), {
    internal_notes: internalNotes.value,
  }, {
    preserveScroll: true,
    onFinish: () => {
      saving.value = false
    },
  })
}
const orderHeaders = [
  { text: "ID", value: "id" },
  { text: "Total", value: "total" },
  { text: "Status", value: "status" },
  { text: "Data", value: "created_at" },
  { text: "Ações", value: "actions", sortable: false },
]

const statusClass = (status) => {
  switch (status) {
    case 'pago':
      return 'bg-green-100 text-green-700 font-semibold px-2 py-1 rounded text-xs';
    case 'pendente':
      return 'bg-yellow-100 text-yellow-700 font-semibold px-2 py-1 rounded text-xs';
    case 'cancelado':
      return 'bg-red-100 text-red-700 font-semibold px-2 py-1 rounded text-xs';
    default:
      return 'bg-gray-100 text-gray-700 font-medium px-2 py-1 rounded text-xs';
  }
}
</script>
