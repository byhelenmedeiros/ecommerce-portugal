<template>
    <div class="container">
        <h1>Pedidos</h1>
        <div v-if="orders.length === 0">Nenhum pedido encontrado.</div>
        <ul v-else>
            <li v-for="order in orders" :key="order.id">
                Pedido #{{ order.id }} - {{ order.status }}
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {
            orders: []
        };
    }
};
</script>