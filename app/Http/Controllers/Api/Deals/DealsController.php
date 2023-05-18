<?php

namespace App\Http\Controllers\Api\Deals;

use App\Http\Controllers\Controller;
use App\Models\Code_Deals;
use App\Models\Deals;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DealsController extends Controller
{

    public function deal(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $rules = [
            'deals' => 'required|between:3,255',
            'image' => 'required|image',

        ];
        $rules['user_uuid'] =
            [
                'required',
                Rule::exists(User::class, 'uuid')->where(function ($query) use ($request) {
                    $query->where('user_type_id', User::DISCOUNT_STORE);
                }),
            ];
        $request->merge([
            'user_uuid' => $user->uuid
        ]);
        $vaild = $request->all();
        $validator = Validator::make($vaild, $rules);
        if ($validator->fails()) {
            return mainResponse(false, __('deals failed'), [], $validator->errors()->messages(), 101);
        }


        $deals = Deals::create($request->only([
            'deals',
            'user_uuid',
        ]));
        if ($request->image) {
            UploadImage($request->image, null, 'App\Models\Deals', $deals->uuid, false);
        }
        return mainResponse(true, __('deals successfully'), [], [], 101);
    }

    public function deal_code(Request $request)
    {

        Code_Deals::create($request->only([
            'code',
            'deal_uuid',
        ]));
        return mainResponse(true, __('ok'), [], [], 101);
    }
}
