<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


Route::view('/', 'web.home')->name('home');
Route::view('/about', 'web.about')->name('about');
Route::view('/contact', 'web.contact')->name('contact');
Route::post('conatct/submit', function (Request $request) {
    Mail::to(env('BUSINESS_EMAIL'))->send(new \App\Mail\ContactMail($request->all()));
    return redirect()->back()->with('success', 'Your message has been sent successfully');
})->name('contact.submit');
Route::view('/locations', view: 'web.locations')->name('locations');
Route::view('/properties', 'web.properties')->name('properties');
Route::view('/properties/{slug}', 'web.property')->name('property');
Route::view('/locations/{slug}', 'web.location')->name('location');
// Route::view('/blog', 'web.blog')->name('blog');






Route::view('/file-manager', 'admin.filemanager')
    ->middleware(['auth', 'verified'])
    ->name('file-manager')->prefix('admin');


/**Admin routes */
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::view('/', 'admin.dashboard')->name('dashboard');
    Route::redirect('settings', 'settings/profile');
    Route::view('configuration', 'admin.configuration')->name('web.conf');
    Route::view('properties', 'admin.properties')->name('properties');
    Route::view('properties/create', 'admin.properties')->name('properties.create');
    Route::view('properties/edit/{id}', 'admin.properties')->name('properties.edit');
    Route::view('properties/view/{id}', 'admin.properties')->name('properties.show');
    Route::view('locations', 'admin.locations')->name('locations');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});;

require __DIR__ . '/auth.php';
