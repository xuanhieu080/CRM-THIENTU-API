<?php

namespace App\V1\API\Requests\Users;


use App\V1\API\Requests\ValidatorCustom;

class CreateRequest extends ValidatorCustom
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
        ];
    }
}
