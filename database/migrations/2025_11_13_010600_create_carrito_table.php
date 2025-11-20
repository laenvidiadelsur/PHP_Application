<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('carrito', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('usuario_id')->nullable()->constrained('usuario')->nullOnDelete();
            $table->decimal('total', 12, 2)->default(0);
            $table->string('estado', 20)->default('activo');
            $table->timestampTz('fecha_expiracion')->nullable();
            $table->string('session_id', 100)->nullable();
            $table->timestampTz('created_at')->useCurrent();
            $table->timestampTz('updated_at')->useCurrent();

            $table->index('usuario_id', 'idx_carrito_usuario');
            $table->index('estado', 'idx_carrito_estado');
            $table->index('fecha_expiracion', 'idx_carrito_fecha_expira');
        });

        DB::statement("
            ALTER TABLE carrito
            ADD CONSTRAINT carrito_total_check CHECK (total >= 0)
        ");

        DB::statement("
            ALTER TABLE carrito
            ADD CONSTRAINT carrito_estado_check CHECK (
                estado IN ('activo','procesando','completado','abandonado')
            )
        ");

        DB::statement("CREATE UNIQUE INDEX idx_carrito_session_activo ON carrito (session_id) WHERE session_id IS NOT NULL");
    }

    public function down(): void
    {
        DB::statement('DROP INDEX IF EXISTS idx_carrito_session_activo');
        Schema::dropIfExists('carrito');
    }
};

