<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;


$factory->define(Category::class, function(Faker $faker) {



    // $category = $categories[rand(0, count($categories) -1)];

    return [
        // 'name' => $category['name'],
        // 'category_img' => $category['category_img']
    ];
});
