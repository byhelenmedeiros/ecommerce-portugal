<script setup>
import AddressCard from '../Partials/AddressCard.vue'
import { ref, watch } from 'vue'

const props = defineProps({
  fiscal: Object,
  entrega: Object,
})

const fiscalAddress = ref(props.fiscal)
const entregaAddress = ref(props.entrega)

watch(() => props.fiscal, (val) => {
  fiscalAddress.value = val
})

watch(() => props.entrega, (val) => {
  entregaAddress.value = val
})

function copiarFiscalParaEntrega() {
  entregaAddress.value = { ...fiscalAddress.value }
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
      @updated="val => fiscalAddress.value = val"
       delete-url="account.address.account.entrega" 
      @delete="entregaAddress.value = {}" 
    

    />

    <!-- Morada Entrega -->
    <AddressCard
      title="Morada de Entrega"
      :initial-address="entregaAddress"
      update-url="account.address.account.entrega"
      @updated="val => entregaAddress.value = val"
      delete-url="account.address.account.entrega"
      @delete="entregaAddress.value = {}"
    />
  </div>
</template>

<style scoped>
@keyframes fade-in {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
.animate-fade-in {
  animation: fade-in 0.4s ease-out;
}
</style>
