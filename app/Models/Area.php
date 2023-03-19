<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Area extends Model
{
    use HasFactory , HasTranslations;
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $translatable = ['name'];
    protected $guarded = [];
    protected $appends = ['name_text','name_city'];
protected $hidden=['name','uuid'];
    public function getNameTextAttribute()
    {
        return @$this->name;
    }

    public function cites(){
        return @$this->belongsTo(City::class,'city_uuid');
    }

    public function getNameCityAttribute()
    {
        return @$this->cites->name;
    }
    public static function boot()
    {
        parent::boot();
        self::creating(function ($area) {
            $area->uuid = Str::uuid();
        });

    }
}
