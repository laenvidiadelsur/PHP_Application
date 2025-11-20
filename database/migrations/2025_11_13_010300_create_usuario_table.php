<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('usuario', function (Blueprint $table): void {
            $table->id();
            $table->string('nombre', 120);
            $table->string('email', 120)->unique();
            $table->string('password_hash', 255);
            $table->string('rol', 20)->default('usuario');
            $table->foreignId('fundacion_id')->nullable()->constrained('fundacion')->nullOnDelete();
            $table->foreignId('proveedor_id')->nullable()->constrained('proveedor')->nullOnDelete();
            $table->string('rol_model', 20)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestampTz('created_at')->useCurrent();
            $table->timestampTz('updated_at')->useCurrent();
        });

        DB::statement("
            ALTER TABLE usuario
            ADD CONSTRAINT usuario_rol_check
            CHECK (rol IN ('admin','fundacion','proveedor','usuario'))
        ");

        DB::statement("
            ALTER TABLE usuario
            ADD CONSTRAINT usuario_rol_model_check
            CHECK (
                rol_model IS NULL
                OR rol_model IN ('Fundacion','Proveedor')
            )
        ");

        DB::statement("
            ALTER TABLE usuario
            ADD CONSTRAINT usuario_rol_dependencies_check
            CHECK (
                (rol_model = 'Fundacion' AND fundacion_id IS NOT NULL AND proveedor_id IS NULL)
                OR (rol_model = 'Proveedor' AND proveedor_id IS NOT NULL AND fundacion_id IS NULL)
                OR (rol_model IS NULL AND fundacion_id IS NULL AND proveedor_id IS NULL)
            )
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};

