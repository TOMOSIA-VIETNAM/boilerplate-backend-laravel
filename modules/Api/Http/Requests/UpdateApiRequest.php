<?php

namespace Modules\Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'string|max:255',
            'type' => 'string|in:public,private,internal',
            'client_id' => 'exists:clients,id',
            'description' => 'nullable|string',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
            'rate_limit' => 'nullable|integer|min:1',
            'status' => 'string|in:active,inactive'
        ];
    }

    public function messages(): array
    {
        return [
            'name.max' => 'The name may not be greater than 255 characters.',
            'type.in' => 'The type must be one of: public, private, internal.',
            'client_id.exists' => 'The selected client is invalid.',
            'rate_limit.min' => 'The rate limit must be at least 1.',
            'status.in' => 'The status must be either active or inactive.',
            'permissions.array' => 'The permissions must be an array.',
            'permissions.*.exists' => 'One or more selected permissions are invalid.'
        ];
    }
} 