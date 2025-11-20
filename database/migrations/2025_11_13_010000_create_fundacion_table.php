<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fundacion', function (Blueprint $table): void {
            $table->id();
            $table->string('nombre', 120);
            $table->string('nit', 50)->unique();
            $table->string('direccion', 200);
            $table->string('telefono', 30);
            $table->string('email', 120)->unique();
            $table->string('representante_nombre', 120);
            $table->string('representante_ci', 40);
            $table->text('mision');
            $table->date('fecha_creacion')->default(DB::raw('CURRENT_DATE'));
            $table->string('area_accion', 120);
            $table->string('cuenta_bancaria', 80)->nullable();
            $table->string('logo', 255)->nullable();
            $table->text('descripcion')->nullable();
            $table->boolean('activa')->default(true);
            $table->timestampTz('created_at')->useCurrent();
            $table->timestampTz('updated_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fundacion');
    }
};

