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
    protected $appends=['year_to','year_from','images','brand_name','model_name'];
    protected $guarded = [];
    public function image()
    {
        return $this->morphMany(Image::class, 'imageable');
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
    public function getBrandNameAttribute()
    {
        return @$this->brand->name;
    }
    public function getmodelNameAttribute()
    {
        return @$this->model->name;
    }
    public function getImagesAttribute()
    {
        $image=[];
        foreach ($this->image as $item) {
            array_push($image,'uploads/'.$item->filename);
        }
        return $image;
    }
    public static function boot()
    {
        parent::boot();
        self::creating(function ($car) {
            $car->uuid = Str::uuid();
        });
        self::deleted(function ($car) {
            foreach ($car->image as $item) {
                File::delete(public_path('uploads/'.$item->filename));
            }
            $car->image()->delete();
        });

    }
}
