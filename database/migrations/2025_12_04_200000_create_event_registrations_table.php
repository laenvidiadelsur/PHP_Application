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
        Schema::create('test.event_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('test.users')->onDelete('cascade');
            $table->foreignId('event_id')->constrained('test.events')->onDelete('cascade');
            $table->enum('status', ['registered', 'cancelled', 'attended'])->default('registered');
            $table->timestamp('registered_at')->useCurrent();
            $table->timestamps();
            
            // Unique constraint - one registration per user per event
            $table->unique(['user_id', 'event_id']);
            
            $table->index('user_id');
            $table->index('event_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test.event_registrations');
    }
};
