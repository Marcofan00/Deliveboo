<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function homepage() {
        return view('pages.homepage');
    }

    public function dashboard() {
        return view('pages.dashboard');
    }

    public function statistics() {
        return view('pages.statistics');
    }

    public function create() {
        return view('pages.create');
    }

    public function edit() {
        return view('pages.edit');

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