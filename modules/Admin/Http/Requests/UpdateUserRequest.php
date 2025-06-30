<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'string|max:255',
            'email' => 'email|unique:users,email,' . $this->route('id'),
            'password' => 'string|min:8',
            'role' => 'string',
            'department' => 'string',
            'status' => 'string|in:active,inactive',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ];
    }

    public function messages(): array
    {
        return [
            'name.max' => 'The name may not be greater than 255 characters.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'This email is already taken.',
            'password.min' => 'The password must be at least 8 characters.',
            'status.in' => 'The status must be either active or inactive.',
            'permissions.array' => 'The permissions must be an array.',
            'permissions.*.exists' => 'One or more selected permissions are invalid.'
        ];
    }
} 