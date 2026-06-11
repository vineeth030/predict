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
        DB::statement("ALTER TABLE game_notification MODIFY notification_type ENUM('REWARD', 'DAILY_REWARD', 'PREDICTION_REWARD', 'SHARE_SENT', 'SHARE_RECEIVED', 'REDEEM', 'REEDEEM_STAR', 'COUNTRY_COMPLETE') NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE game_notification MODIFY notification_type ENUM('REWARD', 'DAILY_REWARD', 'PREDICTION_REWARD', 'SHARE_SENT', 'SHARE_RECEIVED', 'REDEEM', 'COUNTRY_COMPLETE') NULL");
    }
};
