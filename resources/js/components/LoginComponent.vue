<template>
    <div id="login">
        <form>
            <div class="data">
                <label for="email">E-mail</label>
                <input type="text" name="email" v-model.trim="email" :class="emailError ? 'red' : 'green'">
                <div class="error" v-if="emailError">{{ emailError }}</div>
            </div>
            
            <div class="data">
                <label for="password">Password</label>
                <input type="password" name="password" v-model.trim="password" :class="passwordError ? 'red' : 'green'">
                <div class="error" v-if="passwordError">{{ passwordError }}</div>
            </div>
            
            <button type="button" class="btn login-btn" @click="logUser">Accedi</button>

        </form>
        <div id="register">Se non sei ancora registrato <a href="/register">Clicca qui</a></div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                email: '',
                password: '',
                emailError: '',
                passwordError: ''
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
            }
        },
        methods: {
            logUser: async function() {

                let validEmail = this.validateEmail(this.email),
                    validPassword = true;

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
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: data
                    });
                }
            },
            validateEmail(email) {

                if (!email || !/^([a-zA-Z0-9\_\-\.]+)@([a-zA-Z0-9\_\-\.]+)\.([a-zA-Z]{2,5})$/g.test(email)) {
                    this.emailError = 'Email non valida';
                    return false;
                }

                this.emailError = '';
                return true;
            },
            validatePassword(password) {

                if (!password || !/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/g.test(password)) {
                    this.passwordError = 'Password non valida';
                    return false;
                }

                this.passwordError = '';
                return true;
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