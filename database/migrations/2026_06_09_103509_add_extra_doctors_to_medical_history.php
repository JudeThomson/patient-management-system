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
            $table->string('doctor_hospital_2')->nullable()->after('doctor_hospital');
            $table->string('doctor_hospital_3')->nullable()->after('doctor_hospital_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assessment_medical_histories', function (Blueprint $table) {
            $table->dropColumn(['doctor_hospital_2', 'doctor_hospital_3']);
        });
    }
};
