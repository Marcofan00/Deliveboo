<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'PageController@homepage') -> name('homepage');
Route::get('/restaurant/{id}', 'PageController@getRestaurantMenu') -> name('restaurant_page');

Route::get('/cart', 'PageController@cartPage') -> name('cart_page');

Route::get('/register', 'PageController@registerPage') -> name('register_page');
Route::get('/login', 'PageController@loginPage') -> name('login_page');

Route::post('/register', 'Auth\RegisterController@register') -> name('register');

Route::post('/login', 'Auth\LoginController@login') -> name('login');
Route::get('/logout', 'Auth\LoginController@logout') -> name('logout');

// UR routes (protected)

Route::middleware('auth')->group(function() {
    Route::get('/dashboard', 'PageController@dashboard') -> name('dashboard');
    Route::get('/statistics', 'PageController@statistics') -> name('statistics');

    Route::get('/food/create', 'PageController@create') -> name('create');
    Route::get('/food/edit/{id}', 'PageController@edit') -> name('edit');
});
