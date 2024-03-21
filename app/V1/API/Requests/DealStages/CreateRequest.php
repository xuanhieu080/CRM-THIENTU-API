<?php

namespace App\V1\API\Requests\DealStages;


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
            'name'        => 'required|unique:deal_stages,name|max:255',
            'description' => 'nullable|max:300',
            'percent'     => 'nullable|numeric|min:0|max:100',
        ];
    }
}
