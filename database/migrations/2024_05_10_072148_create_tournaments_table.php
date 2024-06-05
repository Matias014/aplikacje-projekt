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
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('name', 40)->unique();
            $table->string('description', 255)->nullable();
            $table->timestamp('date'); // data nie starsza nie starsza niż 01.01.2020
            $table->decimal('price', 8, 2); // dodać dolne ograniczenie ceny
            $table->string('img', 40)->nullable();
            $table->integer('max_team_A')->default(0);
            $table->integer('max_team_B')->default(0);
            // $table->integer('max_team_gamma')->default(0);
            // $table->integer('max_team_delta')->default(0);
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};
