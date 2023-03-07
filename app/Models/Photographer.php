<?php

namespace App\Models;

use App\Models\Area;
use App\Models\City;
use App\Models\User;
use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Photographer extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = 'uuid';
    protected $hidden=[
        'city_id',
        'area_id',
        'city',
        'area'
    ];
    public $incrementing = false;
    protected $appends = ['area_name', 'city_name', 'user_name'];

    public function uploudphotographer()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function city(){
        return @$this->belongsTo(City::class);
    }
    public function area(){
        return @$this->belongsTo(Area::class);
    }
    public function getCityNameAttribute()
    {
        return @$this->city->name;
    }
    public function getAreaNameAttribute()
    {
        return @$this->area->name;
    }
    public static function boot()
    {
        parent::boot();
        self::creating(function ($photographer) {
            $photographer->uuid = Str::uuid();
        });
    }

    protected static function booted()
    {
        static::deleted(function ($photographer) {
            File::delete(public_path('uploads/' . $photographer->uploudphotographer->filename));
            $photographer->uploudphotographer()->delete();
        });
    }

    public const TYPES = [
        1 => 'image',
        2 => 'imageVideo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getUserNameAttribute()
    {
        return @$this->user->name;
    }
}
