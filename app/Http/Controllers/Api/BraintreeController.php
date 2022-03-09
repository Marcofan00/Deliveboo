<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Models\Order;
use App\Mail\OrderReceived;
use App\Mail\OrderReceivedRestaurant;

use Illuminate\Support\Facades\Mail;

use App\Models\Food;
use App\Models\User;

class BraintreeController extends Controller
{

    public function configGateway() {
        return new \Braintree\Gateway([
            'environment' => 'sandbox',
            'merchantId' => 'myqf9wyvg5pdnvw5',
            'publicKey' => 'gfv2d6997thjbrnn',
            'privateKey' => '3fb7d4a8ccb6d9a964fe9a08dc4cf01d'
        ]);
    }

    public function getToken() {
        
        $gateway = $this->configGateway();

        $clientToken = $gateway->clientToken()->generate();

        return response()->json($clientToken);
    }

    public function processPayment(Request $request) {

        $sessionCart = session()->get('cart');

        $foodId = $sessionCart['foods'][0]['id'];

        $userId = Food::findOrFail($foodId)->user_id;

        $user = User::findOrFail($userId);

        // dd($user);

        $data = $request->all();

        $validatedData = Validator::make($data, [
            'order_date' => ['required', 'date'],
            'buyer_fullname' => ['required', 'string', 'max:150'],
            'buyer_email' => ['required', 'email', 'max:60'],
            'buyer_address' => ['required', 'string'],
            'buyer_phone' => ['nullable', 'string', 'max:40', 'min:10'],
            'note' => ['nullable', 'string']
        ])->validate();

        $gateway = $this->configGateway();

        $clientNonce = $request->paymentMethodId;

        $result = $gateway->transaction()->sale([
            'amount' => $sessionCart['total'],
            'paymentMethodNonce' => $clientNonce,
            // 'deviceData' => $deviceDataFromTheClient,
            'options' => [
              'submitForSettlement' => True
            ]
        ]);

        $transactionStatus = 0;

        if ($result->success) {
            $transactionStatus = 1;
        } else {
            $transactionStatus = 0;
        }

        $newOrder = Order::create([
            'bill' => $sessionCart['total'],
            'order_date' => $data['order_date'],
            'buyer_fullname' => $data['buyer_fullname'],
            'buyer_email' => $data['buyer_email'],
            'buyer_address' => $data['buyer_address'],
            'buyer_phone' => $data['buyer_phone'],
            'note' => $data['note'],
            'transaction_status' => $transactionStatus,
            'transaction_id' => $result->transaction->id
        ]);

        foreach($sessionCart['foods'] as $food) {
            $newOrder -> foods() ->attach($food['id'], ['food_qty' => $food['quantity']]);
        }

        Mail::to($data['buyer_email'])->send(new OrderReceived($newOrder, $user));
        Mail::to($user->email)->send(new OrderReceivedRestaurant($newOrder, $user));

            

        return response()->json($newOrder);
    }
}
