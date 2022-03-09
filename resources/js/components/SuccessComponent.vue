<template>
    <div>
        <div>{{ order.buyer_fullname }}</div>
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
