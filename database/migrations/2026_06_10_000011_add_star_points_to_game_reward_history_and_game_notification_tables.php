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
            $table->unsignedInteger('star_points')->default(0)->after('quantity');
        });

        Schema::table('game_notification', function (Blueprint $table) {
            $table->unsignedInteger('star_points')->default(0)->after('message');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_reward_history', function (Blueprint $table) {
            $table->dropColumn('star_points');
        });

        Schema::table('game_notification', function (Blueprint $table) {
            $table->dropColumn('star_points');
        });
    }
};
