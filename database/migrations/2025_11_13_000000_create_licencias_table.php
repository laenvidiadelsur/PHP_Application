<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('licencias', function (Blueprint $table): void {
            $table->id();
            $table->string('numero')->unique();
            $table->unsignedBigInteger('titular_id');
            $table->string('estado')->default('pendiente');
            $table->date('vigencia_desde');
            $table->date('vigencia_hasta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('licencias');
    }
};

