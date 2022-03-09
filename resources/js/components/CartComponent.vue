<template>
    <div>
        <h2>Riepilogo Carrello</h2>
        <div v-for="(item, i) in cart" :key="i">
            <!-- <img src="" alt="immagine piatto"> -->
            <div>{{ item.name }}</div>
            <div>{{ item.price }}</div>
            <div><button class="btn" @click="addQty(item.id)">+</button>{{ item.quantity }}<button class="btn" @click="removeQty(item.id)">-</button></div>
            <button class="btn" @click="removeItem(item.id)">Rimuovi piatto</button>
            <div>{{ item.subtotal }}</div>
        </div>
        <div>{{ total }}</div>
        <button class="btn" @click="emptyCart()">Svuota carrello</button>
        <a href="/checkout" target="_blank">Vai al Checkout</a>
    </div>
</template>

<script>
 export default {
     data() {
         return {
             cart: [],
             total: ''
         }
     },
     mounted() {
         this.getCart();
     },
     methods: {
         getCart: async function() {
             try {

                 let response = await fetch('http://localhost:8000/api/cart');

                 if (response.ok) {
                     let responseToJson = await response.json();

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
     }
 }
</script>