<?php

namespace App\Http\Resources;

use App\Models\Deals;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use mysql_xdevapi\Collection;

class TypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $id=User::where('discount_type_id',$this->id)->pluck('id');
        return [
            'uuid'=>$this->id,
            'title'=>$this->name,
            'deals'=>Deals::whereIn('user_id',$id)->get()
        ];

    }
}
