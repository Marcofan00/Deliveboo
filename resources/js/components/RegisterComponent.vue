<template>
    <div id="register">
        <h2>Registrazione</h2>
        <form>
            <label for="email">E-mail</label><br>
            <input type="text" name="email" v-model="email"><br>
            <label for="password">Password</label><br>
            <input type="password" name="password" v-model="password"><br>
            <label for="password_confirmation">Conferma Password</label><br>
            <input type="password" name="password_confirmation" v-model="passwordConfirmed"><br>
            <label for="firstame">Nome</label><br>
            <input type="text" name="firstname" v-model="firstName"><br>
            <label for="lastname">Cognome</label><br>
            <input type="text" name="lastname" v-model="lastName"><br>
            <label for="restaurant_name">Nome Ristorante</label><br>
            <input type="text" name="restaurant_name" v-model="restaurantName"><br>
            <label for="street">Indirizzo Ristorante</label><br>
            <input type="text" name="street" v-model="restaurantAddress"><br>
            <label for="streetnumber">Numero Civico</label><br>
            <input type="number" name="streetnumber" v-model="streetNumber"><br>
            <label for="postalcode">CAP</label><br>
            <input type="number" name="postalcode" v-model="postalCode"><br>
            <label for="city">Città</label><br>
            <input type="text" name="city" v-model="city"><br>
            <label for="vat_number">Partita IVA</label><br>
            <input type="text" name="vat_number" v-model="vatNumber">
            <div v-for="category in categories" :key="category.id">
                <label for="categories">{{ category.name }}</label>
                <input type="checkbox" :value="category.id" v-model="categoriesChecked">
            </div>
            <label for="logo">Logo</label><br>
            <input type="file" name="logo" @change="getFile"><br>

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
                vatNumber: ''
            }
        },
        mounted() {
            this.getAllCategories();
        },
        computed: {
            fullName() {
                // console.log(this.firstName, this.lastName);
                return this.firstName + ' ' + this.lastName;
            },
            fullAddress() {
                // console.log(this.restaurantAddress + ', ' + this.streetNumber + ', ' + this.postalCode + ', ' + this.city);
                return this.restaurantAddress + ', ' + this.streetNumber + ', ' + this.postalCode + ', ' + this.city;
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

                if (this.validateFormData()) {
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
            validateFormData() {

                let namesRegex = '/^[a-z ,.\'-]+$/i';

                if (!this.email.includes('/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/')) {
                    return false;
                }

                if (!this.password.includes('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/')) {
                    return false;
                }

                if (this.passwordConfirmed !== this.password) {
                    return false;
                }

                if (!this.firstName.includes(namesRegex)) {
                    return false;
                }

                if (!this.lastName.includes(namesRegex)) {
                    return false;
                }

                if (!this.restaurantName.includes(namesRegex)) {
                    return false;
                }

                if (!this.restaurantAddress.includes(namesRegex)) {
                    return false;
                }

                if (typeof this.streetNumber !== 'Number' || typeof this.postalCode !== 'Number') {
                    return false;
                }

                if (!this.city.includes(namesRegex)) {
                    return false;
                }

                if (!this.vatNumber.includes('/it\d{14}/i')) {
                    return false;
                }

                if (!this.file.type.includes('/image/')) {
                    return false;
                }

                if (!this.categoriesChecked) {
                    return false;
                }

                return true;
            }
        }
    }
</script>