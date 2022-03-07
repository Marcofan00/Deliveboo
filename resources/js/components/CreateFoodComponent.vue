<template>
<div id="create">
    <h2>Aggiungi un nuovo piatto</h2>

    <form>
        <div class="data">
            <label for="name">Nome</label>
            <input type="text" name="name" v-model="name" required id="name">
            <div class="error" v-if="errors.nameError">Campo obbligatorio. {{ errors.nameError }}</div>
        </div>

        <div class="data">
            <label for="description_ingredients">Descrizione/Ingredienti</label>
            <textarea name="description_ingredients" id="" rows="10" v-model="descriptionIngredients" required placeholder="Min 150 caratteri"></textarea>
            <div v-if="descriptionIngredients">Numero caratteri digitati: {{ descriptionLength }}</div>
            <div class="error" v-if="errors.descriptionError">Campo obbligatorio. {{ errors.descriptionError }}</div>
        </div>

        <div class="data">
            <label for="price">Prezzo</label>
            <input step=".10" type="number" name="price" v-model="price" required id="price">
            <div class="error" v-if="errors.priceError">Campo obbligatorio. {{ errors.priceError }}</div>
        </div>

        <div class="data">
            <label for="visible">Visibilit&agrave;</label>
            <select v-model="visible" name="visible" id="">
                <option value="0">No</option>
                <option value="1">Si</option>
            </select><br>
        </div>

        <div class="data">
            <label for="food_img">Inserisci immagine piatto</label>
            <input @change="getFile" type="file" name="food_img" required>
            <div class="error" v-if="errors.fileError">Campo obbligatorio. {{ errors.fileError }}</div>
        </div>

        <button class="btn save-btn" @click="sendFood" type="button">Salva</button>
    </form>
</div>
    
</template>

<script>
    export default {
        props : {
            userid : Number,
        },
        data(){
            return {
                file : "",
                name : "",
                descriptionIngredients : "",
                price : "",
                visible : "1",
                errors: {
                    nameError: '',
                    descriptionError: '',
                    priceError: '',
                    visibilityError: '',
                    fileError: ''
                }
            }
        },
        mounted() {
            console.log(this.userid)
        },
        computed: {
            descriptionLength() {
                return this.descriptionIngredients.length;
            }
        },
        methods :{
            getFile(){
                this.file = event.target.files[0];
            },
            sendFood: async function() {

                let validFile = this.validateFileType(),
                    validName = this.validateName(),
                    validDescription = this.validateDescription(),
                    validPrice = this.validatePrice();

                if (
                    validFile &&
                    validName &&
                    validDescription &&
                    validPrice
                ) {

                    let data = new FormData();

                    data.append('user_id', this.userid);
                    data.append('name', this.name);
                    data.append('description_ingredients',this.descriptionIngredients );
                    data.append('price', this.price);
                    data.append('visible',this.visible );
                    data.append('food_img', this.file);

                    try {
                        let response = await fetch('http://localhost:8000/api/dashboard/create',{
                            method : 'POST',
                            body : data,
                            
                            })
                            
                    } catch (err) {
                        console.log(err);
                    }
                }
                
            },
            validateName() {

                if (!this.name || this.name.length < 2) {

                    this.errors.nameError = 'Inserire almeno un dato valido';
                    return false;

                } else {

                    this.errors.nameError = '';
                    return true;

                }
            },
            validateDescription() {

                if (!this.descriptionIngredients || this.descriptionIngredients.length < 150) {

                    this.errors.descriptionError = 'Inserire una descrizione di almeno 150 caratteri';
                    return false;

                } else {

                    this.errors.descriptionError = '';
                    return true;
                }
            },
            validatePrice() {

                if (!this.price || typeof Number(this.price) !== 'number') {

                    this.errors.priceError = 'Inserire un prezzo valido';
                    return false;

                } else {

                    this.errors.priceError = '';
                    return true;

                }
            },
            validateFileType() {

                if (!this.file || !this.file.type.includes('/image/')) {

                    this.errors.fileError = 'File non caricato o formato non valido. Inserisci una immagine';
                    return false;

                } else {

                    this.errors.fileError = '';
                    return true;

                }
            }
        }
    }
</script>

<style scoped>
    #create {
        width: 90%;
        margin: 0 auto;
        padding-top: 2rem;
        padding-bottom: 2rem;
    }

    h2 {
        font-size: 1.5rem;
        padding: 1rem 0;
    }

    .data {
        margin: 0.5rem 0;
    }

    .error {
        font-size: 10px;
        color: red;
        padding-bottom: 0.6rem;
    }

    #name {
        width: 96.8%;
    }

    textarea {
        width: 100%;
    }

    #price {
        width: 4rem;
        margin-right: 1.5rem;
    }

    .save-btn {
        background-color: green;
        color: white;
        display: block;
    }
</style>