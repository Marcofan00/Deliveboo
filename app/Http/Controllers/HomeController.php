<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function homepage() {
        return view('pages.homepage');
    }

    public function registerpage() {
        return view('pages.registerpage');
      }
    
    public function loginpage() {
        return view('pages.loginpage');
    }
}