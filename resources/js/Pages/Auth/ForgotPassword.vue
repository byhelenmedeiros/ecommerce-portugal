<template>
  <GuestLayout>
    <Head title="Recuperar Palavra-passe" />

    <div class="w-full min-h-[calc(100vh-150px)] flex items-center justify-center bg-gray-100 px-4">
      <div class="w-full max-w-md bg-white p-8 rounded shadow space-y-6">
        <h2 class="text-2xl font-bold text-center text-green-700">Esqueceu a palavra-passe?</h2>
        <p class="text-sm text-gray-600 text-center">Insira o seu email para receber um link de redefinição.</p>

        <form @submit.prevent="submit" class="space-y-4">
          <div>
            <InputLabel for="email">Email</InputLabel>
            <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus />
            <InputError class="mt-2" :message="form.errors.email" />
          </div>

          <PrimaryButton class="w-full justify-center bg-green-700 hover:bg-green-800" :disabled="form.processing">
            Enviar link
          </PrimaryButton>
        </form>

        <div v-if="status" class="text-sm text-green-600 text-center">{{ status }}</div>
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

defineProps({ status: String });

const form = useForm({ email: '' });

const submit = () => {
  form.post(route('password.email'));
};
</script>
