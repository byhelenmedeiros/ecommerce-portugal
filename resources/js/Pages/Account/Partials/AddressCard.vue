<script setup>
import { ref, watch } from 'vue'
import { useForm, router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

const props = defineProps({
  title: String,
  initialAddress: {
    type: Object,
    default: () => ({})
  },
  updateUrl: String,
  deleteUrl: String,
  editable: {
    type: Boolean,
    default: true
  }
})

const emits = defineEmits(['updated', 'deleted'])

const editing = ref(false)

const addressData = ref({ ...props.initialAddress })

const form = useForm({
  address: '',
  door: '',
  floor: '',
  location: '',
  postal_code: '',
  city: '',
  district: '',
  country: 'Portugal',
})

watch(() => props.initialAddress, (val) => {
  addressData.value = val ?? {}
  Object.assign(form, val ?? {})
}, { immediate: true })

function cancelEdit() {
  editing.value = false
  form.reset()
}

function submit() {
  form.patch(route(props.updateUrl), {
    preserveScroll: true,
    onSuccess: () => {
      editing.value = false
      emits('updated', { ...form.data() })
      toast('Morada atualizada com sucesso!')
    },
  })
}

function remove() {
  if (confirm('Tem a certeza que deseja remover esta morada?')) {
    router.delete(route(props.deleteUrl), {
      preserveScroll: true,
      onSuccess: () => {
        emits('deleted')
        toast('Morada removida com sucesso.')
      },
    })
  }
}

function toast(message) {
  const el = document.createElement('div')
  el.textContent = message
  el.className = 'fixed bottom-5 right-5 bg-green-600 text-white px-4 py-2 rounded shadow text-sm animate-fade-in-out'
  document.body.appendChild(el)
  setTimeout(() => el.remove(), 3000)
}
</script>

<template>
  <div class="bg-white p-6 rounded shadow border space-y-4">
    <div class="flex justify-between items-start">
      <h2 class="text-lg font-semibold text-gray-800">{{ title }}</h2>
      <div class="flex items-center gap-3">
        <button
          v-if="!editing && editable"
          @click="editing = true"
          class="text-sm text-green-600 hover:underline"
        >
          Editar
        </button>
        <button
          v-if="editable"
          @click="remove"
          class="text-sm text-red-500 hover:underline"
        >
          Remover
        </button>
      </div>
    </div>

    <form
      v-if="editing"
      @submit.prevent="submit"
      class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm"
    >
      <div v-for="field in [
        { label: 'Morada', key: 'address', required: true },
        { label: 'Nº Porta', key: 'door' },
        { label: 'Andar', key: 'floor' },
        { label: 'Localidade', key: 'location' },
        { label: 'Código Postal', key: 'postal_code', required: true },
        { label: 'Cidade', key: 'city', required: true },
        { label: 'Distrito', key: 'district', required: true },
        { label: 'País', key: 'country', required: true },
      ]" :key="field.key">
        <label class="text-xs text-gray-500">{{ field.label }}</label>
        <input
          v-model="form[field.key]"
          type="text"
          class="w-full border rounded px-2 py-1"
          :required="field.required"
        />
      </div>

      <div class="col-span-2 flex justify-end gap-3 mt-2">
        <button type="button" @click="cancelEdit" class="px-3 py-1 bg-gray-100 rounded hover:bg-gray-200">
          Cancelar
        </button>
        <button
          type="submit"
          class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700"
          :disabled="form.processing"
        >
          Guardar
        </button>
      </div>
    </form>

    <div v-else class="text-sm text-gray-700 space-y-1">
      <p><strong>Morada:</strong> {{ addressData.address }}</p>
      <p><strong>Localidade:</strong> {{ addressData.location }}</p>
      <p><strong>Código Postal:</strong> {{ addressData.postal_code }}</p>
      <p><strong>Cidade:</strong> {{ addressData.city }}</p>
      <p><strong>Distrito:</strong> {{ addressData.district }}</p>
      <p><strong>País:</strong> {{ addressData.country }}</p>
      <p><strong>Nº Porta:</strong> {{ addressData.door }}</p>
      <p><strong>Andar:</strong> {{ addressData.floor }}</p>
    </div>
  </div>
</template>
