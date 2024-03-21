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
        ];
    }
}
