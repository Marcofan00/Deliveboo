<template>
    <div id="layout"  :class="hamburgermenu? 'if_open' : ''">
        <img id="layout_style_1" src="/storage/img/Vector.svg" alt="vettore1">
        <img id="layout_style_2" src="/storage/img/vectoruno.png" alt="vettore2">

        <div class="container container_xxl_"> 
            <section id="jumbotron">
                <div id="img-jumbotron">
                    <img src="/storage/img/delivebooDefault.png" alt="">
                </div>
                <div id="text-jumbotron">
                    <h1>I piatti che ami, a domicilio.</h1>
                    <h2>#aCasaTuaConDeliveboo</h2>
                </div>
            </section>

            <section id="categories-filters">
                <h1>Filtra per</h1>
                <ul id="categories-cards">
                    <li @click="getCategoryId(category.id)" class="category-card" v-for="category in categories" :key="category.id">
                        <img :src="category.category_img" alt="category_img">
                        <h3>{{ category.name }}</h3>
                    </li>
                </ul>
                <button class="btn btn-secondary" @click="searchResults()">Filtra</button><button class="btn btn-secondary" @click="getAllRestaurants()">Reset</button>
            </section>

            <section id="users">
                <h1>I tuoi piatti preferiti, consegnati da noi.</h1>
                <ul id="users-cards">
                    <li class="user-card" v-for="user in users" :key="user.id">
                        <a :href="`restaurant/` + user.id">
                            <img src="/storage/img/delivebooDefault.png" alt="logo">
                            <h3>{{ user.restaurant_name }}</h3>
                            <h5>{{ user.address }}</h5>
                            <h6>{{ user.category_name }}</h6>
                        </a>
                    </li>
                </ul>
            </section>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            categories: [],
            users: [],
            hamburgermenu : false,
            selectedCategories: []
        };
    },
    created(){
        this.$root.$on('openHambMenu',(value)=>{
               this.hamburgermenu = value;
            });
       
    },

    mounted() {
        axios.get('/api/categories')
        .then(r => this.categories = r.data)
        .catch(e => console.error(e));

        this.getAllRestaurants();

    },
    methods: {
        getCategoryId(id) {
            if (this.selectedCategories.includes(id)) {
                let categoryIndex = this.selectedCategories.indexOf(id);
                this.selectedCategories.splice(categoryIndex, 1);
            } else {
                this.selectedCategories.push(id);
            }

            console.log(this.selectedCategories);
        },
        searchResults: async function() {
            // console.log(this.selectedCategories);
            try {

                let response = await fetch('http://localhost:8000/api/search', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ categories: this.selectedCategories })
                });

                if (response.ok) {
                    
                    this.users = await response.json();
                    this.selectedCategories = [];
                }

            } catch(err) {
                console.log(err);
            }
        },

        getAllRestaurants() {
            axios.get('/api/restaurants')
            .then(r => this.users = r.data)
            .catch(e => console.error(e));
        }
    }
}
</script>