<template>
    <div class="container"> 
        <section :class="hamburgermenu? 'if_open' : ''" id="jumbotron">
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
            <button class="btn btn-secondary">Filtra</button>
        </section>

        <section id="users">
            <h1>I tuoi piatti preferiti, consegnati da noi.</h1>
            <ul id="users-cards">
                <li class="user-card" v-for="user in users" :key="user.id">
                    <a :href="`restaurant/` + user.id">
                        <img src="/storage/img/deliverooDefault.png" alt="logo">
                        <h3>{{ user.restaurant_name }}</h3>
                        <h5>{{ user.address }}</h5>
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
            categories: [],
            users: [],
            hamburgermenu : false
        };
    },
    created(){
        this.$root.$on('openHambMenu',(value)=>{
               this.hamburgermenu = value;
                console.log(this.hamburgermenu);
            });
       
    },

    mounted() {
        axios.get('/api/categories')
        .then(r => this.categories = r.data)
        .catch(e => console.error(e));

        axios.get('/api/restaurants')
        .then(r => this.users = r.data)
        .catch(e => console.error(e));
    }
}
</script>