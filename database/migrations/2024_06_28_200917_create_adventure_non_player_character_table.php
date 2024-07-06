<?php

use App\Models\Adventure;
use App\Models\NonPlayerCharacter;
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
        Schema::create('adventure_non_player_character', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Adventure::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(NonPlayerCharacter::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adventure_non_player_character');
    }
};
