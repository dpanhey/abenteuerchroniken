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
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id')->constrained();
            $table->string('name');
            $table->string('familie')->nullable();
            $table->string('geburtsort')->nullable();
            $table->string('geburtsdatum')->nullable();
            $table->string('alter')->nullable();
            $table->string('geschlecht')->nullable();
            $table->decimal('groesse')->nullable();
            $table->decimal('gewicht')->nullable();
            $table->string('haarfarbe')->nullable();
            $table->string('augenfarbe')->nullable();
            $table->string('titel')->nullable();
            $table->string('sozialstatus')->nullable();
            $table->text('charakteristiken')->nullable();
            $table->text('hintergrundgeschichte')->nullable();
            $table->text('andere_informationen')->nullable();
            $table->integer('ap_gesamt')->nullable();
            $table->integer('ap_verfuegbar')->nullable();
            $table->integer('ap_ausgegeben')->nullable();
            $table->string('portrait_url', 2048)->nullable();
            $table->boolean('lebendig')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
