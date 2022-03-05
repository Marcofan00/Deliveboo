<template>
    <div>

    
    <header class="container container_xxl_">

            <!-- logo  -->
        <a href="/">
            <img src="/storage/img/Logo.png" alt="logo_deeboo">
        </a>

        <!-- auth -->
        <div v-if="userid !== 0">
            <a class="accedi_logout_btn" href="/logout">LOGOUT</a>
            

            <!-- carrello  -->
                <i @click="openCart" class="fas fa-cart-arrow-down"></i>
    
        </div>
        <!-- endauth -->

        <!-- guest -->
            <div v-if="userid === 0" id="Action_user">
                <!-- carrello  -->
                <i @click="openCart" class="fas fa-cart-arrow-down"></i>
                
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
                        <i @click="openCart" class="fas fa-cart-arrow-down"></i>
                        
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
    <div class="container container_xxl_ cart_block " v-if="cartSelected">
            <div class="viewcart">
               <ul>
                   <li v-for="foodcart,i in cartArrayUser" :key="i">
                       <div>
                           Nome food : <span>{{foodcart.name}}</span>
                       </div>

                       <div>
                          quantita: <span class="quantitaspan operator" @click="addQuantity(foodcart.id)">+</span> <span class="quantitaspan " > {{foodcart.quantity}} </span>  <span @click="lessQuantity(foodcart.id)" class="quantitaspan operator">-</span>
                       </div>

                       <div>
                          price: <span> {{foodcart.price}} </span>
                       </div>
                   </li>
               </ul>
               <div @click="prezzototale">
                   
                   total price : {{prezzoFinale}}
               </div>
            </div>
        </div>
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
                prezzoFinale : 0
            }
        },
        created(){
            this.testApi();
        },
        computed:{
        
        },
        methods : {
             mobilecheck(){
                this.mobile_check = !this.mobile_check;
            },
            openCart(){
                this.cartSelected = !this.cartSelected;
            },
              testApi: async function(){
                    const response = await fetch('http://localhost:8000/api/testi/', {
                        method: 'GET',
                        headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    
                        },
                        // body: JSON.stringify(addFoodToCart)

                        });
                    let risposta = await response.json();
                    this.cartArrayUser = risposta[0];
                    this.prezzoFinale = risposta[1];

            },

            addQuantity(id){
              this.cartArrayUser.forEach(element => {
                  if (element.id === id){
                      element.quantity ++
                  }
              });
            },
            lessQuantity(id){
                this.cartArrayUser.forEach(element => {
                  if (element.id === id && element.quantity >= 2 ){
                      element.quantity --
                  }
              });
            },
            prezzototale(){
                this.prezzoFinale = 0;
               this.cartArrayUser.forEach(element => {
                   
                    this.prezzoFinale +=  (element.price * element.quantity);
                    
               });
               
                
            }
           
        },
        mounted() {

        }
    }
</script>