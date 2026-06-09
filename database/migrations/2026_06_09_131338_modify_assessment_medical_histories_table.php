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
            $table->dropColumn(['dm', 'htn', 'asthma', 'cad']);
            $table->text('dm_htn_asthma_cad_details')->nullable();
            $table->date('dm_htn_asthma_cad_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assessment_medical_histories', function (Blueprint $table) {
            $table->string('dm')->nullable();
            $table->string('htn')->nullable();
            $table->string('asthma')->nullable();
            $table->string('cad')->nullable();
            $table->dropColumn(['dm_htn_asthma_cad_details', 'dm_htn_asthma_cad_date']);
        });
    }
};
