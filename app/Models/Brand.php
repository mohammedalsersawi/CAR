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
    protected $fillable = [
        'name',
    ];
    protected $appends = ['name_text'];


    public function avatar()
    {
        return $this->belongsTo(Upload::class, 'id','relation_id')->where('file_type','brands');
    }

    public function getNameTextAttribute()
    {
        return @$this->name;
    }
    public static function createWithRooms(Request $request){
        DB::beginTransaction();
        try {
            $brands=Brand::create([
                'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
            ]);
            ImageUpload::UploadImage($request->image, 'brands', $brands->id , 17);
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

    }
    public static function updateWithRooms(Request $request){
        DB::beginTransaction();
        try {
            $brands = Brand::find($request->id);
            $brands->update([
                'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
            ]);
            if($request->hasFile('image')){
                ImageUpload::UploadImage($request->image, 'brands' ,null, null ,$request->id);
            }
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

    }


    protected static function booted()
    {
        static::deleted(function ($brand) {
            File::delete(public_path('uploads/'.$brand->avatar->full_small_path));
            $brand->avatar()->delete();
        });

    }

}
