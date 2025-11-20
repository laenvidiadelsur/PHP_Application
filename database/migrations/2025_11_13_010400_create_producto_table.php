<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('producto', function (Blueprint $table): void {
            $table->id();
            $table->string('nombre', 150);
            $table->text('descripcion');
            $table->decimal('precio', 12, 2);
            $table->string('unidad', 20);
            $table->integer('stock')->default(0);
            $table->string('categoria', 30);
            $table->foreignId('proveedor_id')->constrained('proveedor');
            $table->foreignId('fundacion_id')->constrained('fundacion');
            $table->string('estado', 20)->default('activo');
            $table->timestampTz('created_at')->useCurrent();
            $table->timestampTz('updated_at')->useCurrent();

            $table->index('nombre', 'idx_producto_nombre');
            $table->index('categoria', 'idx_producto_categoria');
            $table->index('proveedor_id', 'idx_producto_proveedor');
            $table->index('fundacion_id', 'idx_producto_fundacion');
        });

        DB::statement("
            ALTER TABLE producto
            ADD CONSTRAINT producto_precio_check CHECK (precio >= 0)
        ");

        DB::statement("
            ALTER TABLE producto
            ADD CONSTRAINT producto_unidad_check CHECK (unidad IN ('kg','unidad','litro','metro'))
        ");

        DB::statement("
            ALTER TABLE producto
            ADD CONSTRAINT producto_stock_check CHECK (stock >= 0)
        ");

        DB::statement("
            ALTER TABLE producto
            ADD CONSTRAINT producto_categoria_check CHECK (
                categoria IN ('materiales','equipos','alimentos','gaseosas','otros')
            )
        ");

        DB::statement("
            ALTER TABLE producto
            ADD CONSTRAINT producto_estado_check CHECK (estado IN ('activo','inactivo'))
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('producto');
    }
};

