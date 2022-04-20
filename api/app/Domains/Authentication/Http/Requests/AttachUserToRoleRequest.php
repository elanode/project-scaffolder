<?php

namespace App\Domains\Authentication\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttachUserToRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => ['required', 'numeric', 'exists:users,id'],
            'role_names' => ['required', 'array', 'min:1'],
            'role_names.*' => ['required', 'string', 'exists:roles,name'],
        ];
    }
}
