<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sell extends Model
{
    protected $fillable = [
        'sell_dog',
        'sell_dog_buy_price',
        'sell_dog_sell_price',
        'sell_dog_discount_price',
        'sell_microchip',
        'sell_microchip_buy_price',
        'sell_microchip_sell_price',
        'sell_microchip_discount_price',
        'sell_cus_name',
        'sell_cus_tel_no',
        'sell_cus_address',
        'sell_transport_price',
    ];
}
