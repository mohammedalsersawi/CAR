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
            "id"=> $this->id,
            "phone"=> $this->phone,
            "lat"=> $this->lat,
            "lng"=> $this->lng,
            "type"=> $this->type_name,
            "image"=> 'uploads/'.$this->image_user

        ];
    }
}
