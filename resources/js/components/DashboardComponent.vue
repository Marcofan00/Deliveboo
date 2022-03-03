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
            
                <ul v-for="food, i in foods" :key="i">
                    <li>
                        <div id="action_food">

                            <a :href="`/food/edit/${food.id}`" target="_blank">
                                 <div>
                                    <i class="fas fa-edit"></i> Edit
                                </div>
                            </a>
                           

                            <div>
                            
                                 <div v-if="food.visible" id="nascondi" @click="hideCard(food.id)">
                                   <i class="far fa-eye-slash"></i> Hide  
                                </div>
                                <div v-else >
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
                orders_visibility : false,
                hidebtn : true,
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
            // test 
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
                    axios.post('http://localhost:8000/api/dashboard/delete/'+ id)
                .then(res => {
                    console.log(res.data);
                    (res.data);
                    // let food = res.data;
                    // console.log(food.id);
                    // for ( let i = 0 ; i < this.foods.length; i++){
                    //     element = this.foods[i];
                        
                    //     if( element.id === id){
                    //         element.visible = 0;
                    //         element = food;
                    //     }
                    // }


                }).catch(err=>{
                    console.error(err);
                });
                // let data = id;
                // try {
                //     let response = await fetch('http://localhost:8000/api/dashboard/delete/'+ id,{
                //         method : 'POST',
                //         body : data
                //     })
                // } catch (err) {
                //     console.log(err);
                // }
            },
            MakeVisibleFood(id){
                 axios.post('http://localhost:8000/api/dashboard/delete/'+ id)
                .then(res => {

                    let food = res.data;
                    console.log(food);
                    // console.log(food.id);
                    // for ( let i = 0 ; i < this.foods.length; i++){
                    //     element = this.foods[i];
                        
                    //     if( element.id === id){
                    //         element.visible = 1;
                    //         element = food;
                    //     }
                    // }



                }).catch(err=>{
                    console.error(err);
                });
            }
        }
    }
</script>