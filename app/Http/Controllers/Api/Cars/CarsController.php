<?php

namespace App\Http\Controllers\Api\Cars;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Image;
use App\Models\ModelCar;
use App\Models\OrderAppointment;
use App\Models\Specification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CarsController extends Controller
{
    public function addcar(Request $request){
//return json_decode($request->specification);

        $rules = [];
        $rules['lat'] = 'required';
        $rules['lng'] = 'required';
        $rules['year'] = 'required';
        $rules['price'] = 'required';
        $rules['phone'] = 'required';
        $rules['mileage'] = 'required';
        $rules['image'] = 'required';
        $rules['brand_uuid'] = 'required|exists:brands,uuid';
        $rules['model_uuid'] =
            [
                'required',
                Rule::exists(ModelCar::class, 'uuid')->where(function ($query) use ($request) {
                    $query->where('brand_uuid', $request->brand_uuid);
                }),
            ];
        $rules['appointment_uuid'] = 'nullable|exists:order_appointments,uuid';

        $rules['engine_uuid'] = 'required|exists:engines,uuid';
        $rules['fule_type_uuid'] = 'required|exists:fuel_types,uuid';
        $rules['color_exterior_uuid'] = 'required|exists:color_cars,uuid';
        $rules['color_interior_uuid'] = 'required|exists:color_cars,uuid';
        $rules['transmission_uuid'] = 'required|exists:transmissions,uuid';
        $vaild = $request->all();
        $validator = Validator::make($vaild, $rules);
        if ($validator->fails()) {
            return mainResponse(false, __('car failed'), [], $validator->errors()->messages(), 101);
        }
        $user=Auth::guard('sanctum')->user();
        if ($user->user_type_id==User::SHOWROOM) {
            $request->merge([
                'showroom_uuid' => $user->uuid
            ]);
        }
        $Car = Car::create($request->only(
            'transmission_uuid',
            'lat',
            'lng',
            'year',
            'price',
            'appointment_uuid',
            'phone',
            'mileage',
            'brand_uuid',
            'model_uuid',
            'showroom_uuid',
            'engine_uuid',
            'fule_type_uuid',
            'color_exterior_uuid',
            'color_interior_uuid',
        ));
        if ($user->user_type_id==User::PHOTOGRAPHER) {
            $Appointment= OrderAppointment::find($request->appointment_uuid);
            $Appointment->update([
                'status'=>OrderAppointment::complete
            ]);
        }

        foreach ($request->File('image') as $file) {
            UploadImage($file, null, Car::class, $Car->uuid, false,null,Image::IMAGE);
        }
        foreach ($request->File('video') as $file) {
            UploadImage($file, null, Car::class, $Car->uuid, false,null,Image::VIDEO);
        }
        $i=0;
       if($request->has('specification')){
           $specification=json_decode($request->specification);
           foreach ($specification as $item){
               Specification::create([
                   'name'=>$item,
                   'car_uuid'=>$Car->uuid,
               ]);
               $i++;
           }
       }
        return mainResponse(true, __('car successfully'), [], [], 101);

    }
    public function getonecar($uuid){

        $car = Car::find($uuid)
            ->with('specification:name,car_uuid')
            ->first();
        if ($car){
            return mainResponse(true, __('ok'), $car, [], 101);

        }
        return mainResponse(false, __('failed'), $car, [], 101);


    }
}
