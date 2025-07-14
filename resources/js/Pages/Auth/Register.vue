<template>
  <form @submit.prevent="submitRegister" class="space-y-4">
    <h3 class="text-xl font-bold text-green-700 text-center">Criar Conta</h3>

    <div>
      <InputLabel for="name">Nome</InputLabel>
      <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required />
      <InputError class="mt-2" :message="form.errors.name" />
    </div>

    <div>
      <InputLabel for="email">Email</InputLabel>
      <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />
      <InputError class="mt-2" :message="form.errors.email" />
    </div>

    <div>
      <InputLabel for="password">Password</InputLabel>
      <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required />
      <InputError class="mt-2" :message="form.errors.password" />
    </div>

    <div>
      <InputLabel for="password_confirmation">Confirmar Password</InputLabel>
      <TextInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required />
    </div>

    <PrimaryButton class="w-full justify-center bg-green-700 hover:bg-green-800" :disabled="form.processing">
      Registar
    </PrimaryButton>
  </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const submitRegister = () => {
  form.post(route('register'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>
