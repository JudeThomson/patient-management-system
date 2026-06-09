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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('patient_id')->unique();
            $table->string('sct_no')->nullable();
            $table->string('name');
            $table->integer('age');
            $table->string('gender');
            $table->string('phone');
            $table->text('diagnosis')->nullable();
            $table->text('address')->nullable();
            $table->string('pincode')->nullable();
            $table->string('referred_by')->nullable();
            $table->string('hospital_department')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
