<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
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

        return response()->json(['data' => $clientToken]);
    }

    public function processPayment(Request $request) {

        $clientNonce = $request->paymentMethodId;

        $gateway = $this->configGateway();

        $result = $gateway->transaction()->sale([
            'amount' => '10.00',
            'paymentMethodNonce' => $clientNonce,
            // 'deviceData' => $deviceDataFromTheClient,
            'options' => [
              'submitForSettlement' => True
            ]
        ]);

        dd($result);
    }
}
