<?php

namespace Modules\Admin\Http\Requests\User;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['nullable', 'string', 'email', 'unique:users,email,' . $this->id],
            'password' => ['nullable', 'string', 'required_with:password_confirmation', 'confirmed'],
            'password_confirmation'  => ['nullable', 'string'],
            'name' => ['nullable', 'string'],
            'avatar' => ['nullable', 'file', 'image', 'max:5120', 'file_extension:jpg,jpeg,png,webp', 'mimes:jpg,png,jpeg,webp', 'mimetypes:image/jpeg,image/png,image/webp'],
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
            'name',
            'avatar'
        ]);
    }
}
