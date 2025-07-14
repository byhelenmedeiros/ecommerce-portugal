<template>
    <form @submit.prevent="submit" class="  text-sm">
        <!-- Abas -->
        <div class="flex border-b mb-2 space-x-1">
            <button v-for="tab in tabs" :key="tab" type="button" @click="activeTab = tab" :class="[
                'px-2 py-1 font-semibold rounded-t-md',
                activeTab === tab ? 'bg-green-700 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
            ]">
                {{ tab }}
            </button>
        </div>

        <div class="bg-white shadow rounded p-6 space-y-4">
            <!-- Detalhes -->
            <div v-if="activeTab === 'Detalhes'" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <InputLabel for="name" value="Nome do Produto" />
                    <TextInput id="name" v-model="form.name" class="w-full h-8 text-xs" />
                    <InputError :message="form.errors.name" />
                </div>

                <div>
                    <InputLabel for="slug" value="Slug (URL amigável)" />
                    <TextInput id="slug" v-model="form.slug" class="w-full h-8 text-xs" />
                    <InputError :message="form.errors.slug" />
                </div>

                <div class="col-span-2">
                    <InputLabel for="description" value="Descrição" />
                    <textarea id="description" v-model="form.description" rows="3"
                        class="w-full p-2 border border-gray-300 rounded text-xs resize-none"
                        placeholder="Ex: Produto típico da região..." />
                    <InputError :message="form.errors.description" />
                </div>
            </div>

            <!-- Preço -->
            <div v-if="activeTab === 'Preço & Categoria'" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <InputLabel for="price" value="Preço (€)" />
                    <TextInput id="price" v-model="form.price" type="number" step="0.01" class="w-full h-8 text-xs" />
                    <InputError :message="form.errors.price" />
                </div>
                <div>
                    <InputLabel for="discount" value="Desconto (%)" />
                    <TextInput id="discount" v-model="form.discount" type="number" step="0.01"
                        class="w-full h-8 text-xs" />
                    <InputError :message="form.errors.discount" />
                </div>
                <div>
                    <InputLabel for="category_id" value="Categoria" />
                    <select id="category_id" v-model="form.category_id" class="w-full h-8 text-xs border rounded">
                        <option disabled value="">Seleciona...</option>
                        <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                    </select>
                    <InputError :message="form.errors.category_id" />
                </div>
                <div>
                    <InputLabel for="region_id" value="Região" />
                    <select id="region_id" v-model="form.region_id" class="w-full h-8 text-xs border rounded">
                        <option disabled value="">Seleciona...</option>
                        <option v-for="reg in regions" :key="reg.id" :value="reg.id">{{ reg.name }}</option>
                    </select>
                    <InputError :message="form.errors.region_id" />
                </div>
            </div>

            <!-- Imagens -->
            <div v-if="activeTab === 'Imagens'">
                <InputLabel for="images" value="Imagens do Produto" />
                <FilePond name="images" ref="pond" imageCropAspectRatio="1:1"  allowMultiple accepted-file-types="image/jpeg, image/png"
                    label-idle="Arraste ou clique para fazer upload..." @updatefiles="handleFilePondUpdate"
                    class="filepond-horizontal w-full" />

                <InputError :message="form.errors.images" />
            </div>
        </div>

        <!-- Botão -->
        <div class="text-end mt-4">
            <PrimaryButton class="bg-green-700 hover:bg-green-800 px-4 py-2 text-sm" :disabled="form.processing">
                Criar Produto
            </PrimaryButton>
        </div>
    </form>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

import vueFilePond from 'vue-filepond';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import 'filepond/dist/filepond.min.css';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';
import FilePondPluginImageCrop from 'filepond-plugin-image-crop';



const FilePond = vueFilePond(FilePondPluginImagePreview, FilePondPluginFileValidateType);

const props = defineProps({
    product: Object,
    categories: Array,
    regions: Array,
});

const tabs = ['Detalhes', 'Preço & Categoria', 'Imagens'];
const activeTab = ref('Detalhes');

const form = useForm({
    name: props.product?.name ?? '',
    slug: props.product?.slug ?? '',
    description: props.product?.description ?? '',
    price: props.product?.price ?? '',
    discount: props.product?.discount ?? '',
    category_id: props.product?.category_id ?? '',
    region_id: props.product?.region_id ?? '',
    images: [],
});

const handleFilePondUpdate = (files) => {
    form.images = files.map(f => f.file);
};

const submit = () => {
    const formData = new FormData();
    Object.entries(form.data()).forEach(([key, value]) => {
        if (key === 'images') {
            value.forEach((file, i) => formData.append(`images[${i}]`, file));
        } else {
            formData.append(key, value);
        }
    });

    form.post(route('admin.products.store'), { forceFormData: true });
};
</script>
