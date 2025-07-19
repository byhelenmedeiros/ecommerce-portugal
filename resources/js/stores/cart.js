import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useCart = defineStore('cart', () => {
  const cart = ref([])

  function addToCart(product, quantity = 1) {
    const existing = cart.value.find(item => item.id === product.id)

    if (existing) {
      existing.quantity += quantity
    } else {
      cart.value.push({ ...product, quantity })
    }

     localStorage.setItem('cart', JSON.stringify(cart.value))
  }

  function removeFromCart(productId) {
    cart.value = cart.value.filter(item => item.id !== productId)
    localStorage.setItem('cart', JSON.stringify(cart.value))
  }

  function getQuantity(productId) {
    const item = cart.value.find(p => p.id === productId)
    return item ? item.quantity : 1
  }

  function increaseQty(productId) {
    const item = cart.value.find(p => p.id === productId)
    if (item) item.quantity++
  }

  function decreaseQty(productId) {
    const item = cart.value.find(p => p.id === productId)
    if (item && item.quantity > 1) item.quantity--
  }

  function loadCartFromStorage() {
    const stored = localStorage.getItem('cart')
    if (stored) {
      cart.value = JSON.parse(stored)
    }
  }

  return {
    cart,
    addToCart,
    removeFromCart,
    getQuantity,
    increaseQty,
    decreaseQty,
    loadCartFromStorage,
  }
})
