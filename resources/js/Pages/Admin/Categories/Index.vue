<template>
  <Head title="Gerir categorias" />
  <AdminLayout title="Categorias">
    
  <h1 class="text-md font-bold  text-black">Gerir Categorias</h1>
    <template #header>
      <h2 class="text-base font-semibold text-gray-800 leading-tight">Categorias</h2>
    </template>

    <div class="py-6">
      <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <!-- Lista de Categorias -->
          <div class="md:col-span-2">
            <div class="bg-white border rounded shadow-sm">
              <div class="px-4 py-3 border-b bg-gray-50 flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-700">Categorias</h3>
              </div>

              <div v-for="element in sortedCategories" :key="element.id" class="divide-y text-xs">
                <div class="grid grid-cols-5 items-center hover:bg-gray-50 px-2 py-1">
                  <div>#{{ element.id }}</div>
                  <div>{{ element.name }}</div>
                  <div class="text-gray-500">{{ element.slug }}</div>
                  <div class="text-gray-500">{{ element.order }}</div>
                  <div class="text-end">
                    <button @click="destroy(element.id)" class="text-red-600 hover:underline text-xs">Excluir</button>
                  </div>
                </div>
              </div>

              <div v-if="!sortedCategories.length" class="p-3 text-center text-gray-500 text-xs">
                Nenhuma categoria encontrada.
              </div>
            </div>
          </div>

          <!-- Formulário -->
          <div>
            <div class="bg-white border rounded shadow-sm overflow-hidden">
              <div class="px-4 py-3 border-b bg-gray-50">
                <h3 class="text-sm font-medium text-gray-700">
                  {{ form.id ? 'Editar' : 'Nova' }} Categoria
                </h3>
              </div>

              <form @submit.prevent="submit" class="px-4 py-4 space-y-3">
                <div>
                  <InputLabel for="name" value="Nome" class="text-xs" />
                  <TextInput id="name" v-model="form.name" class="w-full h-8 text-xs" />
                  <InputError :message="form.errors.name" />
                </div>

                <div>
                  <InputLabel for="slug" value="Slug" class="text-xs" />
                  <TextInput id="slug" v-model="form.slug" class="w-full h-8 text-xs" />
                  <InputError :message="form.errors.slug" />
                </div>

                <div>
                  <InputLabel for="parent_id" value="Categoria Pai" class="text-xs" />
                  <select id="parent_id" v-model="form.parent_id" class="w-full h-8 text-xs border rounded">
                    <option :value="null">Nenhuma (categoria principal)</option>
                    <option v-for="cat in categories.filter(c => c.id !== form.id)" :key="cat.id" :value="cat.id">
                      {{ cat.name }}
                    </option>
                  </select>
                  <InputError :message="form.errors.parent_id" />
                </div>

                <div>
                  <InputLabel for="order" value="Ordem" class="text-xs" />
                  <TextInput id="order" type="number" min="0" v-model="form.order" class="w-full h-8 text-xs" />
                  <InputError :message="form.errors.order" />
                </div>

                <div class="text-end pt-3 border-t">
                  <PrimaryButton :disabled="form.processing" class="text-xs px-3 py-1">
                    {{ form.id ? 'Atualizar' : 'Adicionar' }}
                  </PrimaryButton>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { useForm, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, computed } from 'vue';

const props = defineProps({
  category: {
    type: Object,
    default: null,
  },
  categories: Array
});

const sortedCategories = ref([...props.categories]);

const form = useForm({
  id: props.category?.id ?? null,
  name: props.category?.name ?? '',
  slug: props.category?.slug ?? '',
  order: props.category?.order ?? 0,
  parent_id: props.category?.parent_id ?? null,
});

const submit = () => {
  if (form.id) {
    form.put(route('admin.categories.update', form.id), {
      onSuccess: () => {
        // Atualiza a categoria na lista existente
        const index = sortedCategories.value.findIndex(c => c.id === form.id);
        if (index !== -1) {
          sortedCategories.value[index] = { ...form.data(), id: form.id };
        }
        resetForm();
      }
    });
  } else {
    form.post(route('admin.categories.store'), {
      preserveScroll: true,
      onSuccess: (res) => {
        if (res?.props?.category) {
          sortedCategories.value.push(res.props.category);
        } else {
          sortedCategories.value = [...sortedCategories.value, { ...form.data(), id: new Date().getTime() }];
        }
        resetForm();
      }
    });
  }
};
const resetForm = () => {
  form.id = null;
  form.name = '';
  form.slug = '';
  form.order = 0;
  form.parent_id = null;
};



const destroy = (id) => {
  if (confirm('Tem certeza que deseja excluir esta categoria?')) {
    router.delete(route('admin.categories.destroy', id));
  }
};
</script>
