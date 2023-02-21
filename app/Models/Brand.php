<?php

namespace App\Models;

use App\Models\Upload;
use App\Utils\ImageUpload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $translatable = ['name'];
    protected $guarded=[];

    protected $appends = ['name_text'];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
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
