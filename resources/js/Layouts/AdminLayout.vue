<template>
 

      <Head title="Gestão de loja" />

  <div class="min-h-screen flex bg-gray-100 text-gray-800">
    <!-- Sidebar -->
    <aside class="w-56 bg-white border-r shadow-sm hidden md:flex flex-col justify-start">
      <div>
        <div class="p-4 text-xl font-bold text-green-700 border-b">ALMAMINHOTA</div>
        <nav class="p-4 space-y-1 text-sm">
          <Link :href="route('admin.dashboard')" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-green-100">
            <font-awesome-icon icon="fa-solid fa-chart-line" class="text-green-600" />
            Dashboard
          </Link>
          <!-- Produtos (submenu) -->
<div class="space-y-1">
  <div class="flex items-center gap-3 px-3 py-2 text-sm font-semibold text-green-700">
    <font-awesome-icon icon="fa-solid fa-boxes-stacked" class="text-green-600" />
    Produtos
  </div>
  <div class="ml-6 space-y-1 text-sm">
    <Link :href="route('admin.products.index')" class="block px-3 py-2 rounded hover:bg-green-100">
      Todos os Produtos
    </Link>
    <Link :href="route('admin.products.create')" class="block px-3 py-2 rounded hover:bg-green-100">
      Criar Produto
    </Link>
  </div>
</div>
      <div class="relative" @mouseenter="open.categories = true" @mouseleave="open.categories = false">
  <!-- Botão principal -->
  <div class="flex items-center gap-3 px-3 py-2 rounded hover:bg-green-100 cursor-pointer">
    <font-awesome-icon icon="fa-solid fa-tags" class="text-green-600" />
    <span>Categorias</span>
    <font-awesome-icon icon="fa-solid fa-chevron-down" class="ml-auto text-xs" />
  </div>

  <!-- Submenu -->
  <div v-if="open.categories" class="absolute left-0 mt-1 bg-white shadow-lg border rounded w-48 z-10">
    <Link :href="route('admin.categories.index')" class="flex items-center gap-2 px-4 py-2 hover:bg-green-50 text-sm">
      <font-awesome-icon icon="fa-solid fa-list" class="text-green-500" />
      Ver Categorias
    </Link>
    <Link :href="route('admin.categories.create')" class="flex items-center gap-2 px-4 py-2 hover:bg-green-50 text-sm">
      <font-awesome-icon icon="fa-solid fa-plus" class="text-green-500" />
      Nova Categoria
    </Link>
  </div>
</div>


          <Link :href="route('admin.orders.index')" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-green-100">
            <font-awesome-icon icon="fa-solid fa-file-invoice-dollar" class="text-green-600" />
            Pedidos
          </Link>
            
            <Link :href="route('logout')" method="post" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-red-100">   
            <font-awesome-icon icon="fa-solid fa-right-from-bracket" class="text-red-600" />
            Sair    
            </Link>

          
        </nav>
      </div>

      <div class="p-4 text-xs text-gray-400">&copy; 2025</div>
    </aside>

    <!-- Conteúdo Principal -->
    <div class="flex-1 p-6 overflow-x-auto">
      <slot />
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const isOpenProdutos = ref(false);
const isOpenCategorias = ref(false);

</script>
