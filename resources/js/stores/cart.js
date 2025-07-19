import { ref, watch } from 'vue'

const wishlist = ref([])
const cart = ref([])

if (localStorage.getItem('wishlist')) {
  wishlist.value = JSON.parse(localStorage.getItem('wishlist'))
}
if (localStorage.getItem('cart')) {
  cart.value = JSON.parse(localStorage.getItem('cart'))
}

watch(wishlist, () => {
  localStorage.setItem('wishlist', JSON.stringify(wishlist.value))
}, { deep: true })

watch(cart, () => {
  localStorage.setItem('cart', JSON.stringify(cart.value))
}, { deep: true })

export function useWishlist() {
  function toggleWishlist(product) {
    const index = wishlist.value.findIndex(p => p.id === product.id)
    if (index > -1) {
      wishlist.value.splice(index, 1)
    } else {
      wishlist.value.push(product)
    }
  }

  function isInWishlist(productId) {
    return wishlist.value.some(p => p.id === productId)
  }

  return { wishlist, toggleWishlist, isInWishlist }
}

export function useCart() {
  function addToCart(product) {
    const exists = cart.value.find(p => p.id === product.id)
    if (!exists) {
      cart.value.push({ ...product, quantity: 1 })
    } else {
      exists.quantity += 1
    }
  }

  function removeFromCart(productId) {
    cart.value = cart.value.filter(p => p.id !== productId)
  }

  return { cart, addToCart, removeFromCart }
}
