<template>
  <div class="bg-white p-6 rounded shadow group transition-all border hover:border-green-500">
    <div class="flex justify-between items-start">
      <h2 class="text-lg font-semibold text-gray-700">{{ title }}</h2>
      <button
        v-if="!editing"
        @click="editing = true"
        class="text-sm text-green-600 hover:underline"
      >
        Editar
      </button>
    </div>

    <!-- Formulário de edição -->
    <form
      v-if="editing"
      @submit.prevent="form.patch(route(updateUrl), { onSuccess: () => editing = false })"
      class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4 text-sm"
    >
      <div>
        <label class="text-xs text-gray-500 mb-1 block">Morada</label>
        <input v-model="form.address" type="text" required placeholder="Rua, Avenida..." class="w-full border rounded px-2 py-1" />
      </div>

      <div>
        <label class="text-xs text-gray-500 mb-1 block">Nº Porta</label>
        <input v-model="form.door" type="text" placeholder="Ex: 23A" class="w-full border rounded px-2 py-1" />
      </div>

      <div>
        <label class="text-xs text-gray-500 mb-1 block">Andar</label>
        <input v-model="form.floor" type="text" placeholder="Ex: 2º Esquerdo" class="w-full border rounded px-2 py-1" />
      </div>

      <div>
        <label class="text-xs text-gray-500 mb-1 block">Localidade</label>
        <input v-model="form.location" type="text" class="w-full border rounded px-2 py-1" />
      </div>

      <div>
        <label class="text-xs text-gray-500 mb-1 block">Código Postal</label>
        <input
          v-model="form.postal_code"
          type="text"
          pattern="^\d{4}-\d{3}$"
          required
          placeholder="Ex: 1234-567"
          class="w-full border rounded px-2 py-1"
        />
      </div>

      <div>
        <label class="text-xs text-gray-500 mb-1 block">Cidade</label>
        <input v-model="form.city" type="text" required class="w-full border rounded px-2 py-1" />
      </div>

      <div>
        <label class="text-xs text-gray-500 mb-1 block">Distrito</label>
        <input v-model="form.district" type="text" required class="w-full border rounded px-2 py-1" />
      </div>

      <div>
        <label class="text-xs text-gray-500 mb-1 block">País</label>
        <input v-model="form.country" type="text" required class="w-full border rounded px-2 py-1" />
      </div>

      <div class="col-span-2 flex justify-end gap-3 mt-2">
        <button
          type="button"
          @click="cancelEdit"
          class="px-3 py-1 rounded bg-gray-100 hover:bg-gray-200"
        >
          Cancelar
        </button>
        <button
          type="submit"
          class="px-3 py-1 rounded bg-green-600 text-white hover:bg-green-700"
          :disabled="form.processing"
        >
          Guardar
        </button>
      </div>
    </form>

    <!-- Visualização -->
    <div v-else class="text-sm text-gray-600 mt-3 space-y-1 transition-all group-hover:scale-[1.01]">
      <p><strong>Morada:</strong> {{ initialAddress?.address ?? '—' }} {{ initialAddress?.door ?? '' }} {{ initialAddress?.floor ?? '' }}</p>
      <p><strong>Localidade:</strong> {{ initialAddress?.location ?? '—' }}</p>
      <p><strong>Código Postal:</strong> {{ initialAddress?.postal_code ?? '—' }}</p>
      <p><strong>Cidade:</strong> {{ initialAddress?.city ?? '—' }}</p>
      <p><strong>Distrito:</strong> {{ initialAddress?.district ?? '—' }}</p>
      <p><strong>País:</strong> {{ initialAddress?.country ?? '—' }}</p>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
  title: String,
  initialAddress: Object,
  updateUrl: String,
})

const editing = ref(false)

const form = useForm({
  address: props.initialAddress?.address ?? '',
  door: props.initialAddress?.door ?? '',
  floor: props.initialAddress?.floor ?? '',
  location: props.initialAddress?.location ?? '',
  postal_code: props.initialAddress?.postal_code ?? '',
  city: props.initialAddress?.city ?? '',
  district: props.initialAddress?.district ?? '',
  country: props.initialAddress?.country ?? 'Portugal',
})

watch(() => props.initialAddress, (newVal) => {
  form.address = newVal?.address ?? ''
  form.door = newVal?.door ?? ''
  form.floor = newVal?.floor ?? ''
  form.location = newVal?.location ?? ''
  form.postal_code = newVal?.postal_code ?? ''
  form.city = newVal?.city ?? ''
  form.district = newVal?.district ?? ''
  form.country = newVal?.country ?? 'Portugal'
})

function cancelEdit() {
  editing.value = false
  form.reset()
}
</script>
