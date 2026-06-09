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
        Schema::create('assessment_medical_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained()->onDelete('cascade');
            $table->string('problem_started_on')->nullable();
            $table->text('illness_details')->nullable();
            $table->string('doctor_hospital')->nullable();
            $table->string('diagnosed_at')->nullable();
            $table->string('surgery')->nullable();
            $table->string('radiation')->nullable();
            $table->string('chemotherapy')->nullable();
            $table->string('colostomy')->nullable();
            $table->string('renal_problems')->nullable();
            $table->string('dm')->nullable();
            $table->string('htn')->nullable();
            $table->string('asthma')->nullable();
            $table->string('cad')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_medical_histories');
    }
};
