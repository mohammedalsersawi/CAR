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
use App\Models\year;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
        $ColorCar = ColorCar::select(['name', 'id','color'])->get();
        $year = Year::select(['id', 'to','from'])->get();
        return view('admin.pages.adscar.index', compact(['Brand', 'Engine', 'ModelCar', 'FuelType', 'Transmission', 'ColorCar','year']));
    }


    public function store(Request $request)
    {
        $rules = [];
        $rules['lat'] = 'required';
        $rules['lng'] = 'required';
        $rules['year_id'] = 'required|exists:years,id';
        $rules['phone'] = 'required';
        $rules['mileage'] = 'required';
        $rules['image'] = 'required';
        $rules['brand_id'] = 'required|exists:brands,id';
        $rules ['model_id']=
            ['required',
                Rule::exists(ModelCar::class, 'id')->where(function ($query) use ($request) {
                    $query->where('brand_id',$request->brand_id);
                }),
            ];
        $rules['engine_id'] = 'required|exists:engines,id';
        $rules['fule_type_id'] = 'required|exists:fuel_types,id';
        $rules['color_exterior_id'] = 'required|exists:color_cars,id';
        $rules['color_interior_id'] = 'required|exists:color_cars,id';
        $rules['transmission_id'] = 'required|exists:transmissions,id';
        $this->validate($request, $rules);
        $Car = Car::create($request->only(
            'transmission_id',
            'lat',
            'lng',
            'year_id',
            'phone',
            'mileage',
            'brand_id',
            'model_id',
            'engine_id',
            'fule_type_id',
            'color_exterior_id',
            'color_interior_id',
        ));
        foreach($request->File('image') as $file){
            UploadImage($file, null, 'App\Models\Car', $Car->uuid, false);
        }

        return $this->sendResponse(null, __('item_added'));
    }


    public function update(Request $request)
    {
        $rules = [];
        $rules['lat'] = 'required';
        $rules['lng'] = 'required';
        $rules['year_id'] = 'required|exists:years,id';
        $rules['phone'] = 'required';
        $rules['mileage'] = 'required';
        $rules['image'] = 'nullable|image';
        $rules['brand_id'] = 'required|exists:brands,id';
        $rules ['model_id']=
            ['required',
                Rule::exists(ModelCar::class, 'id')->where(function ($query) use ($request) {
                    $query->where('brand_id',$request->brand_id);
                }),
            ];
        $rules['engine_id'] = 'required|exists:engines,id';
        $rules['fule_type_id'] = 'required|exists:fuel_types,id';
        $rules['color_exterior_id'] = 'required|exists:color_cars,id';
        $rules['color_interior_id'] = 'required|exists:color_cars,id';
        $rules['transmission_id'] = 'required|exists:transmissions,id';
        $this->validate($request, $rules);
        $Car = Car::findOrFail($request->uuid);
        $Car->update($request->only(
            'transmission_id',
            'lat',
            'lng',
            'phone',
            'year_id',
            'mileage',
            'brand_id',
            'model_id',
            'engine_id',
            'fule_type_id',
            'color_exterior_id',
            'color_interior_id',
        ));
        if ($request->hasFile('image')){
            UploadImage($request->image, null, 'App\Models\Car', $Car->uuid, true);
        }
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
            ->filter(function ($query) use ($request) {
                if ($request->get('phone')) {
                    $query->where('phone',$request->phone);
                }
                if ($request->get('mileage')) {
                    $query->where('mileage',$request->get('mileage'));
                }
                if ($request->get('year_id')) {
                    $query->where('year_id',$request->get('year_id'));
                }

                if ($request->get('brand')) {
                    $query->where('brand_id', $request->get('brand'));
                }
                if ($request->get('model')) {
                    $query->where('model_id', $request->get('model'));
                }
                if ($request->get('engine')) {
                    $query->where('engine_id', $request->get('engine'));
                }
                if ($request->get('transmission')) {
                    $query->where('transmission_id', $request->get('transmission'));
                }
                if ($request->get('color_exterior')) {
                    $query->where('color_exterior_id',$request->get('color_exterior'));
                }
                if ($request->get('fueltype')) {
                    $query->where('fule_type_id',$request->get('fueltype'));
                }
                if ($request->get('color_interior')) {
                    $query->where('color_interior_id',$request->get('color_interior'));
                }
            })
            ->addIndexColumn()
            ->addColumn('action', function ($que) {
                $data_attr = '';
                $data_attr .= 'data-uuid="' . @$que->uuid . '" ';
                $data_attr .= 'data-lat="' . @$que->lat . '" ';
                $data_attr .= 'data-lng="' . @$que->lng . '" ';
                $data_attr .= 'data-phone="' . @$que->phone . '" ';
                $data_attr .= 'data-mileage="' .@ $que->mileage . '" ';
                $data_attr .= 'data-year_to="' . @$que->year_to . '" ';
                $data_attr .= 'data-year="' .@$que->year_id . '" ';
                $data_attr .= 'data-brand_id="' .@ $que->brand_id . '" ';
                $data_attr .= 'data-brand_name="' .@ $que->brand->name . '" ';
                $data_attr .= 'data-model_name="' .@ $que->model->name . '" ';
                $data_attr .= 'data-model_id="' .@ $que->model_id . '" ';
                $data_attr .= 'data-engine_id="' .@ $que->engine_id . '" ';
                $data_attr .= 'data-fueltype_id="' . @$que->fule_type_id . '" ';
                $data_attr .= 'data-fueltype_name="' .@ $que->fueltype->name . '" ';
                $data_attr .= 'data-color_exterior_id="' . @$que->color_exterior_id . '" ';
                $data_attr .= 'data-color_interior_id="' . @$que->color_interior_id . '" ';
                $data_attr .= 'data-transmission_id="' .@ $que->transmission_id . '" ';
                $string = '';
                $string .= '<button class="edit_btn btn btn-sm btn-outline-primary btn_edit" data-toggle="modal"
                    data-target="#edit_modal" ' . $data_attr . '>' . __('edit') . '</button>';
                $string .= ' <button type="button" class="btn btn-sm btn-outline-danger btn_delete" data-id="' . $que->uuid .
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
                return $row->color_exterior->color;
            })
            ->addColumn('color_interior', function ($row) {
                return $row->color_interior->color;
            })
            ->addColumn('transmission', function ($row) {
                return $row->transmission->name;
            })
//            ->addColumn('image', function ($row) {
//                $imageData = @$row->image->filename;
//                return $imageData;
//            })
//            ->rawColumns(['image'])
            ->rawColumns(['action'])
            ->make(true);
    }
}
