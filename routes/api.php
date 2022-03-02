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

Route::get('/restaurants', 'Api\RestaurantController@getAllRestaurants');
Route::get('/restaurants/{id}', 'Api\RestaurantController@getFoodsByUserId');

Route::post('/restaurants/foods/store', 'Api\RestaurantController@foodStore');
Route::post('/restaurants/foods/update/{id}', 'MovieController@foodUpdate');


Route::get('/categories', 'Api\CategoryController@getAllCategories');

Route::get('restaurant/{id}', 'Api\RestaurantController@getRestaurantFoodById');

Route::get('/orders/{id}', 'Api\RestaurantController@getRestaurantOrdersById');

Route::post('/create', 'Api\RestaurantController@createNewFood');

Route::post('/edit/{id}', 'Api\RestaurantController@editFood');

Route::get('/search', 'Api\RestaurantController@getRestaurantsByCategory');

Route::get('/token', 'Api\BraintreeController@getToken');

Route::post('/checkout', 'Api\BraintreeController@processPayment');