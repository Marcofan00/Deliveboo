<template>
    <div id="register_deeboo" class="container container_xxl_">


        <form>
            <div class="container_deeboo">
                <div class="data dati_register">
                    <h3>Dati personali</h3>
                    <label for="email">E-mail</label>
                    <input type="email" name="email" v-model.trim="email" :class="errors.emailError ? 'red' : 'green' " placeholder="email@example.com"><br>
                    <div class="error_register" v-if="errors.emailError">{{ errors.emailError }}</div>

                    <label for="password">Password</label>
                    <input type="password" name="password" v-model.trim="password" :class="errors.passwordError ? 'red' : 'green' " placeholder="Password1!"><br>
                    <div class="error_register" v-if="errors.passwordError">{{ errors.passwordError }}</div>

                    <label for="password_confirmation">Conferma Password</label>
                    <input type="password" name="password_confirmation" v-model.trim="passwordConfirmed" :class="errors.passwordConfirmError ? 'red' : 'green' " placeholder="Password1!"><br>
                    <div class="error_register" v-if="errors.passwordConfirmError">{{ errors.passwordConfirmError }}</div>

                    <label for="firstame">Nome</label>
                    <input type="text" name="firstname" v-model.trim="firstName" :class="errors.firstNameError ? 'red' : 'green' "><br>
                    <div class="error_register" v-if="errors.firstNameError">{{ errors.firstNameError }}</div>

                    <label for="lastname">Cognome</label>
                    <input type="text" name="lastname" v-model.trim="lastName" :class="errors.lastNameError ? 'red' : 'green' "><br>
                    <div class="error_register" v-if="errors.lastNameError">{{ errors.lastNameError }}</div>
                </div>
                <div class="data dati_register">
                    <h3>Dati Ristorante</h3>
                    <label for="restaurant_name">Nome Ristorante</label>
                    <input type="text" name="restaurant_name" v-model.trim="restaurantName" :class="errors.restaurantNameError ? 'red' : 'green' "><br>
                    <div class="error_register" v-if="errors.restaurantNameError">{{ errors.restaurantNameError }}</div>

                    <label for="street">Indirizzo Ristorante</label>
                    <input type="text" name="street" v-model.trim="restaurantAddress" :class="errors.restaurantAddressError ? 'red' : 'green' "><br>
                    <div class="error_register" v-if="errors.addressError">{{ errors.addressError }}</div>

                    <label for="streetnumber">Numero Civico</label>
                    <input type="number" name="streetnumber" v-model.trim="streetNumber" :class="errors.streetNumberPostalCordeError ? 'red' : 'green' "><br>
                    <div class="error_register" v-if="errors.streetNumberError">{{ errors.streetNumberError }}</div>

                    <label for="postalcode">CAP</label>
                    <input type="number" name="postalcode" v-model.trim="postalCode" :class="errors.streetNumberPostalCordeError ? 'red' : 'green' "><br>
                    <div class="error_register" v-if="errors.postalCodeError">{{ errors.postalCodeError }}</div>

                    <label for="city">Città</label>
                    <input type="text" name="city" v-model.trim="city" :class="errors.cityError ? 'red' : 'green' "><br>
                    <div class="error_register" v-if="errors.cityError">{{ errors.cityError }}</div>

                    <label for="vat_number">Partita IVA</label>
                    <input type="text" name="vat_number" v-model.trim="vatNumber" :class="errors.vatNumberError ? 'red' : 'green' " placeholder="IT12345678901234">
                    <div class="error_register" v-if="errors.vatNumberError">{{ errors.vatNumberError }}</div>
                </div>
                <div class="data dati_register column_category">
                    <h3>Categorie</h3>
                    <div class="categories_register" v-for="category in categories" :key="category.id">
                        <label class="label_categories" for="categories">{{ category.name }}</label>
                        <input class="checkbox_register" type="checkbox" :value="category.id" v-model="categoriesChecked">
                    </div>
                    <div class="error_register" v-if="errors.categoryError">{{ errors.categoryError }}</div>

                    <div id="logo">
                        <label id="label_img"  for="logo">Immagine di copertina</label>
                        <input type="file" name="logo" @change="getFile">
                        <div id="errore_img" class="error_register" v-if="errors.fileError">{{ errors.fileError }}</div>
                    </div>
                    
                </div>
            </div>
            <div class="btn_registra">
                <button id="btn_reg" type="button" class="btn register-btn" @click="sendData">Registrami</button>
            </div>
            
        </form>

    </div>
</template>

<script>
    import { 
        validateEmail, 
        validatePassword, 
        validatePasswordConfirm, 
        validateFirstName, 
        validateLastName, 
        validateRestaurantName, 
        validateAddress, 
        validateStreetNumber, 
        validatePostalCode, 
        validateCity, 
        validateVatNumber, 
        validateFileType, 
        validateCategory,
        errors
    } from "../utils";

    export default {
        data() {
            return {
                categories: [],
                categoriesChecked: [],
                file: '',
                email: '',
                password: '',
                passwordConfirmed: '',
                firstName: '',
                lastName: '',
                restaurantName: '',
                restaurantAddress: '',
                streetNumber: '',
                postalCode: '',
                city: '',
                vatNumber: '',
                errors
            }
        },
        mounted() {
            this.getAllCategories();
        },
        computed: {
            fullName() {
                return this.firstName + ' ' + this.lastName;
            },
            fullAddress() {
                return this.restaurantAddress + ', ' + this.streetNumber + ', ' + this.postalCode + ', ' + this.city;
            }
        },
        watch: {
            email(value) {
                this.email = value;
                validateEmail(value);
            },
            password(value) {
                this.password = value;
                validatePassword(value);
            },
            passwordConfirmed(value) {
                this.passwordConfirmed = value;
                validatePasswordConfirm(value, this.password);
            },
            firstName(value) {
                this.firstName = value;
                validateFirstName(value);
            },
            lastName(value) {
                this.lastName = value;
                validateLastName(value);
            },
            restaurantName(value) {
                this.restaurantName = value;
                validateRestaurantName(value);
            },
            restaurantAddress(value) {
                this.restaurantAddress = value;
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
            vatNumber(value) {
                this.vatNumber = value;
                validateVatNumber(value);
            }
        },
        methods: {
            getAllCategories: async function() {
                try {

                    let response = await fetch('http://localhost:8000/api/categories');

                    if (response.ok) {
                        let responseToJson = await response.json();
                        
                        this.categories = responseToJson;
                    }

                } catch(err) {
                    console.log(err);
                }
            },
            getFile() {
                this.file = event.target.files[0];
                validateFileType(this.file, false);
            },
            sendData: async function() {

                let validEmail = validateEmail(this.email),
                    validCategories = validateCategory(this.categoriesChecked),
                    validCity = validateCity(this.city),
                    validFileType = validateFileType(this.file, false),
                    validFirstName = validateFirstName(this.firstName),
                    validLastName = validateLastName(this.lastName),
                    validPassword = validatePassword(this.password),
                    validPasswordConfirmed = validatePasswordConfirm(this.passwordConfirmed, this.password),
                    validAddress = validateAddress(this.restaurantAddress),
                    validRestaurantName = validateRestaurantName(this.restaurantName),
                    validStreetNumber = validateStreetNumber(this.streetNumber),
                    validPostalCode = validatePostalCode(this.postalCode),
                    validVatNumber = validateVatNumber(this.vatNumber);

                if (
                    validEmail &&
                    validCategories &&
                    validCity &&
                    validFileType &&
                    validFirstName &&
                    validLastName &&
                    validPassword &&
                    validPasswordConfirmed &&
                    validAddress &&
                    validRestaurantName &&
                    validStreetNumber &&
                    validPostalCode &&
                    validVatNumber
                ) {
                    let data = new FormData();

                    data.append('categories', this.categoriesChecked);
                    data.append('logo', this.file);
                    data.append('email', this.email);
                    data.append('password', this.password);
                    data.append('password_confirmation', this.passwordConfirmed);
                    data.append('full_name', this.fullName);
                    data.append('restaurant_name', this.restaurantName);
                    data.append('address', this.fullAddress);
                    data.append('vat_number', this.vatNumber);

                    try {

                        let response = await fetch('http://localhost:8000/register', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: data
                        });

                        if (!response.ok) {
                            let responseToJson = await response.json();

                            if (responseToJson.errors.email) {
                                this.errors.emailError = responseToJson.errors.email.toString();
                            }

                            if (responseToJson.errors.logo) {
                                this.errors.fileError = responseToJson.errors.logo.toString();
                            }
                            
                            if (responseToJson.errors.password) {
                                this.errors.passwordError = responseToJson.errors.password.toString();
                            }
                            
                            if (responseToJson.errors.full_name) {
                                this.errors.firstNameError = responseToJson.errors.full_name.toString();
                                this.errors.lastNameError = responseToJson.errors.full_name.toString();
                            }

                            if (responseToJson.errors.restaurant_name) {
                                this.errors.restaurantNameError = responseToJson.errors.restaurant_name.toString();
                            }
                            
                            if (responseToJson.errors.address) {
                                this.errors.addressError = responseToJson.errors.address.toString();
                                this.errors.streetNumberError = responseToJson.errors.address.toString();
                                this.errors.postalCodeError = responseToJson.errors.address.toString();
                                this.errors.cityError = responseToJson.errors.address.toString();
                            }
                            
                            if (responseToJson.errors.vat_number) {
                                this.errors.vatNumberError = responseToJson.errors.vat_number.toString();
                            }
                            
                            if (responseToJson.errors.categories) {
                                this.errors.categoryError = responseToJson.errors.categories.toString();
                            }
                        } else {
                            window.location.href = '/dashboard/';
                        }

                    } catch(err) {
                        console.log(err)
                    }

                } else {
                    console.log('errore');
                }

            }
        }
    }
</script>

<style scoped>
    #register {
        width: 90%;
        margin: 0 auto;
        padding-top: 2rem;
        padding-bottom: 2rem;
    }

    #logo, h3 {
        font-size: 1.2rem;
        display: block;
    }

    .container-flex {
        display: flex;
        width: 100%;
        justify-content: space-evenly;
    }

    .data {
        width: 33%;
    }

    .categories {
        display: inline-block;
        padding-right: 0.5rem;
    }

    .categories label {
        margin-bottom: 0;
    }

    .red {
        border: 1px solid red;
    }

    .green {
        border: 1px solid green;
    }

    .error {
        font-size: 10px;
        color: red;
        padding-bottom: 0.6rem;
    }

    .btn-container {
        text-align: right;
        padding: 1rem 0;
    }

    .register-btn {
        background-color: green;
        color: white;
    }
</style>