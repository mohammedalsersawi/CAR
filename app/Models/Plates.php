<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Plates extends Model
{
    use HasFactory;
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $guarded=[];
    protected $appends = ['city_name'];

    public function city(){
        return @$this->belongsTo(City::class);
    }

    public function getCityNameAttribute()
    {
        return @$this->city->name;
    }
    public static function boot()
    {
        parent::boot();
        self::creating(function ($photographer) {
            $photographer->uuid = Str::uuid();
        });
    }
}
