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
        Schema::create('assessment_pains', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained()->onDelete('cascade');
            $table->char('pain_label', 1); // A, B, C, D
            $table->string('duration')->nullable();
            $table->string('continuous_intermittent')->nullable();
            $table->integer('pain_score')->nullable();
            $table->string('radiation')->nullable();
            $table->string('quality')->nullable();
            $table->text('provoking_factors')->nullable();
            $table->text('palliating_factors')->nullable();
            $table->text('impact_on_adls')->nullable();
            $table->text('impact_on_person')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_pains');
    }
};
