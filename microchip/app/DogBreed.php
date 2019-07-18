<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DogBreed extends Model
{
    protected $fillable = [
        'dog_breed', 'dog_breed_male_count', 'dog_breed_female_count',
    ];
}
