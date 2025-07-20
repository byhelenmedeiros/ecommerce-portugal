import './bootstrap'
import '../css/app.css'

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'
import VueTelInput from 'vue-tel-input'
import 'vue-tel-input/vue-tel-input.css'

import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import * as solidIcons from '@fortawesome/free-solid-svg-icons'
import * as regularIcons from '@fortawesome/free-regular-svg-icons'
import * as brandIcons from '@fortawesome/free-brands-svg-icons'


import { createPinia } from 'pinia'

 const solid = Object.keys(solidIcons).filter(k => k !== 'fas' && k !== 'prefix').map(k => solidIcons[k])
const regular = Object.keys(regularIcons).filter(k => k !== 'far' && k !== 'prefix').map(k => regularIcons[k])
const brands = Object.keys(brandIcons).filter(k => k !== 'fab' && k !== 'prefix').map(k => brandIcons[k])
library.add(...solid, ...regular, ...brands)

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

createInertiaApp({
title: title => `${title} - ${appName}`,
  resolve: name =>
    resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) })

    const pinia = createPinia()
    app.use(pinia)

     import('@/stores/cart').then(({ useCart }) => {
      useCart().loadCartFromStorage()
    })

    app.component('FontAwesomeIcon', FontAwesomeIcon)
    app.use(plugin)
    app.use(ZiggyVue)
    app.use(VueTelInput)

    app.mount(el)

    return app
  },
  progress: {
    color: '#4B5563',
  },
})
