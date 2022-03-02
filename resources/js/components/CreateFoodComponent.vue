<template>
<div>
    <h2>Create</h2>

    <form>
        <label for="name">Name:</label>
        <input type="text" name="name" placeholder="nome piatto" v-model="name"><br>
        <textarea name="description_ingredients" id="" cols="30" rows="10" v-model="descriptionIngredients"></textarea>
        <label for="price">Price:</label>
        <input step=".01" type="number" name="price" v-model="price"><br>

        <label for="food_img">Inserisci immagine</label>
        <input @change="getFile" type="file" name="food_img">

        <label for="visible">visibility</label>
        <select v-model="visible" name="visible" id="">
            <option value="0">No</option>
            <option value="1">Si</option>
        </select>
        <input @click="sendFood" type="button" value="Create">
    </form>
</div>
    
</template>

<script>
    export default {

        data(){
            return {
                file : "",
                name : "",
                descriptionIngredients : "",
                price : "",
                visible : "",
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods :{
            getFile(){
                this.file = event.target.files[0];
            },
            sendFood: async function() {

                  let data = new FormData();

                    data.append('user_id', 1);
                    data.append('name', 'Andrea');
                    data.append('description_ingredients', 'Piatto a base di uova, guanciale e pecorino');
                    data.append('price', 8.00);
                    data.append('visible', 1);
                    data.append('food_img', this.file);

                try {
                    let response = await fetch('http://localhost:8000/api/dashboard/create',{
                        method : 'POST',
                        body : data
                    })
                } catch (err) {
                    console.log(err);
                }
            }
        }
    }
</script>
