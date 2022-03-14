<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Carbon\Carbon;

use App\Models\Food;

class ChartController extends Controller
{
    public function getOrdersByDate($id) {
        $foods = Food::all()->where('user_id', $id);

        // dump($foods);

        $allOrders = new Collection([]);

        foreach($foods as $food) {
            $allOrders[] = $food->orders->toArray();
        }

        $allOrders = $allOrders->collapse()->unique('id')->sortBy('order_date')->groupBy(function($item) {
            $orderDate = Carbon::create($item['order_date'])->format('Y-m');
            $item['order_date'] = $orderDate;
            return $item['order_date'];
        });

        $result = [];

        foreach($allOrders as $order) {
            $data = [];
            $data['total'] = round($order->sum('bill'), 2);
            $data['date'] = Carbon::create($order[0]['order_date'])->format('Y-m');
            $result[] = $data;
        }

        return response()->json($result);
    }
}
