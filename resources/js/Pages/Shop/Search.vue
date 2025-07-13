<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'

const route = usePage().url
const query = computed(() => new URLSearchParams(route.split('?')[1]).get('query'))
</script>

<template>
  <GuestLayout>
    <div class="max-w-7xl mx-auto py-10 px-4">
      <h2 class="text-2xl font-bold text-red-600 mb-4">Resultados para: "{{ query }}"</h2>

      <!-- Exemplo de conteúdo de resultados -->
      <p class="text-gray-700 mb-6">Aqui vão aparecer os produtos filtrados por "{{ query }}"</p>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="border rounded shadow p-4 text-center" v-for="i in 6" :key="i">
          <h3 class="text-lg font-semibold">Produto {{ i }}</h3>
          <p class="text-sm text-gray-500">Resultado genérico</p>
        </div>
      </div>
    </div>
  </GuestLayout>
</template>
