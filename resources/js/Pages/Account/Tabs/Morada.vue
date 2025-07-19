<template>
  <div class="space-y-10 animate-fade-in">
    <h1 class="text-xl font-semibold text-gray-800">📍 Moradas</h1>

    <AddressCard
      title="Morada Fiscal"
      :initial-address="fiscal"
      update-url="account.addresses.update.fiscal"
    />

    <AddressCard
      title="Morada de Entrega"
      :initial-address="entrega"
      update-url="account.addresses.update.entrega"
    />
  </div>
</template>

<script setup>
import AddressCard from '../Partials/AddressCard.vue'

const props = defineProps({
  fiscal: Object,
  entrega: Object,
})
</script>

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
