<?php

namespace App\Http\Controllers\Api\home;

use App\Http\Controllers\Controller;
use App\Http\Resources\carresourse;
use App\Http\Resources\profileResource;
use App\Http\Resources\roomresourse;
use App\Models\Brand;
use App\Models\Car;
use App\Models\Deals;
use App\Models\User;
use App\Models\video;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function home()
    {
       $videoo= video::query()->take(1)->value('video');
        $video = [
            'link' =>'uploads/'.$videoo
        ];
        $room = User::where('user_type_id', User::SHOWROOM)->select(['name', 'id'])->limit(10)->get();
        $showrooms = roomresourse::collection($room);
        $deals = Deals::select(['uuid', 'user_id', 'deals', 'type_id'])->get();
        $brands = Brand::select('name', 'id')->get();
        $ads = Car::query()->select(['uuid','brand_id','model_id','year'])->take(3)->get();
        $cars = carresourse::collection($ads);
        return mainResponse(true, __('ok'), compact('video', 'showrooms', 'deals', 'brands', 'cars'), [], 200);

    }
    public function profile(){
//        $user=User::where('id',Auth::guard('sanctum')->id())->get();
        $user=Auth::guard('sanctum')->user();
        $profile = new profileResource($user);
        return mainResponse(true, __('ok'), $profile, [], 200);
    }
}
