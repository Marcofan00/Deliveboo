<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Models\Order;

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

        $validatedData = Validator::make($request->all(), [
            'bill' => ['required', 'numeric'],
            'order_date' => ['required', 'date'],
            'buyer_fullname' => ['required', 'string', 'max:150'],
            'buyer_email' => ['required', 'email', 'max:60'],
            'buyer_phone' => ['nullable', 'string', 'max:40', 'min:40'],
            'note' => ['nullable', 'string'],
            'cart' => ['required']
        ])->validate();

        $gateway = $this->configGateway();

        $clientNonce = $request->paymentMethodId;

        $transaction = $gateway->transaction()->sale([
            'amount' => $orderData['bill'],
            'paymentMethodNonce' => $clientNonce,
            // 'deviceData' => $deviceDataFromTheClient,
            'options' => [
              'submitForSettlement' => True
            ]
        ]);

        $newOrder = Order::create();

        dd($result);
    }
}
