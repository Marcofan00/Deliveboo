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
                    <div class="error_register" v-if="errors.restaurantAddressError">{{ errors.restaurantAddressError }}</div>

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
                errors: {
                    emailError: '',
                    fileError: '',
                    passwordError: '',
                    passwordConfirmError: '',
                    firstNameError: '',
                    lastNameError: '',
                    restaurantNameError: '',
                    restaurantAddressError: '',
                    streetNumberPostalCordeError: '',
                    cityError: '',
                    vatNumberError: '',
                    categoryError: ''
                },
                namesRegex: /^[a-z\s]+$/i
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
                this.validateEmail(value);
            },
            password(value) {
                this.password = value;
                this.validatePassword(value);
            },
            passwordConfirmed(value) {
                this.passwordConfirmed = value;
                this.validatePasswordConfirm(value);
            },
            firstName(value) {
                this.firstName = value;
                this.validateFirstName(value);
            },
            lastName(value) {
                this.lastName = value;
                this.validateLastName(value);
            },
            restaurantName(value) {
                this.restaurantName = value;
                this.validateRestaurantName(value);
            },
            restaurantAddress(value) {
                this.restaurantAddress = value;
                this.validateRestaurantAddress(value);
            },
            streetNumber(value) {
                this.streetNumber = value;
                this.validateStreetNumber(value);
            },
            postalCode(value) {
                this.postalCode = value;
                this.validatePostalCode(value);
            },
            city(value) {
                this.city = value;
                this.validateCity(value);
            },
            vatNumber(value) {
                this.vatNumber = value;
                this.validateVatNumber(value);
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
                this.validateFileType(this.file);
            },
            sendData: async function() {

                let validEmail = this.validateEmail(this.email),
                    validCategories = this.validateCategory(),
                    validCity = this.validateCity(this.city),
                    validFileType = this.validateFileType(),
                    validFirstName = this.validateFirstName(this.firstName),
                    validLastName = this.validateLastName(this.lastName),
                    validPassword = this.validatePassword(this.password),
                    validPasswordConfirmed = this.validatePasswordConfirm(this.passwordConfirmed),
                    validRestaurantAddress = this.validateRestaurantAddress(this.restaurantAddress),
                    validRestaurantName = this.validateRestaurantName(this.restaurantName),
                    validStreetNumber = this.validateStreetNumber(this.streetNumber),
                    validPostalCode = this.validatePostalCode(this.postalCode),
                    validVatNumber = this.validateVatNumber(this.vatNumber);

                if (
                    validEmail &&
                    validCategories &&
                    validCity &&
                    validFileType &&
                    validFirstName &&
                    validLastName &&
                    validPassword &&
                    validPasswordConfirmed &&
                    validRestaurantAddress &&
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
                                this.errors.restaurantAddressError = responseToJson.errors.address.toString();
                                this.errors.streetNumberPostalCodeError = responseToJson.errors.address.toString();
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

            },
            validateEmail(email) {

                if (!email || !/^([a-zA-Z0-9\_\-\.]+)@([a-zA-Z0-9\_\-\.]+)\.([a-zA-Z]{2,5})$/g.test(email)) {
                    this.errors.emailError = 'Email non valida';
                    return false;
                }

                this.errors.emailError = '';
                return true;
            },
            validatePassword(password) {

                if (!password || !/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/g.test(password)) {
                    this.errors.passwordError = 'Password non valida';
                    return false;
                }

                this.errors.passwordError = '';
                return true;
            },
            validatePasswordConfirm(passwordConfirmed) {

                if (passwordConfirmed !== this.password) {
                    this.errors.passwordConfirmError = 'Questa password non corrisponde alla prima inserita';
                    return false;
                }

                this.errors.passwordConfirmError = '';
                return true;
            },
            validateFirstName(firstName) {

                if (!firstName || !this.namesRegex.test(firstName)) {
                    this.errors.firstNameError = 'Nome non valido';
                    return false;
                }

                this.errors.firstNameError = '';
                return true;
            },
            validateLastName(lastName) {

                if (!lastName || !this.namesRegex.test(lastName)) {
                    this.errors.lastNameError = 'Cognome non valido';
                    return false;
                }

                this.errors.lastNameError = '';
                return true;                
            },
            validateRestaurantName(restaurantName) {

                if (!restaurantName || !/^[-a-z ,.\'0-9]+$/gi.test(restaurantName)) {
                    this.errors.restaurantNameError = 'Nome ristorante non valido';
                    return false;
                }

                this.errors.restaurantNameError = '';
                return true;                 
            },
            validateRestaurantAddress(restaurantAddress) {

                if (!restaurantAddress || !/^[-a-z ,.\'0-9]+$/gi.test(restaurantAddress)) {
                    this.errors.restaurantAddressError = 'Indirizzo non valido';
                    return false;
                }

                this.errors.restaurantAddressError = '';
                return true;  
            },
            validateStreetNumber(number) {

                if (!number || !/^\d+$/.test(number)) {
                    this.errors.streetNumberError = 'Numero civico non valido';
                    return false;
                }

                    this.errors.streetNumberError = '';
                    return true;                
            },
            validatePostalCode(number) {

                if (!number || !/^\d+$/.test(number)) {
                    this.errors.postalCodeError = 'CAP non valido';
                    return false;
                }

                    this.errors.postalCodeError = '';
                    return true;                
            },
            validateCity(city) {

                if (!city || !this.namesRegex.test(city)) {
                    this.errors.cityError = 'Città non valida';
                    return false;
                }

                this.errors.cityError = '';
                return true;                 
            },
            validateVatNumber(vatNumber) {

                if (!vatNumber || !/^it\d{14}$/gi.test(vatNumber)) {
                    this.errors.vatNumberError = 'Partita IVA non valida. Formato richiesto: IT seguito da 14 cifre';
                    return false;
                }

                this.errors.vatNumberError = '';
                return true;
            },
            validateFileType() {

                if (this.file && !this.file.type.includes('image')) {
                    this.errors.fileError = 'Formato file non valido. Inserisci una immagine';
                    return false;
                }

                this.errors.fileError = '';
                return true;
            },
            validateCategory() {

                if (this.categoriesChecked.length === 0) {
                    this.errors.categoryError = 'Devi scegliere almeno una categoria';
                    return false;
                }

                this.errors.categoryError = '';
                return true;
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