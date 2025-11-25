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
        Schema::create('test.cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained('test.carts')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('test.products')->onDelete('cascade');
            $table->integer('quantity')->check('quantity > 0');
            
            $table->index('cart_id', 'idx_cart_items_cart_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test.cart_items');
    }
};
