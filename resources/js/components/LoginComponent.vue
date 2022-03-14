<template>
    <div id="login_deeboo" class="container container_xxl_">
        <form>
            <div class="data_accesso">
                <label for="email">E-mail</label>
                <div class="form_login">
                    <input type="text" name="email" v-model.trim="email" :class="errors.emailError ? 'red' : 'green'" placeholder="Inserire email">
                </div>
            </div>
            <div class="error" v-if="errors.emailError">{{ errors.emailError }}</div>

            
            <div class="data_accesso">
                <label for="password">Password</label>
                <div class="form_login">
                    <input type="password" name="password" v-model.trim="password" :class="errors.passwordError ? 'red' : 'green'" placeholder="Inserire password">
                </div>
            </div>
            <div class="error" v-if="errors.passwordError">{{ errors.passwordError }}</div>

            <div id="btn">
                <button type="button" class="btn login_btn" @click="logUser">Accedi</button>
            </div>

        </form>
        <div id="register">Se non sei ancora registrato <a href="/register">Clicca qui</a></div>
    </div>
</template>

<script>
import swal from 'sweetalert';

import { validateEmail, validatePassword, errors } from '../utils.js';

    export default {
        data() {
            return {
                email: '',
                password: '',
                errors
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
            }
        },
        methods: {
            logUser: async function() {

                let validEmail = validateEmail(this.email),
                    validPassword = true; // temporarly set on true to allow login with laravel seeders passwords

                    // this.validatePassword(this.password);

                if (validEmail && validPassword) {

                    let data = JSON.stringify({
                        email: this.email,
                        password: this.password
                    });

                    let response = await fetch('http://localhost:8000/login', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: data
                    });

                    let responseToJson = await response.json();
                    
                    if (!response.ok) {

                        if (responseToJson.errors.email) {
                            swal(responseToJson.errors.email.toString());
                        }

                        if (responseToJson.errors.password) {
                            swal(responseToJson.errors.password.toString());
                        }
                    } else {
                        window.location.href = '/dashboard/';
                    }

                }
            }
        }
    }
</script>

<style scoped>

    #login {
        width: 90%;
        margin: 0 auto;
        padding: 2rem 0;
    }

    .data {
        margin: 0.5rem 0;
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

    .login-btn {
        background-color: green;
        color: white;
        display: block;
    }

    #register {
        margin: 0.5rem 0;
    }

    #register a {
        text-decoration: none;
    }

</style>