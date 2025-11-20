<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('proveedor', function (Blueprint $table): void {
            $table->id();
            $table->string('nombre', 120);
            $table->string('nit', 50)->unique();
            $table->string('direccion', 200);
            $table->string('telefono', 30);
            $table->string('email', 120)->unique();
            $table->string('representante_nombre', 120);
            $table->string('representante_ci', 40);
            $table->string('tipo_servicio', 120);
            $table->foreignId('fundacion_id')->constrained('fundacion');
            $table->string('estado', 20)->default('pendiente');
            $table->boolean('activo')->default(true);
            $table->timestampTz('created_at')->useCurrent();
            $table->timestampTz('updated_at')->useCurrent();
        });

        DB::statement("
            ALTER TABLE proveedor
            ADD CONSTRAINT proveedor_estado_check
            CHECK (estado IN ('pendiente','aprobado','rechazado'))
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('proveedor');
    }
};

