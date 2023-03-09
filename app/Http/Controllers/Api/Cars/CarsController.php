<?php

namespace App\Http\Controllers\Api\Cars;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\ModelCar;
use App\Models\Specification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CarsController extends Controller
{
    public function car(Request $request){
//return json_decode($request->specification);

        $rules = [];
        $rules['lat'] = 'required';
        $rules['lng'] = 'required';
        $rules['year'] = 'required';
        $rules['price'] = 'required';
        $rules['phone'] = 'required';
        $rules['mileage'] = 'required';
        $rules['image'] = 'required';
        $rules['brand_id'] = 'required|exists:brands,id';
        $rules['model_id'] =
            [
                'required',
                Rule::exists(ModelCar::class, 'id')->where(function ($query) use ($request) {
                    $query->where('brand_id', $request->brand_id);
                }),
            ];
        $rules['engine_id'] = 'required|exists:engines,id';
        $rules['fule_type_id'] = 'required|exists:fuel_types,id';
        $rules['color_exterior_id'] = 'required|exists:color_cars,id';
        $rules['color_interior_id'] = 'required|exists:color_cars,id';
        $rules['transmission_id'] = 'required|exists:transmissions,id';
        $vaild = $request->all();
        $validator = Validator::make($vaild, $rules);
        if ($validator->fails()) {
            return mainResponse(false, __('car failed'), [], $validator->errors()->messages(), 101);
        }
        $request->merge([
            'user_id'=>Auth::guard('sanctum')->id(),
        ]);
        $Car = Car::create($request->only(
            'transmission_id',
            'lat',
            'lng',
            'year',
            'price',
            'user_id',
            'phone',
            'mileage',
            'brand_id',
            'model_id',
            'engine_id',
            'fule_type_id',
            'color_exterior_id',
            'color_interior_id',
        ));
        foreach ($request->File('image') as $file) {
            UploadImage($file, null, Car::class, $Car->uuid, false);
        }
        $i=0;
       if($request->has('specification')){
           $specification=json_decode($request->specification);
           foreach ($specification as $item){
               Specification::create([
                   'name'=>$item,
                   'car_id'=>$Car->uuid,
               ]);
               $i++;
           }
       }
        return mainResponse(true, __('car successfully'), [], [], 101);

    }
    public function onecar($uuid){

        $car = Car::find($uuid)
            ->with('specification:name,car_id')
            ->first();
        if ($car){
            return mainResponse(true, __('ok'), $car, [], 101);

        }
        return mainResponse(false, __('failed'), $car, [], 101);


    }
}
