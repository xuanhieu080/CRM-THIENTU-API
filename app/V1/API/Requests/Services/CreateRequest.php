<?php

namespace App\V1\API\Requests\Services;


use App\V1\API\Requests\ValidatorBase;
use Illuminate\Validation\Rule;

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
            'name'        => 'required|unique:services,name|max:255',
            'description' => 'nullable|max:300',
        ];
    }
}
