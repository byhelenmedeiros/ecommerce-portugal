<template>
  <Head title="Gestão de loja" />

  <div class="min-h-screen  flex bg-gray-100 text-gray-800">
    <!-- Sidebar -->
    <aside class="w-48 bg-white border-r shadow-sm hidden md:flex flex-col justify-between">
      <div>
        <div class="p-2 text-md font-bold text-green-700 border-b">ALMAMINHOTA</div>
        <nav class="p-4 space-y-1 text-sm">

          <!-- Dashboard -->
          <Link :href="route('admin.dashboard')" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-green-100">
            <font-awesome-icon icon="fa-solid fa-chart-line" class="text-green-600" />
            Dashboard
          </Link>

          <!-- Produtos -->
          <div>
            <button @click="isOpenProdutos = !isOpenProdutos" class="flex items-center justify-between w-full px-3 py-2 rounded hover:bg-green-100">
              <span class="flex items-center gap-3">
                <font-awesome-icon icon="fa-solid fa-boxes-stacked" class="text-green-600" />
                Produtos
              </span>
              <font-awesome-icon :icon="isOpenProdutos ? 'fa-chevron-up' : 'fa-chevron-down'" class="text-xs" />
            </button>
            <div v-if="isOpenProdutos" class="ml-6 space-y-1 text-xs">
              <Link :href="route('admin.products.index')" class="block px-3 py-2 rounded hover:bg-green-100">Todos os Produtos</Link>
              <Link :href="route('admin.products.create')" class="block px-3 py-2 rounded hover:bg-green-100">Criar Produto</Link>
            </div>
          </div>

          <!-- Categorias -->
          <div>
            <button @click="isOpenCategorias = !isOpenCategorias" class="flex items-center justify-between w-full px-3 py-2 rounded hover:bg-green-100">
              <span class="flex items-center gap-3">
                <font-awesome-icon icon="fa-solid fa-tags" class="text-green-600" />
                Categorias
              </span>
              <font-awesome-icon :icon="isOpenCategorias ? 'fa-chevron-up' : 'fa-chevron-down'" class="text-xs" />
            </button>
            <div v-if="isOpenCategorias" class="ml-6 space-y-1 text-xs">
              <Link :href="route('admin.categories.index')" class="block px-3 py-2 rounded hover:bg-green-100">Ver Categorias</Link>
            </div>
            
            <div v-if="isOpenCategorias" class="ml-6 space-y-1 text-xs">
              <Link v-for="sub in subcategorias" :key="sub.id" :href="route('admin.subcategories.index', { category: sub.category.slug })" class="block px-3 py-2 rounded hover:bg-green-100">
                {{ sub.name }}
              </Link>
            </div>
          </div>

          <!-- Pedidos -->
          <div>
            <button @click="isOpenPedidos = !isOpenPedidos" class="flex items-center justify-between w-full px-3 py-2 rounded hover:bg-green-100">
              <span class="flex items-center gap-3">
                <font-awesome-icon icon="fa-solid fa-file-invoice-dollar" class="text-green-600" />
                Pedidos
              </span>
              <font-awesome-icon :icon="isOpenPedidos ? 'fa-chevron-up' : 'fa-chevron-down'" class="text-xs" />
            </button>
            <div v-if="isOpenPedidos" class="ml-6 space-y-1 text-xs">
<Link :href="route('orders.index')" class="block px-3 py-2 rounded hover:bg-green-100">Todos os Pedidos</Link>
            </div>
          </div>
          <Link :href="route('admin.users.index')" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-green-100">
            <font-awesome-icon icon="fa-solid fa-users" class="text-green-600" />
            Clientes
          </Link>
          <Link :href="route('admin.tags.index')" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-green-100">
            <font-awesome-icon icon="fa-solid fa-tags" class="text-green-600" />
            Gestão de Etiquetas
          </Link>

          <!-- Logout -->
          <Link :href="route('logout')" method="post" as="button" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-red-100 mt-4">
            <font-awesome-icon icon="fa-solid fa-right-from-bracket" class="text-red-600" />
            Sair
          </Link>

        </nav>
      </div>

      <!-- Rodapé -->
      <div class="p-4 text-xs text-gray-400">&copy; 2025</div>
    </aside>

    <!-- Conteúdo Principal -->
    <div class="flex-1 p-2 overflow-x-auto">
      <slot />
    </div>
  </div>
</template>
<script setup>
import { ref } from 'vue';
import { Link, Head } from '@inertiajs/vue3';

const isOpenProdutos = ref(false);
const isOpenCategorias = ref(false);
const isOpenPedidos = ref(false);

defineProps({
  title: String
})
</script>
