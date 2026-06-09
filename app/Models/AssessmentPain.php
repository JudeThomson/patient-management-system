<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssessmentPain extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessment_id',
        'pain_label',
        'duration',
        'continuous_intermittent',
        'pain_score',
        'radiation',
        'quality',
        'provoking_factors',
        'palliating_factors',
        'impact_on_adls',
        'impact_on_person',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }
}
