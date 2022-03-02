<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// public routes
Route::get('/restaurants', 'Api\RestaurantController@getAllRestaurants'); // gets all available restaurants
Route::get('restaurant/{id}', 'Api\RestaurantController@getRestaurantFoodById'); // gets all visible restaurant's food
Route::get('/categories', 'Api\CategoryController@getAllCategories'); // gets all restaurants' categories
Route::post('/search', 'Api\RestaurantController@getRestaurantsByCategory'); // returns restaurants filtered by category
    // payment routes
Route::get('/token', 'Api\BraintreeController@getToken'); // returns braintree token
Route::post('/checkout', 'Api\BraintreeController@processPayment'); // process payment


// UR routes
Route::get('/dashboard/restaurant/{id}', 'Api\RestaurantController@getFoodsByUserId'); // returns all restaurant's food
Route::get('/dashboard/orders/{id}', 'Api\RestaurantController@getRestaurantOrdersById'); // returns all restaurant's orders
Route::post('/dashboard/create', 'Api\RestaurantController@createNewFood'); // creates new record in food table
Route::post('/dashboard/edit/{id}', 'Api\RestaurantController@editFood'); // updates existing record in food table



