<?php

use Illuminate\Support\Facades\Route;

Route::get('/homepage', 'HomeController@homepage') -> name('homepage');

Route::get('/registerpage', 'HomeController@registerpage') -> name('registerpage');
Route::get('/loginpage', 'HomeController@loginpage') -> name('loginpage');

Route::post('/register', 'Auth\RegisterController@register') -> name('register');

Route::post('/login', 'Auth\LoginController@login') -> name('login');
Route::get('/logout', 'Auth\LoginController@logout') -> name('logout');

// UR routes

Route::get('/dashboard', 'PageController@dashboard') -> name('dashboard');
Route::get('/statistics', 'PageController@statistics') -> name('statistics');
Route::get('/food/create', 'PageController@create') -> name('create');
Route::get('/food/edit', 'PageController@edit') -> name('edit');