<?php

namespace App\V1\API\Requests\LeadStatus;


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
            'name'        => 'required|unique:lead_statuses,name|max:255',
        ];
    }
}
