<?php

namespace App\Http\Controllers\Admin\Plates;

use App\Models\City;
use App\Models\User;
use App\Models\Plates;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ResponseTrait;
use Yajra\DataTables\Facades\DataTables;

class PlatesController extends Controller
{

    use ResponseTrait;

    public function index()
    {
        $users = User::select(['name', 'uuid', 'phone'])->get();
        $cities = City::select(['name', 'uuid'])->get();
        return view('admin.pages.Plates.index', compact('cities', 'users'));
    }


    public function store(Request $request)
    {
        $rules = [];
        $rules['numberone'] = 'required|numeric|digits:4';
        $rules['numbertow'] = 'required|numeric|digits:4';
        $rules['stringone'] = 'required|string|size:3';
        $rules['stringtow'] = 'required|string|size:3';
        $rules['phone'] = 'required|between:8,14';
        $rules['city_uuid'] = 'required|exists:cities,uuid';
        $rules['price'] = 'required|numeric';
        $rules['user_uuid'] = 'required|exists:users,uuid';
        $this->validate($request, $rules);
        $plates = Plates::create($request->only(
            'numberone',
            'numbertow',
            'stringone',
            'stringtow',
            'phone',
            'city_uuid',
            'price',
            'user_uuid',
        ));
        return $this->sendResponse(null, __('item_added'));
    }
    public function update(Request $request)
    {
        $rules = [];
        $rules['numberone'] = 'required|numeric|digits:4';
        $rules['numbertow'] = 'required|numeric|digits:4';
        $rules['stringone'] = 'required|string|size:3';
        $rules['stringtow'] = 'required|string|size:3';
        $rules['phone'] = 'required|between:8,14';
        $rules['city_uuid'] = 'required|exists:cities,id';
        $rules['price'] = 'required|numeric';
        $rules['user_uuid'] = 'required|exists:users,id';
        $this->validate($request, $rules);
        $plates = Plates::findOrFail($request->uuid);
        $plates->update($request->only(
            'numberone',
            'numbertow',
            'stringone',
            'stringtow',
            'phone',
            'city_uuid',
            'price',
            'user_uuid',
        ));

        return $this->sendResponse(null, __('item_added'));
    }


    public function getData(Request $request)
    {

        $Car = Plates::query();
        return Datatables::of($Car)
            ->filter(function ($query) use ($request) {

                if ($request->get('city_uuid')) {
                    $query->where('city_uuid',$request->get('city_uuid'));
                }
                if ($request->get('phone')) {
                    $query->where('phone',$request->get('phone'));
                }
                if ($request->get('price')) {
                    $query->where('price',$request->price);
                }

                if ($request->get('status') !== null) {
                    $query->where('status', '=', $request->get('status'));
                }
            })
            ->addColumn('checkbox',function ($que){
                return $que->uuid;
            })
            ->addColumn('action', function ($que) {
                $data_attr = '';
                $data_attr .= 'data-uuid="' . @$que->uuid . '" ';
                $data_attr .= 'data-numberone="' . @$que->numberone . '" ';
                $data_attr .= 'data-numbertow="' . @$que->numbertow . '" ';
                $data_attr .= 'data-stringone="' . @$que->stringone . '" ';
                $data_attr .= 'data-stringtow="' . @$que->stringtow . '" ';
                $data_attr .= 'data-phone="' . @$que->phone . '" ';
                $data_attr .= 'data-price="' . @$que->price . '" ';
                $data_attr .= 'data-user_uuid="' . @$que->user_uuid . '" ';
                $data_attr .= 'data-city_uuid ="' . @$que->city_uuid  . '" ';
                $data_attr .= 'data-city_name="' . @$que->city->name . '" ';

                $string = '';
                $string .= '<button class="edit_btn btn btn-sm btn-outline-primary btn_edit" data-toggle="modal"
                    data-target="#edit_modal" ' . $data_attr . '>' . __('edit') . '</button>';
                $string .= ' <button type="button" class="btn btn-sm btn-outline-danger btn_delete" data-id="' . $que->uuid .
                    '">' . __('delete') . '</button>';
                return $string;
            })
            ->addColumn('status', function ($que) {
                $string = '';
                if($que->status == 1){
                    $string .= '<span class="badge badge-primary">' . __('Sold') . '</span>';
                }else{
                    $string .= '<span class="badge badge-success">' . __('Nat_Sold') . '</span>';
                }
                return $string;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }


    public function destroy($uuid)
    {
        $uuids=explode(',', $uuid);
        Plates::whereIn('uuid', $uuids)->delete();
        return $this->sendResponse(null, null);
    }
}
