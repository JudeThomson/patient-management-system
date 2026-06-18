<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'sct_no',
        'name',
        'age',
        'gender',
        'phone',
        'diagnosis',
        'address',
        'route_map',
        'pincode',
        'referred_by',
        'hospital_department',
        'doctor',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::creating(function ($patient) {
            if (empty($patient->patient_id)) {
                $latestPatient = Patient::latest('id')->first();
                $lastId = $latestPatient ? (int) str_replace('PAT', '', $latestPatient->patient_id) : 0;
                $patient->patient_id = 'PAT' . str_pad($lastId + 1, 6, '0', STR_PAD_LEFT);
            }
        });
    }

    public function caregivers(): HasMany
    {
        return $this->hasMany(Caregiver::class);
    }

    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class);
    }
}
