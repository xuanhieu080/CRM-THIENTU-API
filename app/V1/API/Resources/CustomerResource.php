<?php

namespace App\V1\API\Resources;

use App\Models\ContactSource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

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
            'full_name'         => $this->full_name,
            'email'             => $this->email,
            'phone'             => $this->phone,
            'avatar'            => $this->avatar_url,
            'position_name'     => $this->position_name,
            'message'           => $this->message,
            'last_updated_at'   => Carbon::parse($this->last_updated_at)->format('d-m-Y H:i:s'),
            'created_at'        => Carbon::parse($this->created_at)->format('d-m-Y H:i:s'),
            'contact_funnel_id' => $this->contact_funnel_id,
            'contact_funnel'    => new ContactFunnelResource($this->contactFunnel),
            'contact_source_id' => $this->contact_source_id,
            'contact_source'    => new ContactSourceResource($this->contactSource),
            'lead_status_id'    => $this->lead_status_id,
            'lead_status'       => new LeadStatusResource($this->leadStatus),
            'contact_id'        => $this->contact_id,
            'contact'           => new UserResource($this->contact),
            'service_id'        => $this->service_id,
            'service'           => new ServiceResource($this->service),
            'companies'         => CompanyResource::collection($this->companies),
        ];

        return $data;
    }
}
