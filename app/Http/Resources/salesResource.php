<?php

namespace App\Http\Resources;

use App\Models\Code_Deals;
use Illuminate\Http\Resources\Json\JsonResource;

class salesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
               $buyers =Code_Deals::where('deal_id',$this->id)->count();

        return [
            "name"=> $this->deals,
            "buyers"=> $buyers,


        ];
    }
}
