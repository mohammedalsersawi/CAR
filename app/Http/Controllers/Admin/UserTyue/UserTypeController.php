<?php

namespace App\Http\Controllers\Admin\UserTyue;

use App\Http\Controllers\Admin\ResponseTrait;
use App\Http\Controllers\Controller;

use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use App\Models\Image;
use App\Models\Type;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class UserTypeController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        Gate::authorize('user.view');
        $cities=City::select(['name','uuid'])->get();
        $country=Country::select(['name','uuid'])->get();
        $type=Type::select(['name','uuid'])->get();
        $user=UserType::all();

//        $area=Area::select(['uuid','name'])->get();

        return view('admin.pages.usertype.index',compact(['cities','user','country','type']));
    }


    public function store(Request $request)
    {
        Gate::authorize('setting.create');
//        $latlng=$request->latlng;
//        $num=strpos($latlng, ",");
//        $lat= substr($latlng, strpos($latlng, "("),$num);
//        $lng=substr($latlng, $num, strpos($latlng, ")"));
        $rules = [];
        $rules['about'] = 'nullable';
        $rules['lat'] = 'nullable';
        $rules['lng'] = 'nullable';
        $rules['name'] = 'nullable';
        $rules['phone'] = 'required|between:8,14';
        $rules['city_uuid'] = 'nullable|exists:cities,uuid';
        $rules['discount_type_id'] = 'nullable|exists:types,uuid';
        $rules ['area_uuid']=
            ['nullable',
                Rule::exists(Area::class, 'uuid')->where(function ($query) use ($request) {
                    $query->where('city_uuid',$request->city_uuid);
                }),
            ];
        $rules['user_type_id'] = 'required|exists:user_types,id';
        $rules['password'] = 'required';
        $this->validate($request, $rules);
        $data=[];
        $data['about'] = $request->about;
        $data['lat'] = $request->lat;
        $data['lng'] = $request->lng;
        $data['name'] = $request->name;
        $data['phone']=$request->phone;
        $data['discount_type_uuid']=$request->discount_type_uuid;
        $data['city_uuid']=$request->city_uuid;
        $data['area_uuid']=$request->area_uuid;
        $data['password']=Hash::make($request->password);
        $data['user_type_id']=$request->user_type_id;
        $user= User::create($data);

        if($request->image)
        {
            UploadImage($request->image, null, 'App\Models\User', $user->uuid, false,null,Image::IMAGE);
        }
        return $this->sendResponse(null, __('item_added'));
    }


    public function update(Request $request)
    {
        Gate::authorize('setting.update');
        $rules = [];

        $rules['name'] = 'nullable';
        $rules['about'] = 'nullable';
        $rules['phone'] = 'required|between:8,14';
        $rules['discount_type_uuid'] = 'nullable|exists:types,uuid';
        $rules['city_uuid'] = 'nullable|exists:cities,uuid';
        $rules ['area_uuid']=
            ['nullable',
                Rule::exists(Area::class, 'uuid')->where(function ($query) use ($request) {
                    $query->where('city_uuid',$request->city_uuid);
                }),
            ];
        $rules['user_type_id'] = 'nullable|exists:user_types,id';
        $rules['lat'] = 'nullable';
        $rules['lng'] = 'nullable';
        $this->validate($request, $rules);
        $user=User::findOrFail($request->uuid);
        $user->update($request->only(['about',
            'name',
            'lat',
            'lng',
            'discount_type_uuid',
            'phone',
            'city_uuid',
            'area_uuid',
            'user_type_id',
            ]));
        if($request->image)
        {
            UploadImage($request->image, null, 'App\Models\User', $user->uuid, true,null,Image::IMAGE);
        }


        return $this->sendResponse(null, __('item_edited'));
    }

    public function destroy($uuid)
    {
        Gate::authorize('setting.delete');
        $uuids=explode(',', $uuid);
        User::whereIn('uuid', $uuids)->delete();
        return $this->sendResponse(null, null);
    }


    public function getData(Request $request)
    {


        $user = User::query();
        return Datatables::of($user)
            ->filter(function ($query) use ($request) {

                if ($request->get('city_uuid')) {
                    $query->where('city_uuid',$request->get('city_uuid'));
                }
                if ($request->get('area_uuid')) {
                    $query->where('area_uuid',$request->get('area_uuid'));
                }
                if ($request->get('phone')) {
                    $query->where('phone','like', "%{$request->phone}%");
                }
                if ($request->get('number')) {
                    $query->where('number', 'like', "%{$request->get('number')}%");
                }
                if ($request->get('user_type_id')) {
                    $query->where('user_type_id', $request->get('user_type_id'));
                }
                if ($request->get('discount_type_uuid')) {
                    $query->where('discount_type_uuid', $request->get('discount_type_uuid'));
                }
            })
            ->addColumn('checkbox',function ($que){
                return $que->uuid;
            })
            ->addColumn('action', function ($que) {
                $data_attr = '';
                $data_attr .= 'data-uuid="' . @$que->uuid . '" ';
//                $data_attr .= 'data-number="' . @$que->number . '" ';
                $data_attr .= 'data-phone="' .@ $que->phone . '" ';
                $data_attr .= 'data-city="' .@ $que->city_uuid . '" ';
                $data_attr .= 'data-area="' .@ $que->area_uuid . '" ';
                $data_attr .= 'data-name="' .@ $que->name . '" ';
                $data_attr .= 'data-area_name="' .@ $que->area_name . '" ';
                $data_attr .= 'data-city_name="' . @$que->city_name . '" ';
                $data_attr .= 'data-country="' .@ $que->city->country_uuid . '" ';
                $data_attr .= 'data-country_name="' .@ $que->city->country->name . '" ';
                $data_attr .= 'data-lat="' . @$que->lat . '" ';
                $data_attr .= 'data-lng="' . @$que->lng . '" ';
                $data_attr .= 'data-user_type_id="' .@ $que->user_type_id . '" ';
                $data_attr .= 'data-about="' .@ $que->about . '" ';
                $string = '';
                $string .= '<button class="edit_btn btn btn-sm btn-outline-primary btn_edit" data-toggle="modal"
                    data-target="#edit_modal" ' . $data_attr . '>' . __('edit') . '</button>';
                $string .= ' <button type="button" class="btn btn-sm btn-outline-danger btn_delete" data-uuid="' . $que->uuid .
                    '">' . __('delete') . '</button>';
                return $string;
            })
            ->addColumn('image', function ($row) {
                $imageData = @$row->image->filename;
                return @$imageData;
            })
            ->rawColumns(['image'])
            ->rawColumns(['Type'])
            ->rawColumns(['action'])
            ->make(true);
    }
    public function area($uuid)
    {
        $Area = Area::where("city_uuid", $uuid)->pluck("name", "uuid");

        return $Area;
    }



    public function country($uuid)
    {
        $City = City::where("country_uuid", $uuid)->pluck("name", "uuid");

        return $City;
    }
}
