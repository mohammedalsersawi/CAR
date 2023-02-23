<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        $rules = [
            'phone' => 'required|exists:users,phone',
            'password' => 'required|min:6',
        ];
        $vaild = $request->all();
        $validator = Validator::make($vaild, $rules);
        if ($validator->fails()) {
            return mainResponse(false, $validator->errors()->first(), [], $validator->errors()->messages(), 101);
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
            'phone' => 'required|unique:users',
            'password' => 'required|string|min:6',
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
        return mainResponse(true, 'User created successfully', $user, [], 101);

    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return mainResponse(true, __('ok'), [], [], 200);
    }


}
