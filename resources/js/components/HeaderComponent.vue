<template>
    <div>
    
    <header class="container container_xxl_">

            <!-- logo  -->
        <a href="/">
            <img src="/storage/img/Logo.png" alt="logo_deeboo">
        </a>

        <!-- auth -->
        <div v-if="userid !== 0">
            

            <!-- carrello  -->
                <i @click="getCart" class="fas fa-cart-arrow-down"></i>
                <div class=" cart_block " v-if="cartSelected">
                    <div class="viewcart">

                        <h2>Riepilogo Carrello</h2>

                        <ul>

                            <li v-for="(item, i) in cart" :key="i">
                                
                                <div>
                                    Nome food : <span>{{ item.name }}</span>
                                </div>

                                    <div><button class="btn" @click="removeQty(item.id)">-</button>  {{ item.quantity }}  <button class="btn" @click="addQty(item.id)">+</button></div>
                                    <button class="btn" @click="removeItem(item.id)">Rimuovi piatto</button>
                                    <div>price: {{ item.price }}</div>
                                    <div>subtotal : {{ item.subtotal }}</div>

                                <hr>
                            </li>
                            
                        </ul>

                    <div> total price : {{ total }}</div>
                        
                        <button class="btn" @click="emptyCart()">Svuota carrello</button>
                    </div>
                </div>
            <a class="accedi_logout_btn" href="/logout">LOGOUT</a>

    
        </div>
        <!-- endauth -->

        <!-- guest -->
            <div v-if="userid === 0" id="action_user">
                
                <!-- carrello  -->
                <i @click="getCart" class="fas fa-cart-arrow-down"></i>
                 <div class="cart_block " v-if="cartSelected">
                    <div class="viewcart">

                        <h2>Riepilogo Carrello</h2>

                        <ul>

                            <li v-for="(item, i) in cart" :key="i">
                                <div>
                                    Nome food : <span>{{ item.name }}</span>
                                </div>

                                    <div><button class="btn" @click="removeQty(item.id)">-</button>  {{ item.quantity }}  <button class="btn" @click="addQty(item.id)">+</button></div>
                                    <button class="btn" @click="removeItem(item.id)">Rimuovi piatto</button>
                                    <div>price: {{ item.price }}</div>
                                    <div>subtotal : {{ item.subtotal }}</div>

                                <hr>
                            </li>
                        </ul>

                    
                    <div> total price : {{ total }}</div>
                        
                        <button class="btn" @click="emptyCart()">Svuota carrello</button>
                    </div>
                </div>

                <!-- Accedi  -->
                 <div class="accedi_logout_btn">
                    <a  href="/login">Accedi</a>
                </div>
               
            </div>

        <!-- endguest     -->






        <div id="header_component">
            <!-- hamburger menu  -->
            <i @click="mobilecheck()" class="fas fa-bars" ></i>

            <!-- dropdown menu ( mobile version se click su hamburge menu)  -->
            <div v-if="mobile_check" id="dropdown-menu" class="container">
                    <div id="menu_top">

                        <!-- carrello  -->
                        <i @click="getCart" class="fas fa-cart-arrow-down"></i>
                        
                        <i @click="mobilecheck()" class="fas fa-bars close_menu" ></i>
                    </div>
                    
                    <!-- Logout BTN -->
                    <div v-if="userid">
                        <a class="accedi_mobile" href="/logout">LOGOUT</a>
                    </div>

                    <!-- ACCEDI BTN  -->
                    <div v-if="!userid">
                        <a class="accedi_mobile" href="/login">Accedi</a>
                    </div>

                    <!-- TESTO  -->
                    <div id="testo_descrizione">
                        {{testo}}
                    </div>

                    <img class="img_default" src="/storage/img/deliverooDefault.png" alt="DEFAULT_IMG">
            </div>
        </div>  

        
    </header>
   
    </div>

   
</template>

<script>
    export default {
        props: {
            userid : Number,
        },
        data(){
            return  {
                mobile_check : false,
                testoVero : "prova vediamo un po",
                test : "Accedi o registrati per usufruire dei servizi DeeBoo !",
                cartSelected : false,
                cartArrayUser : [],
                quantitaProdotto : 1,
                prezzoFinale : 0,
                   cart: [],
                    total: ''
            }
        },
        created(){
            // this.getCart();
        },
        computed:{
        
        },
        methods : {
             mobilecheck(){
                this.mobile_check = !this.mobile_check;
            },
            
             getCart: async function() {
                 this.cartSelected = !this.cartSelected
             try {

                 let response = await fetch('http://localhost:8000/api/cart');

                 if (response.ok) {
                     let responseToJson = await response.json();
                     console.log(responseToJson);

                     this.cart = responseToJson.foods;
                     this.total = responseToJson.total;

                 }

             } catch(err) {
                 console.log(err);
             }
         },

            addQty: async function(id) {

             try {

                 let response = await fetch('http://localhost:8000/api/addqty/' + id, {
                     method: 'POST',
                     headers: {
                         'Content-Type': 'application/json'
                     }
                 });

                 if (response.ok) {

                    let responseToJson = await response.json();

                    this.cart = responseToJson.foods;
                    this.total = responseToJson.total;

                 }

             } catch(err) {
                 console.log(err);
             }
         },
         removeQty: async function(id) {
            
             try {

                 let response = await fetch('http://localhost:8000/api/removeqty/' + id, {
                     method: 'POST',
                     headers: {
                         'Content-Type': 'application/json'
                     }
                 });

                 if (response.ok) {

                    let responseToJson = await response.json();

                    this.cart = responseToJson.foods;
                    this.total = responseToJson.total;

                 }

             } catch(err) {
                 console.log(err);
             }
         },
         removeItem: async function(id) {
             try {

                 let response = await fetch('http://localhost:8000/api/removeitem/' + id, {
                     method: 'POST',
                     headers: {
                         'Content-Type': 'application/json'
                     }
                 });

                 if (response.ok) {
                     let responseToJson = await response.json();

                     this.cart = responseToJson.foods;
                     this.total = responseToJson.total;
                 }

             } catch(err) {
                 console.log(err);
             }
         },
         emptyCart: async function() {
             try {

                 let response = await fetch('http://localhost:8000/api/emptycart', {
                     method: 'POST',
                     headers: {
                         'Content-Type': 'application/json'
                     }
                 });

                 if (response.ok) {
                     let responseToJson = await response.json();

                    this.cart = responseToJson.foods;
                    this.total = responseToJson.total;
                 }

             } catch(err) {
                 console.log(err);
             }
         }
     },


            // addQuantity(id){
            //   this.cartArrayUser.forEach(element => {
            //       if (element.id === id){
            //           element.quantity ++
            //       }
            //   });
            // },
            // lessQuantity(id){
            //     this.cartArrayUser.forEach(element => {
            //       if (element.id === id && element.quantity >= 2 ){
            //           element.quantity --
            //       }
            //   });
            // },
            // prezzototale(){
            //     this.prezzoFinale = 0;
            //    this.cartArrayUser.forEach(element => {
                   
            //         this.prezzoFinale +=  (element.price * element.quantity);
                    
            //    });
               
                
            // }
           
        // },
        mounted() {

        }
    }
</script>