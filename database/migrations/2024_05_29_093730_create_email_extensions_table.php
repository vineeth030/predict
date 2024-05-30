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
        Schema::create('email_extensions', function (Blueprint $table) {
            $table->id(); // This will be the auto-increment primary key
            $table->string('domain')->unique();
            $table->unsignedBigInteger('company_group_id'); // Regular unsigned big integer
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_extensions');
    }
};
