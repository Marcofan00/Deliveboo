<template>
    <div id="register">
        <h2>Registrazione</h2>
        <form>
            <label for="email">E-mail</label><br>
            <input type="text" name="email" v-model="email"><br>
            <label for="password">Password</label><br>
            <input type="password" name="password" v-model="password"><br>
            <label for="password_confirmation">Password confirmation</label><br>
            <input type="password" name="password_confirmation" v-model="passwordConfirmed"><br>
            <label for="full_name">Name</label><br>
            <input type="text" name="full_name" v-model="fullName"><br>
            <label for="restaurant_name">Nome ristorante</label><br>
            <input type="text" name="restaurant_name" v-model="restaurantName"><br>
            <label for="address">Indirizzo</label><br>
            <input type="text" name="address" v-model="restaurantAddress"><br>
            <label for="vat_number">Partita IVA</label><br>
            <input type="text" name="vat_number" v-model="vatNumber">
            <div v-for="category in categories">
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
                fullName: '',
                restaurantName: '',
                restaurantAddress: '',
                vatNumber: ''
            }
        },
        mounted() {
            this.getAllCategories();
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
                let data = new FormData();

                data.append('categories', this.categoriesChecked);
                data.append('logo', this.file);
                data.append('email', this.email);
                data.append('password', this.password);
                data.append('password_confirmation', this.passwordConfirmed);
                data.append('full_name', this.fullName);
                data.append('restaurant_name', this.restaurantName);
                data.append('address', this.restaurantAddress);
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
            }
        }
    }
</script>