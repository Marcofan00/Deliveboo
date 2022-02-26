<?php

use Illuminate\Database\Seeder;
use App\Models\Food;
use App\Models\User;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $foods = [
            [
                'name' => 'Parmigiana',
                'description_ingredients' => 'Piatto rivendicato sia dalla Campania che dalla Sicilia',
                'price' => 14.99,
                'visible' => 1,
                'food_img' => 'storage/img/delivebooDefault.png'
            ],
            [
                'name' => 'Pancotto',
                'description_ingredients' => 'Piatto a base di pane raffermo e verdure tipico diella città di Gravina in Puglia',
                'price' => 10.99,
                'visible' => 1,
                'food_img' => 'storage/img/delivebooDefault.png'
            ],
            [
                'name' => 'Margherita',
                'description_ingredients' => 'Pizza con pomodoro, mozzarella, basilico e olive nere denocciolate',
                'price' => 7.00,
                'visible' => 1,
                'food_img' => 'storage/img/delivebooDefault.png'
            ],
            [
                'name' => 'Cacio e Pepe',
                'description_ingredients' => 'Piatto tipico romano',
                'price' => 12.90,
                'visible' => 1,
                'food_img' => 'storage/img/delivebooDefault.png'
            ],
            [
                'name' => 'Big Mac',
                'description_ingredients' => 'Hamburger di carne con insalata, bacon, cetrioli e salse',
                'price' => 5.00,
                'visible' => 1,
                'food_img' => 'storage/img/delivebooDefault.png'
            ],
            [
                'name' => 'Pasta alla Norma',
                'description_ingredients' => 'Piatto a base di pomodoro fresco e melanzane',
                'price' => 10.00,
                'visible' => 1,
                'food_img' => 'storage/img/delivebooDefault.png'
            ],
            [
                'name' => 'Pizza Poker',
                'description_ingredients' => 'Pizza con mozzarella al tartufo e funghi cardoncelli',
                'price' => 13.00,
                'visible' => 1,
                'food_img' => 'storage/img/delivebooDefault.png'
            ],
            [
                'name' => 'Sashimi',
                'description_ingredients' => 'Piatto tipico giapponese a base di pesce',
                'price' => 15.00,
                'visible' => 1,
                'food_img' => 'storage/img/delivebooDefault.png'
            ],
            [
                'name' => 'Pollo alla Cantonese',
                'description_ingredients' => 'Piatto tipico della cucina cinese a base di carne',
                'price' => 10.99,
                'visible' => 1,
                'food_img' => 'storage/img/delivebooDefault.png'
            ],
            [
                'name' => 'Fagioli alla Texana',
                'description_ingredients' => 'Piatto tipico della cucina messicana',
                'price' => 9.00,
                'visible' => 1,
                'food_img' => 'storage/img/delivebooDefault.png'
            ]
        ];

        foreach($foods as $food) {
            factory(Food::class)->
            create([
                'user_id' => rand(1, 5),
                'name' => $food['name'],
                'description_ingredients' => $food['description_ingredients'],
                'price' => $food['price'],
                'visible' => $food['visible'],
                'food_img' => $food['food_img']
            ]);
        }
    }
}
