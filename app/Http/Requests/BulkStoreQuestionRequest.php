<?php

namespace App\Http\Requests;

use App\Models\Question;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class BulkStoreQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Question::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'academic_session_id' => ['required', 'exists:academic_sessions,id'],
            'questions' => ['required', 'array', 'min:1'],
            'questions.*.id' => ['sometimes', 'exists:questions,id'],
            'questions.*.title' => ['required', 'string', 'max:255'],
            'questions.*.type' => [
                'required',
                Rule::in(['text', 'textarea', 'radio', 'checkbox', 'file']),
            ],
            'questions.*.options' => [
                'required_if:questions.*.type,radio,checkbox',
                'json',
            ],
            'questions.*.is_required' => ['boolean'],
        ];
    }

       /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'questions.*.title' => 'question title',
            'questions.*.type' => 'question type',
            'questions.*.options' => 'question options',
            'questions.*.is_required' => 'required status',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'questions.*.options.required_if' => 'Options are required for multiple choice questions.',
            'questions.*.options.json' => 'Options must be a valid JSON string.',
        ];
    }
}
