<?php

namespace App\V1\API\Requests\Customers;


use App\V1\API\Requests\ValidatorBase;
use App\V1\API\Requests\ValidatorCustom;
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
            'email'             => 'required|email|unique:customers,email|max:255',
            'first_name'        => 'required|string|max:255',
            'last_name'         => 'required|string|max:255',
            'company_name'      => 'nullable|string|max:255',
            'phone'             => 'required|phone',
            'service_id'        => 'required|exists:services,id',
            'position_name'     => 'nullable|max:255',
            'contact_funnel_id' => 'nullable|exists:contact_funnels,id',
            'contact_source_id' => 'nullable|exists:contact_sources,id',
            'lead_status_id'    => 'nullable|exists:lead_statuses,id',
            'contact_id'        => 'nullable|exists:users,id',
            'message'           => 'nullable',
            'avatar'            => 'nullable|image|max:3024|mimes:jpg,jpeg,png,bmp,gif,svg,webp,mp4,ogx,oga,ogv,ogg,webm',
        ];
    }
}
