<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModelCar extends Model
{
    use HasFactory, HasTranslations;
    public $translatable = ['name'];
    protected $fillable = [
        'name',
        'brand_uuid'
    ];
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $hidden=['name'];
    protected $appends = ['name_text'];
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_uuid');
    }
    public function getNameTextAttribute()
    {
        return @$this->name;
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($modelCar) {
            $modelCar->uuid = Str::uuid();
        });

    }
}
