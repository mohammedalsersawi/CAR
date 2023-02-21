<?php

namespace App\Utils;

use App\Models\Image;
use App\Models\Upload;
use Illuminate\Support\Facades\File;

class ImageUpload
{

    public static function UploadImage($file,$path=null,$model,$id,$update=false)
    {
        $imagename = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/'.$path), $imagename);
        if (!$update) {
            Image::create([
                'filename'=>  $imagename,
                'imageable_id'=>$id,
                'imageable_type'=>$model,
            ]);
        }else {
           $image= Image::where('imageable_id',$id)->first();
            File::delete(public_path('uploads/'.$path.$image->filename));
            $image->update([
                'filename'=>  $imagename,
                'imageable_id'=>$id,
                'imageable_type'=>$model,
            ]);


        }
    }
}
