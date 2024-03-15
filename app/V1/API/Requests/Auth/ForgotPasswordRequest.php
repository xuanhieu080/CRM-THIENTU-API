<?php

namespace App\V1\API\Requests\Auth;

use App\V1\API\Requests\ValidatorBase;

class ForgotPasswordRequest extends ValidatorBase
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => [
                'required',
                'email',
                'exists:users,email',
//                function ($attribute, $value, $fail) {
//                    $item = PasswordReset::whereEmail($value)->first();
//                    if (!empty($item) && (strtotime($item->created_at) + 600) != time()) {
//                        return $fail(__('messages.unique', ['name' => "$attribute: #$value"]));
//                    }
//                }
            ],
        ];
    }
}
