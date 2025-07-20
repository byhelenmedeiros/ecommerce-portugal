<template>
  <div class="relative">
    <!-- Botão de abrir modal -->
    <button
      @click="showPopup = true"
      class="text-green-600 hover:text-red-600 text-xl transition-all duration-200"
    >
      <font-awesome-icon :icon="['fas', 'search']" />
    </button>

    <!-- Modal de busca -->
    <transition name="slide-down">
      <div
        v-if="showPopup"
        class="fixed inset-0 z-50 bg-white/90 backdrop-blur-sm flex flex-col items-center px-4 pt-10 sm:pt-20"
      >
        <!-- Botão de Fechar -->
        <button
          @click="showPopup = false"
          class="absolute top-4 right-4 text-gray-500 hover:text-red-600 text-2xl"
        >
          <font-awesome-icon :icon="['fas', 'xmark']" />
        </button>

        <!-- Campo de Pesquisa com ícone -->
        <form @submit.prevent="submit" class="w-full max-w-xl relative">
          <font-awesome-icon
            :icon="['fas', 'search']"
            class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-base"
          />
          <input
            v-model="query"
            type="text"
            placeholder="Pesquisar..."
            class="w-full pl-10 pr-4 py-3 text-lg border-b border-gray-400 bg-transparent text-gray-800 focus:outline-none focus:border-green-600"
            autofocus
          />
        </form>

        <!-- Sugestões -->
        <div class="mt-6 w-full max-w-xl">
          <h2 class="text-sm font-semibold text-gray-700 mb-3">Sugestões populares</h2>
          <ul class="grid grid-cols-2 sm:grid-cols-3 gap-2 text-sm text-gray-600">
            <li
              v-for="sugestao in sugestões"
              :key="sugestao"
              @click="selectSuggestion(sugestao)"
              class="cursor-pointer px-3 py-2 rounded hover:bg-gray-100 transition"
            >
              {{ sugestao }}
            </li>
          </ul>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const showPopup = ref(false)
const query = ref('')

const sugestões = [
  'vinhos portugueses',
  'azeites artesanais',
  'queijos do norte',
  'doces tradicionais',
  'bordados minhotos',
  'cerâmica portuguesa',
  'compotas caseiras'
]

const submit = () => {
  if (query.value.trim()) {
    window.location.href = `/search?query=${encodeURIComponent(query.value)}`
  }
}

const selectSuggestion = (texto) => {
  query.value = texto
  showPopup.value = false
  submit()
}
</script>

<style scoped>
.slide-down-enter-active {
  transition: all 0.3s ease-out;
  transform: translateY(-100%);
  opacity: 0;
}
.slide-down-enter-to {
  transform: translateY(0);
  opacity: 1;
}
.slide-down-leave-active {
  transition: all 0.2s ease-in;
  transform: translateY(0);
  opacity: 1;
}
.slide-down-leave-to {
  transform: translateY(-20%);
  opacity: 0;
}
</style>
