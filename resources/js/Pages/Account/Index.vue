<script setup>
import { ref } from 'vue'
import SidebarLink from '@/Components/SidebarLink.vue'
import Navbar from '@/Components/Navbar.vue'
import Footer from '@/Components/Footer.vue'

import DadosPessoais from './Tabs/DadosPessoais.vue'
import MeusPedidos from './Tabs/MeusPedidos.vue'
import Morada from './Tabs/Morada.vue'
import Wishlist from './Tabs/Wishlist.vue'

const props = defineProps({ user: Object })
const activeTab = ref('dados')
</script>

<template>
  <div class="min-h-screen bg-gray-100 flex flex-col">
    <Navbar />

    <main class="max-w-7xl w-full mx-auto py-10 px-4 lg:flex lg:space-x-6 flex-1">
      <aside class="w-full lg:w-1/4 bg-white rounded shadow-sm mb-6 lg:mb-0">
        <nav class="p-4 space-y-2 text-sm font-medium text-gray-700">
          <SidebarLink icon="user" label="Dados Pessoais" :active="activeTab === 'dados'" @select="activeTab = 'dados'" />
          <SidebarLink icon="box" label="Meus Pedidos" :active="activeTab === 'pedidos'" @select="activeTab = 'pedidos'" />
          <SidebarLink icon="location-dot" label="Morada" :active="activeTab === 'morada'" @select="activeTab = 'morada'" />
          <SidebarLink icon="heart" label="Wishlist" :active="activeTab === 'Wishlist'" @select="activeTab = 'Wishlist'" />
        </nav>  
      </aside>

      <section class="flex-1 space-y-6">
        <transition name="fade-slide" mode="out-in">
          <div :key="activeTab" class="bg-white p-6 rounded shadow">
            <DadosPessoais v-if="activeTab === 'dados'" :user="user" />
            <MeusPedidos v-else-if="activeTab === 'pedidos'" />
<Morada
  v-else-if="activeTab === 'morada'"
  :fiscal="user.fiscalAddress"
  :entrega="user.entregaAddress"
/>
            <Wishlist v-else-if="activeTab === 'Wishlist'" />
          </div>
        </transition>
      </section>
    </main> 

    <Footer />
  </div>
</template>

<style scoped>
.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: all 0.3s ease;
}
.fade-slide-enter-from,
.fade-slide-leave-to {
  opacity: 0;
  transform: translateY(10px);
}
</style>
