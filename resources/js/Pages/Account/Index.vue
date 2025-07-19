<template>
  <section class="max-w-4xl mx-auto p-6 space-y-6">
    <h1 class="text-2xl font-bold text-gray-800">Minha Conta</h1>

    <!-- Dados do usuário -->
    <div class="bg-white p-4 rounded shadow space-y-2">
      <p><strong>Nome:</strong> {{ user.name }}</p>
      <p><strong>Email:</strong> {{ user.email }}</p>
      <p><strong>Registado em:</strong> {{ formatDate(user.created_at) }}</p>
    </div>

    <!-- Se houver perfil -->
    <div v-if="user.customer_profile" class="bg-white p-4 rounded shadow space-y-2">
      <h2 class="text-lg font-semibold">Informações do Perfil</h2>
      <p><strong>Telefone:</strong> {{ user.customer_profile.phone }}</p>
      <p><strong>Cidade:</strong> {{ user.customer_profile.city }}</p>
      <p><strong>Morada:</strong> {{ user.customer_profile.address }}</p>
    </div>

    <!-- Botão para editar -->
    <div class="flex justify-end">
      <Link :href="route('profile.edit')" class="btn-primary">Editar Perfil</Link>
    </div>
  </section>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { format } from 'date-fns'
import { pt } from 'date-fns/locale'

const props = defineProps({
  user: Object,
})

const formatDate = (date) => format(new Date(date), "dd 'de' MMMM 'de' yyyy", { locale: pt })
</script>
