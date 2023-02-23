<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Area extends Model
{
    use HasFactory , HasTranslations;

    protected $translatable = ['name'];
    protected $guarded = [];
    protected $appends = ['name_text','name_city'];

    public function getNameTextAttribute()
    {
        return @$this->name;
    }

    public function cites(){
        return @$this->belongsTo(City::class,'city_id');
    }

    public function getNameCityAttribute()
    {
        return @$this->cites->name;
    }
}
