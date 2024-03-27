<?php

namespace App\V1\API\Requests\Users;


use App\V1\API\Requests\ValidatorBase;
use Illuminate\Validation\Rule;

class UpdateRequest extends ValidatorBase
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'      => 'nullable|email|unique:users,email|max:255',
            'first_name' => 'nullable|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'username'   => [
                'nullable',
                'string',
                'regex:/^[a-zA-Z0-9]+$/',
                'max:255',
                Rule::unique('users', 'username')->ignore($this->route('user')->id)
            ],
            'password'   => [
                'nullable',
                'min:8',
                'max:255',
                function ($attribute, $value, $fail) {
                    $containsUpper = preg_match('/[A-Z]/', $value);
                    $containsLower = preg_match('/[a-z]/', $value);
                    $containsNumber = preg_match('/[0-9]/', $value);
                    $containsDigit = preg_match('/\d/', $value);
                    $containsSpecial = preg_match('/[^a-zA-Z\d]/', $value);

                    if (strlen($value) < 8 || !$containsDigit || !$containsUpper || !$containsLower || !$containsNumber || !$containsSpecial) {
                        return $fail(__("Password has at least one number, special char, upper case, lower case and greater than 8 digits!"));
                    }
                }
            ],
        ];
    }
}
