<template>
  <AuthenticatedLayout>
    <Head title="Minha Conta" />

    <div class="max-w-3xl mx-auto p-6 bg-white shadow rounded">
      <h2 class="text-xl font-bold text-green-700 mb-6">Dados da Conta</h2>

      <form @submit.prevent="submit" class="space-y-4">
        <div>
          <InputLabel for="name">Nome</InputLabel>
          <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" required />
          <InputError :message="form.errors.name" class="mt-2" />
        </div>

        <div>
          <InputLabel for="email">Email</InputLabel>
          <TextInput id="email" v-model="form.email" type="email" class="mt-1 block w-full" required />
          <InputError :message="form.errors.email" class="mt-2" />
        </div>

        <PrimaryButton class="mt-4 bg-green-700 hover:bg-green-800" :disabled="form.processing">
          Atualizar Conta
        </PrimaryButton>
      </form>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
  mustVerifyEmail: Boolean,
  status: String,
  auth: Object,
});

const form = useForm({
  name: props.auth.user.name,
  email: props.auth.user.email,
});
const submit = () => {
  form.patch(route('account.update'));
};
</script>
