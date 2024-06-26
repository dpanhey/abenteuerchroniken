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
        Schema::create('adventure_location', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Adventure::class)->constrained()->noActionOnDelete();
            $table->foreignIdFor(\App\Models\Location::class)->constrained()->noActionOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adventure_location');
    }
};
