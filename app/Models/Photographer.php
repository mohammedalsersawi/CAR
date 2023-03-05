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
    public $incrementing = false;
    public function uploudphotographer()
    {
        return $this->morphOne(Image::class, 'imageable');
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
