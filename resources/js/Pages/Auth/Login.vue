<template>
  <GuestLayout>
    <Head title="Entrar" />

    <div class="w-full max-w-md mx-auto mt-12 bg-white p-8 shadow rounded">
      <h1 class="text-xl font-bold mb-6 text-center text-green-700">Acesso à Conta</h1>

      <form @submit.prevent="submit">
        <!-- Email -->
        <div class="mb-4">
          <InputLabel for="email" value="Email" />
          <TextInput
            id="email"
            type="email"
            class="mt-1 block w-full"
            v-model="form.email"
            required
            autofocus
            autocomplete="username"
          />
          <InputError class="mt-2" :message="form.errors.email" />
        </div>

        <!-- Password -->
        <div class="mb-4">
          <InputLabel for="password" value="Password" />
          <TextInput
            id="password"
            type="password"
            class="mt-1 block w-full"
            v-model="form.password"
            required
            autocomplete="current-password"
          />
          <InputError class="mt-2" :message="form.errors.password" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mb-6">
          <label class="flex items-center">
            <Checkbox v-model:checked="form.remember" />
            <span class="ml-2 text-sm text-gray-600">Lembrar-me</span>
          </label>

          <Link
            v-if="canResetPassword"
            :href="route('password.request')"
            class="text-sm text-green-700 hover:underline"
          >
            Esqueceu a palavra-passe?
          </Link>
        </div>

        <PrimaryButton
          class="w-full justify-center bg-green-700 hover:bg-green-800"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Entrar
        </PrimaryButton>
      </form>
    </div>
  </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import Checkbox from '@/Components/Checkbox.vue';

defineProps({
  canResetPassword: Boolean,
  status: String,
});

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>
