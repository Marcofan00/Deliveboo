<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\models\User;
use App\models\Food;


class PageController extends Controller
{
    public function homepage() {
        // $checkp =  Auth::check();
        // dd($check);
        return view('pages.homepage');
    }

    public function dashboard() {
        $check =  Auth::User() -> id;
        $food_user = Food::All() ;

        
        return view('pages.dashboard',compact('check','food_user'));
    }

    public function statistics() {
        return view('pages.statistics');
    }

    public function create() {
        return view('pages.create');
    }
    public function store(Request $request){
        $data = $request -> validate([
            'name' => 'required|string|max:255',
            'description_ingredients' => 'required|string',
            'price' => 'required|numeric',
            'food_img' => 'required|image',
            'visible' => 'Boolean'
        ]);
        $imageFile = $data['food_img'];
        $imageName = rand(100000,999999) ."_". time() .".". $imageFile ->getClientOriginalExtension();
        $imageFile -> storeAs('/foods',$imageName,'public');
        $data['food_img'] = $imageName;

        $data['user_id'] = Auth::User() -> id;
        $food = Food::create($data);

        return redirect() -> route('dashboard');
    }

    
    public function edit($id) {
        $food = Food::FindOrFail($id);
        return view('pages.edit',compact('food'));
    }
    public function update(Request $request){
        $data = $request -> validate([
            'name' => 'required|string|max:255',
            'description_ingredients' => 'required|string',
            'price' => 'required|numeric',
            'food_img' => 'required|image',
            'visible' => 'Boolean'
        ]);
        $imageFile = $data['food_img'];
        $imageName = rand(100000,999999) ."_". time() .".". $imageFile ->getClientOriginalExtension();
        $imageFile -> storeAs('/foods',$imageName,'public');
        $data['food_img'] = $imageName;

        $data['user_id'] = Auth::User() -> id;
        $food = Food::create($data);

        return redirect() -> route('dashboard');
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
        $check =  Auth::check();
        return view('pages.loginpage',compact('check'));
    }
}