<template>
    <div class="container" :class="hamburgermenu? 'if_open' : ''">
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

                    <button class="btn btn-primary"  @click="addToCart(food.id)">Aggiungi al Carrello</button>     

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
                quantity : 1,
                hamburgermenu : false,
                errors: {
                    itemError: '',
                    userError: ''
                }
            };
        },

        props: {
            restaurant: Number
        },
        created(){
             this.$root.$on('openHambMenu',(value)=>{
               this.hamburgermenu = value;
            });
        },
        mounted() {
            axios.get('/api/restaurant/' + this.restaurant)
            .then((r) => {
                
                this.foods = r.data.foods;
                this.users = r.data.user;
                
            })
            .catch(e => console.error(e));

        },
        
        methods: {
            addToCart: async function(id) {

                try {

                    let response = await fetch('http://localhost:8000/api/add/' + id, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    if (!response.ok) {
                        let responseToJson = await response.json();

                        if (responseToJson.errors.itemError) {
                            this.errors.itemError = responseToJson.errors.itemError.toString();
                        }

                        if (responseToJson.errors.userError) {
                            this.errors.userError = responseToJson.errors.userError.toString();
                        }

                    }

                } catch(err) {
                    console.log(err);
                }
                this.$root.$emit('addItem');
               
            },

        }
    }
</script>