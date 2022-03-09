<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\Food;
use App\Models\Order;
use App\Models\Category;


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

        return response()->json(['foods' => $food->values()->all(), 'user' => $user]);
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
            ])->validate();
    
            $imageFile = $validatedData['food_img'];
    
            $fileName = rand(100000, 999999) . '_' . time().'.'.$validatedData['food_img']->extension();
    
            $imageFile -> storeAs('img', $fileName, 'public');
    
            $validatedData['food_img'] = $fileName;
    
            return Food::create($validatedData);

        }

    }

    // updates existing record in food table
    public function editFood(Request $request, $id) {

        $foodToEdit = Food::findOrFail($id);

        if ($foodToEdit) {

            $data = $request->all();

            // dd($data);

            $validatedData = Validator::make($data, [
                'user_id' => ['required', 'numeric'],
                'name' => ['required', 'string', 'max:60'],
                'description_ingredients' => ['required', 'string'],
                'price' => ['required', 'numeric'],
                'visible' => ['required', 'boolean'],
                'food_img' => ['nullable', 'image']
            ])->validate();

            if ($validatedData['food_img']) {

                $imageFile = $validatedData['food_img'];

                $fileName = rand(100000, 999999) . '_' . time().'.'.$validatedData['food_img']->extension();
        
                $imageFile -> storeAs('img', $fileName, 'public');
        
                $validatedData['food_img'] = $fileName;

            } else {

                $validatedData['food_img'] = $foodToEdit['food_img'];

            }

            $foodToEdit -> update($validatedData);
    
        }
    }

    // returns restaurant's orders in desc order
    public function getRestaurantOrdersById($id) {

        $userFoods = Food::all()->where('user_id', '=', $id);

        $orders = $userFoods->map(function($food) {
            return $food->orders->toArray();
        });

        $result = $orders->collapse()->values()->unique('id')->sortByDesc('order_date');

        return response()->json($result->values()->all());
    }

    // toggles food visibility
    public function foodVisibility($id) {
        
        $food = Food::findOrFail($id);

        if($food['visible']) { 
            $food['visible'] = 0;

        } else {
            $food['visible'] = 1;
        }   


        $food -> update();

        return response()->json($food);
    }

    // returns all restaurant's food in dashboard
    public function getFoodsByUserId($id) {

        $foods = Food::all()->where('user_id', '=', $id);

        return response()->json($foods->values()->all());

    }

    // filters restaurants by category
    public function getRestaurantsByCategory(Request $request) {
        $selectedCategories = $request->categories;

        $allUsers = User::all();

        $searchResults = [];

        foreach($allUsers as $user) {
            $collection = $user->categories->whereIn('pivot.category_id', $selectedCategories)->groupBy('pivot.user_id')->collapse();
            
            if (count($collection->all()) === count($selectedCategories)) {
                $searchResults[] = User::findOrFail($collection->unique('pivot.user_id')->pluck('pivot.user_id'))->toArray()[0];               
            }
        }
        
        return response()->json($searchResults);

    }
}
