<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //

    protected $casts = [
        'latitude' => 'float',
        'images' => 'array',
        'custom' => 'array'

    ];


    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
