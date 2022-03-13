<?php

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Food;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = [
            [
                'bill' => 20.00,
                'order_date' => now(),
                'buyer_fullname' => 'Gioacchino Rossini',
                'buyer_email' => 'giacchino@mail.com',
                'buyer_address' => 'Via delle Crociate, 74, 70100, Bari',
                'transaction_id' => 'ABCDEF123456',
                'transaction_status' => 1
            ],
            [
                'bill' => 15.98,
                'order_date' => now(),
                'buyer_fullname' => 'Phil Anselmo',
                'buyer_email' => 'phil@mail.com',
                'buyer_address' => 'Via Trieste, 15, 70024, Gravina in Puglia',
                'transaction_id' => 'GHILMN123456',
                'transaction_status' => 1
            ],
            [
                'bill' => 9.00,
                'order_date' => now(),
                'buyer_fullname' => 'Ozzy Osbourne',
                'buyer_email' => 'ozzy@mail.com',
                'buyer_address' => 'Via Milano, 36, 70022, Altamura',
                'transaction_id' => 'GHILMN789123',
                'transaction_status' => 1
            ],
        ];

        foreach($orders as $order) {
            factory(Order::class)->
            create([
                'bill' => $order['bill'],
                'order_date' => $order['order_date'],
                'buyer_fullname' => $order['buyer_fullname'],
                'buyer_email' => $order['buyer_email'],
                'buyer_address' => $order['buyer_address'],
                'transaction_id' => $order['transaction_id'],
                'transaction_status' => $order['transaction_status']
            ])->each(function($order) {

                $food = Food::inRandomOrder()->first();

                $order -> foods() -> attach($food, ['food_qty' => 2]);
            });
        }
    }
}
