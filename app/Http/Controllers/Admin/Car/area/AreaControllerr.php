<?php

namespace App\Http\Controllers\Admin\Car\area;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ResponseTrait;
use App\Models\Area;
use Yajra\DataTables\Facades\DataTables;

class AreaControllerr extends Controller
{
    use ResponseTrait;
    public function index()
    {
       $cities=City::select(['name','id'])->get();

        return view('admin.pages.area.index',compact('cities'));
    }


    public function store(Request $request)
    {

        $rules = [];
        foreach (locales() as $key => $language) {
            $rules['name_' . $key] = 'required|string|max:45';
        }
        $rules['city_id']='required|exists:cities,id';
        $this->validate($request, $rules);
        $data = [];
        foreach (locales() as $key => $language) {
            $data['name'][$key] = $request->get('name_' . $key);
        }
        $data['city_id']=$request->city_id;
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
        $rules['city_id']='required|exists:cities,id';
        $this->validate($request, $rules);
        $data = [];
        foreach (locales() as $key => $language) {
            $data['name'][$key] = $request->get('name_' . $key);
        }
        $data['city_id']=$request->city_id;
        $area = Area::findOrFail($request->id);
        $area->update($data);
        return $this->sendResponse(null, __('item_edited'));

    }

    public function destroy($id)
    {
        $area = Area::destroy($id);
        return $this->sendResponse(null, null);
    }


    public function getData(Request $request)
    {
        $city = Area::query();
        return Datatables::of($city)
            ->filter(function ($query) use ($request) {
                if ($request->get('search')) {
                    $locale = app()->getLocale();
                    $query->where('name->'.locale(), 'like', "%{$request->search['value']}%");
                }
            })
            ->addIndexColumn()

            ->addColumn('action', function ($que) {
                $data_attr = '';
                $data_attr .= 'data-id="' . $que->id . '" ';
                $data_attr .= 'data-city_id="' . $que->cites->id . '" ';
                foreach (locales() as $key => $value) {
                    $data_attr .= 'data-name_' . $key . '="' . $que->getTranslation('name', $key) . '" ';
                }
                $string = '';
                $string .= '<button class="edit_btn btn btn-sm btn-outline-primary btn_edit" data-toggle="modal"
                    data-target="#edit_modal" ' . $data_attr . '>' . __('edit') . '</button>';
                $string .= ' <button type="button"  class="btn btn-sm btn-outline-danger btn_delete" data-id="' . $que->id .
                    '">' . __('delete') . '  </button>';
                return $string;
            })
            ->addColumn('cites',function ($que){
                return $que->cites->name;
            })
            ->rawColumns(['cites'])
            ->rawColumns(['action'])
            ->make(true);
    }
}
