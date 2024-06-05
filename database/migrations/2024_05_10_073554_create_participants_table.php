<?php

use App\Models\Tournament;
use App\Models\User;
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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Tournament::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            // $table->string('team', 20);
            $table->enum('team', ['A', 'B']); // Użycie enum do ograniczenia wartości
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
