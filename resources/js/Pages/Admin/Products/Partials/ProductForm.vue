<template>
    <form @submit.prevent="submit" class="text-sm">
        <!-- Abas -->
        <div class="flex border-b  space-x-1">
            <button v-for="tab in tabs" :key="tab" type="button" @click="activeTab = tab" :class="[
                'px-2 py-1 font-semibold rounded-t-md',
                activeTab === tab ? 'bg-green-700 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
            ]">
                {{ tab }}
            </button>
        </div>

        <div class="bg-white shadow p-6 rounded-b-md">
            <!-- Aba: Detalhes -->
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
                        class="w-full p-2 border rounded text-xs resize-none" />
                    <InputError :message="form.errors.description" />
                </div>
                <div>
                    <InputLabel for="status" value="Status do Produto" />
                    <select id="status" v-model="form.status" class="w-full h-8 text-xs border rounded">
                        <option value="rascunho">Rascunho</option>
                        <option value="publicado">Publicado</option>
                        <option value="esgotado">Esgotado</option>
                    </select>
                    <InputError :message="form.errors.status" />
                </div>

            </div>

            <!-- Aba: Preço & Categoria -->
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

            <!-- Aba: Imagens -->
            <div v-if="activeTab === 'Imagens'">
                <InputLabel for="images" value="Imagens do Produto" />
                <FilePond name="images" ref="pond" allowMultiple imageCropAspectRatio="1:1"
                    accepted-file-types="image/jpeg, image/png" label-idle="Arraste ou clique para fazer upload..."
                    @updatefiles="handleFilePondUpdate" class="filepond-horizontal w-full" />
                <InputError :message="form.errors.images" />
            </div>

            <!-- Aba: Estoque & Visibilidade -->
            <div v-if="activeTab === 'Estoque & Visibilidade'" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <InputLabel for="stock" value="Quantidade em Stock" />
                    <TextInput id="stock" v-model="form.stock" type="number" min="0" class="w-full h-8 text-xs" />
                    <InputError :message="form.errors.stock" />
                </div>
                <div>
                    <InputLabel for="weight" value="Peso (kg)" />
                    <TextInput id="weight" v-model="form.weight" type="number" step="0.01" class="w-full h-8 text-xs" />
                    <InputError :message="form.errors.weight" />
                </div>
                <div class="col-span-2 flex gap-4 items-center mt-2">
                    <label class="flex items-center gap-2 text-xs">
                        <input type="checkbox" v-model="form.visible" />
                        Visível na loja
                    </label>
                    <label class="flex items-center gap-2 text-xs">
                        <input type="checkbox" v-model="form.featured" />
                        Destaque na homepage
                    </label>
                </div>
                <div class="col-span-2">
                    <InputLabel for="release_date" value="Data de Lançamento" />
                    <TextInput id="release_date" v-model="form.release_date" type="date" class="w-full h-8 text-xs" />
                    <InputError :message="form.errors.release_date" />
                </div>
            </div>

            <!-- Aba: SEO -->
            <div v-if="activeTab === 'SEO'" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <InputLabel for="seo_title" value="Título SEO" />
                    <TextInput id="seo_title" v-model="form.seo_title" class="w-full h-8 text-xs" />
                    <InputError :message="form.errors.seo_title" />
                </div>
                <div>
                    <InputLabel for="seo_description" value="Descrição SEO" />
                    <textarea id="seo_description" v-model="form.seo_description" rows="2"
                        class="w-full p-2 border rounded text-xs resize-none" />
                    <InputError :message="form.errors.seo_description" />
                </div>
            </div>

            <!-- Informações Avançadas -->
            <div v-if="activeTab === 'Informações Avançadas'" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <InputLabel for="ean" value="EAN" />
                    <TextInput id="ean" v-model="form.ean" class="w-full h-8 text-xs" />
                </div>
                <div>
                    <InputLabel for="sku" value="SKU" />
                    <TextInput id="sku" v-model="form.sku" class="w-full h-8 text-xs" />
                </div>
                <div>
                    <InputLabel for="brand" value="Marca" />
                    <TextInput id="brand" v-model="form.brand" class="w-full h-8 text-xs" />
                </div>
                <div>
                    <InputLabel for="unit" value="Unidade de Medida" />
                    <TextInput id="unit" v-model="form.unit" class="w-full h-8 text-xs" placeholder="Ex: kg, un, ml" />
                </div>
                <div>
                    <InputLabel for="min_order_quantity" value="Mínimo por Encomenda" />
                    <TextInput id="min_order_quantity" type="number" v-model="form.min_order_quantity"
                        class="w-full h-8 text-xs" />
                </div>
                <div>
                    <InputLabel for="max_order_quantity" value="Máximo por Encomenda" />
                    <TextInput id="max_order_quantity" type="number" v-model="form.max_order_quantity"
                        class="w-full h-8 text-xs" />
                </div>
                <div>
                    <InputLabel for="shipping_time" value="Tempo de Envio" />
                    <TextInput id="shipping_time" v-model="form.shipping_time" class="w-full h-8 text-xs"
                        placeholder="Ex: 2-3 dias úteis" />
                </div>
                <div>
                    <InputLabel for="expiration_date" value="Validade" />
                    <TextInput id="expiration_date" v-model="form.expiration_date" type="date"
                        class="w-full h-8 text-xs" />
                </div>
                <div>
                    <InputLabel for="visibility_start" value="Início de Visibilidade" />
                    <TextInput id="visibility_start" v-model="form.visibility_start" type="date"
                        class="w-full h-8 text-xs" />
                </div>
                <div>
                    <InputLabel for="visibility_end" value="Fim de Visibilidade" />
                    <TextInput id="visibility_end" v-model="form.visibility_end" type="date"
                        class="w-full h-8 text-xs" />
                </div>
          <!-- Aba: Ficheiros -->
<div v-if="activeTab === 'Ficheiros'" class="space-y-2">
    <InputLabel for="files" value="Ficheiros do Produto" />
    <input type="file" id="files" @change="handleFileUpload" multiple class="w-full h-8 text-xs" />
    <InputError :message="form.errors.files" />
    <div v-if="form.files.length > 0" class="mt-2">
        <h4 class="text-sm font-semibold">Ficheiros Selecionados:</h4>
        <ul class="list-disc pl-5"> 
            <li v-for="file in form.files" :key="file.name" class="text-xs">{{ file.name }}</li>
        </ul>
    </div>
</div>



                <div>
                    <label class="flex items-center gap-2 mt-2">
                        <input type="checkbox" v-model="form.is_active" class="h-4 w-4" />
                        Produto ativo
                    </label>
                </div>
            </div>

        </div>
        <!-- Botão -->
        <div class="text-end mt-4">
            <PrimaryButton class="bg-green-700 hover:bg-green-800 px-4 py-2 text-sm" :disabled="form.processing">
                {{ props.product ? 'Atualizar' : 'Criar' }} Produto
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
import FilePondPluginImageCrop from 'filepond-plugin-image-crop';

import 'filepond/dist/filepond.min.css';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';

const FilePond = vueFilePond(
    FilePondPluginImagePreview,
    FilePondPluginFileValidateType,
    FilePondPluginImageCrop
);

// Props recebidos
const props = defineProps({
    product: Object,
    categories: Array,
    regions: Array,
});

// Abas visíveis no topo do formulário
const tabs = [
  'Detalhes',
  'Preço & Categoria',
  'Imagens',
  'Estoque & Visibilidade',
  'SEO',
  'Informações Avançadas',
  'Ficheiros',
  
];

const activeTab = ref('Detalhes');

// Formulário com valores iniciais
const form = useForm({
  name: '',
  slug: '',
  description: '',
  price: '',
  discount: '',
  category_id: '',
  region_id: '',
  images: [],
  files: [],
  stock: '',
  weight: '',
  visible: false,
  featured: false,
  release_date: '',
  seo_title: '',
  seo_description: '',
  ean: '',
  sku: '',
  brand: '',
  unit: '',
  min_order_quantity: '',
  max_order_quantity: '',
  shipping_time: '',
  expiration_date: '',
  visibility_start: '',
  visibility_end: '',
  status: 'rascunho',
  comments: '',
  is_active: true,
});


// Imagens
const handleFilePondUpdate = (files) => {
    form.images = files.map(f => f.file);
};

form.files = [];

const handleFileUpload = (e) => {
  form.files = Array.from(e.target.files);
};

 
const submit = () => {
  const formData = new FormData();

  Object.entries(form.data()).forEach(([key, value]) => {
    if (key === 'images' || key === 'files') {
      value.forEach((file, i) => {
        formData.append(`${key}[${i}]`, file);
      });
    } else {
      formData.append(key, value);
    }
  });

  form.post(route('admin.products.store'), {
    forceFormData: true,
  });
};

</script>
