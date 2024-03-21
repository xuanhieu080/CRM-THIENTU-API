<?php

namespace App\V1\API\Requests\ContactSources;


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
                Rule::unique('contact_sources', 'name')->ignore($this->route('contact_source')->id)
            ],
            'description' => 'nullable|max:300',
            'is_default'  => 'nullable|in:1,2,false,true'
        ];
    }
}
