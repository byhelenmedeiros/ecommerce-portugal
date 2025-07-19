<template>
  <div class="space-y-6 animate-fade-in">
    <!-- Cabeçalho -->
    <div class="flex items-center justify-between">
      <h1 class="text-xl font-semibold text-gray-800">Dados Pessoais</h1>
      <button
        class="px-3 py-1 text-sm text-green-700 border border-green-600 rounded hover:bg-green-600 hover:text-white transition"
      >
        Editar
      </button>
    </div>

    <!-- Bloco de Dados -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-700">
      <div class="group hover:shadow-md hover:bg-gray-50 rounded p-4 transition">
        <p class="text-xs text-gray-400 mb-1">Nome completo</p>
        <p class="font-medium group-hover:text-green-700">{{ user.name }}</p>
      </div>

      <div class="group hover:shadow-md hover:bg-gray-50 rounded p-4 transition">
        <p class="text-xs text-gray-400 mb-1">Email</p>
        <p class="font-medium group-hover:text-green-700">{{ user.email }}</p>
      </div>

      <div class="group hover:shadow-md hover:bg-gray-50 rounded p-4 transition">
        <p class="text-xs text-gray-400 mb-1">Registado em</p>
        <p class="font-medium group-hover:text-green-700">{{ formatDate(user.created_at) }}</p>
      </div>

    
    </div>
  </div>
</template>

<script setup>
import { format } from 'date-fns'
import { pt } from 'date-fns/locale'

const props = defineProps({ user: Object })

const formatDate = (date) =>
  format(new Date(date), "dd 'de' MMMM 'de' yyyy", { locale: pt })
</script>

<style scoped>
@keyframes fade-in {
  0% {
    opacity: 0;
    transform: translateY(10px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}
.animate-fade-in {
  animation: fade-in 0.4s ease-out;
}
</style>
