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
        // Orders
        Schema::table('orders', function (Blueprint $table) {
            $table->string('estado', 30)->default('pendiente')->after('total_amount');
        });
        DB::table('orders')->update(['estado' => DB::raw('status')]);
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        // Payments
        Schema::table('payments', function (Blueprint $table) {
            $table->string('estado', 30)->default('pendiente')->after('payment_method');
        });
        DB::table('payments')->update(['estado' => DB::raw('status')]);
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Orders
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status', 30)->default('pending')->after('total_amount');
        });
        DB::table('orders')->update(['status' => DB::raw('estado')]);
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('estado');
        });

        // Payments
        Schema::table('payments', function (Blueprint $table) {
            $table->string('status', 30)->default('pending')->after('payment_method');
        });
        DB::table('payments')->update(['status' => DB::raw('estado')]);
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
};
