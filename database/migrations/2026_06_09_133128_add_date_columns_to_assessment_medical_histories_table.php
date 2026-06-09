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
        Schema::table('assessment_medical_histories', function (Blueprint $table) {
            $table->date('problem_started_on_date')->nullable();
            $table->date('illness_details_date')->nullable();
            $table->date('doctor_hospital_date')->nullable();
            $table->date('doctor_hospital_2_date')->nullable();
            $table->date('doctor_hospital_3_date')->nullable();
            $table->date('diagnosed_at_date')->nullable();
            $table->date('surgery_date')->nullable();
            $table->date('radiation_date')->nullable();
            $table->date('chemotherapy_date')->nullable();
            $table->date('colostomy_date')->nullable();
            $table->date('renal_problems_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assessment_medical_histories', function (Blueprint $table) {
            $table->dropColumn([
                'problem_started_on_date',
                'illness_details_date',
                'doctor_hospital_date',
                'doctor_hospital_2_date',
                'doctor_hospital_3_date',
                'diagnosed_at_date',
                'surgery_date',
                'radiation_date',
                'chemotherapy_date',
                'colostomy_date',
                'renal_problems_date'
            ]);
        });
    }
};
