<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Food;

class CartController extends Controller
{
    public function index()
    {
        // $products = Food::get();
        

        $cart = session()->get('cart');
        if ($cart == null)
        $cart = [];
        
        
            return json_encode($cart);

    }

    public function addToCart(Request $request)
    {
        $food = Food::FindOrFail($request->id);
        $food['quantity'] = $request->quantity;
        session()->push('cart', $food);
        
        return response()->json([
            'status' => 'added'
        ]);
    }
}