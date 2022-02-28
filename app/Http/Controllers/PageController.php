<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
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
}