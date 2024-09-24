<?php

namespace Modules\Api\Http\Requests\User;

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
            'email' => ['required', 'string', 'email', 'unique:users,email,' . auth()->guard('api')->user()->id],
            'name' => ['required', 'string'],
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
            'name',
            'avatar'
        ]);
    }
}
