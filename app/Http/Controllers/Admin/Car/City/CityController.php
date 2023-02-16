<?php

namespace App\Http\Controllers\Admin\Car\City;

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
       $country=Country::select(['name','id'])->get();

        return view('admin.pages.city.index',compact('country'));
    }


    public function store(Request $request)
    {
        $rules = [];
        foreach (locales() as $key => $language) {
            $rules['name_' . $key] = 'required|string|max:45';
        }
        $rules['country_id']='required|exists:countries,id';
        $this->validate($request, $rules);
        $data = [];
        foreach (locales() as $key => $language) {
            $data['name'][$key] = $request->get('name_' . $key);
        }
        $data['country_id']=$request->country_id;
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
        $rules['country_id']='required|exists:countries,id';
        $this->validate($request, $rules);
        $data = [];
        foreach (locales() as $key => $language) {
            $data['name'][$key] = $request->get('name_' . $key);
        }
        $data['country_id']=$request->country_id;
        $brands = City::findOrFail($request->id);
        $brands->update($data);
        return $this->sendResponse(null, 'تم التعدييل بنجاح');

    }

    public function destroy($id)
    {
        $brands = City::destroy($id);
        return $this->sendResponse(null, 'تم الحذف بنجاح');
    }


    public function getData(Request $request)
    {
        $city = City::query();
        return Datatables::of($city)
            ->addIndexColumn()
            ->addColumn('action', function ($que) {
                $data_attr = '';
                $data_attr .= 'data-id="' . $que->id . '" ';
                $data_attr .= 'data-country_name="' . $que->country->name . '" ';
                $data_attr .= 'data-country_id="' . $que->country->id . '" ';
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
            ->addColumn('country',function ($que){
                return $que->country->name;
            })
            ->rawColumns(['country'])
            ->rawColumns(['action'])
            ->make(true);
    }
}
