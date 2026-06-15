<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:50',
            'sct_no' => 'nullable|string|max:255',
            'age' => 'required|integer|min:0',
            'gender' => 'required|string|in:Male,Female,Other',
            'phone' => 'required|string|max:20',
            'diagnosis' => 'nullable|string',
            'address' => 'nullable|string',
            'route_map' => 'nullable|string',
            'pincode' => 'nullable|string|max:10',
            'referred_by' => 'nullable|string|max:255',
            'hospital_department' => 'nullable|string|max:255',
            'caregivers' => 'required|array|min:1',
            'caregivers.*.name' => 'required|string|max:255',
            'caregivers.*.relation' => 'required|string|max:255',
            'caregivers.*.contact_no' => 'required|string|max:20',
        ];
    }
}
