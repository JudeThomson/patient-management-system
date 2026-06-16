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
            'assessment_date' => 'required|date|before_or_equal:today',
            'distress_meter' => 'required|integer|min:0|max:10',
            'status' => 'required|string|in:Draft,Completed',
            'symptoms' => 'nullable|array',
            'complaints' => 'nullable|array',
            'complaints.*' => 'nullable|string|min:5|max:500',
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
            'medical_history.*.details' => 'nullable|string|max:120',
            'medical_history.*.date' => 'nullable|date|before_or_equal:today',
            'medication' => 'nullable|array',
            'medication.diabetes_medicine' => 'nullable|string|max:120',
            'medication.bp_medicine' => 'nullable|string|max:120',
            'medication.chemo_medicine' => 'nullable|string|max:120',
            'medication.pain_medicine' => 'nullable|string|max:120',
        ];
    }

    public function messages(): array
    {
        return [
            'assessment_date.before_or_equal' => 'Assessment date cannot be in the future.',
            'medical_history.*.date.before_or_equal' => 'Future dates are not allowed.',
            'complaints.*.min' => 'Presenting complaints must be at least 5 characters.',
            'complaints.*.max' => 'Presenting complaints may not exceed 500 characters.',
            'medication.*.max' => 'Medication details may not exceed 120 characters.',
        ];
    }
}
