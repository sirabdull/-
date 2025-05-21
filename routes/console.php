<?php

use Illuminate\Foundation\Inspiring;
use Spatie\Sitemap\SitemapGenerator;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('sitemap:generate', fn() => SitemapGenerator::create('http://127.0.0.1:8000/')->getSitemap()->writeToDisk('public', 'sitemap.xml'))
    ->purpose('Generate a sitemap and write it to the public disk');
