<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'bill',
        'order_date',
        'buyer_fullname',
        'buyer_email',
        'buyer_address',
        'buyer_phone',
        'note',
        'transaction_id',
        'transaction_status'
    ];

    public function foods() {
        return $this -> belongsToMany('App\Models\Food');
    }
}
