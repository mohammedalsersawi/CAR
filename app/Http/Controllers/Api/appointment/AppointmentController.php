<?php

namespace App\Http\Controllers\Api\appointment;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\OrderAppointment;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
   public function addappointment(Request $request){
       $rules = [];

       $rules['phone'] = 'required';
       $rules['type'] = 'required|in:1,2';
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
       $photographer =  OrderAppointment::create($request->only(['type','user_uuid','city_uuid', 'area_uuid', 'date', 'phone', 'time']));
       if ($request->hasFile('image')) {
           UploadImage($request->image, null, OrderAppointment::class, $photographer->uuid, false);
       }
       if ($request->hasFile('video')) {
           UploadImage($request->video, null, OrderAppointment::class, $photographer->uuid, false);
       }
       if ($photographer) {
           return mainResponse(true, __('ok'), $photographer, [], 200);
       }else{
           return mainResponse(false, __('fail'), [], [], 200);

       }
   }
   public function accept(Request $request){

       $user=Auth::guard('sanctum')->user();

       $request->merge([
          'user'=>$user->uuid
       ]);
       $rules = [];
       $rules ['user']=
           ['required',
               Rule::exists(User::class, 'uuid')->where(function ($query) use ($request) {
                   $query->where('user_type_id',User::PHOTOGRAPHER);
               }),
           ];
       $rules['uuid'] = 'required|exists:photographers,uuid';
       $vaild = $request->all();
       $validator = Validator::make($vaild, $rules);
       if ($validator->fails()) {
           return mainResponse(false, __('failed'), [], $validator->errors()->messages(), 101);
       }
       $photographer=  OrderAppointment::find($request->uuid);
       $photographer->update([
           'photographer_uuid'=>$user->uuid,
           'status'=>OrderAppointment::accept
       ]);
       return mainResponse(true, __('ok'), $photographer, [], 200);

   }
}
