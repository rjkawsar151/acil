<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->string('platform');
            $table->string('icon')->nullable();
            $table->string('url');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('navigation_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('url');
            $table->foreignId('parent_id')->nullable()->constrained('navigation_items')->nullOnDelete();
            $table->string('location')->default('header'); // header, footer, topbar
            $table->string('target')->default('_self');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->longText('value')->nullable();
            $table->string('group')->default('general'); // general, contact, company, logos, social, appearance
            $table->string('type')->default('text'); // text, textarea, image, boolean, code
            $table->string('label');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('seo_settings', function (Blueprint $table) {
            $table->id();
            $table->string('page_key')->unique(); // home, about, products, sinoda, manufacturing, quality, sustainability, news, contact
            $table->string('page_name');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('og_image')->nullable();
            $table->string('canonical_url')->nullable();
            $table->longText('schema_markup')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_settings');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('navigation_items');
        Schema::dropIfExists('social_links');
    }
};
