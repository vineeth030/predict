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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->integer('team_one_id');
            $table->integer('team_two_id');
            $table->string('game_type');
            $table->integer('team_one_goals')->nullable();
            $table->integer('team_two_goals')->nullable();
            $table->integer('winning_team_id')->nullable();
            $table->integer('first_goal_team_id')->nullable();
            $table->string('kick_off_time');
          //  $table->timestamp('kick_off_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
