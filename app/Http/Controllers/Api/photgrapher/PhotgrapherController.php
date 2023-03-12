<?php

namespace App\Http\Controllers\Api\photgrapher;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Photographer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class PhotgrapherController extends Controller
{
   public function post(Request $request){
       $rules = [];
       $rules['video'] = 'nullable';
       $rules['image'] = 'required';
       $rules['phone'] = 'required';
       $rules['city_uuid'] = 'required|exists:cities,uuid';
       $rules ['area_uuid']=
           ['required',
               Rule::exists(Area::class, 'uuid')->where(function ($query) use ($request) {
                   $query->where('city_uuid',$request->city_uuid);
               }),
           ];
       $rules['date'] = 'required';
       $rules['time'] = 'required';
       $vaild = $request->all();
       $validator = Validator::make($vaild, $rules);
       if ($validator->fails()) {
           return mainResponse(false, __('failed'), [], $validator->errors()->messages(), 101);
       }
       $user=Auth::guard('sanctum')->user();
       $request->merge([
           'user_uuid'=>$user->uuid
       ]);
       $photographer =  Photographer::create($request->only(['user_uuid','city_uuid', 'area_uuid', 'date', 'phone', 'time']));
       if ($request->hasFile('image')) {
           UploadImage($request->image, null, Photographer::class, $photographer->uuid, false);
       }
       if ($request->hasFile('video')) {
           UploadImage($request->video, null, Photographer::class, $photographer->uuid, false);
       }
       if ($photographer) {
           return mainResponse(true, __('ok'), $photographer, [], 200);
       }else{
           return mainResponse(false, __('fail'), [], [], 200);

       }
   }
   public function acsept(Request $request){
       $user=Auth::guard('sanctum')->user();
       $photographer=  Photographer::where('uuid',$request->uuid)->first();
       $photographer->update([
           'photographer_uuid'=>$user->uuid,
           'status'=>2
       ]);
       return mainResponse(true, __('ok'), $photographer, [], 200);

   }
}
