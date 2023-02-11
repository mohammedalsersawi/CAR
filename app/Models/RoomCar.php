<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class RoomCar extends Model
{
    use HasFactory, HasTranslations;
    public $translatable = ['name','city'];
    protected $guarded=[];
    public function avatar()
    {
        return $this->belongsTo(Upload::class, 'id','relation_id')->where('file_type','rooms');
    }
}
