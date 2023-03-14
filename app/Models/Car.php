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
    protected $appends=['images','brand_name','model_name','user_name','transmission_name','color_interior','color_exterior','engine_name','fueltype_name'];
    protected $hidden=[
      'user',
        'ImagesCar',
        'brand',
        'engine',
        'fueltype',
        'color_exterior_uuid',
        'color_interior_uuid',
        'model',
        'transmission',
        'model_uuid',
        'brand_uuid',
        'transmission_uuid',
        'user_uuid',
        'color_exterior_car',
        'color_interior_car',
        'fule_type_uuid',
        'engine_uuid',
        'updated_at',
        'created_at'

    ];
    protected $guarded = [];
    public function user(){
        return $this->belongsTo(User::class,'user_uuid');
    }
    public function ImagesCar()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
    public function brand(){
        return $this->belongsTo(Brand::class,'brand_uuid');
    }
    public function engine(){
        return $this->belongsTo(Engine::class,'engine_uuid');
    }
    public function fueltype(){
        return $this->belongsTo(FuelType::class,'fule_type_uuid');
    }
    public function color_interior_car(){
        return $this->belongsTo(ColorCar::class,'color_interior_uuid');
    }
    public function color_exterior_car(){
        return $this->belongsTo(ColorCar::class,'color_exterior_uuid');
    }
    public function year(){
        return $this->belongsTo(Year::class,'year_uuid');
    }
    public function model(){
        return $this->belongsTo(ModelCar::class,'model_uuid');
    }
    public function transmission(){
        return $this->belongsTo(Transmission::class,'transmission_uuid');
    }
    public function specification(){
        return $this->hasMany(Specification::class,'car_uuid');
    }
    public function getBrandNameAttribute()
    {
        return @$this->brand->name;
    }
//    public function getSpecificationNameAttribute()
//    {
//        return @$this->specification->name;
//    }
    public function gettransmissionNameAttribute()
    {
        return @$this->transmission->name;
    }
    public function getUserNameAttribute()
    {
        return @$this->user->name;
    }
    public function getmodelNameAttribute()
    {
        return @$this->model->name;
    }
    public function getFueltypeNameAttribute()
    {
        return @$this->fueltype->name;
    }
    public function getEngineNameAttribute()
    {
        return @$this->engine->name;
    }
    public function getColorInteriorAttribute()
    {
        return @$this->color_interior_car->color;
    }
    public function getColorExteriorAttribute()
    {
        return @$this->color_exterior_car->color;
    }
    public function getImagesAttribute()
    {
        $images=[];
        foreach ($this->ImagesCar as $item) {
            array_push($images,url()->previous().'uploads/'.$item->filename);
        }
        return $images;
    }
    public static function boot()
    {
        parent::boot();
        self::creating(function ($car) {
            $car->uuid = Str::uuid();
        });
        self::deleted(function ($car) {
            foreach ($car->images as $item) {
                File::delete(public_path('uploads/'.$item->filename));
            }
            $car->ImagesCar()->delete();
        });

    }


}
