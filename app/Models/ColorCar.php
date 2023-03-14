<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ColorCar extends Model
{
    use HasFactory;
    use HasTranslations;

    public $translatable = ['name'];
    protected $fillable = [
        'name',
        'color'
    ];
    protected $primaryKey = 'uuid';
    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($colorCar) {
            $colorCar->uuid = Str::uuid();
        });
    }

}
