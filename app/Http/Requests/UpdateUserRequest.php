<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->role === 'Admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->route('user');
        $isSelf = auth()->id() === $user->id;

        $rules = [
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                Rule::unique('users')->ignore($user->id),
            ],
            'role' => ['required', 'string', 'in:Admin,Staff'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];

        if ($isSelf) {
            $rules['role'] = ['required', 'string', Rule::in([$user->role])];
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'role.in' => 'You cannot change your own role.',
        ];
    }
}
