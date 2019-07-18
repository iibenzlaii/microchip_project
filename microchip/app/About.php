<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $fillable = [
        'about_title', 'about_subtitle', 'about_content', 'about_image',
    ];
}
