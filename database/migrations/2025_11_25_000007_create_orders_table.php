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
        Schema::create('test.orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained('test.carts')->onDelete('set null');
            $table->decimal('total_amount', 12, 2)->check('total_amount >= 0');
            $table->string('status', 30)->default('pending');
            $table->timestampTz('created_at')->useCurrent();
            
            $table->index('cart_id', 'idx_orders_cart_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test.orders');
    }
};
