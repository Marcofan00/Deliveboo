<template>
    <div class="container"> 
        <section id="jumbotron">
            <img :src="`/storage/img/deliverooDefault.png`" alt="">
            <h1>I piatti che ami, a domicilio.</h1>
            <h2>#aCasaTuaConDeliveboo</h2>
        </section>

        <section id="categories-filters">
            <h1>Filtra per</h1>
            <ul id="categories-cards">
                <li class="category-card" v-for="category in categories" :key="category.id">
                    <img src="https://www.donnamoderna.com/content/uploads/2021/01/sushi-nigiri-830x625.jpg" alt="category_img">
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
                        <img src="https://static.gamberorosso.it/2022/01/sushi-1024x683.jpeg" alt="logo">
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
            selectedCategories: []
        };
    },

    mounted() {
        axios.get('/api/categories')
        .then(r => this.categories = r.data)
        .catch(e => console.error(e));

        this.getAllRestaurants();

    },
    methods: {
        getCategoryId(id) {
            this.selectedCategories.push(id);
        },
        searchResults: async function() {
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