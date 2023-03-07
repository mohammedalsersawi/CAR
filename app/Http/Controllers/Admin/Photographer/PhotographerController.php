<?php

namespace App\Http\Controllers\Admin\Photographer;

use App\Models\Area;
use App\Models\City;
use App\Models\User;
use App\Models\Deals;
use App\Models\Country;
use App\Models\Photographer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Admin\ResponseTrait;

class PhotographerController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        $cities = City::select(['name', 'id'])->get();
        $country = Country::select(['name', 'id'])->get();
        $users = User::select(['name', 'id', 'phone'])->get();
        $type =  Photographer::TYPES;
        return view('admin.pages.photographer.index', compact('country', 'cities', 'users', 'type'));
    }
    public function store(Request $request)
    {
        $rules = [];
        $rules['typeContent'] = 'required';
        $rules['video'] = 'required_if:typeContent,2';
        $rules['image'] = 'required_if:typeContent,1,2';
        $rules['user_id'] = 'required';
        $rules['phone'] = 'required|numeric';
        $rules['country_id'] = 'required';
        $rules['area_id'] = 'required_with:city_id';
        $rules['city_id'] = 'required_with:country_id';
        $rules['date'] = 'required';
        $this->validate($request, $rules);
        $photographer =  Photographer::create($request->only(['user_id', 'city_id', 'area_id', 'date', 'phone']));
        if ($request->hasFile('image')) {
            UploadImage($request->image, null, Photographer::class, $photographer->uuid, false);
        }
        if ($request->hasFile('video')) {
            UploadImage($request->video, null, Photographer::class, $photographer->uuid, false);
        }
        return $this->sendResponse(null, __('item_added'));
    }
    public function update(Request $request)
    {
        $rules = [];
        // $rules['typeContent'] = 'required';
        // $rules['video'] = 'required_if:typeContent,2';
        // $rules['image'] = 'required_if:typeContent,1,2';
        $rules['user_id'] = 'required';
        $rules['phone'] = 'required|numeric';
        $rules['country_id'] = 'required';
        $rules['area_id'] = 'required_with:city_id';
        $rules['city_id'] = 'required_with:country_id';
        $rules['date'] = 'required';
        $this->validate($request, $rules);
        $photographer =  Photographer::findOrFail($request->uuid);
        $photographer->user_id = $request->user_id;
        $photographer->phone = $request->phone;
        $photographer->area_id = $request->area_id;
        $photographer->city_id = $request->city_id;
        $photographer->date = $request->date;
        $photographer->save();
        if ($request->hasFile('image')) {
            UploadImage($request->image, null, Photographer::class, $photographer->uuid, true);
        }
        if ($request->hasFile('video')) {
            UploadImage($request->video, null, Photographer::class, $photographer->uuid, true);
        }
        return $this->sendResponse(null, __('item_added'));


        return $this->sendResponse(null, __('item_edited'));
    }
    public function destroy($uuid)
    {
        $photographer = Photographer::destroy($uuid);
        return $this->sendResponse(null, null);
    }
    public function getData(Request $request)
    {
        $Photographer = Photographer::all();

        return Datatables::of($Photographer)

            ->addIndexColumn()
            ->addColumn('action', function ($que) {
                $data_attr = '';
                $data_attr .= 'data-uuid="' . $que->uuid . '" ';
                $data_attr .= 'data-city_id="' . $que->city_id . '" ';
                $data_attr .= 'data-user_id="' . $que->user_id . '" ';
                $data_attr .= 'data-area_id="' . $que->area_id . '" ';
                $data_attr .= 'data-phone="' . $que->phone . '" ';
                $data_attr .= 'data-date="' . $que->date . '" ';
                $string = '';
                $string .= '<button class="edit_btn btn btn-sm btn-outline-primary btn_edit" data-toggle="modal"
                    data-target="#edit_modal" ' . $data_attr . '>' . __('edit') . '</button>';
                $string .= ' <button type="button"  class="btn btn-sm btn-outline-danger btn_delete" data-id="' . $que->uuid .
                    '">' . __('delete') . '  </button>';
                return $string;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
