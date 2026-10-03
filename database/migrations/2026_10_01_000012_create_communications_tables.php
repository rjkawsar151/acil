<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('company')->nullable();
            $table->string('phone')->nullable();
            $table->string('email');
            $table->string('subject')->nullable();
            $table->text('message');
            $table->string('ip_address')->nullable();
            $table->boolean('is_read')->default(false);
            $table->enum('status', ['new', 'replied', 'archived'])->default('new');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('product_inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->string('product_name')->nullable();
            $table->string('name');
            $table->string('company')->nullable();
            $table->string('phone')->nullable();
            $table->string('email');
            $table->string('quantity_requirement')->nullable();
            $table->text('message');
            $table->string('ip_address')->nullable();
            $table->boolean('is_read')->default(false);
            $table->enum('status', ['pending', 'in_review', 'contacted', 'closed'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_inquiries');
        Schema::dropIfExists('contact_messages');
    }
};
