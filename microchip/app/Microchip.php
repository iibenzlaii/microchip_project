<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Microchip extends Model
{
    protected $fillable = [
        'microchip_no', 'microchip_buy_price', 'microchip_sell_price', 'microchip_owner', 'microchip_status', 'install_status', 'dog_id',
    ];
}
