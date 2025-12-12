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
        Schema::table('test.events', function (Blueprint $table) {
            if (!Schema::hasColumn('test.events', 'name')) {
                $table->string('name')->nullable();
            }
            if (!Schema::hasColumn('test.events', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('test.events', 'start_date')) {
                $table->dateTime('start_date')->nullable();
            }
            if (!Schema::hasColumn('test.events', 'end_date')) {
                $table->dateTime('end_date')->nullable();
            }
            if (!Schema::hasColumn('test.events', 'location')) {
                $table->string('location')->nullable();
            }
            if (!Schema::hasColumn('test.events', 'capacity')) {
                $table->integer('capacity')->default(0);
            }
            if (!Schema::hasColumn('test.events', 'status')) {
                $table->enum('status', ['active', 'cancelled', 'completed'])->default('active');
            }
            if (!Schema::hasColumn('test.events', 'image_url')) {
                $table->string('image_url')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test.events', function (Blueprint $table) {
            //
        });
    }
};
