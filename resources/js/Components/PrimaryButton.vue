<template>
  <button
    class="inline-flex items-center px-4 py-2 bg-green-700 border border-transparent rounded-md font-semibold text-white tracking-widest hover:bg-green-800 focus:outline-none transition ease-in-out duration-150"
    v-bind="$attrs"
  >
    <slot />
  </button>
</template>
