<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Car extends Model
{
    use HasFactory;
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $appends=['year_to','year_from'];
    protected $guarded = [];
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function brand(){
        return $this->belongsTo(Brand::class,'brand_id');
    }
    public function engine(){
        return $this->belongsTo(Engine::class,'engine_id');
    }
    public function fueltype(){
        return $this->belongsTo(FuelType::class,'fule_type_id');
    }
    public function color_interior(){
        return $this->belongsTo(ColorCar::class,'color_interior_id');
    }
    public function color_exterior(){
        return $this->belongsTo(ColorCar::class,'color_exterior_id');
    }
    public function year(){
        return $this->belongsTo(Year::class,'year_id');
    }
    public function model(){
        return $this->belongsTo(ModelCar::class,'model_id');
    }
    public function transmission(){
        return $this->belongsTo(Transmission::class,'transmission_id');
    }
    public function specification(){
        return $this->hasMany(Specification::class,'car_id');
    }
    public function getYearToAttribute()
    {
        return @$this->year->to;
    }
    public function getYearFromAttribute()
    {
        return @$this->year->from;
    }
    public static function boot()
    {
        parent::boot();
        self::creating(function ($car) {
            $car->uuid = Str::uuid();
        });
        self::deleted(function ($car) {
            File::delete(public_path('uploads/'.$car->image->filename));
            $car->image()->delete();
        });

    }
}
