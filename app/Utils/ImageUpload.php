<?php

namespace App\Utils;

use App\Models\Upload;
use Illuminate\Support\Facades\File;

class ImageUpload
{

    public static function UploadImage($file, $file_type, $relation_id=null, $folder = null, $update_id = null)
    {
        $imagename = uniqid() . '.' . $file->getClientOriginalExtension();
        $full_original_path = $file->move(public_path('uploads'), $imagename);
        if ($update_id == null) {
            $Upload = new Upload();
            $Upload->file_type = $file_type;
            $Upload->relation_id = $relation_id;
            $Upload->full_original_path = $full_original_path;
            $Upload->full_small_path = $imagename;
            $Upload->save();
        }else {
            $Upload = Upload::where(['relation_id' => $update_id , 'file_type' => $file_type])->first();
            File::delete(public_path('uploads/' . $Upload->full_small_path));
            $Upload->update([
                'full_small_path' => $imagename,
                'full_original_path' => $full_original_path,

            ]);
        }
    }
}
