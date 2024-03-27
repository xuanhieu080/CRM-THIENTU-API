<?php

namespace App\V1\API\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'id'            => $this->id,
            'name'          => $this->name,
            'domain'        => $this->domain,
            //            'email'            => $this->email,
            //            'phone'            => $this->phone,
            'image'         => $this->image_url,
            //            'address'          => $this->address,
            'description'   => $this->description,
            'facebook_link' => $this->facebook_link,
            'linkedin_link' => $this->linkedin_link,
            'industry_id'   => $this->industry_id,
            'industry'      => new IndustryResource($this->industry),
            //            'lead_status_id'   => $this->lead_status_id,
            //            'lead_status_name' => object_get($this, 'leadStatus.name'),
            'contact_id'    => $this->contact_id,
            'contact'       => new UserResource($this->contact),
            //            'contact_name'     => object_get($this, 'contact.name'),
        ];

        return $data;
    }
}
