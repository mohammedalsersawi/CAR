<?php

namespace App\Http\Controllers\Api\home;

use App\Http\Resources\salesResource;
use App\Http\Resources\TypeResource;
use App\Models\Car;
use App\Models\Code_Deals;
use App\Models\OrderAppointment;
use App\Models\Photographer;
use App\Models\Type;
use App\Models\User;
use App\Models\Brand;
use App\Models\Deals;
use App\Models\video;
use App\Http\Resources\carresourse;
use App\Http\Controllers\Controller;
use App\Http\Resources\roomresourse;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\profileResource;
use Illuminate\Http\Request;
use mysql_xdevapi\Collection;


class HomeController extends Controller
{
    public function home()
    {
        $videoo = video::query()->take(1)->value('video');
        $video = [
            'link' => url('/') . '/uploads/' . $videoo
        ];
        $room = User::where('user_type_id', User::SHOWROOM)->select(['name', 'uuid'])->limit(10)->get();
        $showrooms = roomresourse::collection($room);
        $deals = Deals::select(['uuid', 'user_uuid', 'deals'])->get();
        $brands = Brand::select('name', 'uuid')->get();
        $ads = Car::query()->select(['uuid', 'brand_uuid', 'model_uuid', 'year'])->take(3)->get();
        $cars = carresourse::collection($ads);
        return mainResponse(true, __('ok'), compact('video', 'showrooms', 'deals', 'brands', 'cars'), [], 200);
    }

    public function profile()
    {
        $user = Auth::guard('sanctum')->user();
        $profile = new profileResource($user);
        $data = [];
        if ($user->user_type_id == User::SHOWROOM) {
            $ads = $user->cars;
            $data = carresourse::collection($ads);
        } elseif ($user->user_type_id == User::DISCOUNT_STORE) {
            $data = $user->deals;
            $sales = salesResource::collection($user->deals()->select('deals')->withCount('seals')->get());
            return mainResponse(true, __('ok'), compact('profile', 'data', 'sales'), [], 200);

        } elseif ($user->user_type_id == User::USER) {
            $profile = [
                'uuid' => $user->uuid,
                'phone' => $user->phone,
                'type' => $user->user_type_id

            ];
            $Appointment = OrderAppointment::where('user_uuid', $user->uuid)->pluck('uuid');
            $ads = Car::whereIn('appointment_uuid', $Appointment)->get();
            $data = carresourse::collection($ads);
        } elseif ($user->user_type_id == User::PHOTOGRAPHER) {
            $data = OrderAppointment::where('status', OrderAppointment::pending)->where('area_uuid', $user->area_uuid)->orWhere('photographer_uuid', $user->uuid)->get();
        }


        return mainResponse(true, __('ok'), compact('profile', 'data'), [], 200);
    }

    public function lodemor(Request $request)
    {
        $query = Car::query();
        $query->when($request->get('search'), function ($query, $search) {
            $query->where('year', $search)
                  ->orWhere(function ($query) use ($search) {
                    $query->whereHas('brand', function ($query) use ($search) {
                        $query->where('name->' . locale(), 'like', "%{$search}%");
                        foreach (locales() as $key => $value) {
                            if ($key != locale())
                                $query->orWhere('name->' . $key, 'like', "%{$search}%");
                        }
                    });
                })
                ->orWhere(function ($query) use ($search) {
                    $query->whereHas('model', function ($query) use ($search) {
                        $query->where('name->' . locale(), 'like', "%{$search}%");
                        foreach (locales() as $key => $value) {
                            if ($key != locale())
                                $query->orWhere('name->' . $key, 'like', "%{$search}%");
                        }
                    });
                });

        });


        $ads = $query->select(['uuid', 'brand_uuid', 'model_uuid', 'year'])->paginate(6);
        $cars = carresourse::collection($ads);

        return mainResponse(true, __('ok'), $cars, [], 200);
    }

    public function deals()
    {
        $type = Type::all();
        $data = TypeResource::collection($type);
        return mainResponse(true, __('ok'), $data, [], 200);
    }

}
