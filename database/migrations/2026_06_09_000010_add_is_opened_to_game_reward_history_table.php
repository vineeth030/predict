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
        Schema::table('game_reward_history', function (Blueprint $table) {
            $table->boolean('is_opened')->default(false)->after('reward_source');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_reward_history', function (Blueprint $table) {
            $table->dropColumn('is_opened');
        });
    }
};
