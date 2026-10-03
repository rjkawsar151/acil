<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->nullable();
            $table->string('brand')->default('SINODA');
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->text('benefits')->nullable();
            $table->text('usage_information')->nullable();
            $table->text('ingredients_information')->nullable();
            $table->text('packaging_information')->nullable();
            $table->string('available_sizes')->nullable();
            $table->string('ph_level')->nullable();
            $table->string('color_appearance')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('brochure')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['active', 'inactive', 'draft'])->default('active');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->integer('sort_order')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
