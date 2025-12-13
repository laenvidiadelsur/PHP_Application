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
        Schema::table('events', function (Blueprint $table) {
            if (!Schema::hasColumn('events', 'name')) {
                $table->string('name')->nullable();
            }
            if (!Schema::hasColumn('events', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('events', 'start_date')) {
                $table->dateTime('start_date')->nullable();
            }
            if (!Schema::hasColumn('events', 'end_date')) {
                $table->dateTime('end_date')->nullable();
            }
            if (!Schema::hasColumn('events', 'location')) {
                $table->string('location')->nullable();
            }
            if (!Schema::hasColumn('events', 'capacity')) {
                $table->integer('capacity')->default(0);
            }
            if (!Schema::hasColumn('events', 'status')) {
                $table->enum('status', ['active', 'cancelled', 'completed'])->default('active');
            }
            if (!Schema::hasColumn('events', 'image_url')) {
                $table->string('image_url')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            //
        });
    }
};
