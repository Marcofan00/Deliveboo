<template>
    <div :class="hamburgermenu? 'if_open' : ''" id="layout_restaurant_page" >
        <img  :src="'/storage/img/'+ users.logo" alt="">

        <div id="restaurant" class="container container_xxl_">

            <div class="info_user">
                <h1>{{ users.restaurant_name }}</h1>
                <div class="diamond">
                    <i class="fas fa-star"></i>
                </div>
                 <h5>{{ users.address }}</h5>
            </div>
            
        <h3>
            I nostri piatti
        </h3>
        <section id="foods">
            <ul id="foods-cards" >
                <li v-for="food in foods" :key="food.id" class="food-class" >
                    <img class="img_card" :src="'/storage/img/'+ food.food_img" alt="img_food">
                    <div class="body_card">
                        <h3>{{ food.name }}</h3>
                        <p>{{ food.description_ingredients }}</p>
                        <h4>{{ food.price }}&euro;</h4>

                        <button class="btn btn_food"  @click="addToCart(food.id)">Aggiungi al Carrello</button>     
                    </div>
                   
                </li>
                
            </ul>
        </section>
        </div>
    </div>
    
</template>

<script>
    import swal from 'sweetalert';
    export default {
        data: function() {
            return {
                foods: [],
                users: '',
                quantita : 0,
                cartArray : [],
                quantity : 1,
                hamburgermenu : false,
                thereError : false,
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
                            swal(this.errors.itemError);
                            
                        }

                        if (responseToJson.errors.userError) {
                            this.errors.userError = responseToJson.errors.userError.toString();
                            swal(this.errors.userError);
                            
                        }

                    }

                } catch(err) {
                    console.log(err);
                }
                this.$root.$emit('addItem');
               
            },
            erroricheck(){
                this.thereError = false;
            }

        }
    }
</script>