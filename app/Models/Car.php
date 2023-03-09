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
        'color_interior',
        'color_exterior',
        'year',
        'model',
        'transmission',
        'model_id',
        'brand_id',
        'transmission_id',
        'user_id',
        'color_interior_id',
        'color_exterior_id',
        'fule_type_id',
        'engine_id',
        'updated_at',
        'created_at'

    ];
    protected $guarded = [];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function ImagesCar()
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
        return @$this->color_interior->name;
    }
    public function getColorExteriorAttribute()
    {
        return @$this->color_exterior->name;
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
