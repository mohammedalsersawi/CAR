<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $rules = [
            'phone' => 'required|exists:users,phone',
            'password' => 'required|min:6',
        ];
        $vaild = $request->all();
        $validator = Validator::make($vaild, $rules);
        if ($validator->fails()) {
            return mainResponse(false, __('auth.failed'), [], $validator->errors()->messages(), 101);
        }
        $user=User::where('phone',$request->phone)->first();

        if($user && Hash::check($request->password,$user->password)) {
            $user['token']=$user->createToken('api')->plainTextToken;
            return mainResponse(true, __('Login successfully'), $user, [], 101);
        }else{
            return mainResponse(false, __('auth.failed'), [], [], 101);
        }


    }

    public function register(Request $request){
        $rules = [
            'phone' => 'required|unique:users|max:12',
            'password' => 'required|min:6',
        ];
        $vaild = $request->all();
        $validator = Validator::make($vaild, $rules);
        if ($validator->fails()) {
            return mainResponse(false, $validator->errors()->first(), [], $validator->errors()->messages(), 101);
        }


        $user = User::create([
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
        $data=[$user->phone,$user->createToken('api')->plainTextToken];

        return mainResponse(true, 'User created successfully', $data, [], 101);

    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return mainResponse(true, __('ok'), [], [], 200);
    }

    public function verification_code(Request $request){

    }

    public function resend_code(Request $request){

    }

}
