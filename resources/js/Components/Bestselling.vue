<template>
  <section class="bg-white py-16 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Título -->
      <div class="text-center mb-10">
        <h2 class="text-3xl sm:text-4xl font-extrabold text-green-700 drop-shadow-sm">
          Produtos em Destaque
        </h2>
        <p class="mt-2 text-base sm:text-lg text-gray-600">
          Os favoritos da nossa comunidade. Descubra os seus.
        </p>
      </div>

      <!-- Fades laterais -->
      <div class="absolute top-0 bottom-0 left-0 w-12 bg-gradient-to-r from-white to-transparent z-10 pointer-events-none"></div>
      <div class="absolute top-0 bottom-0 right-0 w-12 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none"></div>

      <!-- Slider com efeito de continuidade -->
      <div
        class="flex gap-6 overflow-x-auto no-scrollbar scroll-smooth snap-x snap-mandatory pb-4 pr-10 scroll-px-6"
      >
        <div
          v-for="(produto, index) in destaques"
          :key="index"
          class="flex-shrink-0 w-[200px] bg-white rounded-xl shadow hover:shadow-lg transition-all duration-300 group snap-start"
        >
          <div class="relative overflow-hidden rounded-t-xl">
            <img
              :src="produto.imagem"
              :alt="produto.nome"
              class="w-full h-40 object-cover transition-transform duration-300 group-hover:scale-105"
            />
          </div>
          <div class="p-4 space-y-2">
            <h3 class="text-sm font-semibold text-gray-800">{{ produto.nome }}</h3>
            <p class="text-green-700 font-bold text-sm">€ {{ produto.preco }}</p>
            <a
              href="/shop"
              class="inline-block mt-2 px-4 py-2 bg-green-600 text-white rounded-full text-xs font-semibold hover:bg-red-600 transition"
            >
              Ver Produto
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  data() {
    return {
      destaques: [
        { nome: 'Queijo da Serra', preco: '12.99', imagem: '/images/queijo.png' },
        { nome: 'Vinho Verde', preco: '9.90', imagem: '/images/vinho-verde.png' },
        { nome: 'Mel Silvestre', preco: '5.20', imagem: '/images/mel.png' },
        { nome: 'Azeite Tradicional', preco: '8.40', imagem: '/images/azeite.png' },
        { nome: 'Chouriço Caseiro', preco: '6.70', imagem: '/images/chourico.png' },
        { nome: 'Doce de Abóbora', preco: '4.99', imagem: '/images/doce.png' },
        { nome: 'Broa de Milho', preco: '2.80', imagem: '/images/broa.png' },
        { nome: 'Compota Artesanal', preco: '3.70', imagem: '/images/compota.png' },
        { nome: 'Vinho do Porto', preco: '15.00', imagem: '/images/porto.png' },
        { nome: 'Presunto Curado', preco: '19.00', imagem: '/images/presunto.png' }
      ]
    }
  }
}
</script>
