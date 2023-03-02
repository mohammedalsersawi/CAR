<?php

namespace App\Models;

use App\Models\Upload;
use App\Utils\ImageUpload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $translatable = ['name'];

    protected $guarded=[];
protected $hidden=[
    'name',
    'imageBrand'
];
    protected $appends = ['name_text','image'];

    public function imageBrand()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function getImageAttribute()
    {
        return url()->previous().'/uploads/'.@$this->imageBrand->filename;
    }
    public function getNameTextAttribute()
    {
        return @$this->name;
    }
    protected static function booted()
    {
        self::deleted(function ($brand) {
            File::delete(public_path('uploads/'.$brand->image->filename));
            $brand->image()->delete();
        });

    }

}
