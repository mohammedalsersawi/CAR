<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class carresourse extends JsonResource
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
            "id"=> $this->uuid,
            "image"=> $this->images,
            "dest"=> $this->year_to.','.$this->brand_name.','.$this->model_name,

        ];
    }
}