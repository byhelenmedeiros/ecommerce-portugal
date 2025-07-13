<template>
  <section class="relative overflow-hidden bg-cover bg-center h-[70vh]" style="background-image: url('/images/bg-hero.jpg')">
    <!-- Overlay verde com opacidade -->
    <div class="absolute inset-0 bg-green-700/70 z-0"></div>

    <!-- Nome discreto no fundo -->
    <div class="absolute text-[8rem] sm:text-[16rem] font-bold font-sarina text-white opacity-10 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-0 pointer-events-none select-none">
      almaminhota
    </div>

    <!-- Conteúdo -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
      <!-- Texto -->
      <div class="space-y-6 text-white">
      
      <div class="inline-block bg-white bg-opacity-25 text-green-600 text-xs font-semibold px-3 py-1 rounded-full shadow">
  Produtos regionais do Norte na sua casa
</div>

        <h2 class="text-4xl sm:text-5xl font-extrabold leading-tight">
          Está pronto para descobrir os sabores do Norte?
        </h2>
        <p class="text-base sm:text-lg text-green-100">
          Produtos autênticos, sabores únicos, entregues com carinho. Explore agora.
        </p>
        <a href="/shop" class="inline-block px-6 py-3 bg-white text-green-700 font-semibold rounded-full shadow hover:bg-red-600 hover:text-white transition">
          Comprar Agora
        </a>
      </div>

      <!-- Imagem do produto -->
      <div class="flex justify-center md:justify-end">
        <img src="/images/produto-destaque.png" alt="Produto destaque" class="w-[300px] md:w-[400px] object-contain drop-shadow-xl" />
      </div>
    </div>

    <!-- Produtos em destaque -->
    <div class="relative z-10 px-4 sm:px-6 lg:px-8 pb-16">
      <div class="flex justify-center gap-4 overflow-x-auto pt-4">
        <div v-for="(produto, index) in produtos" :key="index" class="bg-white rounded-xl shadow-md p-4 min-w-[200px] text-center">
          <img :src="produto.imagem" :alt="produto.nome" class="h-24 mx-auto object-contain mb-2" />
          <h4 class="text-sm font-medium text-gray-700">{{ produto.nome }}</h4>
          <p class="text-sm font-semibold text-green-700">€ {{ produto.preco }}</p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
const produtos = [
  {
    nome: 'Queijo da Serra',
    preco: '12.99',
    imagem: '/images/queijo.png',
  },
  {
    nome: 'Vinho Tinto',
    preco: '8.49',
    imagem: '/images/vinho.png',
  },
  {
    nome: 'Doce Artesanal',
    preco: '5.90',
    imagem: '/images/doce.png',
  },
]
</script>
