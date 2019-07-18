<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DogFarm extends Model
{
    protected $fillable = [
        'dog_farm_name', 'dog_farm_count',
    ];
}
