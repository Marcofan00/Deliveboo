<template>
<!-- struttura del form -->
    <div class="demo-frame">  
        <form id="cardForm" >
            <label class="hosted-fields--label" for="firstname">Nome</label><br>
            <input class="hosted-field" type="text" name="firstname" v-model="firstName"><br>
            <label class="hosted-fields--label" for="lastname">Cognome</label><br>
            <input class="hosted-field" type="text" name="lastname" v-model="lastName"><br>
            <label class="hosted-fields--label" for="email">E-mail</label><br>
            <input class="hosted-field" type="text" name="email" v-model="buyerEmail"><br>
            <label class="hosted-fields--label" for="address">Indirizzo</label><br>
            <input class="hosted-field" type="text" name="address" v-model="buyerAddress"><br>
            <label class="hosted-fields--label" for="streetnumber">Numero Civico</label><br>
            <input class="hosted-field" type="text" name="streetnumber" v-model="streetNumber"><br>
            <label class="hosted-fields--label" for="postalcode">CAP</label><br>
            <input class="hosted-field" type="text" name="postalcode" v-model="postalCode"><br>
            <label class="hosted-fields--label" for="city">Citt&agrave;</label><br>
            <input class="hosted-field" type="text" name="city" v-model="city"><br>
            <label class="hosted-fields--label" for="phone">Telefono</label><br>
            <input class="hosted-field" type="text" name="phone" v-model="buyerPhone"><br>
            <label class="hosted-fields--label" for="notes">Note</label>
            <textarea class="hosted-fields" name="note" cols="91" rows="10" v-model="notes"></textarea>

            <label class="hosted-fields--label" for="card-number">Card Number</label>
            <!-- per ogni campo da compilare NON va usato il tag <input> ma il tag <div></div> 
                hostedFields.create nello script provvederà a creare i campi dove poter scrivere -->
            <div type="text" class="hosted-field" id="card-number"></div>

            <label class="hosted-fields--label" for="expiration-date">Expiration Date</label>
            <div type="text" class="hosted-field" id="expiration-date"></div>

            <label class="hosted-fields--label" for="cvv">CVV</label>
            <div type="text" class="hosted-field" id="cvv"></div>

            <div class="button-container">
                <!-- usate type="button" per evitare che la pagina venga refreshata ogni volta che si mandano i dati -->
                <input type="button" class="button button--small button--green" value="Purchase" id="submit" @click="tokenize(hostedFieldsInstance)"/>
            </div>
        </form>
    </div>  

</template>


<script>
    let client = require('braintree-web/client');
    let hostedFields = require('braintree-web/hosted-fields');

    export default {
        data() {
            return {
                clientToken: '',
                hostedFieldsInstance: '',
                firstName: '',
                lastName: '',
                buyerEmail: '',
                buyerAddress: '',
                streetNumber: '',
                postalCode: '',
                city: '',
                buyerPhone: '',
                notes: ''
            }
        },
        computed: {
            fullName() {
                return this.firstName + ' ' + this.lastName;
            },
            fullAddress() {
                return this.buyerAddress + ', ' + this.streetNumber + ', ' + this.postalCode + ', ' + this.city;
            }
        },
        mounted() {
            /* 
                chiama la ns API per avere il clientToken, che serve per l'autorizzazione a tutte le fasi successive del pagamento
            */
            this.callToApi();
        },
        methods: {
            callToApi: async function() {

                // blocco try/catch per la gestione di eventuali errori
                try {

                    let getClientToken = await fetch('http://localhost:8000/api/token');

                    let clientTokenToJson = await getClientToken.json();

                    this.clientToken = clientTokenToJson;

                    
                    if (this.clientToken) {
                        /*
                            funzione che crea cliente Braintree e campi da compilare
                            deve essere chiamata PRIMA che il cliente effettui il pagamento
                        */
                        this.createBraintreeClient();
                    }


                } catch(err) {
                    console.log(err);
                }
            },
            createBraintreeClient() {

                // salva il valore del this dell'istanza Vue in una variabile
                let self = this;

                // crea l'istanza del cliente Braintree (clientInstance)
                client.create(
                    {
                        authorization: this.clientToken
                    }, function(err, clientInstance) {
                    
                        if (err) {
                            console.log(err);
                            return;
                        }

                        // crea l'istanza dei campi da compilare (hostedFieldsInstance)
                        hostedFields.create({
                            client: clientInstance,

                            // campi da creare e relativo div in cui devono essere creati
                            fields: {
                                number: {
                                    container: '#card-number',
                                    placeholder: '4111 1111 1111 1111'
                                },
                                cvv: {
                                    container: '#cvv',
                                    placeholder: '123'
                                },
                                expirationDate: {
                                    container: '#expiration-date',
                                    placeholder: 'MM/YYYY'
                                },
                                // postalCode: {
                                //     container: '#postal-code',
                                //     placeholder: '11111'
                                // }

                            }
                        }, function(err, hostedFieldsInstance) {
                            if (err) {
                                console.log(err);
                                return;
                            }

                            // salva hostedFieldsInstance in this.hostedFieldsInstance nei data() di Vue
                            self.hostedFieldsInstance = hostedFieldsInstance;

                            console.log(self.hostedFieldsInstance);

                        })
                });
            },
            /* 
                al click sul button Purchase tokenizza i dati inseriti nel form e restituisce il paymentMethodNonce da
                mandare al ns server per processare il pagamento
            */
            tokenize(hostedFieldsInstance) {
                let self = this;

                hostedFieldsInstance.tokenize(function(err, payload) {
                    if (err) {
                        alert('Something went wrong. Check your card details and try again.');
                        return;
                    }

                    // stampa in console il paymentMethodNonce
                    console.log(payload.nonce);

                    self.sendPaymentData(payload.nonce);
                })
            },
            sendPaymentData: async function(nonce) {

                let data = JSON.stringify({
                    buyer_fullname: this.fullName,
                    buyer_email: this.buyerEmail,
                    buyer_address: this.fullAddress,
                    buyer_phone: this.buyerPhone,
                    note: this.notes ? this.notes : '',
                    order_date: new Date(),
                    paymentMethodId: nonce
                });

                try {

                    let response = await fetch('http://localhost:8000/api/payment', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: data
                    });

                    if (response.ok) {
                        console.log(await response.json());
                    }

                } catch(err) {
                    console.log(err);
                }
            }
            
        }
    }

</script>

<style scoped>
.hosted-field {
  height: 40px;
  box-sizing: border-box;
  width: 100%;
  padding: 12px;
  display: inline-block;
  box-shadow: none;
  font-weight: 600;
  font-size: 10px;
  border-radius: 6px;
  border: 1px solid #dddddd;
  line-height: 20px;
  background: #fcfcfc;
  margin-bottom: 12px;
  background: linear-gradient(to right, white 50%, #fcfcfc 50%);
  background-size: 200% 100%;
  background-position: right bottom;
  transition: all 300ms ease-in-out;
}



.hosted-fields--label {
  font-family: courier, monospace;
  text-transform: uppercase;
  font-size: 14px;
  display: block;
  margin-bottom: 6px;
}

.button-container {
  display: block;
  text-align: center;
}

.button {
  cursor: pointer;
  font-weight: 500;
  line-height: inherit;
  position: relative;
  text-decoration: none;
  text-align: center;
  border-style: solid;
  border-width: 1px;
  border-radius: 3px;
  -webkit-appearance: none;
  -moz-appearance: none;
  display: inline-block;
}

.button--small {
  padding: 10px 20px;
  font-size: 0.875rem;
}

.button--green {
  outline: none;
  background-color: #64d18a;
  border-color: #64d18a;
  color: white;
  transition: all 200ms ease;
}

.button--green:hover {
  background-color: #8bdda8;
  color: white;
}

.braintree-hosted-fields-focused {
  border: 1px solid #64d18a;
  border-radius: 1px;
  background-position: left bottom;
}

.braintree-hosted-fields-invalid {
  border: 1px solid #ed574a;
}

/* .braintree-hosted-fields-valid {
} */

#cardForm {
  max-width: 50.75em;
  margin: 0 auto;
  padding: 1.875em;
}
</style>