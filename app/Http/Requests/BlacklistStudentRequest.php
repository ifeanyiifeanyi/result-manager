<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class BlacklistStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return request()->user() && request()->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Only validate the blacklist reason if we're blacklisting
        if (!$this->student->is_blacklisted) {
            return [
                'blacklist_reason' => 'required|string|max:255',
            ];
        }

        return [];
    }

    public function student(): User
    {
        return $this->route('student');
    }

    public function blacklistReason(): string
    {
        return $this->input('blacklist_reason');
    }
}
