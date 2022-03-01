<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\Food;

class RestaurantController extends Controller
{
    public function getAllRestaurants() {

        $allRestaurants = User::all()->take(12);

        return response()->json($allRestaurants);
    }

    public function getRestaurantFoodById($id) {

        $food = Food::all()->where('user_id', '=', $id);

        return response()->json($food);
    }

    public function createNewFood(Request $request) {

        $newFood = $request->all();

        $validatedData = Validator::make($newFood, [
            'user_id' => ['required', 'numeric'],
            'name' => ['required', 'string', 'max:60'],
            'description_ingredients' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'visible' => ['required', 'boolean'],
            'food_img' => ['image']
        ]);

        $imageFile = $newFood['food_img'];

        $fileName = rand(100000, 999999) . '_' . time().'.'.$newFood['food_img']->extension();

        $imageFile -> storeAs('img', $fileName, 'public');

        $newFood['food_img'] = $fileName;

        return Food::create($newFood);

    }
}
