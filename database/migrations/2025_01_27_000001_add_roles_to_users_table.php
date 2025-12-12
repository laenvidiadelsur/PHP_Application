<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('test.users', function (Blueprint $table) {
            $table->string('rol', 20)->default('comprador')->after('is_admin');
            $table->unsignedBigInteger('fundacion_id')->nullable()->after('rol');
            $table->unsignedBigInteger('proveedor_id')->nullable()->after('fundacion_id');
            $table->string('rol_model', 20)->nullable()->after('proveedor_id');
            $table->string('approval_status', 20)->default('approved')->after('rol_model');
            $table->boolean('activo')->default(true)->after('approval_status');
            
            // Foreign keys
            $table->foreign('fundacion_id')->references('id')->on('test.foundations')->onDelete('set null');
            $table->foreign('proveedor_id')->references('id')->on('test.suppliers')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('test.users', function (Blueprint $table) {
            $table->dropForeign(['fundacion_id']);
            $table->dropForeign(['proveedor_id']);
            $table->dropColumn(['rol', 'fundacion_id', 'proveedor_id', 'rol_model', 'approval_status', 'activo']);
        });
    }
};

