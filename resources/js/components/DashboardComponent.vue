<template>
    <div :class="hamburgermenu? 'if_open' : ''" class="container container_xxl_">
      <div id="dashboard">
          <div id="menu_select">
              <h2>
                  {{ristorante.restaurant_name}}
              </h2>
                <img class="img_restaurant" :src="'/storage/img/'+ristorante.logo" alt="immagine_ristorante">

              <button class="btn dashboard_action" @click="visibility_foods">Visualizza i miei Piatti</button>


              <button class="btn dashboard_action" @click="visibility_orders">Visualizza i miei Ordini</button>

              <button class="btn dashboard_action" @click="visibility_statistic">Visualizza Statistiche</button>




            <!-- CREA NUOVO PIATTO  -->
              <a class="btn dashboard_action"  href="/food/create">
                  Crea Nuovo piatto
              </a>
            
          </div>
         <div id="view">
             <!-- <div v-for="food, i in foods" :key="i">
                 {{food.name}}
             </div> -->
            
             <div v-if="foods_visibility" id="foods">
                 <h2>
                    I miei piatti
                </h2>

                <div class="msg_foods_empty" v-if="foods.length === 0">
                    Nessun piatto inserito, Crea un nuovo piatto e fai conoscere a tutti i tuoi fantastici prodotti !
                </div>
                <ul>
                    <li v-for="food, i in foods" :key="i" >
                        <div id="action_food">

                            <a :href="`/food/edit/${food.id}`" target="_blank">
                                 <div id="edit_pulsante">
                                    <i class="fas fa-edit"></i> Edit
                                </div>
                            </a>
                           

                            <div>
                            

                                 <div v-if="food.visible" class="nascondi" @click="toggleVisibility(food.id)">
                                   <i class="far fa-eye-slash"></i> Nascondi  
                                </div>
                                <div v-else class="rendi_visibile" >
                                   <i class="fas fa-globe-europe"></i> <span @click="toggleVisibility(food.id)">Rendi visibile</span>
                                </div>
                            
                            </div>
                        </div>
                        <!-- <div class="card_food"> -->
                            <img v-if="`/storage/img/${food.food_img}`" :src="`/storage/img/${food.food_img}`" class="card-img-food" alt="">
                            <img v-else src="/storage/img/deliverooDefault.png" alt="default">
                            <div class="card-body_food">
                                <h5 class="card-title_food">{{food.name}}</h5>
                                <p class="card-text_food">{{food.description_ingredients}}</p>
                                <div class="cart-food-price">
                                    {{food.price}} &euro;
                                </div>
                            </div>

                            
                        <!-- </div> -->
                    </li>


                </ul>
             </div>
            <div v-if="orders_visibility" id="orders">
                    <div class="row riga_ordine_head">
                            <!-- <div class="col head_table">
                                Numero ordine
                            </div> -->
                            <div class="col-lg-2 head_table">
                                Nome acquirente
                            </div>
                            <div class="col head_table">
                                Email acquirente
                            </div>
                            <div class="col-2 head_table">
                                Totale ordine
                            </div>
                            <div class="col-2 head_table">
                                Data ordine
                            </div>
                            <!-- <div class="col-1 head_table">
                                ID transazione
                            </div> -->
                            <div class="col-1 head_table">
                                Info
                            </div>
                             <!-- <div class="col head_table">
                                Stato della transazione
                            </div> -->
                        </div>
                        
                         <div class="msg_foods_empty" v-if="orders.length === 0">
                                Nessun ordine trovato !
                        </div>
                        <div class="row riga_ordine" v-for="order,i in orders" :key="order.id">
                            <!-- <div class="col-1">
                                {{ order.id }}
                            </div> -->
                            <div class="col-2">
                                {{ order.buyer_fullname }}
                            </div>
                            <div class="col">
                                {{ order.buyer_email }}
                            </div>
                            <div class="col-2">
                                {{ order.bill }}&euro;
                            </div>
                            <div class="col-2">
                               {{ order.order_date }}
                            </div>
                            <!-- <div class="col-1">
                                {{ order.transaction_id }}
                            </div> -->
                            <div class="col-1" >

                                <a :href="'/dashboard/order/' + order.id"> <i class="fas fa-info info_order"></i></a>
                            </div>
                            <!-- <div class="col-1">
                                {{ order.transaction_status }}
                            </div> -->
                        </div>
                    
        
            </div>





            <!-- order mobile-->
            <div v-if="orders_visibility" id="orders-mobile">
                        <div class="msg_foods_empty" v-if="orders.length === 0">
                                Nessun ordine trovato !
                        </div>
                    <div class="row riga_ordine_head" v-for="order,i in orders" :key="order.id">
                            <div class="number_order">
                                Ordine n° {{ i + 1}}
                            </div> 
                            <div class="col-sm-12 head_table">
                               <div class="intestazione">
                                   Nome acquirente
                                </div> 
                                <div class="ordine_selected">
                                    {{ order.buyer_fullname }}
                                </div>
                            </div>
                            <div class="col-sm-12 head_table">
                                <div class="intestazione">
                                    Email acquirente
                                </div>
                                
                                <div class="ordine_selected">
                                    {{ order.buyer_email }}
                                </div>
                            </div>
                            <div class="col-sm-12 head_table">
                                <div class="intestazione">
                                    Totale ordine
                                </div>
                                
                                <div class="ordine_selected">
                                     {{ order.bill }}&euro;
                                </div>
                            </div>
                            <div class="col-sm-12 head_table">
                                <div class="intestazione">
                                    Data ordine
                                </div>
                                
                                <div class="ordine_selected">
                                    {{ order.order_date }}
                                </div>
                            </div>
                            <div class="col-sm-12 head_table" id="info_last">
                                <div class="intestazione text-center">
                                     <a class="info_btn" :href="'/dashboard/order/' + order.id"> <i class="fas fa-info info_order"></i>info</a>
                                </div>
                                
                            </div>
                         
                        </div>
                
                        
                    
        
            </div>



            <!-- statistiche  -->
            <div v-if="statistic_visibility">
                Statistiche
            </div>
         </div>
      </div>
    </div>
</template>

<script>
    export default {
        props:{
            logincheck : Number,
        },
        data () {
            
            return {
                ristorante : {},
                foods_visibility : true,
                foods : [],
                orders_visibility : false,
                statistic_visibility : false,
                hidebtn : true,
                orders: [],
                hamburgermenu : false,
            }
        },
        created(){
             this.$root.$on('openHambMenu',(value)=>{
               this.hamburgermenu = value;
            });

            // console.log(this.logincheck);
             axios.get('http://localhost:8000/api/dashboard/restaurant/'+ this.logincheck)
            .then(res => {
                console.log(res.data);
                this.foods = res.data;
            }).catch(err=>{
                console.error(err);
            });

            this.getAllOrders();
            
        },
        mounted() {
             axios.get('/api/restaurant/' + this.logincheck)
            .then((r) => {
                
                this.ristorante = r.data.user;
                
            })
            .catch(e => console.error(e));
        },
        methods : {
            info_order(id){
                console.log(id);
            },
            visibility_statistic(){
                this.orders_visibility = false;
                this.foods_visibility = false;
                this.statistic_visibility = true;
            },
            visibility_foods(){
                this.orders_visibility = false;
                this.statistic_visibility = false;

                this.foods_visibility = true;
            },
            visibility_orders(){
               
                this.foods_visibility = false;
                this.statistic_visibility = false;
                this.orders_visibility = true;

                
            },
            toggleVisibility(id){
                    axios.post('http://localhost:8000/api/dashboard/delete/'+ id)

                    .then((res) => {
                        this.foods.forEach((food) => {
                            if (food.id === res.data.id) {
                                food.visible = res.data.visible;
                            }
                        })

                    }).catch(err=>{
                        console.error(err);
                    });
            },
            getAllOrders: async function() {
                try {

                    let response = await fetch('http://localhost:8000/api/dashboard/orders/' + this.logincheck);

                    if (response.ok) {
                        let responseToJson = await response.json();
                        console.log(responseToJson);
                        this.orders = responseToJson;
                    }

                } catch(err) {
                    console.log(err);
                }
            }
        }
    }
</script>