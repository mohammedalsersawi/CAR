<?php

namespace App\Http\Controllers\Api\Deals;

use App\Http\Controllers\Controller;
use App\Models\Code_Deals;
use App\Models\Deals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DealsController extends Controller
{

    public function deal(Request $request){
        $rules=[
            'deals'=>'required|between:3,255',
            'image'=>'required|image',

        ];
        $vaild = $request->all();
        $validator = Validator::make($vaild, $rules);
        if ($validator->fails()) {
            return mainResponse(false, __('deals failed'), [], $validator->errors()->messages(), 101);
        }
        $user=Auth::guard('sanctum')->user();
        $request->merge([
            'user_uuid'=>$user->uuid
        ]);
        $deals= Deals::create($request->only([
            'deals',
            'user_uuid',
        ]));
        if ($request->image){
            UploadImage($request->image, null, 'App\Models\Deals', $deals->uuid, false);
        }
        return mainResponse(true, __('deals successfully'), [], [], 101);
    }

    public function deal_code(Request $request){

        Code_Deals::create($request->only([
            'code',
            'deal_uuid',
        ]));
                    return mainResponse(true, __('ok'), [], [], 101);


    }
}
