<?php

namespace App\Models;

use App\Utils\ImageUpload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Spatie\Translatable\HasTranslations;

class RoomCar extends Model
{
    use HasFactory, HasTranslations;
    public $translatable = ['name', 'city'];
    protected $guarded = [];
    public function avatar()
    {
        return $this->belongsTo(Upload::class, 'id', 'relation_id')->where('file_type', 'rooms');
    }
    public static function createWithRooms(Request $request)
    {
        DB::beginTransaction();
        try {

            $data = [];
            foreach (locales() as $key => $language) {
                $data['name'][$key] = $request->get('name_' . $key);
                $data['city'][$key] = $request->get('city_' . $key);
            }
            $room =  RoomCar::query()->create($data);
            ImageUpload::UploadImage($request->image, 'rooms', $room->id, null, null);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    public static function updateWithRooms(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = [];
            foreach (locales() as $key => $language) {
                $data['name'][$key] = $request->get('name_' . $key);
                $data['city'][$key] = $request->get('city_' . $key);
            }
            $room = RoomCar::findOrFail($request->id);
            $room->update($data);
            if ($request->hasFile('image')) {
                ImageUpload::UploadImage($request->image, 'rooms', null, null, $room->id);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


    protected static function booted()
    {
        static::deleted(function ($room) {
            File::delete(public_path('uploads/' . $room->avatar->full_small_path));
            $room->avatar()->delete();
        });
    }
}
