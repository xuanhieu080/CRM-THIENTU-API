<?php

namespace App\V1\API\Requests\Customers;


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
            'email'             => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('customers', 'email')->ignore($this->route('customer')->id)
            ],
            'first_name'        => 'nullable|string|max:255',
            'last_name'         => 'nullable|string|max:255',
            'company_name'      => 'nullable|string|max:255',
            'phone'             => [
                'nullable',
                'phone',
                Rule::unique('customers', 'phone')->ignore($this->route('customer')->id)
            ],
            'position_name'     => 'nullable|max:255',
            'service_id'        => 'nullable|exists:services,id',
            'contact_funnel_id' => 'nullable|exists:contact_funnels,id',
            'contact_source_id' => 'nullable|exists:contact_sources,id',
            'lead_status_id'    => 'nullable|exists:lead_statuses,id',
            'contact_id'        => 'nullable|exists:users,id',
            'message'           => 'nullable',
        ];
    }
}
