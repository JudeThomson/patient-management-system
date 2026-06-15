<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientRequest extends FormRequest
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
            'name' => 'required|string|min:3|regex:/^[a-zA-Z\s]+$/',
            'sct_no' => 'nullable|string|max:15',
            'age' => 'required|integer|min:1|max:100',
            'gender' => 'required|string|in:Male,Female,Other',
            'phone' => 'required|digits:10',
            'diagnosis' => 'nullable|string|min:3|max:255',
            'address' => 'required|string|min:5|max:500',
            'route_map' => 'nullable|string|min:3|max:500',
            'pincode' => 'nullable|string|max:10',
            'referred_by' => 'nullable|string|max:255',
            'hospital_department' => 'nullable|string|min:3|max:50',
            'caregivers' => 'required|array|min:1',
            'caregivers.*.id' => 'nullable|exists:caregivers,id',
            'caregivers.*.name' => 'required|string|min:3|regex:/^[a-zA-Z\s]+$/',
            'caregivers.*.relation' => 'required|string|min:2|max:50|regex:/^[a-zA-Z\s]+$/',
            'caregivers.*.contact_no' => 'required|digits:10',
        ];
    }

    public function messages(): array
    {
        return [
            'name.regex' => 'Patient Name must contain only letters and spaces.',
            'phone.digits' => 'Phone Number must be exactly 10 digits.',
            'caregivers.*.name.regex' => 'Caregiver Name must contain only letters and spaces.',
            'caregivers.*.relation.regex' => 'Relationship must contain only letters and spaces.',
            'caregivers.*.contact_no.digits' => 'Contact Number must be exactly 10 digits.',
        ];
    }
}
