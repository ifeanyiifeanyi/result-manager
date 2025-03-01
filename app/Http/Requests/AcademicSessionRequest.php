<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class AcademicSessionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role->name == 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => 'nullable|string',
            'year' => 'required|date',
            'is_active' => 'boolean',
        ];

        // Add unique rule for name, except when updating existing record
        if ($this->method() === 'POST') {
            $rules['name'][] = 'unique:academic_sessions,name';
        } elseif ($this->method() === 'PUT' || $this->method() === 'PATCH') {
            $rules['name'][] = Rule::unique('academic_sessions', 'name')
                ->ignore($this->route('academicSession')->id ?? null);
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'The academic session name is required.',
            'name.unique' => 'This academic session name already exists.',
            'year.required' => 'The academic year is required.',
            'year.date_format' => 'The year must be in YYYY format.',
        ];
    }
}
