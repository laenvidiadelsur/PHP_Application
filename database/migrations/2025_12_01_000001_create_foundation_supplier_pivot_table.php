<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foundation_supplier', function (Blueprint $table): void {
            $table->unsignedBigInteger('foundation_id');
            $table->unsignedBigInteger('supplier_id');

            $table->primary(['foundation_id', 'supplier_id'], 'foundation_supplier_primary');

            $table->foreign('foundation_id')
                ->references('id')
                ->on('foundations')
                ->onDelete('cascade');

            $table->foreign('supplier_id')
                ->references('id')
                ->on('suppliers')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foundation_supplier');
    }
};


