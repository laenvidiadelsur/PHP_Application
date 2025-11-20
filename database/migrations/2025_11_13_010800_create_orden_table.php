<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orden', function (Blueprint $table): void {
            $table->id();
            $table->string('numero_orden', 50)->unique();
            $table->foreignId('usuario_id')->constrained('usuario');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('impuestos', 12, 2)->default(0);
            $table->decimal('envio', 12, 2)->default(0);
            $table->decimal('total', 12, 2);
            $table->string('direccion_calle', 200)->nullable();
            $table->string('direccion_ciudad', 120)->nullable();
            $table->string('direccion_estado', 120)->nullable();
            $table->string('direccion_codigo_postal', 20)->nullable();
            $table->string('direccion_pais', 5)->default('MX');
            $table->decimal('coord_latitud', 9, 6)->nullable();
            $table->decimal('coord_longitud', 9, 6)->nullable();
            $table->string('contacto_nombre', 150)->nullable();
            $table->string('contacto_telefono', 40)->nullable();
            $table->string('contacto_email', 120)->nullable();
            $table->string('estado_pago', 20)->default('pendiente');
            $table->string('estado_envio', 20)->default('pendiente');
            $table->string('metodo_pago', 20)->default('stripe');
            $table->string('stripe_payment_intent_id', 120)->nullable();
            $table->string('stripe_charge_id', 120)->nullable();
            $table->string('stripe_marca', 50)->nullable();
            $table->string('stripe_ultimos4', 4)->nullable();
            $table->string('stripe_tipo', 50)->nullable();
            $table->timestampTz('fecha_pago')->nullable();
            $table->text('notas')->nullable();
            $table->timestampTz('created_at')->useCurrent();
            $table->timestampTz('updated_at')->useCurrent();

            $table->index('usuario_id', 'idx_orden_usuario');
            $table->index('estado_pago', 'idx_orden_estado_pago');
            $table->index('estado_envio', 'idx_orden_estado_envio');
        });

        DB::statement("
            ALTER TABLE orden
            ADD CONSTRAINT orden_subtotal_check CHECK (subtotal >= 0)
        ");

        DB::statement("
            ALTER TABLE orden
            ADD CONSTRAINT orden_impuestos_check CHECK (impuestos >= 0)
        ");

        DB::statement("
            ALTER TABLE orden
            ADD CONSTRAINT orden_envio_check CHECK (envio >= 0)
        ");

        DB::statement("
            ALTER TABLE orden
            ADD CONSTRAINT orden_total_check CHECK (total >= 0)
        ");

        DB::statement("
            ALTER TABLE orden
            ADD CONSTRAINT orden_estado_pago_check CHECK (
                estado_pago IN ('pendiente','procesando','completado','fallido','reembolsado')
            )
        ");

        DB::statement("
            ALTER TABLE orden
            ADD CONSTRAINT orden_estado_envio_check CHECK (
                estado_envio IN ('pendiente','procesando','enviado','entregado','cancelado')
            )
        ");

        DB::statement("
            ALTER TABLE orden
            ADD CONSTRAINT orden_metodo_pago_check CHECK (
                metodo_pago IN ('stripe','efectivo','transferencia')
            )
        ");

        DB::statement('CREATE INDEX idx_orden_created_at ON orden (created_at DESC)');
    }

    public function down(): void
    {
        DB::statement('DROP INDEX IF EXISTS idx_orden_created_at');
        Schema::dropIfExists('orden');
    }
};

