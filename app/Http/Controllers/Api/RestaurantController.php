<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\Food;
use App\Models\Order;


class RestaurantController extends Controller
{
    // gets first 12 available restaurants
    public function getAllRestaurants() {

        $allRestaurants = User::all()->take(12);

        return response()->json($allRestaurants);
    }

    // gets available food for each restaurant
    public function getRestaurantFoodById($id) {

        $user = User::findOrFail($id);

        $food = Food::all()->where('user_id', '=', $id)->where('visible', '=', 1);

        return response()->json(['foods' => $food, 'user' => $user]);
    }

    // create new record in food table
    public function createNewFood(Request $request) {

        $data = $request->all();

        if (User::find($data['user_id'])) {

            $validatedData = Validator::make($data, [
                'user_id' => ['required', 'numeric'],
                'name' => ['required', 'string', 'max:60'],
                'description_ingredients' => ['required', 'string'],
                'price' => ['required', 'numeric'],
                'visible' => ['required', 'boolean'],
                'food_img' => ['image']
            ]);
    
            $newFood = $validatedData->getData();
    
            $imageFile = $newFood['food_img'];
    
            $fileName = rand(100000, 999999) . '_' . time().'.'.$newFood['food_img']->extension();
    
            $imageFile -> storeAs('img', $fileName, 'public');
    
            $newFood['food_img'] = $fileName;
    
            return Food::create($newFood);
        }

    }

    // updates existing record in food table
    public function editFood(Request $request, $id) {

        $foodToEdit = Food::findOrFail($id);

        if ($foodToEdit) {

            $data = $request->all();

            $validatedData = Validator::make($data, [
                'user_id' => ['required', 'numeric'],
                'name' => ['required', 'string', 'max:60'],
                'description_ingredients' => ['required', 'string'],
                'price' => ['required', 'numeric'],
                'visible' => ['required', 'boolean'],
                'food_img' => ['image']
            ]);
            
            $dataToUpdate = $validatedData->getData();

            if ($dataToUpdate['food_img']) {
                $imageFile = $dataToUpdate['food_img'];

                $fileName = rand(100000, 999999) . '_' . time().'.'.$dataToUpdate['food_img']->extension();
        
                $imageFile -> storeAs('img', $fileName, 'public');
        
                $dataToUpdate['food_img'] = $fileName;

                $foodToEdit -> update($dataToUpdate);

            } else {
                $dataToUpdate['food_img'] = $foodToEdit['food_img'];
            }
    
            $foodToEdit -> update($dataToUpdate);
        }
    }


    // returns restaurants orders

    public function getRestaurantOrdersById($id) {

        $userFoods = Food::all()->where('user_id', '=', $id);

        $orders = $userFoods->map(function($food) {
            return $food->orders->toArray();
        });

        $result = $orders->collapse()->values()->unique('id');

        return response()->json($result);
    }


    public function foodVisibility($id) {

        $food = Food::findOrFail($id);

        if($food['visible']) { 

            $food['visible'] = 0;
        }

        $food['visible'] = 1;

        $food -> update();

    // returns all restaurant's food
    public function getFoodsByUserId($id) {

        $foods = Food::all()->where('user_id', '=', $id);

        return response()->json($foods);

    }
}
