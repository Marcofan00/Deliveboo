<template>
    <div id="container"> 
        <section id="jumbotron">
            <img :src="`/storage/img/deliverooDefault.png`" alt="">
            <h1>I piatti che ami, a domicilio.</h1>
            <h2>#aCasaTuaConDeliveboo</h2>
        </section>

        <section id="categories-filters">
            <h1>Filtra per</h1>
            <ul id="categories-cards">
                <li class="category-card" v-for="category in categories" :key="category.id">
                    <img src="/storage/img/deliverooDefault.png" alt="category_img">
                    <h3>{{ category.name }}</h3>
                </li>
            </ul>
        </section>

        <section id="users">
            <h1>I tuoi piatti preferiti, consegnati da noi.</h1>
            <ul id="users-cards">
                <li class="user-card">
                    <a href="">
                        <img src="" alt="">
                        <h3></h3>
                    </a>
                </li>
            </ul>
        </section>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            categories: []
        };
    },

    mounted() {
        axios.get('http://localhost:8000/api/categories')
        .then(r => this.categories = r.data.data)
        .catch(e => console.error(e));
    }
}
</script>