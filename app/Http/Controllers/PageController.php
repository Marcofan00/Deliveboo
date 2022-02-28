<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function homepage() {
        return view('pages.homepage');
    }

    public function resturant() {
        return view('pages.resturant');
    }

    public function cart_page() {
        return view('pages.cart');
    }

    public function register_page() {
        return view('pages.registerpage');
    }
    
    public function login_page() {
        return view('pages.loginpage');
    }
}