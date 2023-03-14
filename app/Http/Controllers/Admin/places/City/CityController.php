<?php

namespace App\Http\Controllers\Admin\places\City;

use App\Http\Controllers\Admin\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Utils\ImageUpload;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CityController extends Controller
{
    use ResponseTrait;
    public function index()
    {
       $country=Country::select(['name','uuid'])->get();

        return view('admin.pages.city.index',compact('country'));
    }


    public function store(Request $request)
    {
        $rules = [];
        foreach (locales() as $key => $language) {
            $rules['name_' . $key] = 'required|string|max:45';
        }
        $rules['country_uuid']='required|exists:countries,uuid';
        $this->validate($request, $rules);
        $data = [];
        foreach (locales() as $key => $language) {
            $data['name'][$key] = $request->get('name_' . $key);
        }
        $data['country_uuid']=$request->country_uuid;
        $this->validate($request, $rules);
         City::create($data);
        return $this->sendResponse(null, 'تم الاضافة بنجاح');
    }

    public function update(Request $request)
    {


        $rules = [];
        foreach (locales() as $key => $language) {
            $rules['name_' . $key] = 'required|string|max:255';
        }
        $rules['country_uuid']='required|exists:countries,uuid';
        $this->validate($request, $rules);
        $data = [];
        foreach (locales() as $key => $language) {
            $data['name'][$key] = $request->get('name_' . $key);
        }
        $data['country_uuid']=$request->country_uuid;
        $brands = City::findOrFail($request->uuid);
        $brands->update($data);
        return $this->sendResponse(null, 'تم التعدييل بنجاح');

    }

    public function destroy($uuid)
    {
        City::destroy($uuid);
        return $this->sendResponse(null, 'تم الحذف بنجاح');
    }


    public function getData(Request $request)
    {
        $city = City::query();
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
                $data_attr .= 'data-uuid="' . $que->uuid . '" ';
                $data_attr .= 'data-country_name="' . $que->country->name . '" ';
                $data_attr .= 'data-country_uuid="' . $que->country->uuid . '" ';
                foreach (locales() as $key => $value) {
                    $data_attr .= 'data-name_' . $key . '="' . $que->getTranslation('name', $key) . '" ';
                }
                $string = '';
                $string .= '<button class="edit_btn btn btn-sm btn-outline-primary btn_edit" data-toggle="modal"
                    data-target="#edit_modal" ' . $data_attr . '>' . __('edit') . '</button>';
                $string .= ' <button type="button"  class="btn btn-sm btn-outline-danger btn_delete" data-uuid="' . $que->uuid .
                    '">' . __('delete') . '  </button>';
                return $string;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
