<?php

namespace App\Http\Controllers\Admin\Photographer;

use App\Models\City;
use App\Models\User;
use App\Models\Country;
use App\Models\Photographer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Admin\ResponseTrait;

class PhotographerController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        $cities = City::select(['name', 'uuid'])->get();
        $country = Country::select(['name', 'uuid'])->get();
        $users = User::select(['name', 'uuid', 'phone'])->get();
        $type =  Photographer::TYPES;
        return view('admin.pages.photographer.index', compact('country', 'cities', 'users', 'type'));
    }
    public function store(Request $request)
    {
        $rules = [];
        $rules['typeContent'] = 'required';
        $rules['video'] = 'required_if:typeContent,2';
        $rules['image'] = 'required_if:typeContent,1,2';
        $rules['user_uuid'] = 'required';
        $rules['phone'] = 'required|numeric';
        $rules['country_uuid'] = 'required';
        $rules['area_uuid'] = 'required_with:city_uuid';
        $rules['city_uuid'] = 'required_with:country_uuid';
        $rules['date'] = 'required|date';
        $rules['time'] = 'required|date_format:H:i';
        $this->validate($request, $rules);
        $photographer =  Photographer::create($request->only(['user_uuid', 'city_uuid', 'area_uuid', 'date', 'phone', 'time']));
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
        $rules['user_uuid'] = 'required';
        $rules['time'] = 'required';
        $rules['phone'] = 'required|numeric';
        $rules['country_uuid'] = 'required';
        $rules['area_uuid'] = 'required_with:city_uuid';
        $rules['city_uuid'] = 'required_with:country_uuid';
        $rules['date'] = 'required';
        $this->validate($request, $rules);
        $photographer =  Photographer::findOrFail($request->uuid);
        $photographer->user_uuid = $request->user_uuid;
        $photographer->phone = $request->phone;
        $photographer->area_uuid = $request->area_uuid;
        $photographer->city_uuid = $request->city_uuid;
        $photographer->date = $request->date;
        $photographer->time = $request->time;
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
        $Photographer = Photographer::query();

        return Datatables::of($Photographer)
            ->filter(function ($query) use ($request) {

                if ($request->get('city_uuid')) {
                    $query->where('city_uuid', $request->get('city_uuid'));
                }
                if ($request->get('area_uuid')) {
                    $query->where('area_uuid', $request->get('area_uuid'));
                }
                if ($request->get('phone')) {
                    $query->where('phone', 'like', "%{$request->phone}%");
                }
                if ($request->get('date')) {
                    $query->where('date', $request->get('date'));
                }
                if ($request->get('user_uuid')) {
                    $query->where('user_uuid', $request->get('user_uuid'));
                }
            })
            ->addIndexColumn()
            ->addColumn('action', function ($que) {
                $data_attr = '';
                $data_attr .= 'data-uuid="' . $que->uuid . '" ';
                $data_attr .= 'data-city_uuid="' . $que->city_uuid . '" ';
                $data_attr .= 'data-user_uuid="' . $que->user_uuid . '" ';
                $data_attr .= 'data-area_uuid="' . $que->area_uuid . '" ';
                $data_attr .= 'data-phone="' . $que->phone . '" ';
                $data_attr .= 'data-date="' . $que->date . '" ';
                $data_attr .= 'data-time="' . $que->time . '" ';
                $data_attr .= 'data-city_name="' . $que->city->name . '" ';
                $data_attr .= 'data-area_name="' . $que->area->name . '" ';
                $data_attr .= 'data-country_uuid="' . $que->city->country->id . '" ';
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
