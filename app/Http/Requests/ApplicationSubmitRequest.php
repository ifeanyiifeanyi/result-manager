<?php

namespace App\Http\Requests;

use App\Models\AcademicSession;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ApplicationSubmitRequest extends FormRequest
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
    public function rules()
    {
        return [
            'answers' => 'required|array',
            'answers.*' => function ($attribute, $value, $fail) {
                // Extract the question ID from the attribute (e.g., 'answers.1')
                $questionId = explode('.', $attribute)[1];
                $activeSession = AcademicSession::active();
                $question = $activeSession->questions->firstWhere('id', $questionId);

                if (!$question) {
                    $fail('Invalid question');
                    return;
                }

                // Validation based on question type
                switch ($question->type) {
                    case 'text':
                    case 'textarea':
                        if ($question->is_required && empty(trim($value))) {
                            $fail(__('This field is required.'));
                        }
                        break;

                    case 'radio':
                    case 'options':
                        $options = $this->getQuestionOptions($question);
                        if ($question->is_required && !in_array($value, $options)) {
                            $fail(__('Please select a valid option.'));
                        }
                        break;

                    case 'checkbox':
                        $options = $this->getQuestionOptions($question);
                        if ($question->is_required && empty($value)) {
                            $fail(__('At least one option must be selected.'));
                        }
                        if (!empty($value)) {
                            $invalidOptions = array_diff($value, $options);
                            if (!empty($invalidOptions)) {
                                $fail(__('Invalid options selected.'));
                            }
                        }
                        break;

                    case 'file':
                        $file = $this->file($attribute);
                        if ($question->is_required && !$file) {
                            $fail(__('A file must be uploaded.'));
                        }
                        if ($file) {
                            $validator = Validator::make(
                                ['file' => $file],
                                ['file' => [
                                    'file',
                                    'mimes:pdf,doc,docx,jpg,jpeg,png',
                                    'max:5120' // 5MB max
                                ]]
                            );

                            if ($validator->fails()) {
                                $fail($validator->errors()->first());
                            }
                        }
                        break;
                }
            }
        ];
    }

    /**
     * Helper method to get question options
     */
    private function getQuestionOptions($question)
    {
        $decodedOptions = is_string($question->options)
            ? json_decode($question->options, true)
            : $question->options;

        return isset($decodedOptions['options']) && is_array($decodedOptions['options'])
            ? $decodedOptions['options']
            : [];
    }
}
