<?php

namespace App\V1\API\Requests\Industries;


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
            'name'        => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('industries', 'name')->ignore($this->route('industry')->id)
            ]
        ];
    }
}
