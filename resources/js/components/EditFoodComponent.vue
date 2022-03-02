<template>
<div>
    <h2>Edit</h2>

    <form >
        <!-- NAME  -->
        <label for="name">Name:</label>
        <input v-model="nameFood" name="name"  type="text">

        <!-- TEXT  -->
        <textarea name="description_ingredients" id="" cols="30" rows="10" v-model="descriptionIngredients"></textarea>

        <!-- PRICE  -->
        <label for="price">Price:</label>
        <input step=".01" type="number" name="price" v-model="price"><br>


        <!-- immagine  -->
        <label for="food_img">Inserisci immagine</label>
        <input @change="getFile" type="file" name="food_img">

        <!-- visibility -->
        <label for="visible">visibility</label>
        <select v-model="visible" name="visible" id="">
            <option :selected="food_edit.visible" value="0">No</option>
            <option :selected="food_edit.visible" value="1">Si</option>
        </select>  
        <!-- edit  -->
        <input @click="sendFood" type="button" value="edit">
    </form>
</div>
    
</template>

<script>
    export default {
        props : {
            food_edit : Object,
        },
        data(){
            return {

                file : "",
                name : "",
            }
        },
        computed: {
            nameFood: {
                get() {
                    return this.food_edit.name;
                },
                set(value) {
                    if (value) {
                        this.food_edit.name = value;
                        return this.food_edit.name;
                    }

                    return this.food_edit.name;
                }
            },
            descriptionIngredients : {
                get() {
                    return this.food_edit.description_ingredients;
                },
                set(value) {
                    if (value) {
                        this.food_edit.description_ingredients = value;
                        return this.food_edit.description_ingredients;
                    }

                    return this.food_edit.description_ingredients;
                }
            },
            
            price : {
                 get() {
                    return this.food_edit.price;
                },
                set(value) {
                    if (value) {
                        this.food_edit.price = value;
                        return this.food_edit.price;
                    }

                    return this.food_edit.price;
                }
            },
            visible : {
                 get() {
                    return this.food_edit.visible;
                },
                set(value) {
                    if (value) {
                        this.food_edit.visible = value;
                        return this.food_edit.visible;
                    }

                    return this.food_edit.visible;
                }
            },
        },
        mounted() {
            // console.log(this.food_edit);
            // console.log(this.food_edit.name);
        },
        methods :{
            sendFood(){
                console.log(this.food_edit.name);
                console.log(this.food_edit.description_ingredients);
                console.log(this.food_edit.price);
                console.log(this.food_edit.visible);
                console.log(this.food_edit.price);

            },
            getFile(){
                this.file = event.target.files[0];
            },
            sendFood: async function() {

                  let data = new FormData();

                    data.append('user_id', this.food_edit.user_id);
                    data.append('name', this.nameFood);
                    data.append('description_ingredients', this.descriptionIngredients);
                    data.append('price', this.price);
                    data.append('visible', this.visible);
                    data.append('food_img', this.file);

                try {
                    let response = await fetch('api/edit/'+this.food_edit.id,{
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