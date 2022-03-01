<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\models\User;

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
    }

    public function restaurant() {
        return view('pages.resturant');
    }

    public function cartPage() {
        return view('pages.cart');
    }

    public function registerPage() {
        return view('pages.registerpage');
    }
    
    public function loginPage() {
        return view('pages.loginpage');
    }
}