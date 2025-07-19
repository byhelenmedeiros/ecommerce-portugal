import { defineStore } from 'pinia'
import { ref, computed, watch } from 'vue'
import axios from '@/utils/axios' 

export const useWishlistStore = defineStore('wishlist', () => {
  const wishlist = ref([])
  const user = ref(null)  

  // Carregar wishlist
  const loadWishlist = async () => {
    if (user.value) {
      try {
        const { data } = await axios.get('/api/wishlist')
        wishlist.value = data
      } catch (error) {
        console.error('Erro ao carregar wishlist do servidor', error)
      }
    } else {
      const local = localStorage.getItem('wishlist')
      wishlist.value = local ? JSON.parse(local) : []
    }
  }

  // Guardar localmente
  watch(wishlist, (val) => {
    if (!user.value) {
      localStorage.setItem('wishlist', JSON.stringify(val))
    }
  }, { deep: true })

  // Adicionar item
  const add = async (item) => {
    if (wishlist.value.find((p) => p.id === item.id)) return

    wishlist.value.push(item)

    if (user.value) {
      await axios.post('/api/wishlist', { product_id: item.id })
    }
  }

  // Remover item
  const remove = async (id) => {
    wishlist.value = wishlist.value.filter((p) => p.id !== id)

    if (user.value) {
      await axios.delete(`/api/wishlist/${id}`)
    }
  }

  // Checar se está na wishlist
  const has = (id) => wishlist.value.some((p) => p.id === id)

  return {
    wishlist,
    user,
    loadWishlist,
    add,
    remove,
    has,
  }
})
