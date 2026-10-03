<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('subtitle')->nullable();
            $table->string('badge_text')->nullable();
            $table->string('badge_icon')->nullable()->default('fa-solid fa-industry');
            $table->string('badge_color')->nullable()->default('blue');
            $table->string('badge_subtext')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();
            $table->string('button_icon')->nullable();
            $table->string('button_style')->nullable()->default('primary');
            $table->string('secondary_button_text')->nullable();
            $table->string('secondary_button_url')->nullable();
            $table->string('secondary_button_icon')->nullable();
            $table->string('secondary_button_style')->nullable()->default('red');
            $table->string('tertiary_button_text')->nullable();
            $table->string('tertiary_button_url')->nullable();
            $table->string('image')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
    }
};
