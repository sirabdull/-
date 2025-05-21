<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    //
    protected $table = 'web_config';


    protected $casts = [
        'banner_images' => 'array',
        'custom' => 'array'
    ];
    
}
