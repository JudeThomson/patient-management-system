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
        'illness_details',
        'doctor_hospital',
        'doctor_hospital_2',
        'doctor_hospital_3',
        'diagnosed_at',
        'surgery',
        'radiation',
        'chemotherapy',
        'colostomy',
        'renal_problems',
        'dm',
        'htn',
        'asthma',
        'cad',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }
}
