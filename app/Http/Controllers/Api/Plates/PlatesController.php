<?php

namespace App\Http\Controllers\Api\Plates;

use App\Http\Controllers\Controller;
use App\Models\Plates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PlatesController extends Controller
{

    public function getplates(){
        $plates=Plates::paginate(6);
        return $plates;
    }

    public function plates(Request $request){

        $rules=[
            'numberone'=>'required|digits:4',
            'numbertow'=>'required|size:4',
            'stringone'=>'required|size:3',
            'stringtow'=>'required|size:3',
            'price'=>'required|',
            'phone'=>'required|between:8,14',
            'city_uuid' => 'required|exists:cities,uuid',
        ];
        $vaild = $request->all();
        $validator = Validator::make($vaild, $rules);
        if ($validator->fails()) {
            return mainResponse(false, __('plates_failed'), [], $validator->errors()->messages(), 101);
        }
        $user=Auth::guard('sanctum')->user();
        $request->merge([
           'user_uuid'=>$user->uuid
        ]);
     Plates::create($request->only([
            'numberone',
            'numbertow',
            'stringone',
            'stringtow',
            'price',
            'phone',
            'city_uuid',
            'user_uuid'
        ]));
        return mainResponse(true, __('plates successfully'), [], [], 101);

    }
}
