<template>
  <div class="space-y-8 animate-fade-in">
    <!-- Cabeçalho -->
    <div class="flex items-center justify-between">
      <h1 class="text-md font-semibold text-gray-900">Dados Pessoais</h1>
      <button
        @click="toggleEdit"
        class="px-4 py-2 text-sm font-medium text-green-700 border border-green-600 rounded hover:bg-green-600 hover:text-white transition-all duration-200"
      >
        {{ editing ? 'Cancelar' : 'Editar' }}
      </button>
    </div>

    <!-- Modo de Visualização -->
    <div v-if="!editing" class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
      <div v-for="field in displayFields" :key="field.key" class="group bg-white rounded shadow-sm p-2 hover:shadow-md transition">
        <p class="text-xs text-gray-400 mb-1">{{ field.label }}</p>
        <p class="font-medium group-hover:text-green-700">
          {{ formatField(field.key) }}
        </p>
      </div>
    </div>

    <!-- Modo de Edição -->
    <form v-else @submit.prevent="submit" class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
      <!-- Nome completo -->
      <div>
        <label class="block text-xs text-gray-500 mb-1">Nome completo</label>
        <input v-model="form.name" type="text" class="w-full rounded border px-3 py-2" required />
      </div>

      <!-- Email -->
      <div>
        <label class="block text-xs text-gray-500 mb-1">Email</label>
        <input v-model="form.email" type="email" class="w-full rounded border px-3 py-2" required />
      </div>

      <!-- Telefones -->
      <div>
        <label class="block text-xs text-gray-500 mb-1">Telefone principal</label>
        <vue-tel-input v-model="form.phone" defaultCountry="PT" />
      </div>

      <div>
        <label class="block text-xs text-gray-500 mb-1">Telemóvel (alternativo)</label>
        <vue-tel-input v-model="form.phone_alt" defaultCountry="PT" />
      </div>

      <!-- Data nascimento -->
      <div>
        <label class="block text-xs text-gray-500 mb-1">Data de nascimento</label>
        <input v-model="form.birth_date" type="date" class="w-full rounded border px-3 py-2" />
      </div>

      <!-- Nome faturação e NIF -->
      <div>
        <label class="block text-xs text-gray-500 mb-1">Nome para faturação</label>
        <input v-model="form.billing_name" type="text" class="w-full rounded border px-3 py-2" />
      </div>

      <div>
        <label class="block text-xs text-gray-500 mb-1">NIF</label>
        <input v-model="form.nif" type="text" class="w-full rounded border px-3 py-2" pattern="^\d{9}$" />
      </div>

      <!-- Checkbox NIF na fatura -->
      <div class="md:col-span-2 flex items-center gap-2 mt-1">
        <input v-model="form.nif_on_invoice" type="checkbox" id="nifInvoice" class="h-4 w-4" />
        <label for="nifInvoice" class="text-sm text-gray-700">Deseja NIF na fatura?</label>
      </div>

      <!-- Botões -->
      <div class="md:col-span-2 flex justify-end gap-3 mt-2">
        <button type="button" @click="cancelEdit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200">Cancelar</button>
        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Guardar</button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { format } from 'date-fns'
import { pt } from 'date-fns/locale'
const props = defineProps({ user: Object })

const editing = ref(false)
const toggleEdit = () => editing.value = !editing.value
const cancelEdit = () => {
  editing.value = false
  Object.assign(form, { ...props.user })
}

const displayFields = [
  { label: 'Nome completo', key: 'name' },
  { label: 'Email', key: 'email' },
  { label: 'Telefone principal', key: 'phone' },
  { label: 'Telemóvel', key: 'phone_alt' },
  { label: 'Data de nascimento', key: 'birth_date' },
  { label: 'Nome para faturação', key: 'billing_name' },
  { label: 'NIF', key: 'nif' },
  { label: 'Deseja NIF na fatura?', key: 'nif_on_invoice' },
]

const formatDate = (date) =>
  format(new Date(date), "dd 'de' MMMM 'de' yyyy", { locale: pt })

const formatField = (key) => {
  const val = props.user[key]
  if (!val) return '—'
  if (key === 'nif_on_invoice') return val ? 'Sim' : 'Não'
  if (key.includes('date')) return formatDate(val)
  return val
}

const form = useForm({
  name: props.user.name ?? '',
  email: props.user.email ?? '',
  phone: props.user.phone ?? '',
  phone_alt: props.user.phone_alt ?? '',
  birth_date: props.user.birth_date ?? '',
  billing_name: props.user.billing_name ?? '',
  nif: props.user.nif ?? '',
  nif_on_invoice: !!props.user.nif_on_invoice,
})

function submit() {
  form.patch(route('account.update'), {
    preserveScroll: true,
    onSuccess: () => {
      editing.value = false
      toast('Dados atualizados com sucesso!')
    },
  })
}

function toast(msg) {
  const el = document.createElement('div')
  el.textContent = msg
  el.className = 'fixed bottom-5 right-5 bg-green-600 text-white px-4 py-2 rounded shadow text-sm animate-fade-in-out'
  document.body.appendChild(el)
  setTimeout(() => el.remove(), 3000)
}
</script>

<style scoped>
@keyframes fade-in {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
  animation: fade-in 0.4s ease-out;
}
@keyframes fade-in-out {
  0% { opacity: 0; transform: translateY(10px); }
  20% { opacity: 1; transform: translateY(0); }
  80% { opacity: 1; }
  100% { opacity: 0; transform: translateY(10px); }
}
.animate-fade-in-out {
  animation: fade-in-out 3s ease-in-out forwards;
}
</style>
