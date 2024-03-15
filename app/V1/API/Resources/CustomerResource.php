<?php

namespace App\V1\API\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'id'                  => $this->id,
            'first_name'          => $this->first_name,
            'last_name'           => $this->last_name,
            'email'               => $this->email,
            'phone'               => $this->phone,
            'avatar'              => $this->avatar_url,
            'position_name'       => $this->position_name,
            'message'             => $this->message,
            'contact_funnel_id'   => $this->contact_funnel_id,
            'contact_funnel_name' => object_get($this, 'contactFunnel.name'),
            'contact_source_id'   => $this->contact_source_id,
            'contact_source_name' => object_get($this, 'contactSource.name'),
            'lead_status_id'      => $this->lead_status_id,
            'lead_status_name'    => object_get($this, 'leadStatus.name'),
            'contact_id'          => $this->contact_id,
            'contact_name'        => object_get($this, 'contact.name'),
            'service_id'          => $this->service_id,
            'service_name'        => object_get($this, 'service.name'),
        ];

        return $data;
    }
}
