<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description_ingredients',
        'price',
        'visible',
        'food_img'
    ];

    public function user() {
        return $this -> belongsTo('App\Models\User');
    }

    public function orders() {
        return $this -> belongsToMany('App\Models\Order');
    }
}
