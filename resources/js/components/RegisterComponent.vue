<template>
    <div id="register">
        <h2>Registrazione</h2>
        <form>

            <label for="email">E-mail</label><br>
            <input type="email" name="email" v-model.trim="email" required :class="errors.emailError ? 'red' : 'green' "><br>
            <div v-if="errors.emailError">{{ errors.emailError }}</div>

            <label for="password">Password</label><br>
            <input type="password" name="password" v-model.trim="password" required><br>
            <div v-if="errors.passwordError">{{ errors.passwordError }}</div>

            <label for="password_confirmation">Conferma Password</label><br>
            <input type="password" name="password_confirmation" v-model.trim="passwordConfirmed" required><br>
            <div v-if="errors.passwordConfirmError">{{ errors.passwordConfirmError }}</div>

            <label for="firstame">Nome</label><br>
            <input type="text" name="firstname" v-model.trim="firstName" required><br>
            <div v-if="errors.firstNameError">{{ errors.firstNameError }}</div>

            <label for="lastname">Cognome</label><br>
            <input type="text" name="lastname" v-model.trim="lastName" required><br>
            <div v-if="errors.lastNameError">{{ errors.lastNameError }}</div>

            <label for="restaurant_name">Nome Ristorante</label><br>
            <input type="text" name="restaurant_name" v-model.trim="restaurantName" required><br>
            <div v-if="errors.restaurantNameError">{{ errors.restaurantNameError }}</div>

            <label for="street">Indirizzo Ristorante</label><br>
            <input type="text" name="street" v-model.trim="restaurantAddress" required><br>
            <div v-if="errors.restaurantAddressError">{{ errors.restaurantAddressError }}</div>

            <label for="streetnumber">Numero Civico</label><br>
            <input type="number" name="streetnumber" v-model.trim="streetNumber" required><br>
            <div v-if="errors.streetNumberPostalCordeError">{{ errors.streetNumberPostalCordeError }}</div>

            <label for="postalcode">CAP</label><br>
            <input type="number" name="postalcode" v-model.trim="postalCode" required><br>
            <div v-if="errors.streetNumberPostalCordeError">{{ errors.streetNumberPostalCordeError }}</div>

            <label for="city">Città</label><br>
            <input type="text" name="city" v-model.trim="city" required><br>
            <div v-if="errors.cityError">{{ errors.cityError }}</div>

            <label for="vat_number">Partita IVA</label><br>
            <input type="text" name="vat_number" v-model.trim="vatNumber" required>
            <div v-if="errors.vatNumberError">{{ errors.vatNumberError }}</div>

            <div v-for="category in categories" :key="category.id">
                <label for="categories">{{ category.name }}</label>
                <input type="checkbox" :value="category.id" v-model="categoriesChecked" required>
            </div>
            <div v-if="errors.categoryError">{{ errors.categoryError }}</div>

            <label for="logo">Logo</label><br>
            <input type="file" name="logo" @change="getFile"><br>
            <div v-if="errors.fileError">{{ errors.fileError }}</div>

            <button type="button" class="btn btn-success" @click="sendData">REGISTER</button>
        </form>

        <a class="btn btn-secondary">BACK TO HOME</a>
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
                namesRegex: /^[a-z ,.\'-]+$/gi
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
                this.validateStreetNumberPostalCode(value);
            },
            postalCode(value) {
                this.postalCode = value;
                this.validateStreetNumberPostalCode(value);
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
            },
            sendData: async function() {

                if (
                    this.validateEmail(this.email) &&
                    this.validateCategory() &&
                    this.validateCity(this.city) &&
                    this.validateFileType() &&
                    this.validateFirstName(this.firstName) &&
                    this.validateLastName(this.lastName) &&
                    this.validatePassword(this.password) &&
                    this.validatePasswordConfirm(this.passwordConfirmed) &&
                    this.validateRestaurantAddress(this.restaurantAddress) &&
                    this.validateRestaurantName(this.restaurantName) &&
                    this.validateStreetNumberPostalCode(this.streetNumber) &&
                    this.validateStreetNumberPostalCode(this.postalCode) &&
                    this.validateVatNumber(this.vatNumber)
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
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            body: data
                        });

                    } catch(err) {
                        console.log(err)
                    }

                } else {
                    console.log('errore');
                }

            },
            validateEmail(email) {

                if (!/^([a-zA-Z0-9\_\-\.]+)@([a-zA-Z0-9\_\-\.]+)\.([a-zA-Z]{2,5})$/g.test(email)) {
                    this.errors.emailError = 'Email non valida';
                    return false;
                }

                this.errors.emailError = '';
                return true;
            },
            validatePassword(password) {

                if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/g.test(password)) {
                    this.errors.passwordError = 'Password non valida';
                    return false;
                }

                this.errors.passwordError = '';
                return true;
            },
            validatePasswordConfirm(passwordConfirmed) {

                if (passwordConfirmed !== this.password) {
                    this.errors.passwordConfirmError = 'Questa password non coirrisponde alla prima inserita';
                    return false;
                }

                this.errors.passwordConfirmError = '';
                return true;
            },
            validateFirstName(firstName) {

                if (!this.namesRegex.test(firstName)) {
                    this.errors.firstNameError = 'Nome non valido';
                    return false;
                }

                this.errors.firstNameError = '';
                return true;
            },
            validateLastName(lastName) {

                if (!this.namesRegex.test(lastName)) {
                    this.errors.lastNameError = 'Cognome non valido';
                    return false;
                }

                this.errors.lastNameError = '';
                return true;                
            },
            validateRestaurantName(restaurantName) {

                if (!/^[-a-z ,.\'0-9]+$/gi.test(restaurantName)) {
                    this.errors.restaurantNameError = 'Nome ristorante non valido';
                    return false;
                }

                this.errors.restaurantNameError = '';
                return true;                 
            },
            validateRestaurantAddress(restaurantAddress) {

                if (!/^[-a-z ,.\'0-9]+$/gi.test(restaurantAddress)) {
                    this.errors.restaurantAddressError = 'Indirizzo non valido';
                    return false;
                }

                this.errors.restaurantAddressError = '';
                return true;  
            },
            validateStreetNumberPostalCode(number) {

                if (typeof Number(number) !== 'number') {
                    this.errors.streetNumberPostalCordeError = 'Numero civico o CAP non validi';
                    return false;
                }

                    this.errors.streetNumberPostalCordeError = '';
                    return true;                
            },
            validateCity(city) {

                if (!this.namesRegex.test(city)) {
                    this.errors.cityError = 'Città non valida';
                    return false;
                }

                this.errors.cityError = '';
                return true;                 
            },
            validateVatNumber(vatNumber) {

                if (!/^it\d{14}$/gi.test(vatNumber)) {
                    this.errors.vatNumberError = 'Partita IVA non valida. Formato richiesto: IT seguito da 14 cifre';
                    return false;
                }

                this.errors.vatNumberError = '';
                return true;
            },
            validateFileType() {

                if (!this.file.type.includes('/image/')) {
                    this.errors.fileError = 'Formato file non valido. Inserisci una immagine';
                    return false;
                }

                this.errors.fileError = '';
                return true;
            },
            validateCategory() {

                if (!this.categoriesChecked) {
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

    .red {
        border-color: red;
    }

    .green {
        border-color: green;
    }
</style>