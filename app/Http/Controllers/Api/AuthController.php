<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $rules = [
            'phone' => 'required',
            'password' => 'required|min:6',
        ];
        $vaild = $request->all();
        $validator = Validator::make($vaild, $rules);
        if ($validator->fails()) {
            return mainResponse(false, __('auth.failed'), [], $validator->errors()->messages(), 101);
        }
        $user = User::where('phone', $request->phone)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $user['token'] = $user->createToken('api')->plainTextToken;
            return mainResponse(true, __('Login successfully'), $user, [], 101);
        } else {
            return mainResponse(false, __('auth.failed'), [], [], 101);
        }
    }

    public function register(Request $request)
    {
        $rules = [
            'phone' => 'required|unique:users|max:12',
            'password' => 'required|min:6',
        ];
        $vaild = $request->all();
        $validator = Validator::make($vaild, $rules);
        if ($validator->fails()) {
            return mainResponse(false, $validator->errors()->first(), [], $validator->errors()->messages(), 101);
        }
        $number = rand(1000, 9999);
        $code = Hash::make($number);
        $user = User::create([
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'code' => $code
        ]);
        $phone = $user->phone;
        $token = $user->createToken('api')->plainTextToken;



        return mainResponse(true, 'User created successfully', compact('phone', 'token', 'number',), [], 101);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return mainResponse(true, __('ok'), [], [], 200);
    }

    public function verification_code(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return mainResponse(false, __('Not auth'), [], [], 200);
        }

        if (Hash::check($request->verification, $user->code)) {
            $user->update([
                'verification' => 1
            ]);
            $user['token'] = $request->token;
            return mainResponse(true, __('ok'), $user, [], 200);
        }
        return mainResponse(true, __('The number you entered'), [], [], 200);
    }

    public function resend_code(Request $request)
    {
        $user = User::where('phone', $request->phone)->first();
        $number = rand(1000, 9999);
        $code = Hash::make($number);
        $user->update([
            'code' => $code
        ]);
        return mainResponse(true, __('ok'), $number, [], 200);
    }
}
