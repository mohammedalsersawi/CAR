<?php

namespace App\Http\Controllers\Admin\places\area;

use App\Http\Controllers\Admin\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AreaControllerr extends Controller
{
    use ResponseTrait;
    public function index()
    {
       $cities=City::select(['name','uuid'])->get();

        return view('admin.pages.area.index',compact('cities'));
    }


    public function store(Request $request)
    {

        $rules = [];
        foreach (locales() as $key => $language) {
            $rules['name_' . $key] = 'required|string|max:45';
        }
        $rules['city_uuid']='required|exists:cities,uuid';
        $this->validate($request, $rules);
        $data = [];
        foreach (locales() as $key => $language) {
            $data['name'][$key] = $request->get('name_' . $key);
        }
        $data['city_uuid']=$request->city_uuid;
        $this->validate($request, $rules);
         Area::create($data);
        return $this->sendResponse(null, __('item_added'));
    }

    public function update(Request $request)
    {
        $rules = [];
        foreach (locales() as $key => $language) {
            $rules['name_' . $key] = 'required|string|max:255';
        }
        $rules['city_uuid']='required|exists:cities,uuid';
        $this->validate($request, $rules);
        $data = [];
        foreach (locales() as $key => $language) {
            $data['name'][$key] = $request->get('name_' . $key);
        }
        $data['city_uuid']=$request->city_uuid;
        $area = Area::findOrFail($request->uuid);
        $area->update($data);
        return $this->sendResponse(null, __('item_edited'));

    }

    public function destroy($uuid)
    {
        $uuids=explode(',', $uuid);
        Area::whereIn('uuid', $uuids)->delete();
        return $this->sendResponse(null, null);
    }


    public function getData(Request $request)
    {
        $city = Area::query();
        return Datatables::of($city)
            ->filter(function ($query) use ($request) {
                if ($request->get('search')) {
                    $query->where('name->' . locale(), 'like', "%{$request->search['value']}%");
                    foreach (locales() as $key => $value) {
                        if ($key != locale())
                            $query->orWhere('name->' . $key, 'like', "%{$request->search['value']}%");
                    }
                }
            })
            ->addColumn('checkbox',function ($que){
                return $que->uuid;
            })

            ->addColumn('action', function ($que) {
                $data_attr = '';
                $data_attr .= 'data-uuid="' .@$que->uuid . '" ';
                $data_attr .= 'data-city_uuid="' .@$que->cites->uuid . '" ';
                foreach (locales() as $key => $value) {
                    $data_attr .= 'data-name_' . $key . '="' . $que->getTranslation('name', $key) . '" ';
                }
                $string = '';
                $string .= '<button class="edit_btn btn btn-sm btn-outline-primary btn_edit" data-toggle="modal"
                    data-target="#edit_modal" ' . $data_attr . '>' . __('edit') . '</button>';
                $string .= ' <button type="button"  class="btn btn-sm btn-outline-danger btn_delete" data-uuid="' . $que->id .
                    '">' . __('delete') . '  </button>';
                return $string;
            })

            ->rawColumns(['action'])
            ->make(true);
    }
}
