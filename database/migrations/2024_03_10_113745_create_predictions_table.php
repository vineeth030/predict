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
        Schema::create('predictions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('game_id');
            $table->integer('team_one_goals')->nullable();
            $table->integer('team_two_goals')->nullable();
            $table->integer('winning_team_id')->nullable();
            $table->integer('first_goal_team_id')->nullable();
            $table->integer('final_team_one_id')->nullable();
            $table->integer('final_team_two_id')->nullable();
          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('predictions');
    }
};
