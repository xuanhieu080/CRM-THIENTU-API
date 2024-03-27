<?php

namespace App\V1\API\Requests\Users;


use App\V1\API\Requests\ValidatorBase;

class CreateRequest extends ValidatorBase
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'      => 'required|email|unique:users,email|max:255',
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'username'   => 'required|regex:/^[a-zA-Z0-9]+$/|string|unique:users,username|max:255',
            'password'   => [
                'required',
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
