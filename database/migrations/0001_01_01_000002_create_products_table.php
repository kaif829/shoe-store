<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('brand')->nullable();
            $table->enum('gender', ['male', 'female', 'unisex'])->default('unisex');
            $table->enum('activity_type', ['running', 'walking', 'sports', 'casual', 'gym'])->default('casual');
            $table->string('size_range')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0);
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->decimal('avg_rating', 3, 2)->default(0);
            $table->integer('review_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();

            $table->index(['gender', 'activity_type', 'price']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
