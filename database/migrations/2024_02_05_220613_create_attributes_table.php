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
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('character_id')->constrained();
            $table->integer('mut')->nullable()->default(8);
            $table->integer('klugheit')->nullable()->default(8);
            $table->integer('intuition')->nullable()->default(8);
            $table->integer('charisma')->nullable()->default(8);
            $table->integer('fingerfertigkeit')->nullable()->default(8);
            $table->integer('gewandtheit')->nullable()->default(8);
            $table->integer('konstitution')->nullable()->default(8);
            $table->integer('koerperkraft')->nullable()->default(8);
            $table->integer('lebensenergie')->nullable()->default(21);
            $table->integer('astralenergie')->nullable()->default(0);
            $table->integer('karmaenergie')->nullable()->default(0);
            $table->integer('seelenkraft')->nullable()->default(-1);
            $table->integer('zaehigkeit')->nullable()->default(-1);
            $table->integer('ausweichen')->nullable()->default(4);
            $table->integer('initiative')->nullable()->default(8);
            $table->integer('wundschwelle')->nullable()->default(4);
            $table->integer('geschwindigkeit')->nullable()->default(8);
            $table->integer('schicksalspunkte')->nullable()->default(3);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
};
