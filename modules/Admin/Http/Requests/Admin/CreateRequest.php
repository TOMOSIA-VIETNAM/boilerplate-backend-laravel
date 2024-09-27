<?php

namespace Modules\Admin\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'unique:admins,email'],
            'password' => ['required', 'string', 'confirmed'],
            'password_confirmation'  => ['required', 'string'],
            'role_user' => ['required', 'integer', 'exists:roles,id']
        ];
    }

    /**
     * @return array
     */
    public function onlyFields(): array
    {
        return $this->only([
            'email',
            'password',
            'role_user'
        ]);
    }
}
