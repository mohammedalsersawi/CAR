<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class profileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "uuid"=> $this->uuid,
            "name"=> $this->name,
            "phone"=> $this->phone,
            "lat"=> $this->lat,
            "lng"=> $this->lng,
            "type"=> $this->type_name,
            "image"=> $this->image_user

        ];
    }
}
