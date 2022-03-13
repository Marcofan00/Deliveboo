<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'PageController@homepage') -> name('homepage');
Route::get('/restaurant/{id}', 'PageController@getRestaurantMenu') -> name('restaurant_page');

Route::get('/cart', 'PageController@cartPage') -> name('cart_page');
Route::get('/checkout', 'PageController@checkout')->name('checkout');

Route::get('/register', 'PageController@registerPage') -> name('register_page');
Route::get('/login', 'PageController@loginPage') -> name('login_page');

Route::post('/register', 'Auth\RegisterController@register') -> name('register');

Route::post('/login', 'Auth\LoginController@login') -> name('login');
Route::get('/logout', 'Auth\LoginController@logout') -> name('logout');

Route::get('/success/{id}', 'PageController@success')->name('success');

Route::get('/error', 'PageController@error')->name('error');

// Contatti 
Route::get('/contatti','PageController@contatti')->name('contatti');
Route::get('/chisiamo','PageController@chisiamo')->name('chisiamo');



// UR routes (protected)

Route::middleware('auth')->group(function() {
    Route::get('/dashboard', 'PageController@dashboard') -> name('dashboard');
    Route::get('/dashboard/order/{id}', 'PageController@orderinfo') -> name('order.info');

    Route::get('/food/create', 'PageController@create') -> name('create');
    Route::get('/food/edit/{id}', 'PageController@edit') -> name('edit');
});

