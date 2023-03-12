<?php

namespace App\Models;
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
        'city_uuid',
        'area_uuid',
        'updated_at',
        'created_at',
        'user_uuid',
        'user',
        'city',
        'area'
    ];
    public $incrementing = false;
    protected $appends = ['area_name', 'city_name', 'photographer'];

    public function uploudphotographer()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    const define=2;
    const undefine=1;
    public static function boot()
    {
        parent::boot();
        self::creating(function ($photographer) {
            $photographer->uuid = Str::uuid();
        });
        self::deleted(function ($photographer) {
            File::delete(public_path('uploads/' . $photographer->uploudphotographer->filename));
            $photographer->uploudphotographer()->delete();
        });
    }

    public const TYPES = [
        1 => 'image',
        2 => 'imageVideo',
    ];
    public function photographerr()
    {
        return $this->belongsTo(User::class, 'photographer_uuid');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid');
    }

    public function city()
    {
        return @$this->belongsTo(City::class);
    }
    public function area()
    {
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
    public function getPhotographerAttribute()
    {
        return @$this->photographerr->name;
    }
}
