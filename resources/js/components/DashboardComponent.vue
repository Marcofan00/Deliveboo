<template>
    <div class="container container_xxl_">
      <div id="dashboard">
          <div id="menu_select">
              <h2>
                  NOME RISTORANTE
              </h2>
                <img class="img_restaurant" src="/storage/img/deliverooDefault.png" alt="immagine_ristorante">

              <button class="btn dashboard_action" @click="visibility_foods">Visualizza i miei Piatti</button>


              <button class="btn dashboard_action" @click="visibility_orders">Visualizza i miei Ordini</button>

              <a href="/food/create">
                <button class="btn dashboard_action" >Crea Nuovo piatto</button>
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
            
                <ul v-for="food, i in foods" :key="i">
                    <li>
                        <div id="action_food">

                            <a :href="`/food/edit/${food.id}`">
                                 <div>
                                    <i class="fas fa-edit"></i> Edit
                                </div>
                            </a>
                           

                            <div>
                            
                                 <div v-if="food.visible" id="nascondi" @click="hideCard(food.id)">
                                   <i class="far fa-eye-slash"></i> Hide  
                                </div>
                                <div v-else>
                                    <button @click="MakeVisibleFood(food.id)">Rendi dinyovo visibile</button>
                                </div>
                            
                            </div>
                        </div>
                        <div class="card" style="width: 14rem;">
                            <img src="/storage/img/deliverooDefault.png" class="card-img-top" alt="">
                            <div class="card-body">
                                <h5 class="card-title">{{food.name}}</h5>
                                <p class="card-text">{{food.description_ingredients}}</p>
                                <span>
                                    {{food.price}}
                                </span>
                            </div>
                        </div>
                    </li>


                </ul>
             </div>
            <div v-if="orders_visibility" id="orders">
                prova
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
                foods_visibility : false,
                foods : [],
                orders_visibility : false
            }
        },
        created(){
            console.log(this.logincheck);
             axios.get('http://localhost:8000/api/dashboard/restaurant/'+ this.logincheck)
            .then(res => {
                console.log(res.data);
                this.foods = res.data;
            }).catch(err=>{
                console.error(err);
            });
            
        },
        mounted() {

        },
        methods : {
            visibility_foods(){
                this.orders_visibility = false;
                this.foods_visibility = !this.foods_visibility;
            },
            visibility_orders(){
               
                this.foods_visibility = false;
                
                this.orders_visibility =! this.orders_visibility;

                
            },
            hideCard(id){
                
               
            },
            MakeVisibleFood(id){

            }
        }
    }
</script>