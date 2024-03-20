<?php

namespace App\V1\API\Requests\LeadStatus;


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
                Rule::unique('lead_statuses', 'name')->ignore($this->route('lead_statuse')->id)
            ],
        ];
    }
}
