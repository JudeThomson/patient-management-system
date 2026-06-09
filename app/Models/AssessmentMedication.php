<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssessmentMedication extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessment_id',
        'diabetes_medicine',
        'bp_medicine',
        'chemo_medicine',
        'pain_medicine',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }
}
