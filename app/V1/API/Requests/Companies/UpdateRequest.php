<?php

namespace App\V1\API\Requests\Companies;


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
            'name'             => [
                'required',
                'string',
                'max:255',
                Rule::unique('services', 'name')->ignore($this->route('customer')->id)
            ],
        ];
    }
}
