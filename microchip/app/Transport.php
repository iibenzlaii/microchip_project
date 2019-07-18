<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    protected $fillable = [
        'transport_name', 
        'transport_price', 
        'transport_count', 
    ];
}
