<template>
<!-- struttura del form -->
    <div class="demo-frame container container_xxl_">  
        <form id="cardForm" >
            <div class="data">
                <label class="hosted-fields--label" for="firstname">Nome</label>
                <input class="hosted-field" type="text" name="firstname" v-model="firstName">
                <div class="error" v-if="errors.firstNameError">{{ errors.firstNameError }}</div>

                <label class="hosted-fields--label" for="lastname">Cognome</label>
                <input class="hosted-field" type="text" name="lastname" v-model="lastName">
                <div class="error" v-if="errors.lastNameError">{{ errors.lastNameError }}</div>

                <label class="hosted-fields--label" for="email">E-mail</label>
                <input class="hosted-field" type="text" name="email" v-model="buyerEmail">
                <div class="error" v-if="errors.emailError">{{ errors.emailError }}</div>

                <label class="hosted-fields--label" for="address">Indirizzo</label>
                <input class="hosted-field" type="text" name="address" v-model="buyerAddress">
                <div class="error" v-if="errors.addressError">{{ errors.addressError }}</div>

                <label class="hosted-fields--label" for="streetnumber">Numero Civico</label>
                <input class="hosted-field" type="number" name="streetnumber" v-model="streetNumber">
                <div class="error" v-if="errors.streetNumberError">{{ errors.streetNumberError }}</div>

                <label class="hosted-fields--label" for="postalcode">CAP</label>
                <input class="hosted-field" type="text" name="postalcode" v-model="postalCode">
                <div class="error" v-if="errors.postalCodeError">{{ errors.postalCodeError }}</div>

                <label class="hosted-fields--label" for="city">Citt&agrave;</label>
                <input class="hosted-field" type="text" name="city" v-model="city">
                <div class="error" v-if="errors.cityError">{{ errors.cityError }}</div>

                <label class="hosted-fields--label" for="phone">Telefono</label>
                <input class="hosted-field" type="text" name="phone" v-model="buyerPhone">
                <div class="error" v-if="errors.phoneError">{{ errors.phoneError }}</div>

                <label class="hosted-fields--label" for="notes">Note</label>
                <textarea class="hosted-fields" name="note" cols="91" rows="10" v-model="notes"></textarea>
            </div>
            
            <div class="data">
                <label class="hosted-fields--label" for="card-number">Card Number</label>
                <!-- per ogni campo da compilare NON va usato il tag <input> ma il tag <div></div> 
                    hostedFields.create nello script provvederà a creare i campi dove poter scrivere -->
                <div type="text" class="hosted-field" id="card-number"></div>

                <label class="hosted-fields--label" for="expiration-date">Expiration Date</label>
                <div type="text" class="hosted-field" id="expiration-date"></div>

                <label class="hosted-fields--label" for="cvv">CVV</label>
                <div type="text" class="hosted-field" id="cvv"></div>
                <div class="error" v-if="errors.creditCardData">{{ errors.creditCardData }}</div>
            </div>

            <div class="button-container">
                <!-- usate type="button" per evitare che la pagina venga refreshata ogni volta che si mandano i dati -->
                <input type="button"  class="button button--small" value="Conferma Pagamento" id="submit" @click="tokenize(hostedFieldsInstance)"/>
            </div>
        </form>

    </div>  

</template>


<script>
import swal from 'sweetalert';
    let client = require('braintree-web/client');
    let hostedFields = require('braintree-web/hosted-fields');

    import {
        validateEmail,
        validateFirstName,
        validateLastName,
        validateAddress,
        validateStreetNumber,
        validatePostalCode,
        validateCity,
        validatePhone,
        errors
    } from '../utils.js';

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
                notes: '',
                errors
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
        watch: {
            firstName(value) {
                this.firstName = value;
                validateFirstName(value);
            },
            lastName(value) {
                this.lastName = value;
                validateLastName(value);
            },
            buyerEmail(value) {
                this.buyerEmail = value;
                validateEmail(value);
            },
            buyerAddress(value) {
                this.buyerAddress = value;
                validateAddress(value);
            },
            streetNumber(value) {
                this.streetNumber = value;
                validateStreetNumber(value);
            },
            postalCode(value) {
                this.postalCode = value;
                validatePostalCode(value);
            },
            city(value) {
                this.city = value;
                validateCity(value);
            },
            buyerPhone(value) {
                this.buyerPhone = value;
                validatePhone(value);
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

                    let response = await fetch('http://localhost:8000/api/token');

                    if (response.ok) {
                        let clientTokenToJson = await response.json();
                        this.clientToken = clientTokenToJson;
                    }

                    
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
                                }

                            }
                        }, function(err, hostedFieldsInstance) {
                            if (err) {
                                console.log(err);
                                return;
                            }

                            // salva hostedFieldsInstance in this.hostedFieldsInstance nei data() di Vue
                            self.hostedFieldsInstance = hostedFieldsInstance;

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
                        self.errors.creditCardData = 'Ooops! Qualcosa è andato storto...Controlla i dati della carta inseriti';
                        return;
                    }

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
                    order_date: this.setOrderDate(),
                    paymentMethodId: nonce
                });

                let validEmail = validateEmail(this.buyerEmail),
                    validCity = validateCity(this.city),
                    validFirstName = validateFirstName(this.firstName),
                    validLastName = validateLastName(this.lastName),
                    validAddress = validateAddress(this.buyerAddress),
                    validStreetNumber = validateStreetNumber(this.streetNumber),
                    validPostalCode = validatePostalCode(this.postalCode),
                    validPhone = validatePhone(this.buyerPhone);

                if (
                    validEmail &&
                    validCity &&
                    validFirstName &&
                    validLastName &&
                    validPhone &&
                    validAddress &&
                    validPostalCode &&
                    validStreetNumber
                ) {
                    try {

                        let response = await fetch('http://localhost:8000/api/payment', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: data
                        });

                        let responseToJson = await response.json();

                        if (!response.ok) {

                            if (responseToJson.errors.emptyCart) {
                                swal(responseToJson.errors.emptyCart.toString())
                                // this.errors.emptyCartError = responseToJson.errors.emptyCart.toString();
                            }

                            if (responseToJson.errors.buyer_email) {
                                this.errors.emailError = responseToJson.errors.buyer_email.toString();
                            }

                            if (responseToJson.errors.buyer_fullname) {
                                this.errors.firstNameError = responseToJson.errors.buyer_fullname.toString();
                                this.errors.lastNameError = responseToJson.errors.buyer_fullname.toString();
                            }

                            if (responseToJson.errors.buyer_address) {
                                this.errors.addressError = responseToJson.errors.buyer_address.toString();
                                this.errors.streetNumberError = responseToJson.errors.buyer_address.toString();
                                this.errors.postalCodeError = responseToJson.errors.buyer_address.toString();
                                this.errors.cityError = responseToJson.errors.buyer_address.toString();
                            }

                            if (responseToJson.errors.buyer_phone) {
                                this.errors.phoneError = responseToJson.errors.buyer_phone.toString();
                            }

                            if (responseToJson.errors.paymentFailed) {
                                window.location.href = 'http://localhost:8000/error';
                            }
                        } else {
                            window.location.href = 'http://localhost:8000/success/' + responseToJson.id;
                        }

                    } catch(err) {
                        console.log(err);
                    }
                }

            },
            setOrderDate() {
                let date = new Date(),
                    fullYear = date.getFullYear(),
                    day = date.getDate(),
                    month = date.getMonth() + 1;

                return fullYear + '/' + month + '/' + day;
            },
            // validateEmail(email) {

            //     if (!email || !/^([a-zA-Z0-9\_\-\.]+)@([a-zA-Z0-9\_\-\.]+)\.([a-zA-Z]{2,5})$/g.test(email)) {
            //         this.errors.emailError = 'Email non valida';
            //         return false;
            //     }

            //     this.errors.emailError = '';
            //     return true;
            // },
            // validateFirstName(firstName) {

            //     if (!firstName || !this.namesRegex.test(firstName)) {
            //         this.errors.firstNameError = 'Nome non valido';
            //         return false;
            //     }

            //     this.errors.firstNameError = '';
            //     return true;
            // },
            // validateLastName(lastName) {

            //     if (!lastName || !this.namesRegex.test(lastName)) {
            //         this.errors.lastNameError = 'Cognome non valido';
            //         return false;
            //     }

            //     this.errors.lastNameError = '';
            //     return true;                
            // },
            // validateAddress(address) {

            //     if (!address || !/^[-a-z ,.\'0-9]+$/gi.test(address)) {
            //         this.errors.addressError = 'Indirizzo non valido';
            //         return false;
            //     }

            //     this.errors.addressError = '';
            //     return true;  
            // },
            // validateStreetNumber(number) {

            //     if (!number || !/^\d+$/.test(number)) {
            //         this.errors.streetNumberError = 'Numero civico non valido';
            //         return false;
            //     }

            //     this.errors.streetNumberError = '';
            //     return true;                
            // },
            // validatePostalCode(number) {

            //     if (!number || !/^\d+$/.test(number)) {
            //         this.errors.postalCodeError = 'CAP non valido';
            //         return false;
            //     }

            //     this.errors.postalCodeError = '';
            //     return true;                
            // },
            // validateCity(city) {

            //     if (!city || !this.namesRegex.test(city)) {
            //         this.errors.cityError = 'Città non valida';
            //         return false;
            //     }

            //     this.errors.cityError = '';
            //     return true;                 
            // },
            // validatePhone(phone) {

            //     if (phone && !/\d{10}/.test(phone)) {
            //         this.errors.phoneError = 'Numero di telefono errato';
            //         return false;
            //     }

            //     this.errors.phoneError = '';
            //     return true;
            // }
            
        }
    }

</script>

<style scoped>

    .error {
        font-size: 10px;
        color: red;
        padding-bottom: 0.6rem;
    }
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
    max-width: 90%;
    margin: 0 auto;
    padding: 2rem;
    display: flex;
    justify-content: space-evenly;
    }
</style>