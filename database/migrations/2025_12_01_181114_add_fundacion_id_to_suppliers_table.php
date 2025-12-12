<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('test.suppliers', function (Blueprint $table) {
            $table->unsignedBigInteger('fundacion_id')->nullable()->after('tax_id');
            $table->foreign('fundacion_id')
                ->references('id')
                ->on('test.foundations')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test.suppliers', function (Blueprint $table) {
            $table->dropForeign(['fundacion_id']);
            $table->dropColumn('fundacion_id');
        });
    }
};
