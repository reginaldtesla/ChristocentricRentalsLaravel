<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->timestamp('returned_at')->nullable()->after('return_time');
            $table->decimal('late_penalty', 10, 2)->default(0)->after('returned_at');
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['returned_at', 'late_penalty']);
        });
    }
};
