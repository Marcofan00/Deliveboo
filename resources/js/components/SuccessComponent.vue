<template>
    <div>
        <h1>Ordine inviato con successo</h1>
        <h3>Di seguito il riepilogo del tuo ordine:</h3>
        <div>Cliente: {{ order.buyer_fullname }}</div>
        <div>Indirizzo di consegna: {{ order.buyer_address }}</div>
        <div>Data ordine: {{ order.order_date }}</div>
        <div>ID transazione: {{ order.transaction_id }}</div>
        <div>Totale: {{ order.bill }} &euro;</div>
    </div>
</template>

<script>
export default {
    props: {
        order: Object
    },
    mounted() {
        console.log(this.order);
    }
}
</script>
