<?php

namespace App\V1\API\Requests\Customers;


use App\V1\API\Requests\ValidatorBase;
use Illuminate\Validation\Rule;

class DeleteRequest extends ValidatorBase
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'required|exists:customers,id',
        ];
    }
}
