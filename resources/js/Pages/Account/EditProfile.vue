<template>
  <GuestLayout>
    <Head title="Perfil" />

    <div class="max-w-3xl mx-auto p-6 bg-white shadow rounded">
      <h2 class="text-xl font-bold text-green-700 mb-6">Informações de Perfil</h2>

      <form @submit.prevent="submit" class="space-y-4">
        <div>
          <InputLabel for="phone">Telefone</InputLabel>
          <TextInput id="phone" v-model="form.phone" type="text" class="mt-1 block w-full" />
          <InputError :message="form.errors.phone" class="mt-2" />
        </div>

        <div>
          <InputLabel for="address">Morada</InputLabel>
          <TextInput id="address" v-model="form.address" type="text" class="mt-1 block w-full" />
        </div>

        <div>
          <InputLabel for="city">Cidade</InputLabel>
          <TextInput id="city" v-model="form.city" type="text" class="mt-1 block w-full" />
        </div>

        <div>
          <InputLabel for="postal_code">Código Postal</InputLabel>
          <TextInput id="postal_code" v-model="form.postal_code" type="text" class="mt-1 block w-full" />
        </div>

        <div>
          <InputLabel for="country">País</InputLabel>
          <TextInput id="country" v-model="form.country" type="text" class="mt-1 block w-full" />
        </div>

        <PrimaryButton class="mt-4 bg-green-700 hover:bg-green-800" :disabled="form.processing">
          Atualizar Perfil
        </PrimaryButton>
      </form>
    </div>
  </GuestLayout>
</template>

<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineProps({
  profile: Object,
});

const form = useForm({
  phone: props.profile?.phone ?? '',
  address: props.profile?.address ?? '',
  city: props.profile?.city ?? '',
  postal_code: props.profile?.postal_code ?? '',
  country: props.profile?.country ?? '',
});

const submit = () => {
  form.patch(route('profile.update'));
};
</script>
