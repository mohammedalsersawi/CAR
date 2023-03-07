<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Photographer extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $primaryKey = 'uuid';
    protected $appends = ['city_name','area_name'];
    protected $hidden=[
        'city_id',
        'area_id',
        'city',
        'area'
    ];
    public $incrementing = false;
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
        self::creating(function ($car) {
            $car->uuid = Str::uuid();
        });
        self::deleted(function ($car) {
            foreach ($car->uploudphotographer as $item) {
                File::delete(public_path('uploads/'.$item->filename));
            }
            $car->uploudphotographer()->delete();
        });

    }
}
