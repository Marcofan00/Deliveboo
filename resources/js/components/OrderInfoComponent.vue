<template>
    <div class="container container_xxl_" id="info_ordine_ristorante">
        <h2>
            Informazione sull ordine
        </h2>
        <ul class="ordine_info">
            <li >
                <div class="info_answer">
                   <div class="info_answer_sx"> Ordine id  </div> <div class="info_response uno"> {{ordinecheck.id}}</div> 
                </div>
                <div class="info_answer">
                   <div class="info_answer_sx">Totale conto </div>  <div class="info_response">{{ordinecheck.bill}} &euro;</div>
                </div>
                <div class="info_answer">
                   <div class="info_answer_sx">Data dell' ordine </div>  <div class="info_response uno">{{ordinecheck.order_date}}</div> 
                </div>
                <div class="info_answer">
                    <div class="info_answer_sx">Orario di acquisto </div>  <div class="info_response">{{ moment(ordinecheck.created_at).format("hh:mm") }}</div> 
                </div>
                <div class="info_answer">
                    <div class="info_answer_sx">Ordine effettuato da </div>  <div class="info_response uno">{{ordinecheck.buyer_fullname}}</div> 
                </div>
                <div class="info_answer">
                    <div class="info_answer_sx">Email acquirente </div>  <div class="info_response">{{ordinecheck.buyer_email}}</div> 
                </div>
                <div class="info_answer">
                    <div class="info_answer_sx">Indirizzo acquirente </div> <div class="info_response uno">{{ordinecheck.buyer_address}}</div> 
                </div>
                <div class="info_answer">
                    <div class="info_answer_sx">Telefono acquirente </div> <div class="info_response">{{ordinecheck.buyer_phone}}</div> 
                </div>
                <div class="info_answer">
                    <div class="info_answer_sx">Note aggiuntive </div> <div class="info_response uno">{{ordinecheck.note}}</div> 
                </div>
                <div class="info_answer">
                    <div class="info_answer_sx">Transazione andata a buon fine ?</div> <div class="info_response"><span v-if="ordinecheck.transaction_status">Si</span> <span v-else>No</span></div>
                </div>
                


            </li>
        </ul>
        <ul >
            <h2>Piatti acquistati</h2>
            <li class="ordine_info" v-for="food,i in ordineInfo" :key="i">
                <h3>Piatto n° {{i + 1}}</h3>
                <div class="info_answer">
                    <div class="info_answer_sx">Piatto acquistato </div>  <div class="info_response">{{food.name}}</div> 
                </div>

                <div class="info_answer">
                    <div class="info_answer_sx">Prezzo singolo piatto  </div>  <div class="info_response">{{food.price}} &euro;</div> 
                </div>

                <div class="info_answer">
                    <div class="info_answer_sx">Quantità acquistate  </div>  <div class="info_response">{{food.pivot.food_qty}}</div> 
                </div>

                <div class="info_answer">
                    <div class="info_answer_sx">Il piatto è ora visibile ? </div>  <div class="info_response"><span v-if="food.visible"> Si </span>  <span v-else>No</span></div> 
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
import moment from "moment";
    export default {
        props : {
            ordine:Array,
            ordinecheck:Object,
        },
          data () {
            
            return {
                ordineInfo : [],
                moment: moment
            }
        },
        mounted() {
            this.ordineInfo = this.ordine;
            console.log(this.ordinecheck);
            console.log(this.ordine);
        },
        methods:{
            
            
        }
    }
</script>