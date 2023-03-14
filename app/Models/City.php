<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory , HasTranslations;
    protected $primaryKey = 'uuid';
    public $incrementing = false;
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
    public static function boot()
    {
        parent::boot();
        self::creating(function ($car) {
            $car->uuid = Str::uuid();
        });


    }
}
