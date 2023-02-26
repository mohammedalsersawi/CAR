<?php

namespace App\Http\Controllers\Api\userOrder;

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
            'phone' => 'required|unique:users,phone|between:8,14',
            'city_id' => 'required|exists:cities,id',
            'area_id' => 'required|exists:areas,id',
        ];
        $vaild = $request->all();
        $validator = Validator::make($vaild, $rules);
        if ($validator->fails()) {
            return mainResponse(false, __('order_failed'), [], $validator->errors()->messages(), 101);
        }
        $data = UserOrder::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'city_id' => $request->city_id,
            'area_id' => $request->area_id,
            'user_id' => Auth::guard('sanctum')->id(),
        ]);
        return mainResponse(true, __('order_successfully'), $data, [], 101);
    }
}
