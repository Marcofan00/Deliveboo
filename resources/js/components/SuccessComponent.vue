<template>
    <div class="container container_xxl_" id="success">
        <h2>Ordine inviato con successo</h2>
        <h3>Di seguito il riepilogo del tuo ordine:</h3>

        <ul class="ordine_info">
            <li>
                <div class="info_answer">
                   <div class="info_answer_sx"> Cliente  </div> <div class="info_response uno"> {{ order.buyer_fullname }}</div> 
                </div>
                <div class="info_answer">
                   <div class="info_answer_sx"> Indirizzo di consegna  </div> <div class="info_response uno"> {{ order.buyer_address }}</div> 
                </div>
                <div class="info_answer">
                   <div class="info_answer_sx"> Data ordine </div> <div class="info_response uno"> {{ order.order_date }}</div> 
                </div>
                <div class="info_answer">
                   <div class="info_answer_sx"> ID transazione:  </div> <div class="info_response uno"> {{ order.transaction_id }}</div> 
                </div>
                <div class="info_answer">
                   <div class="info_answer_sx"> Totale::  </div> <div class="info_response uno"> {{ order.bill }} &euro;</div> 
                </div>
            </li>
        </ul>

    </div>
</template>

<script>
export default {
    props: {
        order: Object
    },
    mounted() {
        console.log(this.order);
    }
}
</script>
