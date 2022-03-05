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
                   
                    <input type="number" :value="quantita" @change="quantitaa">
                    <div class="btn btn-primary" v-if="verifico(food.id)" @click="addCart(food.id)">
                        aggiungi al carrello 
                    </div>
                    <div class="btn btn-danger" v-else @click="deleteToCart(food.id)">
                        test
                    </div>

                   
                </li>
            </ul>
        </section>

        <div @click="test">
            test
        </div>
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
        computed : {
         
        },
        methods:{
            addCart : async function(id){
                // console.log(id+  'id' + 'quantita' +this.quantity);
       

                let addFoodToCart = {
                    'id' : id,
                    'quantity' : this.quantity,
                    // 'user_id' : this.restaurant
                }
                if (this.cartArray.filter(e => e.id === id).length > 0) {
                        alert('gia inserito')
                    } 
                    else{
                        const response = await fetch('http://localhost:8000/api/test/'+addFoodToCart.id , {
                        method: 'POST',
                        headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    
                        },
                        body: JSON.stringify(addFoodToCart)
                    });
                    console.log(response.ok);
                    // const content = await rawResponse.json();
                       this.cartArray.push(addFoodToCart);
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
            quantitaa($event){
               this.quantity = parseInt($event.target.value) ;
            },
            verifico(id){
                if (this.cartArray.filter(e => e.id === id).length > 0) {
                        return false
                    } else{
                       return true
                    }
            },
            test: async function(){
                    const response = await fetch('http://localhost:8000/api/testi/', {
                        method: 'GET',
                        headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    
                        },
                        // body: JSON.stringify(addFoodToCart)

                        });
                    const content = await response.json();
                    // console.log(content);


            }
        }
    }
</script>