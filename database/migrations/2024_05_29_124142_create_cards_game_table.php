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
        Schema::create('cards_game', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('questions_asked')->nullable();
            $table->string('cards_opened')->nullable();
            $table->string('last_attended')->nullable();
            $table->string('is_question_opened')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards_game');
    }
};
