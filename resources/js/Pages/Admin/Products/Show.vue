<template>
  <AdminLayout>
    <Head :title="`Produto: ${product.name}`" />

    <div class="max-w-7xl mx-auto px-4 py-6 text-sm">
      <!-- Topo com Botões -->
      <div class="flex justify-between items-center">
        <Link :href="route('admin.products.index')" class="text-green-700 text-xs hover:underline">
          ← Voltar à lista de produtos
        </Link>
        <div class="space-x-2">
          <Link :href="route('admin.products.create')" class="bg-gray-200 text-gray-800 px-3 py-1.5 rounded text-xs hover:bg-gray-300">
            + Novo Produto
          </Link>
          <Link :href="route('admin.products.edit', product.id)" class="bg-green-700 text-white px-3 py-1.5 rounded text-xs hover:bg-green-800">
            Editar
          </Link>
          <button @click="showModal = true" class="bg-red-600 text-white px-3 py-1.5 rounded text-xs hover:bg-red-700">
            Eliminar
          </button>
        </div>
      </div>

      <!-- Abas -->
      <div class="border-b mb-4 flex space-x-4 text-xs overflow-x-auto">
        <button v-for="tab in tabs" :key="tab" @click="activeTab = tab"
          :class="activeTab === tab ? 'font-semibold text-green-700 border-b-2 border-green-700 pb-1' : 'text-gray-500 hover:text-gray-700'">
          {{ tab }}
        </button>
      </div>

      <!-- Conteúdo das Abas -->
      <div class="bg-white shadow rounded p-6 space-y-4">
        <div v-if="activeTab === 'Detalhes'">
          <Field label="Nome" :value="product.name" />
          <Field label="Slug" :value="product.slug" />
          <Field label="Status" :value="product.status" />
          <Field label="Descrição">
            <div v-html="product.description" class="prose max-w-none text-sm" />
          </Field>
        </div>

        <div v-else-if="activeTab === 'Preço & Categoria'">
          <Field label="Preço" :value="'€' + product.price" />
          <Field label="Desconto" :value="product.discount + '%'" />
          <Field label="Categoria" :value="product.category?.name ?? '-'" />
          <Field label="Região" :value="product.region?.name ?? '-'" />
        </div>

        <div v-else-if="activeTab === 'Imagens'">
          <div v-if="product.images?.length" class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <img v-for="img in product.images" :key="img.id" :src="img.url" class="rounded border object-cover h-32 w-full" />
          </div>
          <div v-else class="text-gray-400">Sem imagens.</div>
        </div>

        <div v-else-if="activeTab === 'Estoque & Visibilidade'">
          <Field label="Stock" :value="product.stock" />
          <Field label="Peso (kg)" :value="product.weight" />
          <Field label="Visível na loja" :value="product.visible ? 'Sim' : 'Não'" />
          <Field label="Destaque na homepage" :value="product.featured ? 'Sim' : 'Não'" />
          <Field label="Data de Lançamento" :value="product.release_date" />
        </div>

        <div v-else-if="activeTab === 'SEO'">
          <Field label="Título SEO" :value="product.seo_title" />
          <Field label="Descrição SEO" :value="product.seo_description" />
        </div>

        <div v-else-if="activeTab === 'Informações Avançadas'">
          <Field label="EAN" :value="product.ean" />
          <Field label="SKU" :value="product.sku" />
          <Field label="Marca" :value="product.brand" />
          <Field label="Unidade" :value="product.unit" />
          <Field label="Mínimo por Encomenda" :value="product.min_order_quantity" />
          <Field label="Máximo por Encomenda" :value="product.max_order_quantity" />
          <Field label="Tempo de Envio" :value="product.shipping_time" />
          <Field label="Validade" :value="product.expiration_date" />
          <Field label="Visível de" :value="product.visibility_start" />
          <Field label="Visível até" :value="product.visibility_end" />
          <Field label="Produto Ativo" :value="product.is_active ? 'Sim' : 'Não'" />
        </div>

        <div v-else-if="activeTab === 'Ficheiros'">
          <div v-if="product.files?.length" class="space-y-2">
            <ul class="list-disc pl-5">
              <li v-for="file in product.files" :key="file.id">
                <a :href="file.url" target="_blank" class="text-blue-600 underline">{{ file.name }}</a>
              </li>
            </ul>
          </div>
          <div v-else class="text-gray-400">Nenhum ficheiro enviado.</div>
        </div>
      </div>

      <ConfirmationModal :show="showModal" @cancel="showModal = false" @confirm="destroy">
        <template #title>Confirmar Eliminação</template>
        <template #content>Tem certeza de que deseja eliminar este produto?</template>
        <template #footer>
          <button @click="showModal = false" class="px-4 py-1.5 text-xs rounded bg-gray-200 text-gray-700 hover:bg-gray-300">
            Cancelar
          </button>
          <button @click="destroy" class="px-4 py-1.5 text-xs rounded bg-red-600 text-white hover:bg-red-700 ml-2">
            Eliminar
          </button>
        </template>
      </ConfirmationModal>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import Field from '@/Components/Field.vue'

const props = defineProps({
  product: Object
})

const showModal = ref(false)
const tabs = [
  'Detalhes',
  'Preço & Categoria',
  'Imagens',
  'Estoque & Visibilidade',
  'SEO',
  'Informações Avançadas',
  'Ficheiros'
]
const activeTab = ref('Detalhes')

const destroy = () => {
  router.delete(route('admin.products.destroy', props.product.id))
  showModal.value = false
}
</script>
