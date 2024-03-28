<?php

namespace App\V1\API\Requests\Companies;


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
            'name'          => 'required|string|max:255',
            'domain'        => 'nullable|unique:companies,domain|max:255|active_url',
            'contact_id'    => 'nullable|exists:users,id',
            'industry_id'   => 'nullable|exists:industries,id',
            'address'       => 'nullable|string',
            'phone'         => 'nullable|phone',
            'facebook_link' => 'nullable|url',
            'linkedin_link' => 'nullable|url',
            'description'   => 'nullable',
            'image'         => 'nullable|image|max:3024|mimes:jpg,jpeg,png,bmp,gif,svg,webp,mp4,ogx,oga,ogv,ogg,webm',
        ];
    }
}
