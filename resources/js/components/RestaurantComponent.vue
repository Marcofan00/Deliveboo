<template>
    <div class="container">
        <section id="restaurant">
            <img src="/storage/img/deliverooDefault.png" alt="">
            <h1>{{ users.restaurant_name }}</h1>
        </section>

        <section id="foods">
            <ul id="foods-cards">
                <li class="food-class" v-for="food in foods" :key="food.id">
                    <img src="/storage/img/deliverooDefault.png" alt="">
                    <h3>{{ food.name }}</h3>
                    <p>{{ food.description_ingredients }}</p>
                    <h4>{{ food.price }}&euro;</h4>
                </li>
            </ul>
        </section>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                foods: [],
                users: ''
            };
        },

        props: {
            restaurant: Number
        },

        mounted() {
            axios.get('/api/restaurant/' + this.restaurant)
            .then((r) => {
                this.foods = r.data.foods;
                this.users = r.data.user;
            })
            .catch(e => console.error(e));
        }
    }
</script>