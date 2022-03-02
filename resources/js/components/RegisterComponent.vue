<template>
    <div id="register">
        <h2>Registrazione</h2>
        <form>
            <label for="email">E-mail</label><br>
            <input type="text" name="email"><br>
            <label for="password">Password</label><br>
            <input type="password" name="password"><br>
            <label for="password_confirmation">Password confirmation</label><br>
            <input type="password" name="password_confirmation"><br>
            <label for="full_name">Name</label><br>
            <input type="text" name="full_name"><br>
            <label for="restaurant_name">Nome ristorante</label><br>
            <input type="text" name="restaurant_name"><br>
            <label for="address">Indirizzo</label><br>
            <input type="text" name="address"><br>
            <label for="vat_number">Partita IVA</label><br>
            <input type="text" name="vat_number"><br>
            <label for="logo">Logo</label><br>
            <input type="file" name="logo"><br>

            <button type="submit" class="btn btn-success">REGISTER</button>
        </form>

        <a class="btn btn-secondary">BACK TO HOME</a>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                categories: []
            }
        },
        mounted() {
            this.getAllCategories();
        },
        methods: {
            getAllCategories: async function() {
                try {

                    let response = await fetch('/api/categories');

                    if (response.ok) {
                        let responseToJson = await response.json();

                        console.log(responseToJson.data);
                    }

                } catch(err) {
                    console.log(err);
                }
            }
        }
    }
</script>