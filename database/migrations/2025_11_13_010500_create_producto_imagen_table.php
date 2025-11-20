<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('producto_imagen', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('producto_id')->constrained('producto')->cascadeOnDelete();
            $table->string('url', 255)->nullable();
            $table->string('public_id', 255)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('producto_imagen');
    }
};

