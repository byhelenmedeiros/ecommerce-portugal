<template>
  <section class="max-w-7xl mx-auto py-8 px-4">
    <div class="grid md:grid-cols-2 gap-8">
      <!-- Imagem -->
      <div>
        <img :src="product.image_url" :alt="product.name" class="w-full rounded shadow" />
        <!-- Galeria (opcional) -->
        <div class="flex mt-4 gap-2">
          <img
            v-for="(img, index) in product.images"
            :key="index"
            :src="img.url"
            class="w-16 h-16 object-cover rounded border cursor-pointer"
          />
        </div>
      </div>

      <!-- Informações do Produto -->
      <div>
        <h1 class="text-2xl font-bold mb-2">{{ product.name }}</h1>
        <p class="text-gray-500 mb-2">{{ product.category?.name }} · {{ product.region?.name }}</p>

        <div class="text-2xl text-green-700 font-semibold mb-4">
          €{{ product.final_price.toFixed(2) }}
        </div>

        <p class="text-gray-700 leading-relaxed mb-6">{{ product.description }}</p>

        <div class="mb-4">
          <span
            class="inline-block px-3 py-1 rounded-full text-sm"
            :class="product.status === 'disponivel' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'"
          >
            {{ product.status === 'disponivel' ? 'Disponível' : 'Esgotado' }}
          </span>
        </div>

        <button
          class="bg-green-700 hover:bg-green-800 text-white px-6 py-3 rounded shadow"
          :disabled="product.status !== 'disponivel'"
        >
          Adicionar ao carrinho
        </button>
      </div>
    </div>
  </section>
</template>

<script setup>
defineProps({
  product: Object
})
</script>
