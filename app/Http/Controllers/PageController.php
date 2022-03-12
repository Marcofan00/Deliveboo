<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Food;
use App\Models\Order;

class PageController extends Controller
{
    public function orderinfo($id){
        $ordineinfo = Order::findOrFail($id);
        $ordine = Order::FindOrFail($id);
        $foods = $ordine->foods;
        // $food = Food::all()->order;

        return view('pages.order-info',compact('foods','ordineinfo'));
    }
    public function homepage() {
        return view('pages.homepage');
    }

    public function dashboard() {
        $check =  Auth::User() -> id;
        
        return view('pages.dashboard', compact('check'));
    }

    public function statistics() {

        return view('pages.charts');
    }

    public function create() {
        return view('pages.create');
    }

    public function edit($id) {

        $foodEdit = Food::FindOrFail($id);
        
        return view('pages.edit', compact('foodEdit'));
    }

    public function getRestaurantMenu($id) {

        return view('pages.restaurant', ['userId' => $id]);
    }

    public function cartPage() {
        return view('pages.cart');
    }

    public function checkout() {
        return view('pages.checkout');
    }

    public function registerPage() {
        return view('pages.registerpage');
    }
    
    public function loginPage() {
        return view('pages.loginpage');
    }

    public function success($id) {

        $order = Order::findOrFail($id);

        return view('pages.success', compact('order'));
    }

    public function error() {
        return view('pages.error');
    }
}