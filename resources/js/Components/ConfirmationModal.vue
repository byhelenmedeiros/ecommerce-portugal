<template>
  <div v-if="show" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded shadow-md text-sm max-w-md w-full">
      <p class="mb-4 text-gray-800">Tem a certeza que deseja remover este produto?</p>
      <div class="flex justify-end space-x-3">
        <button @click="$emit('cancel')" class="px-3 py-1 border rounded text-gray-600 hover:bg-gray-100">Cancelar</button>
        <button @click="$emit('confirm')" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Remover</button>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({ show: Boolean });
</script>
