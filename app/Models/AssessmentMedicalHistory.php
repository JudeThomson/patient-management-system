<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssessmentMedicalHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessment_id',
        'problem_started_on',
        'problem_started_on_date',
        'illness_details',
        'illness_details_date',
        'doctor_hospital',
        'doctor_hospital_date',
        'doctor_hospital_2',
        'doctor_hospital_2_date',
        'doctor_hospital_3',
        'doctor_hospital_3_date',
        'diagnosed_at',
        'diagnosed_at_date',
        'surgery',
        'surgery_date',
        'radiation',
        'radiation_date',
        'chemotherapy',
        'chemotherapy_date',
        'colostomy',
        'colostomy_date',
        'renal_problems',
        'renal_problems_date',
        'dm_htn_asthma_cad_details',
        'dm_htn_asthma_cad_date',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }
}
