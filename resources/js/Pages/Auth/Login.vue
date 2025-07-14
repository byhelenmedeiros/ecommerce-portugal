<template>
  <GuestLayout>
    <Head title="Autenticação" />

    <div class="w-full min-h-[calc(100vh-150px)] flex items-center justify-center bg-gray-100 px-4">
      <div class="max-w-5xl w-full bg-white shadow-lg rounded-lg overflow-hidden grid lg:grid-cols-2">
        
        <!-- COLUNA ESQUERDA -->
        <div class="bg-red-800 text-white p-8 flex flex-col justify-center space-y-4">
          <h2 class="text-3xl font-bold">Descobre os Sabores do Norte</h2>
          <p class="text-lg">
            Regista-te para acompanhar as encomendas, receber ofertas exclusivas e guardar os teus produtos favoritos.
          </p>
          <ul class="list-disc list-inside space-y-1 text-green-100">
            <li>Frete grátis em todas as encomendas</li>
            <li>Descontos para membros registados</li>
            <li>Histórico e rastreamento de pedidos</li>
          </ul>
          <p class="text-sm text-green-200 mt-4">Já tens conta? Usa o formulário ao lado para entrar.</p>
        </div>

        <!-- COLUNA DIREITA -->
        <div class="p-8">
          <!-- Tabs -->
          <div class="flex justify-center mb-6">
            <button
              @click="activeTab = 'login'"
              :class="tabClass('login')"
            >Entrar</button>
            <button
              @click="activeTab = 'register'"
              :class="tabClass('register')"
            >Registar</button>
          </div>

          <!-- Login -->
          <transition name="fade" mode="out-in">
            <form v-if="activeTab === 'login'" key="login" @submit.prevent="submitLogin" class="space-y-4">
              <h3 class="text-xl font-bold text-green-700 text-center">Acesso à Conta</h3>

              <div>
                <InputLabel for="email">Email</InputLabel>
                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="loginForm.email" required />
                <InputError class="mt-2" :message="loginForm.errors.email" />
              </div>

              <div>
                <InputLabel for="password">Password</InputLabel>
                <TextInput id="password" type="password" class="mt-1 block w-full" v-model="loginForm.password" required />
                <InputError class="mt-2" :message="loginForm.errors.password" />
              </div>

              <div class="flex items-center justify-between">
                <label class="flex items-center">
                  <Checkbox v-model:checked="loginForm.remember" />
                  <span class="ml-2 text-sm text-gray-600">Lembrar-me</span>
                </label>
                <Link v-if="canResetPassword" :href="route('password.request')" class="text-sm text-green-700 hover:underline">
                  Esqueceu a palavra-passe?
                </Link>
              </div>

              <PrimaryButton class="w-full justify-center bg-green-700 hover:bg-green-800" :disabled="loginForm.processing">
                Entrar
              </PrimaryButton>
            </form>

            <!-- Register -->
            <Register v-else key="register" />
          </transition>
        </div>
      </div>
    </div>
  </GuestLayout>
</template>

<script setup>
import { ref } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import Checkbox from '@/Components/Checkbox.vue';
import Register from './Register.vue';

defineProps({ canResetPassword: Boolean });

const activeTab = ref('login');

const loginForm = useForm({
  email: '',
  password: '',
  remember: false,
});

const submitLogin = () => {
  loginForm.post(route('login'), {
    onFinish: () => loginForm.reset('password'),
  });
};

const tabClass = (tab) =>
  `px-4 py-2 mx-1 rounded-t-md font-semibold text-sm transition-all ${
    activeTab.value === tab
      ? 'bg-green-700 text-white'
      : 'bg-gray-200 text-gray-600 hover:bg-gray-300'
  }`;
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.4s;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
