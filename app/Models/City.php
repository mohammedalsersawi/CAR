<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory , HasTranslations;
    protected $translatable = ['name'];
    protected $guarded = [];
    protected $appends = ['name_text','name_Country'];


    public function country(){
        return @$this->belongsTo(Country::class);
    }
    public function getNameCountryAttribute()
    {
        return @$this->country->name;
    }
    public function getNameTextAttribute()
    {
        return @$this->name;
    }
}
