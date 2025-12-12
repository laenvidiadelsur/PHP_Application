<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('test.foundation_votes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('foundation_id');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('test.users')
                  ->onDelete('cascade');

            $table->foreign('foundation_id')
                  ->references('id')
                  ->on('test.foundations')
                  ->onDelete('cascade');

            // Ensure a user can only vote once per foundation
            $table->unique(['user_id', 'foundation_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test.foundation_votes');
    }
};
