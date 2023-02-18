<?php

namespace App\Http\Controllers\Admin\UserTyue;

use App\Http\Controllers\Admin\ResponseTrait;
use App\Http\Controllers\Controller;

use App\Models\Area;
use App\Models\City;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserTypeController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        $cities=City::select(['name','id'])->get();
        $user=UserType::all();
        $area=Area::select(['id','name'])->get();

        return view('admin.pages.usertype.index',compact(['cities','user','area']));
    }


    public function store(Request $request)
    {
        $rules = [];
        foreach (locales() as $key => $language) {
            $rules['about_' . $key] = 'required|string';
        }
        $rules['phone'] = 'required|numeric|digits:10';
        $rules['number'] = 'required';
        $rules['city_id'] = 'required|exists:cities,id';
        $rules['area_id'] = 'required|exists:areas,id';
        $rules['user_type_id'] = 'required|exists:user_types,id';
        $rules['password'] = 'required';
        $this->validate($request, $rules);
        $data=[];
        foreach (locales() as $key => $language) {
            $data['about'][$key] = $request->get('about_' . $key);
        }
        $data['phone']=$request->phone;
        $data['number']=$request->number;
        $data['city_id']=$request->city_id;
        $data['area_id']=$request->area_id;
        $data['password']=Hash::make($request->password);
        $data['user_type_id']=$request->user_type_id;
        User::create($data);
        return $this->sendResponse(null, __('item_added'));
    }


    public function update(Request $request)
    {
        $rules = [];
        foreach (locales() as $key => $language) {
            $rules['about_' . $key] = 'required|string';
        }
        $rules['phone'] = 'required|numeric|digits:10';
        $rules['number'] = 'required';
        $rules['city_id'] = 'required|exists:cities,id';
        $rules['area_id'] = 'required|exists:areas,id';
        $rules['user_type_id'] = 'required|exists:user_types,id';

        $this->validate($request, $rules);
        $data=[];
        foreach (locales() as $key => $language) {
            $data['about'][$key] = $request->get('about_' . $key);
        }
        $data['phone']=$request->phone;
        $data['number']=$request->number;
        $data['city_id']=$request->city_id;
        $data['area_id']=$request->area_id;
       $data['user_type_id']=$request->user_type_id;
        $user=User::findOrFail($request->id);
        $user->update($data);
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
                    $query->where('phone','like', "%{$request->get('phone')}%");
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
                $data_attr .= 'data-id="' . $que->id . '" ';
                $data_attr .= 'data-number="' . $que->number . '" ';
                $data_attr .= 'data-phone="' . $que->phone . '" ';
                $data_attr .= 'data-city="' . $que->city_id . '" ';
                $data_attr .= 'data-area="' . $que->area_id . '" ';
                $data_attr .= 'data-user_type_id="' . $que->user_type_id . '" ';
                foreach (locales() as $key => $value) {
                    $data_attr .= 'data-about_' . $key . '="' . $que->getTranslation('about', $key) . '" ';
                }
                $string = '';
                $string .= '<button class="edit_btn btn btn-sm btn-outline-primary btn_edit" data-toggle="modal"
                    data-target="#edit_modal" ' . $data_attr . '>' . __('edit') . '</button>';
                $string .= ' <button type="button" class="btn btn-sm btn-outline-danger btn_delete" data-id="' . $que->id .
                    '">' . __('delete') . '</button>';
                return $string;
            })
            ->addColumn('Type',function ($row){
                return $row->Type->Name;
//                    (app()->currentLocale()=='ar')?$row->Type->name_ar:$row->Type->name_en;
            })
            ->addColumn('city',function ($row){
                return $row->city->name;
            })
            ->addColumn('area',function ($row){
                return $row->area->name;
            })
            ->rawColumns(['Type'])
            ->rawColumns(['action'])
            ->make(true);
    }
    public function area($id)
    {
        $list_classes = Area::where("city_id", $id)->pluck("name", "id");

        return $list_classes;
    }
}
