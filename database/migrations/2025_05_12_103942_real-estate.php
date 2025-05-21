<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('properties');
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->decimal('price', 12, 2);
            $table->string('type'); // house, apartment, land, etc.
            $table->foreignId('location_id')->constrained('locations');
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->decimal('area', 10, 2)->nullable();
            $table->json('images')->nullable();
            $table->string('status')->default('available'); // available, sold, rented
            $table->json('features')->nullable();
            $table->timestamps();
        });

        Schema::dropIfExists('locations');
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // city, state, country
            $table->text('description')->nullable();
            $table->string('slug')->unique();
            $table->string('parent_id')->nullable(); // for hierarchical locations
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->json('images')->nullable();
            $table->string('google_map_link')->nullable();
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('street')->nullable();
            $table->string('neighborhood')->nullable();
            $table->json('custom')->nullable();
            $table->timestamps();
        });

        Schema::dropIfExists('web_config');
        Schema::create('web_config', function (Blueprint $table) {
            $table->id();
            $table->json('custom');
            $table->json('banner_images')->nullable();
            $table->json('social_links')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_address')->nullable();
            $table->string('seo_robots')->nullable();
            $table->string('seo_revisit_after')->nullable();
            $table->string('seo_referrer')->nullable();
            $table->string('seo_type')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('seo_image')->nullable();
            $table->string('seo_author')->nullable();
            $table->string('seo_geo_region')->nullable();
            $table->string('seo_geo_position')->nullable();
            $table->string('seo_twitter_site')->nullable();
            $table->string('seo_twitter_card')->nullable();
            $table->string('seo_fb_app_id')->nullable();
            $table->text('seo_keywords')->nullable();
        });



        Schema::dropIfExists('users');
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->enum('role', ['admin', 'agent', 'user'])->default('user');
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::dropIfExists('inquiries');
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('message');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
        Schema::dropIfExists('users');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('web_config');
        Schema::dropIfExists('property_images');
        Schema::dropIfExists('properties');
    }
};
