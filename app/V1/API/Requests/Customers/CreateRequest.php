<?php

namespace App\V1\API\Requests\Customers;


use App\V1\API\Requests\ValidatorCustom;

class CreateRequest extends ValidatorCustom
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'        => 'required|email|unique:customers,email|max:255',
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'phone'        => 'required|phone',
            'service_id'   => 'required|exists:services,id',
            'message'      => 'nullable',
            'avatar'       => 'nullable|image|max:3024|mimes:jpg,jpeg,png,bmp,gif,svg,webp,mp4,ogx,oga,ogv,ogg,webm',
        ];
    }
}
