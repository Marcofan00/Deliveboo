<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'PageController@homepage') -> name('homepage');
Route::get('/resturant', 'PageController@resturant_page') -> name('resturant_page');

Route::get('/cart', 'PageController@cart_page') -> name('cart_page');

Route::get('/register', 'PageController@register_page') -> name('register_page');
Route::get('/login', 'PageController@login_page') -> name('login_page');

Route::post('/register', 'Auth\RegisterController@register') -> name('register');

Route::post('/login', 'Auth\LoginController@login') -> name('login');
Route::get('/logout', 'Auth\LoginController@logout') -> name('logout');

// UR routes

Route::get('/dashboard', 'PageController@dashboard') -> name('dashboard');
Route::get('/statistics', 'PageController@statistics') -> name('statistics');
Route::get('/food/create', 'PageController@create') -> name('create');
Route::get('/food/edit', 'PageController@edit') -> name('edit');