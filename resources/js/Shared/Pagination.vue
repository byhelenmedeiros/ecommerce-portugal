<template>
  <nav v-if="links.length > 3" class="flex flex-wrap gap-1 justify-center">
    <template v-for="(link, index) in links" :key="index">
      <component
        :is="link.url ? Link : 'span'"
        :href="link.url"
        class="px-3 py-1 text-sm rounded border"
        :class="{
          'bg-green-700 text-white border-green-700': link.active,
          'text-gray-500 cursor-not-allowed': !link.url,
          'hover:bg-gray-100': link.url && !link.active
        }"
        v-html="link.label"
      />
    </template>
  </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
defineProps({
  links: Array
})
</script>
