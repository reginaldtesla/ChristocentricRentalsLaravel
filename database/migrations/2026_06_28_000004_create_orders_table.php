<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('order_number')->unique();
            $table->string('status')->default('pending');
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone')->nullable();
            $table->date('rental_start')->nullable();
            $table->date('rental_end')->nullable();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('total', 10, 2);
            $table->string('payment_method')->nullable();
            $table->string('payment_reference')->nullable();
            $table->string('payment_status')->default('unpaid');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
