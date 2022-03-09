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

                    <button class="btn btn-primary"  @click="addToCart(food.id, food.user_id)">Aggiungi al Carrello</button>     

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
            addToCart: async function(id, userId) {
                   
                let data = JSON.stringify({
                    id,
                    userId,
                    // quantity: this.quantity
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
                this.$root.$emit('addItem');
               
            },

        }
    }
</script>