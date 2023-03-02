<?php

namespace App\Http\Controllers\Admin\Car\Model;

use App\Models\Brand;
use Yajra\DataTables\Facades\DataTables;
use App\Models\ModelCar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ResponseTrait;



class ModelController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $brand=Brand::select(['id','name'])->get();
        return view('admin.pages.model.mode-car',compact('brand'));
    }

    public function store(Request $request)
    {
        $rules = [];
        foreach (locales() as $key => $language) {
            $rules['name_' . $key] = 'required|string|max:255';
        }
        $rules['brand_id']='required|exists:brands,id';
        $this->validate($request, $rules);
        $data = [];
        foreach (locales() as $key => $language) {
            $data['name'][$key] = $request->get('name_' . $key);
        }
        $data['brand_id']=$request->brand_id;

        ModelCar::create($data);
        return $this->sendResponse(null, __('item_added'));

    }


    public function update(Request $request)
    {
        $rules = [];
        foreach (locales() as $key => $language) {
            $rules['name_' . $key] = 'required|string|max:255';
        }
        $rules['brand_id']='required|exists:brands,id';
        $this->validate($request, $rules);
        $data = [];
        foreach (locales() as $key => $language) {
            $data['name'][$key] = $request->get('name_' . $key);
        }
        $data['brand_id']=$request->brand_id;

        $modelCar =   ModelCar::findOrFail($request->id);
        $modelCar->update($data);
        return $this->sendResponse(null, __('item_edited'));

    }

    public function destroy($id)
    {
        $ModelCar = ModelCar::find($id);
        $ModelCar->delete();
        return $this->sendResponse(null,null);
    }


    public function getData(Request $request)
    {
        $modelCars = ModelCar::query();
        return Datatables::of($modelCars)
            ->filter(function ($query) use ($request) {
                if ($request->get('search')) {
                    $query->where('name->' . locale(), 'like', "%{$request->search['value']}%");
                    foreach (locales() as $key => $value) {
                        if ($key != locale())
                            $query->orWhere('name->' . $key, 'like', "%{$request->search['value']}%");
                    }

                }
            })
            ->addIndexColumn()
            ->addColumn('action', function ($que) {
                $data_attr = '';
                $data_attr .= 'data-id="' . $que->id . '" ';
                $data_attr .= 'data-name="' . $que->name . '" ';
                $data_attr .= 'data-brand_id="' . $que->brand_id . '" ';
                foreach (locales() as $key => $value) {
                    $data_attr .= 'data-name_' . $key . '="' . $que->getTranslation('name', $key) . '" ';
                }
                $string = '';
                $string .= '<button class="edit_btn btn btn-sm btn-outline-primary btn_edit" data-toggle="modal"
                    data-target="#edit_modal" ' . $data_attr . '>' . __('edit') . '</button>';
                $string .= ' <button type="button" class="btn btn-sm btn-outline-danger btn_delete" data-id="' . $que->id .
                    '">' . __('delete') . '</button>';
                return $string;
            })
            ->addColumn('brand',function ($row){
                return $row->brand->name;
            })
            ->rawColumns(['brand'])
            ->rawColumns(['action'])
            ->make(true);
    }
}
