<?php

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
        Schema::create('adventures', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(User::class, 'user_id')->constrained()->noActionOnDelete();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->longText('description')->nullable();
            $table->longText('html')->nullable();
            $table->string('cover')->nullable();
            $table->boolean('public')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adventures');
    }
};
