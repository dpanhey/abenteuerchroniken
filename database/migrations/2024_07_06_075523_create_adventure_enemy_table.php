<?php

use App\Models\Adventure;
use App\Models\Enemy;
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
        Schema::create('adventure_enemy', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Adventure::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Enemy::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adventure_enemy');
    }
};
