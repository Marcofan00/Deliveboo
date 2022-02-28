<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Food;

class RestaurantController extends Controller
{
    public function getAllRestaurants() {

        $allRestaurants = User::all()->take(12);

        return response()->json($allRestaurants);
    }

    public function getFoodsByUserId($id) {

        $foods = Food::all()->where('user_id', '=', $id);

        dd($foods);

        // return response()->json($foods);
    }

    public function foodStore(Request $request) {

        $data = $request -> validate([
            'name' => 'required|string|max:60',
            'description_ingredients' => 'required|text',
            'price' => 'required|float',
            'visible' => 'required|boolean',
            'img_food' => 'required|image'
        ]);

        $imageFile = $data['img_food'];
        $imageName = rand(100000, 999999). '_' .time() . '.' . $imageFile -> getClientOriginalExtension();

        $imageFile -> storeAs('/img/', $imageName, 'public');
        $data['img_food'] = $imageName;

        $resturantFood = Food::create($data);

        return response()->json($resturantFood);
    }

    public function foodUpdate(Request $request, $id) {

        $data = $request -> validate([
            'name' => 'required|string|max:60',
            'description_ingredients' => 'required|text',
            'price' => 'required|float',
            'visible' => 'required|boolean',
            'img_food' => 'required|image'
        ]);

        $imageFile = $data['img_food'];
        $imageName = rand(100000, 999999). '_' .time() . '.' . $imageFile -> getClientOriginalExtension();
        
        $imageFile -> storeAs('/img/', $imageName, 'public');
        $data['img_food'] = $imageName;
        
        $resturantFood = Food::findOrFail($id);

        $resturantFood -> update($data);

        return response()->json($resturantFood);
    }

    // public function getRestaurantsByCategory(Request $request) {

    // }
}
