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
            'name'           => 'nullable|string|max:255',
            'domain'         => [
                'nullable',
                'max:255',
                'active_url',
                Rule::unique('companies', 'domain')->ignore($this->route('company')->id)
            ],
            'contact_id'     => 'nullable|exists:users,id',
            'industry_id'    => 'nullable|exists:industries,id',
            'lead_status_id' => 'nullable|exists:lead_statuses,id',
            'address'        => 'nullable|string',
            'facebook_link'  => 'nullable|url',
            'linkedin_link'  => 'nullable|url',
            'description'    => 'nullable',
            'image'          => 'nullable|image|max:3024|mimes:jpg,jpeg,png,bmp,gif,svg,webp,mp4,ogx,oga,ogv,ogg,webm',
        ];
    }
}
