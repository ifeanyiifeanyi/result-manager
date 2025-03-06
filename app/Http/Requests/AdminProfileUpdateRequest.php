<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class AdminProfileUpdateRequest extends FormRequest
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
        $user = Auth::user();
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'other_names' => ['nullable', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', "unique:users,username,{$user->id}"],
            'email' => ['required', 'string', 'email', 'max:255', "unique:users,email,{$user->id}"],
            'phone' => ['required', 'string', 'max:255', "unique:users,phone,{$user->id}"],
            'id_number' => ['nullable', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'address_line_2' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'kin_contact_name' => ['nullable', 'string', 'max:255'],
            'kin_contact_relationship' => ['nullable', 'string', 'max:255'],
            'kin_contact_phone' => ['nullable', 'string', 'max:255'],
            'kin_contact_address' => ['nullable', 'string', 'max:255'],
        ];
    }
    protected function getRedirectUrl()
    {
        return route('admin.profile', ['tab' => 'edit']);
    }
}
