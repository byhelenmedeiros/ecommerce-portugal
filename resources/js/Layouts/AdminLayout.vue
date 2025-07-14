<template>
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
          <Link :href="route('admin.products.index')" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-green-100">
            <font-awesome-icon icon="fa-solid fa-boxes-stacked" class="text-green-600" />
            Produtos
          </Link>
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
import { Link } from '@inertiajs/vue3';
</script>
