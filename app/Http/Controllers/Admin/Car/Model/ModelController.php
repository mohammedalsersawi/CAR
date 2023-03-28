<?php

namespace App\Http\Controllers\Admin\Car\Model;

use App\Models\Brand;
use Illuminate\Support\Facades\Gate;
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
        Gate::authorize('model.view');
        $brand = Brand::select(['uuid', 'name'])->get();
        return view('admin.pages.model.index', compact('brand'));
    }

    public function store(Request $request)
    {
        Gate::authorize('model.create');

        $rules = [];
        foreach (locales() as $key => $language) {
            $rules['name_' . $key] = 'required|string|max:255';
        }
        $rules['brand_uuid'] = 'required|exists:brands,uuid';
        $this->validate($request, $rules);
        $data = [];
        foreach (locales() as $key => $language) {
            $data['name'][$key] = $request->get('name_' . $key);
        }
        $data['brand_uuid'] = $request->brand_uuid;

        ModelCar::create($data);
        return $this->sendResponse(null, __('item_added'));
    }


    public function update(Request $request)
    {
        Gate::authorize('model.update');
        $rules = [];
        foreach (locales() as $key => $language) {
            $rules['name_' . $key] = 'required|string|max:255';
        }
        $rules['brand_uuid'] = 'required|exists:brands,uuid';
        $this->validate($request, $rules);
        $data = [];
        foreach (locales() as $key => $language) {
            $data['name'][$key] = $request->get('name_' . $key);
        }
        $data['brand_uuid'] = $request->brand_uuid;

        $modelCar =   ModelCar::findOrFail($request->uuid);
        $modelCar->update($data);
        return $this->sendResponse(null, __('item_edited'));
    }

    public function destroy($uuid)
    {
        Gate::authorize('model.delete');
        $uuids=explode(',', $uuid);
        ModelCar::whereIn('uuid', $uuids)->delete();
        return $this->sendResponse(null, null);
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
            ->addColumn('checkbox',function ($que){
                return $que->uuid;
            })
            ->addColumn('action', function ($que) {
                $data_attr = '';
                $data_attr .= 'data-uuid="' . $que->uuid . '" ';
                $data_attr .= 'data-name="' . $que->name . '" ';
                $data_attr .= 'data-brand_uuid="' . $que->brand_uuid . '" ';
                foreach (locales() as $key => $value) {
                    $data_attr .= 'data-name_' . $key . '="' . $que->getTranslation('name', $key) . '" ';
                }
                $string = '';
                $string .= '<button class="edit_btn btn btn-sm btn-outline-primary btn_edit" data-toggle="modal"
                    data-target="#edit_modal" ' . $data_attr . '>' . __('edit') . '</button>';
                $string .= ' <button type="button" class="btn btn-sm btn-outline-danger btn_delete" data-uuid="' . $que->uuid .
                    '">' . __('delete') . '</button>';
                return $string;
            })
            ->addColumn('status', function ($que) {
                $currentUrl = url('/');
                return '<div class="checkbox">
                <input class="activate-row"  url="' . $currentUrl . "/model/activate/" . $que->uuid . '" type="checkbox" id="checkbox' . $que->id . '" ' .
                    ($que->status ? 'checked' : '')
                    . '>
                <label for="checkbox' . $que->uuid . '"><span class="checkbox-icon"></span> </label>
            </div>';
            })
            ->addColumn('brand', function ($row) {
                return @$row->brand->name;
            })
            ->rawColumns(['action', 'status', 'brand'])->toJson();
    }

    public function activate($uuid)
    {
        Gate::authorize('model.update');
        $activate =  ModelCar::findOrFail($uuid);
        $activate->status = !$activate->status;
        if (isset($activate) && $activate->save()) {
            return $this->sendResponse(null, __('item_edited'));
        }
    }
}
