<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use RalphJSmit\Laravel\SEO\Support\{HasSEO, SEOData};


class Property extends Model
{
    use HasSeo;
    //
    protected $table = 'properties';

    public function location(): HasOne
    {
        return $this->hasOne(Location::class, 'id', 'location_id');
    }

    public function getDynamicSEOData(): SEOData
    {
        return new SEOData(
            title: $this->title ?? $this->name,
            description: $this->description,
            author: 'Bayscope Solutions LTD',
            image: \Illuminate\Support\Facades\Storage::url($this->images[0]) ?? null,
        );
    }
    protected $casts = [
        'images' => 'array',
        'features' => 'array',
    ];
}
