<?php

namespace Modules\Admin\Http\Requests\Permission;

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
            'name' => ['required', 'string', 'max:50', 'unique:permissions,name'],
        ];
    }

    /**
     * @return array
     */
    public function onlyFields(): array
    {
        return $this->only([
            'name',
        ]);
    }
}
