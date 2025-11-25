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
        Schema::create('test.carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('test.users')->onDelete('cascade');
            $table->foreignId('supplier_id')->constrained('test.suppliers')->onDelete('cascade');
            $table->foreignId('foundation_id')->nullable()->constrained('test.foundations')->onDelete('set null');
            $table->timestampTz('created_at')->useCurrent();
            $table->timestampTz('updated_at')->useCurrent();
            
            $table->index(['user_id', 'supplier_id'], 'idx_cart_user_supplier');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test.carts');
    }
};
