<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->user()->id),
            ],
        ];

        if ($this->user()->patient) {
            $rules['cin'] = ['required', 'string', 'max:20'];
            $rules['telephone'] = ['required', 'string', 'max:20'];
            $rules['date_naissance'] = ['required', 'date'];
        } else {
            $rules['cin'] = ['nullable'];
            $rules['telephone'] = ['nullable'];
            $rules['date_naissance'] = ['nullable'];
        }

        if ($this->user()->medecin) {
            $rules['specialite'] = ['required', 'string', 'max:255'];
        } else {
            $rules['specialite'] = ['nullable'];
        }

        return $rules;
    }
}
