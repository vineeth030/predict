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
        Schema::create('versions', function (Blueprint $table) {
            $table->id();
            $table->string('platform')->unique(); // 'android' or 'ios'
            $table->string('code');
            $table->string('name');
            $table->string('is_mandatory');
            $table->string('countdown_timer');
            $table->string('is_quarter_started');
            $table->string('is_round16_completed');
            $table->string('wc_end_date');
            $table->string('winner');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('versions');
    }
};
