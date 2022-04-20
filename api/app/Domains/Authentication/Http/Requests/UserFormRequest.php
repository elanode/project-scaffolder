<?php

namespace App\Domains\Authentication\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->isMethod('POST')) {
            return $this->postRules();
        }

        return $this->putRules();
    }

    private function defaultRules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:250'],
            'email' => ['required', 'email'],
            'password' => ['present', 'nullable'],
        ];
    }

    private function postRules(): array
    {
        return array_merge($this->defaultRules(), [
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
            ]
        ]);
    }

    private function putRules(): array
    {
        return array_merge($this->defaultRules(), [
            //
        ]);
    }
}
