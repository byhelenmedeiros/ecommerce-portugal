import { defineStore } from 'pinia'
import { ref, watch } from 'vue'
import axios from '@/utils/axios'

export const useWishlistStore = defineStore('wishlist', () => {
  const wishlist = ref([])
  const user = ref(null) // define isso com base na auth real

  const loadWishlist = async () => {
    try {
      const { data } = await axios.get('/wishlist') // baseURL já é /api
      wishlist.value = data
      console.log('wishlist recebida:', data)
    } catch (error) {
      console.error('Erro ao carregar wishlist:', error)
    }
  }

  const syncLocalWishlist = async () => {
    const local = JSON.parse(localStorage.getItem('wishlist') || '[]')
    for (const item of local) {
      try {
        await axios.post('/api/wishlist', { product_id: item.id })
      } catch (e) {
        console.error('Erro ao sincronizar wishlist', e)
      }
    }
    localStorage.removeItem('wishlist')
    await loadWishlist()
  }

  watch(wishlist, (val) => {
    if (!user.value) {
      localStorage.setItem('wishlist', JSON.stringify(val))
    }
  }, { deep: true })

  const add = async (item) => {
    if (wishlist.value.find((p) => p.id === item.id)) return
    wishlist.value.push(item)

    if (user.value) {
      await axios.post('/api/wishlist', { product_id: item.id })
    }
  }

  const remove = async (id) => {
    wishlist.value = wishlist.value.filter((p) => p.id !== id)
    if (user.value) {
      await axios.delete(`/api/wishlist/${id}`)
    }
  }

  const has = (id) => wishlist.value.some((p) => p.id === id)

  return {
    wishlist,
    user,
    loadWishlist,
    syncLocalWishlist,
    add,
    remove,
    has,
  }
})
