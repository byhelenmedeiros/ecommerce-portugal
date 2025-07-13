<template>
  <form @submit.prevent="submit" class="flex items-center gap-2 w-full max-w-xl">
    <input
      v-model="query"
      type="text"
      :placeholder="placeholder"
      @focus="handleFocus"
      @blur="handleBlur"
      class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-800 text-sm shadow-sm transition focus:outline-none focus:ring-2 focus:ring-red-500"
    />
    <button
      type="submit"
      class="px-4 py-2 rounded-lg bg-green-600 text-white text-sm font-semibold hover:bg-red-600 transition"
    >
      Buscar
    </button>
  </form>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const query = ref('')
const placeholder = ref('Pesquisar...')
const paused = ref(false)

const sugestões = [
  'vinhos portugueses',
  'azeites artesanais',
  'queijos do norte',
  'doces tradicionais',
  'artesanato local',
]

let index = 0
let subindex = 0
let apagar = false
let speed = 80

const handleFocus = () => {
  paused.value = true
  placeholder.value = ''
}

const handleBlur = () => {
  paused.value = false
  placeholder.value = 'Pesquisar por ' + sugestões[index].substring(0, subindex)
}

const typewriter = () => {
  if (paused.value) return setTimeout(typewriter, 200)

  const atual = sugestões[index]

  if (!apagar) {
    placeholder.value = 'Pesquisar por ' + atual.substring(0, subindex++)
  } else {
    placeholder.value = 'Pesquisar por ' + atual.substring(0, subindex--)
  }

  if (!apagar && subindex === atual.length + 1) {
    apagar = true
    return setTimeout(typewriter, 1000)
  }

  if (apagar && subindex === 0) {
    apagar = false
    index = (index + 1) % sugestões.length
  }

  setTimeout(typewriter, apagar ? 40 : speed)
}

onMounted(() => {
  typewriter()
})

const submit = () => {
  if (query.value.trim()) {
    window.location.href = `/search?query=${encodeURIComponent(query.value)}`
  }
}
</script>
