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
        Schema::create('test.payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('test.orders')->onDelete('cascade');
            $table->string('payment_method', 50);
            $table->string('status', 30)->default('pending');
            $table->string('transaction_ref', 120)->nullable();
            $table->timestampTz('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test.payments');
    }
};
