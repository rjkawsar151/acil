<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quality_sections', function (Blueprint $table) {
            $table->id();
            $table->integer('step_number')->default(1);
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->json('standards')->nullable();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quality_sections');
    }
};
