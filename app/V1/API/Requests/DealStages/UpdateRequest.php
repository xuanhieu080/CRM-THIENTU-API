<?php

namespace App\V1\API\Requests\DealStages;


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
                'nullable',
                'string',
                'max:255',
                Rule::unique('deal_stages', 'name')->ignore($this->route('deal_stage')->id)
            ],
            'description' => 'nullable|max:300',
            'is_default'  => 'nullable|in:1,2,false,true'
        ];
    }
}
