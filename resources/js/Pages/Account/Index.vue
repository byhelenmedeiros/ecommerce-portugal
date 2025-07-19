<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <Header />

    <main class="max-w-7xl mx-auto py-10 px-4 lg:flex lg:space-x-6">
      <!-- Sidebar -->
      <aside class="w-full lg:w-1/4 bg-white rounded shadow-sm mb-6 lg:mb-0">
        <nav class="p-4 space-y-2 text-sm font-medium text-gray-700">
          <SidebarLink icon="user" label="Dados Pessoais" :active="true" />
          <SidebarLink icon="box" label="Meus Pedidos" />
          <SidebarLink icon="location-dot" label="Endereço" />
          <SidebarLink icon="heart" label="Favoritos" />
          <SidebarLink icon="power-off" label="Terminar Sessão" :href="route('logout')" method="post" />
        </nav>
      </aside>

      <!-- Conteúdo Principal -->
      <section class="flex-1 space-y-6">
        <div class="bg-white p-6 rounded shadow">
          <h1 class="text-2xl font-bold text-gray-800 mb-4">Minha Conta</h1>

          <!-- Dados do usuário -->
          <div class="space-y-2">
            <p><strong>Nome:</strong> {{ user.name }}</p>
            <p><strong>Email:</strong> {{ user.email }}</p>
            <p><strong>Registado em:</strong> {{ formatDate(user.created_at) }}</p>
          </div>
        </div>

        <!-- Se houver perfil -->
        <div v-if="user.customer_profile" class="bg-white p-6 rounded shadow">
          <h2 class="text-lg font-semibold mb-2">Informações do Perfil</h2>
          <div class="space-y-2">
            <p><strong>Telefone:</strong> {{ user.customer_profile.phone }}</p>
            <p><strong>Morada:</strong> {{ user.customer_profile.address }}</p>
            <p><strong>Cidade:</strong> {{ user.customer_profile.city }}</p>
            <p><strong>Código Postal:</strong> {{ user.customer_profile.postal_code }}</p>
            <p><strong>País:</strong> {{ user.customer_profile.country }}</p>
          </div>
        </div>

        <div class="flex justify-end">
          <Link :href="route('profile.edit')" class="btn-primary">Editar Perfil</Link>
        </div>
      </section>
    </main>

    <!-- Footer -->
    <Footer />
  </div>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import { format } from 'date-fns'
import { pt } from 'date-fns/locale'

// Componentes globais
import Header from '@/Components/Layout/Header.vue'
import Footer from '@/Components/Layout/Footer.vue'
import SidebarLink from '@/Components/SidebarLink.vue'

const props = defineProps({
  user: Object,
})

const formatDate = (date) => format(new Date(date), "dd 'de' MMMM 'de' yyyy", { locale: pt })
</script>
