<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE game_reward_history MODIFY reward_source ENUM('DAILY', 'PREDICTION', 'REDEEM', 'SHARED', 'ADMIN') NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE game_reward_history MODIFY reward_source ENUM('DAILY', 'PREDICTION', 'REDEEM', 'ADMIN') NULL");
    }
};
