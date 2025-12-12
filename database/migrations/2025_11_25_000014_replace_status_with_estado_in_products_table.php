<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Products - estado already exists from previous migration, just drop status and migrate data if needed
        // But wait, previous migration added 'estado' but didn't drop 'status'.
        // Let's ensure data is synced and drop status.
        
        DB::table('test.products')->update(['estado' => DB::raw('status')]);
        
        Schema::table('test.products', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test.products', function (Blueprint $table) {
            $table->string('status', 30)->default('active');
        });
        
        DB::table('test.products')->update(['status' => DB::raw('estado')]);
    }
};
