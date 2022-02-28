<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RestaurantController extends Controller
{
    public function getAllRestaurants() {

        $allRestaurants = User::all();

        return response()->json(['data' => $allRestaurants]);
    }
}
