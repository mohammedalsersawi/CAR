<?php

namespace App\Http\Controllers\Admin\UserTyue;

use App\Http\Controllers\Admin\ResponseTrait;
use App\Http\Controllers\Controller;

use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use App\Models\Type;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class UserTypeController extends Controller
{
    use ResponseTrait;
    public function index()
    {

        $cities=City::select(['name','id'])->get();
        $country=Country::select(['name','id'])->get();
        $type=Type::select(['name','id'])->get();
        $user=UserType::all();
//        $area=Area::select(['id','name'])->get();

        return view('admin.pages.usertype.index',compact(['cities','user','country','type']));
    }


    public function store(Request $request)
    {

//        $latlng=$request->latlng;
//        $num=strpos($latlng, ",");
//        $lat= substr($latlng, strpos($latlng, "("),$num);
//        $lng=substr($latlng, $num, strpos($latlng, ")"));
        $rules = [];
        $rules['about'] = 'required';
        $rules['lat'] = 'required';
        $rules['lng'] = 'required';
        $rules['name'] = 'required';
        $rules['phone'] = 'required|between:8,14';
        $rules['city_id'] = 'required|exists:cities,id';
        $rules['discount_type_id'] = 'nullable|exists:types,id';
        $rules ['area_id']=
            ['required',
                Rule::exists(Area::class, 'id')->where(function ($query) use ($request) {
                    $query->where('city_id',$request->city_id);
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
        $data['discount_type_id']=$request->discount_type_id;
        $data['city_id']=$request->city_id;
        $data['area_id']=$request->area_id;
        $data['password']=Hash::make($request->password);
        $data['user_type_id']=$request->user_type_id;
        $user= User::create($data);
        UploadImage($request->image, null, 'App\Models\User', $user->id, false);
        return $this->sendResponse(null, __('item_added'));
    }


    public function update(Request $request)
    {

        $rules = [];

        $rules['name'] = 'nullable';
        $rules['about'] = 'nullable';
        $rules['phone'] = 'required|between:8,14';
        $rules['discount_type_id'] = 'nullable|exists:types,id';
        $rules['city_id'] = 'nullable|exists:cities,id';
        $rules ['area_id']=
            ['nullable',
                Rule::exists(Area::class, 'id')->where(function ($query) use ($request) {
                    $query->where('city_id',$request->city_id);
                }),
            ];
        $rules['user_type_id'] = 'nullable|exists:user_types,id';
        $rules['lat'] = 'nullable';
        $rules['lng'] = 'nullable';
        $this->validate($request, $rules);
        $user=User::findOrFail($request->id);
        $user->update($request->only(['about',
            'name',
            'lat',
            'lng',
            'discount_type_id',
            'phone',
            'city_id',
            'area_id',
            'user_type_id',
            ]));
        if($request->image)
        {
            UploadImage($request->image, null, 'App\Models\User', $user->id, true);
        }


        return $this->sendResponse(null, __('item_edited'));
    }

    public function destroy($id)
    {
        $Color = User::destroy($id);
        return $this->sendResponse(null,null);
    }


    public function getData(Request $request)
    {


        $user = User::query();
        return Datatables::of($user)
            ->filter(function ($query) use ($request) {

                if ($request->get('city_id')) {
                    $query->where('city_id',$request->get('city_id'));
                }
                if ($request->get('area_id')) {
                    $query->where('area_id',$request->get('area_id'));
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
                if ($request->get('discount_type_id')) {
                    $query->where('discount_type_id', $request->get('discount_type_id'));
                }
            })
            ->addIndexColumn()
            ->addColumn('action', function ($que) {
                $data_attr = '';
                $data_attr .= 'data-id="' . @$que->id . '" ';
//                $data_attr .= 'data-number="' . @$que->number . '" ';
                $data_attr .= 'data-phone="' .@ $que->phone . '" ';
                $data_attr .= 'data-city="' .@ $que->city_id . '" ';
                $data_attr .= 'data-area="' .@ $que->area_id . '" ';
                $data_attr .= 'data-name="' .@ $que->name . '" ';
                $data_attr .= 'data-area_name="' .@ $que->area_name . '" ';
                $data_attr .= 'data-city_name="' . @$que->city_name . '" ';
                $data_attr .= 'data-country="' .@ $que->city->country_id . '" ';
                $data_attr .= 'data-country_name="' .@ $que->city->country->name . '" ';
                $data_attr .= 'data-lat="' . @$que->lat . '" ';
                $data_attr .= 'data-lng="' . @$que->lng . '" ';
                $data_attr .= 'data-user_type_id="' .@ $que->user_type_id . '" ';
                $data_attr .= 'data-about="' .@ $que->about . '" ';
                $string = '';
                $string .= '<button class="edit_btn btn btn-sm btn-outline-primary btn_edit" data-toggle="modal"
                    data-target="#edit_modal" ' . $data_attr . '>' . __('edit') . '</button>';
                $string .= ' <button type="button" class="btn btn-sm btn-outline-danger btn_delete" data-id="' . $que->id .
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
    public function area($id)
    {
        $list_classes = Area::where("city_id", $id)->pluck("name", "id");

        return $list_classes;
    }



    public function country($id)
    {
        $country = City::where("country_id", $id)->pluck("name", "id");

        return $country;
    }
}
