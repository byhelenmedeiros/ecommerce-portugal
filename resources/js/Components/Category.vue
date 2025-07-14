<template>
  <section class="bg-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <!-- Título -->
      <h2 class="text-3xl sm:text-4xl font-bold text-green-800 mb-4">
        Descubra por Categorias
      </h2>
      <p class="text-gray-600 mb-10 max-w-2xl mx-auto">
        Explore nossos produtos organizados pelas categorias mais procuradas. Encontre facilmente os sabores e artigos que mais combinam consigo.
      </p>

      <!-- Grid de categorias -->
      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-6">
        <div
          v-for="(cat, i) in categorias"
          :key="i"
          class="group bg-green-50 hover:bg-green-100 transition rounded-lg p-4 cursor-pointer shadow-sm hover:shadow-md"
        >
          <a :href="`/shop?cat=${cat.slug}`" class="flex flex-col items-center">
            <img :src="cat.imagem" :alt="cat.nome" class="h-20 w-20 object-contain mb-3 transition-transform group-hover:scale-105" />
            <span class="text-sm font-semibold text-green-900 group-hover:text-red-600 uppercase tracking-wide">
              {{ cat.nome }}
            </span>
          </a>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
const categorias = [
  { nome: 'Vinhos', slug: 'vinhos', imagem: '/images/categorias/vinhos.png' },
  { nome: 'Queijos', slug: 'queijos', imagem: '/images/categorias/queijos.png' },
  { nome: 'Azeites', slug: 'azeites', imagem: '/images/categorias/azeites.png' },
  { nome: 'Doces', slug: 'doces', imagem: '/images/categorias/doces.png' },
  { nome: 'Artesanato', slug: 'artesanato', imagem: '/images/categorias/artesanato.png' },
]
</script>
