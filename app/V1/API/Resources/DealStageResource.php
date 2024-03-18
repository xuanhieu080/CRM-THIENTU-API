<?php

namespace App\V1\API\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DealStageResource extends JsonResource
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
            'id'   => $this->id,
            'name' => $this->name,
        ];

        return $data;
    }
}
