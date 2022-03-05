<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Food;




class CartController extends Controller {
    private $foods;
    private $total;

    public function __construct() {
        $this->foods = [];
        $this->total = 0.00;
    }

    public function index()
    {
        // $products = Food::get();
        

        $cart = session()->get('cart');
       
        if ($cart == null)
        $cart = [];
        
        $arr = [];
        foreach ($cart as $value) {
            $arr[] = $value;
        }
        
        
        
            return json_encode($arr);

    }

    public function emptyCart() {
        $this->foods = [];
        $this->total = 0.00;
    }

    // Getter and setter for cart
    public function setFoods($foods) {
        $this->foods = $foods;
    }

    public function getFoods() {
        $foods = [];
        if($this->hasFoods()) {
            foreach($this->foods as $food) {
                $foods[] = [
                    'id' => $food['id'],
                    'name' => $food['name'],
                    'description_ingredients' => $food['description_ingredients'],
                    'price' => $food['price'],
                    'food_img' => $food['food_img'],
                    'quantity' => $food['quantity'],
                    'subtotal' => $food['subtotal'],
                ];
            }
        }
        return $foods;
    }


    // Getter and setter for total
    public function setTotal($value) {
        $this->total = $value;
    }

    public function getTotal() {
        return $this->total;
    }


    // Update of the cart
    public function updateCart(Food $product, $quantity) {
        if($this->hasFoods()) {
            foreach($this->foods as &$food)  {
                if($product->id == $food['id']) {
                    $food['quantity'] = $quantity;
                    $food['subtotal'] = ($product->price * $quantity);
                    $this->calculateTotal();
                }
            }
        }
    }


    // Remove from the cart
    public function removeFromCart(Food $product) {
        if($this->hasFoods()) {
            $i = -1;
            foreach($this->foods as $food) {
                $i++;
                if($product->id == $food['id']) {
                    unset($this->foods[$i]);
                    $this->calculateTotal();
                }
            }
        }
    }


    // // Add to cart
    public function addToCart(Food $product, $quantity) {
        if($quantity < 1 || $this->isInCart($product)) {
            return;
        }
        $food = [
            'id' => $product->id,
            'name' => $product->name,
            'description_ingredients' => $product->description_ingredients,
            'price' => $product->price,
            'food_img' => $product->food_img,
            'quantity' => $quantity,
            'subtotal' => ($product->price * $quantity),
        ];
        $this->foods[] = $food;
        $this->calculateTotal();
    }

    private function isInCart(Food $product) {
        if( $this->hasFoods()) {
           foreach( $this->foods as $food ) {
               if($food['id'] == $product->id) {
                   return true;
               }
           }
           return false;
        } else {
            return false;
        }
    }

    private function calculateTotal() {
        $this->total = 0.00;
        if($this->hasFoods()) {
            $tot = 0.00;
            foreach($this->foods as $food) {
                $tot += $food['subtotal'];
            }
            $this->total = $tot;
        }
    }

    private function hasFoods() {
        return ( count( $this->foods ) > 0 );
    }

    // Save 

    public function add(Request $request, $id = '0') {
        $product_id = $id;
        $quantity = 1;
        if ($request->has(['id', 'quantity'])) {
            $product_id = $request->input('id');
            $quantity = (int) $request->input('quantity');
        }
        $product = Food::find($product_id);
        if(is_null($product)) {
            return redirect()->route('home');
        }
        $cart = new CartController();
        $sessionCart = $request->session()->get('cart');
        if(!$sessionCart) {
            $cart->addToCart($product, $quantity);
            $request->session()->put(['cart' => ['foods' => $cart->getFoods(), 'total' => $cart->getTotal()]]);
        } else {
            $cart->setFoods($sessionCart['foods']);
            $cart->setTotal($sessionCart['total']);
            $cart->addToCart($product, $quantity);
            $request->session()->put(['cart' => ['foods' => $cart->getFoods(), 'total' => $cart->getTotal()]]);
        }
        // return redirect()->route('cart');
    }

    public function cartRemove(Request $request) {
        $id = (int) $request->input('id');
        $product = Food::find($id);
        $cart = new CartController();
        $sessionCart = $request->session()->get('cart');
        $cart->setFoods($sessionCart['foods']);
        $cart->setTotal($sessionCart['total']);
        $cart->removeFromCart($product);
        $request->session()->put(['cart' => ['foods' => $cart->getFoods(), 'total' => $cart->getTotal()]]);
        return redirect()->route('cart');
    }

    public function cartUpdate(Request $request) {
        $qty = $request->input('qty');
        $parts = explode(',', $qty);
        $cart = new CartController();
        $sessionCart = $request->session()->get('cart');
        $cart->setFoods($sessionCart['foods']);
        $cart->setTotal($sessionCart['total']);
        foreach($parts as $part) {
            $qtys = explode('-', $part);
            $id = (int) $qtys[0];
            $quantity = (int) $qtys[1];
            $product = Food::find($id);
            $cart->updateCart($product, $quantity);
        }
        $request->session()->put(['cart' => ['foods' => $cart->getFoods(), 'total' => $cart->getTotal()]]);
        return redirect()->route('/');
    }
}









// class CartController extends Controller
// {
    

//     public function addToCart(Request $request)
//     {
//         $food = Food::FindOrFail($request->id);
//         $food['quantity'] = $request->quantity;
//         session()->push('cart', $food);
        
//         return response()->json([
//             'status' => 'added'
//         ]);
//     }
// }