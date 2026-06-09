<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssessmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'assessment_date' => 'required|date',
            'centre' => 'required|string|max:255',
            'distress_meter' => 'required|integer|min:0|max:10',
            'status' => 'required|string|in:Draft,Completed',
            'symptoms' => 'nullable|array',
            'complaints' => 'nullable|array',
            'complaints.*' => 'nullable|string',
            'pains' => 'nullable|array',
            'pains.*.pain_label' => 'required|string|in:A,B,C,D',
            'pains.*.duration' => 'nullable|string',
            'pains.*.continuous_intermittent' => 'nullable|string',
            'pains.*.pain_score' => 'nullable|integer|min:0|max:10',
            'pains.*.radiation' => 'nullable|string',
            'pains.*.quality' => 'nullable|string',
            'pains.*.provoking_factors' => 'nullable|string',
            'pains.*.palliating_factors' => 'nullable|string',
            'pains.*.impact_on_adls' => 'nullable|string',
            'pains.*.impact_on_person' => 'nullable|string',
            'medical_history' => 'nullable|array',
            'medical_history.*.details' => 'nullable|string',
            'medical_history.*.date' => 'nullable|date',
            'medication' => 'nullable|array',
            'medication.diabetes_medicine' => 'nullable|string',
            'medication.bp_medicine' => 'nullable|string',
            'medication.chemo_medicine' => 'nullable|string',
            'medication.pain_medicine' => 'nullable|string',
        ];
    }
}
