<?php

namespace App\V1\API\Resources;

use App\Models\ContactSource;
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
            'id'                => $this->id,
            'first_name'        => $this->first_name,
            'last_name'         => $this->last_name,
            'email'             => $this->email,
            'phone'             => $this->phone,
            'avatar'            => $this->avatar_url,
            'position_name'     => $this->position_name,
            'message'           => $this->message,
            'last_updated_at'   => $this->last_updated_at,
            'contact_funnel_id' => $this->contact_funnel_id,
            'contact_funnel'    => new ContactFunnelResource($this->contactFunnel),
            'contact_source_id' => $this->contact_source_id,
            'contact_source'    => new ContactSourceResource($this->contactSource),
            'lead_status_id'    => $this->lead_status_id,
            'lead_status'       => new LeadStatusResource($this->leadStatus),
            'contact_id'        => $this->contact_id,
            'contact'           => new UserResource($this->contactZ),
            'service_id'        => $this->service_id,
            'service'           => new ServiceResource($this->service),
        ];

        return $data;
    }
}
