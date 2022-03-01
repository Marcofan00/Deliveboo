<template>
    <div>

        <!-- hamburger menu  -->
         <i @click="mobilecheck()" class="fas fa-bars" ></i>

        <!-- dropdown menu ( mobile version se click su hamburge menu)  -->
        <div v-if="mobile_check" id="dropdown-menu" class="container">
                <div id="menu_top">
                    <!-- carrello  -->
                    <a href="/cart">
                        <i class="fas fa-cart-arrow-down"></i>
                    </a>
                    <i @click="mobilecheck()" class="fas fa-bars close_menu" ></i>
                </div>
                
                <!-- Logout BTN -->
                 <!-- <div v-if="userid !== 1">
                    <a class="accedi_mobile" href="/logout">LOGOUT</a>
                </div> -->

                <!-- ACCEDI BTN  -->
                <!-- <div v-if="userid === 1">
                    <a class="accedi_mobile" href="/login">Accedi</a>
                </div> -->

                <!-- TESTO  -->
                <div id="testo_descrizione">
                    {{testo}}
                </div>

                <img class="img_default" src="/storage/img/deliverooDefault.png" alt="DEFAULT_IMG">
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
                test : "Accedi o registrati per usufruire dei servizi DeeBoo !"
            }
        },
        computed:{
           testo(){
               return this.test;
           }
        },
        methods : {
             mobilecheck(){
                this.mobile_check = !this.mobile_check;

                // if (this.mobile_check ){
                //      for ( let i = 0 ; i < this.testoVero.length ; i++ ){
                //     setTimeout(() => {
                //          let char = this.testoVero[i];
                //          this.test += char ;
                //     }, 3000);

                //     }
                // }
            },
           
        },
        mounted() {
            console.log('checkHeader' + this.userid);
        }
    }
</script>