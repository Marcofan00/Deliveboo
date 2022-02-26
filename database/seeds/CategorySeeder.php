<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Giapponese',
                'category_img' => 'storage/img/delivebooDefault.png'
            ],
            [
                'name' => 'Cinese',
                'category_img' => 'storage/img/delivebooDefault.png'
            ],
            [
                'name' => 'Indiano',
                'category_img' => 'storage/img/delivebooDefault.png'
            ],
            [
                'name' => 'Sushi',
                'category_img' => 'storage/img/delivebooDefault.png'
            ],
            [
                'name' => 'Carne',
                'category_img' => 'storage/img/delivebooDefault.png'
            ],
        ];

        foreach($categories as $category) {
            factory(Category::class)->create(['name' => $category['name'], 'category_img' => $category['category_img']]);
        }
        
    }
}
