import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useCart = defineStore('cart', () => {
  const cart = ref([])

  const loadCartFromStorage = () => {
    const stored = localStorage.getItem('cart')
    try {
      const parsed = stored ? JSON.parse(stored) : []
      cart.value = Array.isArray(parsed) ? parsed : []
    } catch (e) {
      cart.value = []
    }
  }

  const saveCartToStorage = () => {
    localStorage.setItem('cart', JSON.stringify(cart.value))
  }

  const addToCart = (product, quantity = 1) => {
    const existing = cart.value.find(p => p.id === product.id)
    if (existing) {
      existing.quantity += quantity
    } else {
      cart.value.push({
        id: product.id,
        name: product.name,
        image_url: product.image_url ?? null,
        price: Number(product.price ?? 0),
        quantity: Number(quantity),
      })
    }
    saveCartToStorage()
  }

  const increaseQty = (productId) => {
    const item = cart.value.find(p => p.id === productId)
    if (item) {
      item.quantity++
      saveCartToStorage()
    }
  }

  const decreaseQty = (productId) => {
    const item = cart.value.find(p => p.id === productId)
    if (item && item.quantity > 1) {
      item.quantity--
      saveCartToStorage()
    }
  }

  const removeFromCart = (productId) => {
    cart.value = cart.value.filter(item => item.id !== productId)
    saveCartToStorage()
  }

  return {
    cart,
    loadCartFromStorage,
    saveCartToStorage,
    addToCart,
    increaseQty,
    decreaseQty,
    removeFromCart
  }
})
