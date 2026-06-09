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
        Schema::create('game_card', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained('teams');
            $table->string('card_code', 50)->nullable()->unique();
            $table->string('card_name', 200)->nullable();
            $table->string('player_name', 200)->nullable();
            $table->enum('card_type', [
                'BRONZE',
                'SILVER',
                'GOLD',
            ]);
            $table->integer('card_order');
            $table->integer('star_value');
            $table->boolean('is_active')->default(true);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_card');
    }
};
