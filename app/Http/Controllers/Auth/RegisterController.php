<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:60', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'full_name' => ['required', 'string', 'max:150'],
            'restaurant_name' => ['required', 'string'],
            'address' => ['required', 'string'],
            'vat_number' => ['required', 'max:16'],
            'logo' => ['nullable', 'image']
        ]);

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        if (!array_key_exists('logo', $data)) {
            $data['logo'] = '';
        }
      
        $newUserData = [
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'restaurant_name' => $data['restaurant_name'],
            'address' => $data['address'],
            'vat_number' => $data['vat_number'],
            'categories' => $data['categories']
        ];

        if ($data['logo']) {

            $imageFile = $data['logo'];
          
            $fileName = rand(100000, 999999) . '_' . time().'.'.$data['logo']->extension();

            $imageFile -> storeAs('img', $fileName, 'public');

            $newUserData['logo'] = $fileName;

        }
      
      $newUser = User::create($newUserData);

      $categories = explode(',', $newUserData['categories']);

      $newUser -> categories() -> sync($categories);

      $newUser -> save();

      return $newUser;

    }
}
