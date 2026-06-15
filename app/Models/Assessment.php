<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessment_id',
        'patient_id',
        'assessment_date',
        'distress_meter',
        'status',
        'created_by',
    ];

    protected static function booted()
    {
        static::creating(function ($assessment) {
            if (empty($assessment->assessment_id)) {
                $latest = Assessment::latest('id')->first();
                $lastId = $latest ? (int) str_replace('ASM', '', $latest->assessment_id) : 0;
                $assessment->assessment_id = 'ASM' . str_pad($lastId + 1, 6, '0', STR_PAD_LEFT);
            }
        });
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function symptoms(): HasMany
    {
        return $this->hasMany(AssessmentSymptom::class);
    }

    public function complaints(): HasMany
    {
        return $this->hasMany(AssessmentComplaint::class);
    }

    public function pains(): HasMany
    {
        return $this->hasMany(AssessmentPain::class);
    }

    public function medicalHistory(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(AssessmentMedicalHistory::class);
    }

    public function medication(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(AssessmentMedication::class);
    }
}
