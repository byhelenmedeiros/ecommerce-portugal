<template>
  <section class="bg-red-400 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      <!-- Título -->
      <h2 class="text-center text-white text-2xl sm:text-3xl font-extrabold mb-8 animate-fade-in">
        <font-awesome-icon :icon="['fas', 'info-circle']" class="mr-2 text-white text-xl" />
        Porque comprar connosco?
      </h2>

      <!-- Grid -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-white text-center">
        <!-- Card -->
        <div
          v-for="(item, i) in beneficios"
          :key="i"
          class="bg-red-700/40 rounded-lg shadow-md hover:shadow-lg p-5 transition-all duration-300 animate-fade-up"
          :style="{ animationDelay: `${i * 100}ms` }"
        >
          <div class="w-12 h-12 mx-auto bg-white/10 rounded-full flex items-center justify-center shadow-inner mb-4">
            <font-awesome-icon :icon="item.icon" class="text-xl text-white" />
          </div>
          <h4 class="text-sm font-bold mb-1">{{ item.titulo }}</h4>
          <p class="text-xs leading-snug text-white/90">{{ item.desc }}</p>
        </div>
      </div>

    </div>
  </section>
</template>

<script setup>
const beneficios = [
  {
    icon: ['fas', 'truck'],
    titulo: 'Entrega Rápida',
    desc: 'Receba sua encomenda em até 48h úteis em Portugal continental.',
  },
  {
    icon: ['fas', 'lock'],
    titulo: 'Pagamento Seguro',
    desc: 'Protegido com criptografia SSL e múltiplas opções de pagamento.',
  },
  {
    icon: ['fas', 'undo-alt'],
    titulo: 'Devoluções Fáceis',
    desc: 'Até 14 dias após a entrega, sem complicações.',
  },
  {
    icon: ['fas', 'leaf'],
    titulo: 'Comércio Local',
    desc: 'Valorizamos pequenos produtores do Norte de Portugal.',
  },
]
</script>

<style scoped>
@keyframes fade-up {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
.animate-fade-up {
  animation: fade-up 0.5s ease forwards;
}
.animate-fade-in {
  animation: fade-up 0.8s ease forwards;
}
</style>
