<template>
  <GuestLayout>
    <Head title="Redefinir Palavra-passe" />

    <div class="w-full min-h-[calc(100vh-150px)] flex items-center justify-center bg-gray-100 px-4">
      <div class="w-full max-w-md bg-white p-8 rounded shadow space-y-6">
        <h2 class="text-2xl font-bold text-center text-green-700">Redefinir palavra-passe</h2>

        <form @submit.prevent="submit" class="space-y-4">
          <input type="hidden" name="token" v-model="form.token" />

          <div>
            <InputLabel for="email">Email</InputLabel>
            <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus />
            <InputError class="mt-2" :message="form.errors.email" />
          </div>

          <div>
            <InputLabel for="password">Nova Password</InputLabel>
            <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required />
            <InputError class="mt-2" :message="form.errors.password" />
          </div>

          <div>
            <InputLabel for="password_confirmation">Confirmar Password</InputLabel>
            <TextInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required />
          </div>

          <PrimaryButton class="w-full justify-center bg-green-700 hover:bg-green-800" :disabled="form.processing">
            Redefinir palavra-passe
          </PrimaryButton>
        </form>
      </div>
    </div>
  </GuestLayout>
</template>

<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
  email: String,
  token: String,
});

const form = useForm({
  token: props.token,
  email: props.email,
  password: '',
  password_confirmation: '',
});

const submit = () => {
  form.post(route('password.store'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>
