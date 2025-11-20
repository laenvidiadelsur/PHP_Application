<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orden_item', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('orden_id')->constrained('orden')->cascadeOnDelete();
            $table->foreignId('producto_id')->constrained('producto');
            $table->foreignId('proveedor_id')->constrained('proveedor');
            $table->string('nombre', 150)->nullable();
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 12, 2);
            $table->decimal('subtotal', 12, 2);

            $table->index('proveedor_id', 'idx_orden_item_proveedor');
        });

        DB::statement("
            ALTER TABLE orden_item
            ADD CONSTRAINT orden_item_cantidad_check CHECK (cantidad >= 1)
        ");

        DB::statement("
            ALTER TABLE orden_item
            ADD CONSTRAINT orden_item_precio_unitario_check CHECK (precio_unitario >= 0)
        ");

        DB::statement("
            ALTER TABLE orden_item
            ADD CONSTRAINT orden_item_subtotal_check CHECK (subtotal >= 0)
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('orden_item');
    }
};

