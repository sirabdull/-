<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Config;

class HeroSection extends Component
{
    public $bannerImages;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $config = Config::first();
        $this->bannerImages = $config->banner_images ?? [];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.hero-section', [
            'bannerImages' => $this->bannerImages
        ]);
    }
}
