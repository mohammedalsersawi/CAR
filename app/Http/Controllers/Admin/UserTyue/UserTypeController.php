<?php

namespace App\Http\Controllers\Admin\UserTyue;

use App\Http\Controllers\Admin\ResponseTrait;
use App\Http\Controllers\Controller;

use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use App\Models\User;
use App\Models\UserType;
use App\Utils\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserTypeController extends Controller
{
    use ResponseTrait;
    public function index()
    {

        $cities=City::select(['name','id'])->get();
        $country=Country::select(['name','id'])->get();
        $user=UserType::all();
//        $area=Area::select(['id','name'])->get();

        return view('admin.pages.usertype.index',compact(['cities','user','country']));
    }


    public function store(Request $request)
    {
//        $latlng=$request->latlng;
//        $num=strpos($latlng, ",");
//        $lat= substr($latlng, strpos($latlng, "("),$num);
//        $lng=substr($latlng, $num, strpos($latlng, ")"));
        $rules = [];
        foreach (locales() as $key => $language) {
            $rules['about_' . $key] = 'required|string';
            $rules['name_' . $key] = 'required|string';

        }
        $rules['lat'] = 'required';
        $rules['lng'] = 'required';
        $rules['phone'] = 'required|numeric|digits:10';
//        $rules['number'] = 'required';
        $rules['city_id'] = 'required|exists:cities,id';
        $rules['area_id'] = 'required|exists:areas,id';
        $rules['user_type_id'] = 'required|exists:user_types,id';
        $rules['password'] = 'required';
        $this->validate($request, $rules);
        $data=[];
        foreach (locales() as $key => $language) {
            $data['about'][$key] = $request->get('about_' . $key);
            $data['name'][$key] = $request->get('name_' . $key);
        }
        $data['lat'] = $request->lat;
        $data['lng'] = $request->lng;
        $data['phone']=$request->phone;
//        $data['number']=$request->number;
        $data['city_id']=$request->city_id;
        $data['area_id']=$request->area_id;
        $data['password']=Hash::make($request->password);
        $data['user_type_id']=$request->user_type_id;
        $user= User::create($data);
        ImageUpload::UploadImage($request->image, null, 'App\Models\User', $user->id, false);
        return $this->sendResponse(null, __('item_added'));
    }


    public function update(Request $request)
    {
        $rules = [];
        foreach (locales() as $key => $language) {
            $rules['about_' . $key] = 'required|string';
            $rules['name_' . $key] = 'required|string';

        }
        $rules['phone'] = 'required|numeric|digits:10';
//        $rules['number'] = 'required';
        $rules['city_id'] = 'required|exists:cities,id';
        $rules['area_id'] = 'required|exists:areas,id';
        $rules['user_type_id'] = 'required|exists:user_types,id';
        $rules['lat'] = 'required';
        $rules['lng'] = 'required';
        $this->validate($request, $rules);
        $data=[];
        foreach (locales() as $key => $language) {
            $data['about'][$key] = $request->get('about_' . $key);
            $data['name'][$key] = $request->get('name_' . $key);

        }
        $data['lat'] = $request->lat;
        $data['lng'] = $request->lng;
        $data['phone']=$request->phone;
        $data['city_id']=$request->city_id;
        $data['area_id']=$request->area_id;
       $data['user_type_id']=$request->user_type_id;
        $user=User::findOrFail($request->id);
        $user->update($data);
        if(isset($request->image))
        {
            ImageUpload::UploadImage($request->image, null, 'App\Models\User', $user->id, true);
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
            })
            ->addIndexColumn()
            ->addColumn('action', function ($que) {
                $data_attr = '';
                $data_attr .= 'data-id="' . @$que->id . '" ';
//                $data_attr .= 'data-number="' . @$que->number . '" ';
                $data_attr .= 'data-phone="' .@ $que->phone . '" ';
                $data_attr .= 'data-city="' .@ $que->city_id . '" ';
                $data_attr .= 'data-area="' .@ $que->area_id . '" ';
                $data_attr .= 'data-area_name="' .@ $que->name_area . '" ';
                $data_attr .= 'data-city_name="' . @$que->name_city . '" ';
                $data_attr .= 'data-country="' .@ $que->city->country_id . '" ';
                $data_attr .= 'data-lat="' . @$que->lat . '" ';
                $data_attr .= 'data-lng="' . @$que->lng . '" ';
                $data_attr .= 'data-user_type_id="' .@ $que->user_type_id . '" ';
                foreach (locales() as $key => $value) {
                    $data_attr .= 'data-about_' . $key . '="' . $que->getTranslation('about', $key) . '" ';
                    $data_attr .= 'data-name_' . $key . '="' . $que->getTranslation('name', $key) . '" ';
                }
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
