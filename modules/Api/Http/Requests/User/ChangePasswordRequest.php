<?php

namespace Modules\Api\Http\Requests\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'current_password' => 'required|string',
            'password' => ['required', 'string', 'confirmed'],
            'password_confirmation'  => ['required', 'string'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $auth = auth()->guard('api')->user();
            // Check if current password matches the user's password
            if (!Hash::check($this->current_password, $auth->password)) {
                $validator->errors()->add('current_password', 'Current password is invalid.');
            }

            // Check if new password is the same as the current password
            if (strcmp($this->current_password, $this->password) == 0) {
                $validator->errors()->add('password', 'New password cannot be the same as your current password.');
            }
        });
    }

    /**
     * @return array
     */
    public function onlyFields(): array
    {
        return $this->only([
            'password'
        ]);
    }
}
