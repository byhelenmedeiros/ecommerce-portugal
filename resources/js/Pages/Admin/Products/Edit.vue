<template>
  <AdminLayout title="Editar Produto">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Produto</h2>
    </template>

    <section class="py-8">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg p-6">
          <form @submit.prevent="submit" class="text-sm">
            <div class="flex border-b space-x-1 mb-4">
              <button v-for="tab in tabs" :key="tab" type="button" @click="activeTab = tab"
                :class="[
                  'px-2 py-1 font-semibold rounded-t-md',
                  activeTab === tab ? 'bg-green-700 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
                ]">
                {{ tab }}
              </button>
            </div>

            <div class="bg-white rounded-b-md">
              <!-- Aba: Detalhes -->
              <div v-if="activeTab === 'Detalhes'" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><InputLabel for="name" value="Nome do Produto" /> <TextInput id="name" v-model="form.name" class="w-full h-8 text-xs" /> <InputError :message="form.errors.name" /></div>
                <div><InputLabel for="slug" value="Slug" /> <TextInput id="slug" v-model="form.slug" class="w-full h-8 text-xs" /> <InputError :message="form.errors.slug" /></div>
                <div><InputLabel for="status" value="Status" />
                  <select id="status" v-model="form.status" class="w-full h-8 text-xs border rounded">
                    <option value="rascunho">Rascunho</option>
                    <option value="publicado">Publicado</option>
                    <option value="esgotado">Esgotado</option>
                  </select>
                  <InputError :message="form.errors.status" />
                </div>
                <div class="md:col-span-2">
                  <InputLabel for="description" value="Descrição" />
                  <div class="border rounded text-sm overflow-hidden w-full">
                    <QuillEditor id="description" v-model:content="form.description" content-type="html" theme="snow" class="w-full h-[200px] bg-white" />
                  </div>
                  <InputError :message="form.errors.description" />
                </div>
              </div>

              <!-- Aba: Preço & Categoria -->
              <div v-if="activeTab === 'Preço & Categoria'" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div><InputLabel for="price" value="Preço" /> <TextInput id="price" v-model="form.price" type="number" step="0.01" class="w-full h-8 text-xs" /> <InputError :message="form.errors.price" /></div>
                <div><InputLabel for="discount" value="Desconto (%)" /> <TextInput id="discount" v-model="form.discount" type="number" step="0.01" class="w-full h-8 text-xs" /> <InputError :message="form.errors.discount" /></div>
                <div><InputLabel for="category_id" value="Categoria" /> <select id="category_id" v-model="form.category_id" class="w-full h-8 text-xs border rounded"><option disabled value="">Seleciona...</option><option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option></select> <InputError :message="form.errors.category_id" /></div>
                <div><InputLabel for="region_id" value="Região" /> <select id="region_id" v-model="form.region_id" class="w-full h-8 text-xs border rounded"><option disabled value="">Selecione</option><option v-for="reg in regions" :key="reg.id" :value="reg.id">{{ reg.name }}</option></select> <InputError :message="form.errors.region_id" /></div>
              </div>

              <!-- As demais abas foram adicionadas -->
              <div v-if="activeTab === 'Imagens'">
                <InputLabel for="images" value="Imagens do Produto" />
                <FilePond name="images" ref="pond" allowMultiple imageCropAspectRatio="1:1" accepted-file-types="image/jpeg, image/png" label-idle="Arraste ou clique para fazer upload..." @updatefiles="handleFilePondUpdate" class="filepond-horizontal w-full" />
                <InputError :message="form.errors.images" />
              </div>

              <div v-if="activeTab === 'Estoque & Visibilidade'" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><InputLabel for="stock" value="Stock" /> <TextInput id="stock" v-model="form.stock" type="number" min="0" class="w-full h-8 text-xs" /> <InputError :message="form.errors.stock" /></div>
                <div><InputLabel for="weight" value="Peso (kg)" /> <TextInput id="weight" v-model="form.weight" type="number" step="0.01" class="w-full h-8 text-xs" /> <InputError :message="form.errors.weight" /></div>
                <div class="col-span-2 flex gap-4 items-center mt-2">
                  <label class="flex items-center gap-2 text-xs"><input type="checkbox" v-model="form.visible" /> Visível</label>
                  <label class="flex items-center gap-2 text-xs"><input type="checkbox" v-model="form.featured" /> Destaque</label>
                </div>
                <div class="col-span-2">
                  <InputLabel for="release_date" value="Lançamento" />
                  <TextInput id="release_date" v-model="form.release_date" type="date" class="w-full h-8 text-xs" />
                </div>
              </div>

              <div v-if="activeTab === 'SEO'" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><InputLabel for="seo_title" value="Título SEO" /> <TextInput id="seo_title" v-model="form.seo_title" class="w-full h-8 text-xs" /> <InputError :message="form.errors.seo_title" /></div>
                <div><InputLabel for="seo_description" value="Descrição SEO" /> <textarea id="seo_description" v-model="form.seo_description" rows="2" class="w-full p-2 border rounded text-xs resize-none" /> <InputError :message="form.errors.seo_description" /></div>
              </div>

              <div v-if="activeTab === 'Informações Avançadas'" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><InputLabel for="ean" value="EAN" /> <TextInput id="ean" v-model="form.ean" class="w-full h-8 text-xs" /></div>
                <div><InputLabel for="sku" value="SKU" /> <TextInput id="sku" v-model="form.sku" class="w-full h-8 text-xs" /></div>
                <div><InputLabel for="brand" value="Marca" /> <TextInput id="brand" v-model="form.brand" class="w-full h-8 text-xs" /></div>
                <div><InputLabel for="unit" value="Unidade" /> <TextInput id="unit" v-model="form.unit" class="w-full h-8 text-xs" /></div>
                <div><InputLabel for="min_order_quantity" value="Mínimo por Encomenda" /> <TextInput id="min_order_quantity" type="number" v-model="form.min_order_quantity" class="w-full h-8 text-xs" /></div>
                <div><InputLabel for="max_order_quantity" value="Máximo por Encomenda" /> <TextInput id="max_order_quantity" type="number" v-model="form.max_order_quantity" class="w-full h-8 text-xs" /></div>
                <div><InputLabel for="shipping_time" value="Tempo de Envio" /> <TextInput id="shipping_time" v-model="form.shipping_time" class="w-full h-8 text-xs" /></div>
                <div><InputLabel for="expiration_date" value="Validade" /> <TextInput id="expiration_date" v-model="form.expiration_date" type="date" class="w-full h-8 text-xs" /></div>
                <div><InputLabel for="visibility_start" value="Início Visibilidade" /> <TextInput id="visibility_start" v-model="form.visibility_start" type="date" class="w-full h-8 text-xs" /></div>
                <div><InputLabel for="visibility_end" value="Fim Visibilidade" /> <TextInput id="visibility_end" v-model="form.visibility_end" type="date" class="w-full h-8 text-xs" /></div>
                <div><label class="flex items-center gap-2 mt-2"><input type="checkbox" v-model="form.is_active" class="h-4 w-4" /> Produto ativo</label></div>
              </div>

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

              <div class="text-end mt-4">
                <PrimaryButton class="bg-green-700 hover:bg-green-800 px-4 py-2 text-sm" :disabled="form.processing">
                  Atualizar Produto
                </PrimaryButton>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>
  </AdminLayout>
</template>


<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';

const props = defineProps({
  product: Object,
  categories: Array,
  regions: Array,
});

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

const form = useForm({
  ...props.product
});

const submit = () => {
  const formData = new FormData();
  Object.entries(form.data()).forEach(([key, value]) => {
    if (Array.isArray(value)) {
      value.forEach((v, i) => formData.append(`${key}[${i}]`, v));
    } else {
      formData.append(key, value);
    }
  });

  form.post(route('admin.products.update', props.product.id), {
    forceFormData: true,
    preserveScroll: true,
  });
};
</script>
