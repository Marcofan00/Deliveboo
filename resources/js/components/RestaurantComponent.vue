<template>
    <div class="container">
        <section id="restaurant">
            <img src="/storage/img/deliverooDefault.png" alt="">
            <h1>{{ users.restaurant_name }}</h1>
        </section>

        <section id="foods">
            <ul id="foods-cards" >
                <li v-for="food in foods" :key="food.id" class="food-class" >
                    <img src="/storage/img/deliverooDefault.png" alt="">
                    <h3>{{ food.name }}</h3>
                    <p>{{ food.description_ingredients }}</p>
                    <h4>{{ food.price }}&euro;</h4>
                    <button class="btn" @click="addToCart(food.id, food.user_id)">Aggiungi al Carrello</button>                 
                    <input type="number" v-model="quantity">
                    <div class="btn btn-danger" v-else @click="deleteToCart(food.id)">
                        test
                    </div>
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
                users: '',
                quantita : 0,
                cartArray : [],
                quantity : 0,
                // clicked : -1,

            };
        },

        props: {
            restaurant: Number
        },

        mounted() {
            axios.get('/api/restaurant/' + this.restaurant)
            .then((r) => {
                // console.log(r.data);
                
                this.foods = r.data.foods;
                this.users = r.data.user;
            })
            .catch(e => console.error(e));

        },
        methods: {
            addToCart: async function(id, userId) {
                
                let data = JSON.stringify({
                    id,
                    userId,
                    quantity: this.quantity
                });

                try {

                    let response = await fetch('http://localhost:8000/api/add/' + id, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: data
                    });

                    if (response.ok) {
                        console.log(await response.json());
                    }

                } catch(err) {
                    console.log(err);
                }
            },
            deleteToCart(id){
                let index = this.cartArray.map(x => {
                    return x.id;
                }).indexOf(id);

                    this.cartArray.splice(index, 1);

            },

            testo(){
                // console.log(this.cartArray);
                this.foods.forEach(element => {
                    // console.log(element);
                });

            },
            verifico(id){
                if (this.cartArray.filter(e => e.id === id).length > 0) {
                        return false
                    } else{
                       return true
                    }
            },
        }
    }
</script>