<?php

namespace Modules\Admin\Http\Requests\Permission;

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
            'role_user' => ['required', 'integer']
        ];
    }

    /**
     * @return array
     */
    public function onlyFields(): array
    {
        return $this->only([
            'role_user'
        ]);
    }
}
