<script setup>
import AddressCard from '../Partials/AddressCard.vue'
import { ref, watch } from 'vue'

const props = defineProps({
  fiscal: {
    type: Object,
    default: () => ({})
  },
  entrega: {
    type: Object,
    default: () => ({})
  },
})

const fiscalAddress = ref({ ...props.fiscal })
const entregaAddress = ref({ ...props.entrega })

watch(() => props.fiscal, (val) => {
  fiscalAddress.value = val ?? {}
})

watch(() => props.entrega, (val) => {
  entregaAddress.value = val ?? {}
})

function copiarFiscalParaEntrega() {
  if (!fiscalAddress.value || Object.keys(fiscalAddress.value).length === 0) {
    toast('A morada fiscal está vazia!')
    return
  }
  entregaAddress.value = { ...fiscalAddress.value }
}

function toast(msg) {
  const el = document.createElement('div')
  el.textContent = msg
  el.className = 'fixed bottom-5 right-5 bg-red-600 text-white px-4 py-2 rounded shadow text-sm animate-fade-in-out'
  document.body.appendChild(el)
  setTimeout(() => el.remove(), 3000)
}
</script>

<template>
  <div class="space-y-10 animate-fade-in">
    <div class="flex items-center justify-between">
      <h1 class="text-xl font-semibold text-gray-800">Moradas</h1>
      <button
        class="text-sm text-red-600 hover:underline"
        @click="copiarFiscalParaEntrega"
      >
        Morada de entrega igual à de faturação
      </button>
    </div>

    <!-- Morada Fiscal -->
    <AddressCard
      title="Morada Fiscal"
      :initial-address="fiscalAddress"
      update-url="account.address.account.fiscal"
      delete-url="account.address.account.fiscal"
      @updated="val => fiscalAddress.value = val"
      @deleted="fiscalAddress.value = {}"
    />

    <!-- Morada Entrega -->
    <AddressCard
      title="Morada de Entrega"
      :initial-address="entregaAddress"
      update-url="account.address.account.entrega"
      delete-url="account.address.account.entrega"
      @updated="val => entregaAddress.value = val"
      @deleted="entregaAddress.value = {}"
    />
  </div>
</template>

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
