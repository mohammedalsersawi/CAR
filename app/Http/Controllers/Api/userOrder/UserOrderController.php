<?php

namespace App\Http\Controllers\Api\userOrder;

use App\Events\UserOrderEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserOrderController extends Controller
{


    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'phone' => 'required|between:8,14',
            'city_uuid' => 'required|exists:cities,uuid',
            'area_uuid' => 'required|exists:areas,uuid',

        ];
        $vaild = $request->all();
        $validator = Validator::make($vaild, $rules);
        if ($validator->fails()) {
            return mainResponse(false, __('order_failed'), [], $validator->errors()->messages(), 101);
        }
        $user=Auth::guard('sanctum')->user();

        $data = UserOrder::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'city_uuid' => $request->city_uuid,
            'area_uuid' => $request->area_uuid,
            'user_uuid' =>$user->uuid,
        ]);
        event(new UserOrderEvent());

        return mainResponse(true, __('order_successfully'), $data, [], 101);
    }



}
