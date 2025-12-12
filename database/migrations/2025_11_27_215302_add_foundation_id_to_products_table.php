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
        Schema::table('test.products', function (Blueprint $table) {
            $table->foreignId('foundation_id')->nullable()->constrained('test.foundations')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test.products', function (Blueprint $table) {
            $table->dropForeign(['foundation_id']);
            $table->dropColumn('foundation_id');
        });
    }
};
