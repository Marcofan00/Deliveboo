<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class RestaurantController extends Controller
{
    public function getAllRestaurants() {

        $allRestaurants = User::all();

        return response()->json(['data' => $allRestaurants]);
    }
}
