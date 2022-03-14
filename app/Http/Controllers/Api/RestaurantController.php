<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Food;
use App\Models\Order;
use App\Models\Category;


class RestaurantController extends Controller
{
    // saves img file in storage/img and formats file name
    public static function formatImageFile($image) {
        $imageFile = $image;
    
        $fileName = rand(100000, 999999) . '_' . time().'.'.$image->extension();

        $imageFile -> storeAs('img', $fileName, 'public');

        return $fileName;

    }

    // validates input data
    public static function validateInputData($data, $imgRequired) {
        $messages = [
            'name.required' => 'Questo campo è obbligatorio',
            'name.max' => 'Questo campo deve contenere massimo 60 caratteri',
            'description_ingredients.required' => 'Questo campo è obbligatorio',
            'description_ingredients.min' => 'Questo campo deve contenere minimo 100 caratteri',
            'price.required' => 'Questo campo è obbligatorio',
            'price.numeric' => 'Questo campo deve essere di tipo numerico',
            'visible.required' => 'Questo campo è obbligatorio',
            'food_img.image' => 'Il file caricato deve essere di tipo immagine'
        ];

        if ($imgRequired) {
            $messages['food_img.required'] = 'Questo campo è obbligatorio';
        }

        $rules = [
            'user_id' => ['required', 'numeric'],
            'name' => ['required', 'string', 'max:60'],
            'description_ingredients' => ['required', 'string', 'min:50'],
            'price' => ['required', 'numeric'],
            'visible' => ['required', 'boolean'],
            'food_img' => ['nullable', 'image']
        ];

        if ($imgRequired) {
            $rules['food_img'] = ['required', 'image'];
        }

        $validator = Validator::make($data, $rules, $messages);

        $validator->validate();

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
    }

    // gets first 12 available restaurants
    public function getAllRestaurants() {

        $allRestaurants = User::all()->take(12);

        foreach($allRestaurants as $restaurant) {
            $restaurant['categories'] = $restaurant->categories;
        }

        return response()->json($allRestaurants);
    }

    // gets available food for each restaurant
    public function getRestaurantFoodById($id) {

        $user = User::findOrFail($id);

        $food = Food::all()->where('user_id', '=', $id)->where('visible', '=', 1);

        return response()->json(['foods' => $food->values()->all(), 'user' => $user]);
    }

    // creates new record in food table
    public function createNewFood(Request $request) {

        $data = $request->all();

        if (User::find($data['user_id'])) {

            self::validateInputData($data, true);

            $data['food_img'] = self::formatImageFile($data['food_img']);
    
            return Food::create($data);

        }

    }

    // updates existing record in food table
    public function editFood(Request $request, $id) {

        $foodToEdit = Food::findOrFail($id);

        if ($foodToEdit) {

            $data = $request->all();

            self::validateInputData($data, false);

            if ($data['food_img']) {
        
                $data['food_img'] = self::formatImageFile($data['food_img']);

            } else {

                $data['food_img'] = $foodToEdit['food_img'];

            }

            $foodToEdit -> update($data);
    
        }
    }

    // returns restaurant's orders in desc order
    public function getRestaurantOrdersById($id) {

        $userFoods = Food::all()->where('user_id', '=', $id);

        $orders = $userFoods->map(function($food) {
            return $food->orders->toArray();
        });

        $result = $orders->collapse()->values()->unique('id')->sortByDesc('created_at');

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
                $result = User::findOrFail($collection->unique('pivot.user_id')->pluck('pivot.user_id'))->all()[0];
                $result['categories'] = $result->categories;
                $searchResults[] = $result;              
            }
        }
        
        return response()->json($searchResults);

    }
}
