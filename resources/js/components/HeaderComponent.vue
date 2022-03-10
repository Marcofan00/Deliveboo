<template>
    <div>
    
    <header :class="!mobile_check? 'container container_xxl_' : 'container mobile_header'">

        <!-- logo  -->
        <a href="/">
            <img src="/storage/img/Logo.png" alt="logo_deeboo">
        </a>

        <!-- auth -->
        <div v-if="userid !== 0" class="action_user">
            
            <!-- carrello  -->
                <span>{{lunghezzaCart}}</span>
                <i @click="openCart()" class="fas fa-cart-arrow-down"></i>

                <!-- Apertura riepilogo al click  -->
                 <div class="cart_block " v-if="cartSelected">
                    <div class="viewcart">

                        <h2>Riepilogo Carrello</h2>

                        <ul>

                            <li v-for="(item, i) in cart" :key="i">
                                <!-- Nome prodotto e icona rimuovi  -->
                                <div class="Nome_Rimuovi">
                                    {{ item.name }}
                                    <i @click="removeItem(item.id)" class="fas fa-times"></i>
                                </div>

                                <!-- prezzo singolo  -->
                                <div class="price_font">Prezzo singolo : {{ item.price }} &euro;</div>
                                
                                <!-- subtotale e gestione quantita  -->
                                <div class="subtot_qty">
                                        <div class="price_font" >Subtotale : {{ item.subtotal }} &euro;</div>
                                        <div><button class="button" @click="removeQty(item.id)">-</button>  {{ item.quantity }}  <button class="button" @click="addQty(item.id)">+</button></div>
                                </div>

                                <hr>
                            </li>
                        </ul>

                    <!-- PREZZO TOTALE  -->
                    <div class="total_price">  TOTALE: {{ total }} &euro;</div>
                        
                        <!-- SVUOTA IL CARRELLO  -->
                        <div  class="svuota_cart" @click="emptyCart()"> Svuota carrello <i  class="fas fa-trash"></i> </div> 

                        <!-- link to checkout  -->
                        <a class="btn go_checkout" href="/checkout">Prosegui con il pagamento</a>
                    </div>
                </div>
            


            <a  class="go_dashboard" href="/dashboard">Visualizza la dashboard</a>
            
            <!-- PULSANTE LOGOUT  -->
            <div class="accedi_logout_btn">
                <a  href="/logout">LOGOUT</a>
            </div>

    
        </div>
        <!-- endauth -->

        <!-- guest -->
            <div v-if="userid === 0" class="action_user">
                
                <!-- carrello  -->
                <span>{{lunghezzaCart}}</span>
                <i @click="openCart()" class="fas fa-cart-arrow-down"></i>

                <!-- Apertura riepilogo al click  -->
                 <div class="cart_block " v-if="cartSelected">
                    <div class="viewcart">

                        <h2>Riepilogo Carrello</h2>

                        <ul>

                            <li v-for="(item, i) in cart" :key="i">

                                <!-- Nome prodotto e icona rimuovi     -->
                                <div class="Nome_Rimuovi">
                                    {{ item.name }}
                                    <i @click="removeItem(item.id)" class="fas fa-times"></i>
                                </div>

                                <!-- Prezzo singolo prodotto  -->
                                <div class="price_font">Prezzo singolo : {{ item.price }} &euro;</div>

                                <!-- Subtotale e gestione quantita  -->
                                <div class="subtot_qty">
                                    <div class="price_font" >Subtotale : {{ item.subtotal }} &euro;</div>
                                    <div><button class="button" @click="removeQty(item.id)">-</button>  {{ item.quantity }}  <button class="button" @click="addQty(item.id)">+</button></div>
                                </div>

                                <hr>
                            </li>
                        </ul>

                    <!-- PREZZO TOTALE  -->
                    <div class="total_price">  
                        TOTALE: {{ total }} &euro;</div>
                        <!-- Pulsante svuota carrello  -->
                        <div class="svuota_cart" @click="emptyCart()"> Svuota carrello <i  class="fas fa-trash"></i> </div> 

                        <!-- link to checkout  -->
                        <a class="btn go_checkout" href="/checkout">Prosegui con il pagamento</a>
                    </div>
                </div>

                <!-- Accedi  -->
                 <div class="accedi_logout_btn">
                    <a  href="/login">Accedi</a>
                </div>
               
            </div>

        <!-- endguest     -->


        <!-- GESTIONE MOBILE VIEW  -->
        <div id="header_component_mobile">
            <!-- hamburger menu  -->
            <i @click="mobilecheck()" class="fas fa-bars" ></i>

            <!-- dropdown menu ( mobile version se click su hamburge menu)  -->
            <div v-if="mobile_check" id="dropdown-menu" class="container">
                    <div id="menu_top">
                        <div>
                            <span>{{lunghezzaCart}}</span>
                            <!-- carrello  -->
                            <i @click="openCart()" class="fas fa-cart-arrow-down"></i>
                        </div>
                      
                        <!-- chiudi tendina  -->
                        <i @click="mobilecheck()" class="fas fa-bars close_menu" ></i>
                    </div>

                    <!-- blocco carrello  -->
                    <div class="cart_block " v-if="cartSelected">
                    <div class="viewcart">

                        <h2>Riepilogo Carrello</h2>

                        <ul>

                            <li v-for="(item, i) in cart" :key="i">

                                <!-- Nome prodotto e icona rimuovi     -->
                                <div class="Nome_Rimuovi">
                                    {{ item.name }}
                                    <i @click="removeItem(item.id)" class="fas fa-times"></i>
                                </div>

                                <!-- Prezzo singolo prodotto  -->
                                <div class="price_font">Prezzo singolo : {{ item.price }} &euro;</div>

                                <!-- Subtotale e gestione quantita  -->
                                <div class="subtot_qty">
                                    <div class="price_font" >Subtotale : {{ item.subtotal }} &euro;</div>
                                    <div><button class="button" @click="removeQty(item.id)">-</button>  {{ item.quantity }}  <button class="button" @click="addQty(item.id)">+</button></div>
                                </div>

                                <hr>
                            </li>
                        </ul>

                    <!-- PREZZO TOTALE  -->
                    <div class="total_price">  
                        TOTALE: {{ total }} &euro;</div>
                        <!-- Pulsante svuota carrello  -->
                        <div class="svuota_cart" @click="emptyCart()"> Svuota carrello <i  class="fas fa-trash"></i> </div> 

                        <!-- link to checkout  -->
                        <a class="btn go_checkout" href="/checkout">Prosegui con il pagamento</a>
                    </div>
                </div>
                    
                    <!-- Logout BTN -->
                    <div class="contenitore_blocco_if_logout" v-if="userid">

                        <a class="accedi_mobile" href="/logout">LOGOUT</a>

                        <div class="btn redirect">
                            <a href="/dashboard">
                                Vai alla dashboard
                            </a>
                        </div>

                        <div class="btn redirect">
                            <a href="/statistiche">
                                Visualizza le statistiche
                            </a>
                        </div>

                        <img class="img_default" :src="logoRistorante + '.png' " alt="DEFAULT_IMG">

                    </div>

                    <!-- ACCEDI BTN  -->
                    <div v-if="!userid">
                        <div id="descrizione_mobile">
                            Hai un ristorante ? Registrati su DeeBoo e fai conoscere a tutti i tuoi fantastici prodotti !
                        </div>
                        <a class="accedi_mobile" href="/login">Accedi</a>
                    </div>

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
                cartSelected : false,
                prezzoFinale : 0,
                cart: [],
                total: '',
                logoRistorante : "",
            }
        },
        computed : {
            lunghezzaCart () {
                return this.cart.length;
            }
        },
        created(){
            this.getImgRestaurant();
            this.getCart();
            self = this;
            this.$root.$on('addItem',()=>{

                self.getCart();
                
            });
        },
        
        methods : {
            getImgRestaurant(){
                if (this.userid !== 0){
                    axios.get('/api/restaurant/' + this.userid)
                    .then((r) => {
                        this.logoRistorante = r.data.user.logo;
                    })
                    .catch(e => console.error(e));
                }
                  
            },

             mobilecheck(){
                this.mobile_check = !this.mobile_check;
                this.$root.$emit('openHambMenu',this.mobile_check);
            },
            openCart(){
                 this.cartSelected = !this.cartSelected
                this.getCart();
            },
             getCart: async function() {
             try {

                 let response = await fetch('http://localhost:8000/api/cart');

                 if (response.ok) {
                     let responseToJson = await response.json();

                     console.log(responseToJson.total);


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
                    if(responseToJson.foods){
                        this.cart = responseToJson.foods;
                        this.total = responseToJson.total;
                    } else {
                        this.cart = [];
                        this.total = 0;
                    }  
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
                        if(responseToJson.foods){
                            this.cart = responseToJson.foods;
                            this.total = responseToJson.total;
                        } else {
                            this.cart = [];
                            this.total = 0;
                        } 
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
                   this.cart = [];
                   this.total = 0;
                 }

             } catch(err) {
                 console.log(err);
             }
         }
     },
    }
</script>