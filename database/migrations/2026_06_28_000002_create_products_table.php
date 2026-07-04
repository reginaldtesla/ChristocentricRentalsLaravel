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
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('excerpt', 500)->nullable();
            $table->decimal('price_per_day', 10, 2);
            $table->string('image')->nullable();
            $table->boolean('is_new')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->unsignedTinyInteger('rating')->default(4);
            $table->boolean('in_stock')->default(true);
            $table->unsignedInteger('quantity')->default(1);
            $table->string('rentopian_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
