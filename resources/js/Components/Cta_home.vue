<template>
  <section class="bg-green-800  text-white py-12">
    <div class=" mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">

        <!-- Texto e CTA -->
        <div class="text-center lg:text-left space-y-4">
          <h2 class="text-2xl sm:text-3xl font-extrabold">
            Sabores autênticos, entregues à sua porta.
          </h2>
          <p class="text-base sm:text-lg">
            Produtos regionais selecionados com carinho, direto do Norte para sua casa.<br />
            <span class="font-semibold text-white">Frete grátis para todo o país – aproveite agora!</span>
          </p>
          <a
            href="/shop"
            class="inline-block px-6 py-3 bg-white text-green-700 font-bold rounded-full shadow hover:bg-red-600 hover:text-white transition duration-300"
          >
            Explorar Produtos
          </a>
        </div>

        <!-- Slider de Produtos -->
        <div class="relative overflow-hidden">
          <div class="flex gap-4 animate-slide" style="animation: slide 20s linear infinite;">
            <div
              v-for="(produto, index) in produtosMaisVendidos"
              :key="index"
              class="flex-shrink-0 w-48 bg-white text-green-800 rounded-lg shadow p-4 text-center"
            >
              <img :src="produto.imagem" :alt="produto.nome" class="w-full h-32 object-cover rounded mb-2" />
              <h3 class="text-sm font-bold truncate">{{ produto.nome }}</h3>
              <p class="text-sm">€{{ produto.preco.toFixed(2) }}</p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
</template>

<script setup>
const produtosMaisVendidos = [
  { nome: 'Vinho Verde', preco: 12.5, imagem: 'https://via.placeholder.com/150' },
  { nome: 'Queijo da Serra', preco: 8.9, imagem: 'https://via.placeholder.com/150' },
  { nome: 'Doce de Abóbora', preco: 5.3, imagem: 'https://via.placeholder.com/150' },
  { nome: 'Presunto Curado', preco: 14.0, imagem: 'https://via.placeholder.com/150' },
  { nome: 'Azeite Artesanal', preco: 7.2, imagem: 'https://via.placeholder.com/150' }
];
</script>

<style scoped>
@keyframes slide {
  0% { transform: translateX(0%); }
  100% { transform: translateX(-100%); }
}
</style>
