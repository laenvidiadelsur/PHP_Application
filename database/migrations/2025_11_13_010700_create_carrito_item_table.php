<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('carrito_item', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('carrito_id')->constrained('carrito')->cascadeOnDelete();
            $table->foreignId('producto_id')->constrained('producto');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 12, 2);
            $table->decimal('subtotal', 12, 2);
        });

        DB::statement("
            ALTER TABLE carrito_item
            ADD CONSTRAINT carrito_item_cantidad_check CHECK (cantidad >= 1)
        ");

        DB::statement("
            ALTER TABLE carrito_item
            ADD CONSTRAINT carrito_item_precio_unitario_check CHECK (precio_unitario >= 0)
        ");

        DB::statement("
            ALTER TABLE carrito_item
            ADD CONSTRAINT carrito_item_subtotal_check CHECK (subtotal >= 0)
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('carrito_item');
    }
};

