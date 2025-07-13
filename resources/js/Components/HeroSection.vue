<template>
<section class="relative overflow-visible bg-cover bg-center h-[70vh] pb-[100px]" style="background-image: url('/images/bg-hero.jpg')">
    <!-- Overlay com degradê animado -->
    <div class="absolute inset-0 bg-gradient-to-br from-green-800/80 to-red-800/80 backdrop-blur-sm z-0 animate-pulse-slow"></div>

    <!-- Marca d’água discreta -->
    <div class="absolute text-[6rem] sm:text-[14rem] font-bold font-sarina text-white opacity-5 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-0 pointer-events-none select-none">
      almaminhota
    </div>

    <!-- Conteúdo principal -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full grid grid-cols-1 md:grid-cols-2 items-center gap-12">
      
  <!-- Texto -->
<div class="text-white space-y-6 animate-fade-in">
  
  <!-- Selo com ícone -->
  <div class="inline-flex items-center gap-2 bg-white/20 text-xs font-semibold px-4 py-1 rounded-full shadow">
    <font-awesome-icon :icon="['fas', 'leaf']" class="text-green-100 text-sm" />
    Produtos regionais com alma portuguesa
  </div>

  <!-- Título com destaques -->
  <h1 class="text-5xl sm:text-6xl font-extrabold leading-tight tracking-tight drop-shadow-lg">
    <span class="block">Explore os</span>
    <span class="text-red-400">sabores autênticos</span>
    <span class="block">do <span class="text-red-400">Norte</span></span>
  </h1>

  <!-- Parágrafo com ícone + ênfase -->
  <p class="text-base sm:text-lg text-green-100 flex items-start gap-2">
    <font-awesome-icon :icon="['fas', 'wine-bottle']" class="text-green-200 pt-1" />
    <span>
      <strong class="text-white">Queijos premiados</strong>, <strong class="text-white">vinhos de excelência</strong> e <strong class="text-white">doces artesanais</strong>.
      Uma viagem de sabores em cada clique.
    </span>
  </p>

  <!-- Call-to-action com ícone -->
  <a
    href="/shop"
    class="inline-flex items-center gap-2 px-6 py-3 bg-white text-green-700 font-semibold rounded-full shadow-lg hover:bg-red-600 hover:text-white transition duration-300"
  >
    <font-awesome-icon :icon="['fas', 'shopping-basket']" />
    Ver Produtos
  </a>
</div>

<!-- Selo rotativo no canto superior direito -->
<div class="absolute top-6 right-6 z-20 animate-spin-slow">
  <div class="relative w-24 h-24 rounded-full border-2 border-white flex items-center justify-center text-white text-[10px] font-semibold uppercase tracking-wider">
    <span class="absolute text-[9px] text-center w-full leading-tight">
      Entrega Gratuita em Portugal
    </span>
  </div>
</div>

      <!-- Imagem principal -->
      <div class="flex justify-center md:justify-end animate-fade-up">
        <img
          src="/images/vinho.png"
          alt="Celebrando com vinho"
          class="w-[340px] md:w-[500px]"
        />
      </div>
    </div>

<!-- Produtos destacados flutuantes -->
<div
  class="absolute bottom-[-60px] left-1/2 -translate-x-1/2 z-20 w-full max-w-6xl px-4 sm:px-6 lg:px-8"
>
  <div class="flex justify-center gap-6 pt-4 flex-wrap">
    <div
      v-for="(produto, index) in produtos"
      :key="index"
      class="relative bg-white rounded-xl shadow-md p-3 w-[200px] flex items-center justify-between hover:shadow-2xl hover:scale-105 transition-all duration-300"
    >
      <!-- Imagem -->
      <img
        :src="produto.imagem"
        :alt="produto.nome"
        class="h-14 w-14 object-contain"
      />

      <!-- Nome e preço -->
      <div class="ml-3">
        <h4 class="text-sm font-semibold text-gray-800">{{ produto.nome }}</h4>
        <p class="text-sm font-bold text-green-700 mt-1">€ {{ produto.preco }}</p>
      </div>

      <!-- Botão de carrinho -->
      <div
        class="absolute -bottom-4 -right-4 bg-green-600 hover:bg-red-600 text-white w-10 h-10 flex items-center justify-center rounded-full shadow-lg transition-all duration-300 cursor-pointer"
      >
        <font-awesome-icon :icon="['fas', 'shopping-cart']" class="text-sm" />
      </div>
    </div>
  </div>
</div>



  </section>
  <section class="mt-[80px] ">
  </section>

</template>

<script setup>
const produtos = [
  { nome: 'Queijo da Serra', preco: '12.99', imagem: '/images/queijo.png' },
  { nome: 'Vinho Tinto', preco: '8.49', imagem: '/images/vinho.png' },
  { nome: 'Doce Artesanal', preco: '5.90', imagem: '/images/doce.png' },
]
</script>

<style scoped>
</style>