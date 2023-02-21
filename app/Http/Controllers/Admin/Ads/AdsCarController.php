<?php

namespace App\Http\Controllers\Admin\Ads;

use App\Http\Controllers\Admin\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Car;
use App\Models\ColorCar;
use App\Models\Engine;
use App\Models\FuelType;
use App\Models\ModelCar;
use App\Models\Transmission;
use App\Utils\ImageUpload;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdsCarController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $Brand = Brand::select(['name', 'id'])->get();
        $Engine = Engine::select(['name', 'id'])->get();
        $ModelCar = ModelCar::select(['name', 'id'])->get();
        $FuelType = FuelType::select(['name', 'id'])->get();
        $Transmission = Transmission::select(['name', 'id'])->get();
        $ColorCar = ColorCar::select(['name', 'id'])->get();
        return view('admin.pages.adscar.index', compact(['Brand', 'Engine', 'ModelCar', 'FuelType', 'Transmission', 'ColorCar']));
    }


    public function store(Request $request)
    {
        $rules = [];
        $rules['lat'] = 'required';
        $rules['lng'] = 'required';
        $rules['year_from'] = 'required';
        $rules['year_to'] = 'required';
        $rules['phone'] = 'required';
        $rules['brand_id'] = 'required|exists:brands,id';
        $rules['model_id'] = 'required|exists:model_cars,id';
        $rules['engine_id'] = 'required|exists:engines,id';
        $rules['fule_type_id'] = 'required|exists:fuel_types,id';
        $rules['color_exterior_id'] = 'required|exists:color_cars,id';
        $rules['color_interior_id'] = 'required|exists:color_cars,id';
        $rules['transmission_id'] = 'required|exists:transmissions,id';
        $this->validate($request, $rules);
        $Car = Car::create($request->except('image'));
        ImageUpload::UploadImage($request->image, null, 'App\Models\Car', $Car->uuid, false);

        return $this->sendResponse(null, __('item_added'));
    }


    public function update(Request $request)
    {
        $rules = [];
        $rules['lat'] = 'required';
        $rules['year_from'] = 'required';
        $rules['year_to'] = 'required';
        $rules['lng'] = 'required';
        $rules['phone'] = 'required';
        $rules['model_id'] = 'required|exists:model_cars,id';
        $rules['brand_id'] = 'required|exists:brands,id';
        $rules['engine_id'] = 'required|exists:engines,id';
        $rules['fule_type_id'] = 'required|exists:fuel_types,id';
        $rules['color_exterior_id'] = 'required|exists:color_cars,id';
        $rules['color_interior_id'] = 'required|exists:color_cars,id';
        $rules['transmission_id'] = 'required|exists:transmissions,id';
        $this->validate($request, $rules);
        $Car = Car::findOrFail($request->uuid);
        $Car->update($request->all());
        ImageUpload::UploadImage($request->image, null, 'App\Models\Car', $Car->id, true);

        return $this->sendResponse(null, __('item_edited'));
    }

    public function destroy($uuid)
    {
        $Car = Car::destroy($uuid);
        return $this->sendResponse(null, null);
    }


    public function getData(Request $request)
    {
        $Car = Car::query();
        return Datatables::of($Car)
//            ->filter(function ($query) use ($request) {
//
//                if ($request->get('city_id')) {
//                    $query->where('city_id',$request->get('city_id'));
//                }
//                if ($request->get('area_id')) {
//                    $query->where('area_id',$request->get('area_id'));
//                }
//                if ($request->get('phone')) {
//                    $query->where('phone','like', "%{$request->phone}%");
//                }
//                if ($request->get('number')) {
//                    $query->where('number', 'like', "%{$request->get('number')}%");
//                }
//                if ($request->get('user_type_id')) {
//                    $query->where('user_type_id', $request->get('user_type_id'));
//                }
//            })
            ->addIndexColumn()
            ->addColumn('action', function ($que) {
                $data_attr = '';
                $data_attr .= 'data-uuid="' . $que->uuid . '" ';
                $data_attr .= 'data-lat="' . $que->lat . '" ';
                $data_attr .= 'data-lng="' . $que->lng . '" ';
                $data_attr .= 'data-phone="' . $que->phone . '" ';
                $data_attr .= 'data-brand_id="' . $que->brand_id . '" ';
                $data_attr .= 'data-model_id="' . $que->model_id . '" ';
                $data_attr .= 'data-engine_id="' . $que->engine_id . '" ';
                $data_attr .= 'data-fueltype_id="' . $que->fueltype_id . '" ';
                $data_attr .= 'data-color_exterior_id="' . $que->color_exterior_id . '" ';
                $data_attr .= 'data-color_interior_id="' . $que->color_interior_id . '" ';
                $data_attr .= 'data-transmission_id="' . $que->transmission_id . '" ';
                $string = '';
                $string .= '<button class="edit_btn btn btn-sm btn-outline-primary btn_edit" data-toggle="modal"
                    data-target="#edit_modal" ' . $data_attr . '>' . __('edit') . '</button>';
                $string .= ' <button type="button" class="btn btn-sm btn-outline-danger btn_delete" data-id="' . $que->id .
                    '">' . __('delete') . '</button>';
                return $string;
            })
            ->addColumn('brand', function ($row) {
                return $row->brand->name;
            })
            ->addColumn('model', function ($row) {
                return $row->model->name;
            })
            ->addColumn('engine', function ($row) {
                return $row->engine->name;
            })
            ->addColumn('fueltype', function ($row) {
                return $row->fueltype->name;
            })
            ->addColumn('color_exterior', function ($row) {
                return $row->color->name;
            })
            ->addColumn('color_interior', function ($row) {
                return $row->color->name;
            })
            ->addColumn('transmission', function ($row) {
                return $row->transmission->id;
            })
            ->addColumn('image', function ($row) {
                $imageData = $row->image->filename;
                return $imageData;
            })
            ->rawColumns(['image'])
            ->rawColumns(['action'])
            ->make(true);
    }
}
