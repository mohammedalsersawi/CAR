<?php

namespace App\Http\Controllers\Admin\Ads;

use App\Models\Car;
use App\Models\Specification;
use App\Models\User;
use App\Models\year;
use App\Models\Brand;
use App\Models\Image;
use App\Models\Engine;
use App\Models\ColorCar;
use App\Models\FuelType;
use App\Models\ModelCar;
use App\Models\Transmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Admin\ResponseTrait;

class AdsCarController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $Brand = Brand::select(['name', 'uuid'])->get();
        $Engine = Engine::select(['name', 'uuid'])->get();
        $ModelCar = ModelCar::select(['name', 'uuid'])->get();
        $FuelType = FuelType::select(['name', 'uuid'])->get();
        $Transmission = Transmission::select(['name', 'uuid'])->get();
        $ColorCar = ColorCar::select(['name', 'uuid', 'color'])->get();
        $User = User::select(['name', 'uuid','phone'])->get();
        $year = Year::query()->firstOrFail();

        return view('admin.pages.adscar.index', compact(['User','Brand', 'Engine', 'ModelCar', 'FuelType', 'Transmission', 'ColorCar', 'year']));
    }


    public function store(Request $request)
    {

        $rules = [];
        $rules['lat'] = 'required';
        $rules['lng'] = 'required';
        $rules['year'] = 'required';
        $rules['phone'] = 'required';
        $rules['price'] = 'required';

        $rules['mileage'] = 'required';
        $rules['image'] = 'required';
        $rules['user_uuid'] = 'required|exists:users,uuid';

        $rules['brand_uuid'] = 'required|exists:brands,uuid';
        $rules['model_uuid'] =
            [
                'required',
                Rule::exists(ModelCar::class, 'uuid')->where(function ($query) use ($request) {
                    $query->where('brand_uuid', $request->brand_uuid);
                }),
            ];
        $rules['engine_uuid'] = 'required|exists:engines,uuid';
        $rules['fule_type_uuid'] = 'required|exists:fuel_types,uuid';
        $rules['color_exterior_uuid'] = 'required|exists:color_cars,uuid';
        $rules['color_interior_uuid'] = 'required|exists:color_cars,uuid';
        $rules['transmission_uuid'] = 'required|exists:transmissions,uuid';
        $this->validate($request, $rules);

        $Car = Car::create($request->only(
            'transmission_uuid',
            'lat',
            'lng',
            'year',
            'user_uuid',
            'phone',
            'price',
            'mileage',
            'brand_uuid',
            'model_uuid',
            'engine_uuid',
            'fule_type_uuid',
            'color_exterior_uuid',
            'color_interior_uuid',
        ));
        foreach ($request->File('image') as $file) {
            UploadImage($file, null, 'App\Models\Car', $Car->uuid, false);
        }
        $i=0;
        foreach ($request->specification as $item){
            Specification::create([
                'name'=>$request->specification[$i],
                'car_uuid'=>$Car->uuid,
            ]);
            $i++;
        }
        return $this->sendResponse(null, __('item_added'));
    }


    public function update(Request $request)
    {
        $rules = [];
        $rules['lat'] = 'required';
        $rules['lng'] = 'required';
        $rules['year'] = 'required';
        $rules['phone'] = 'required';
        $rules['price'] = 'required';

        $rules['mileage'] = 'required';
        $rules['user_uuid'] = 'required|exists:users,uuid';

        $rules['brand_uuid'] = 'required|exists:brands,uuid';
        $rules['model_uuid'] =
            [
                'required',
                Rule::exists(ModelCar::class, 'uuid')->where(function ($query) use ($request) {
                    $query->where('brand_uuid', $request->brand_uuid);
                }),
            ];
        $rules['engine_uuid'] = 'required|exists:engines,uuid';
        $rules['fule_type_uuid'] = 'required|exists:fuel_types,uuid';
        $rules['color_exterior_uuid'] = 'required|exists:color_cars,uuid';
        $rules['color_interior_uuid'] = 'required|exists:color_cars,uuid';
        $rules['transmission_uuid'] = 'required|exists:transmissions,uuid';
        $this->validate($request, $rules);
        $Car = Car::findOrFail($request->uuid);
        $Car->update($request->only(
            'transmission_uuid',
            'lat',
            'user_uuid',
            'lng',
            'phone',
            'price',
            'year',
            'mileage',
            'brand_uuid',
            'model_uuid',
            'engine_uuid',
            'fule_type_uuid',
            'color_exterior_uuid',
            'color_interior_uuid',
        ));
        if ($request->hasFile('image')) {
            foreach ($request->File('image') as $file) {
                UploadImage($file, null, 'App\Models\Car', $Car->uuid, false);
            }
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
                    $query->where('phone', $request->phone);
                }
                if ($request->get('price')) {
                    $query->where('price', $request->price);
                }
                if ($request->get('user_uuid')) {
                    $query->where('user_uuid', $request->user_uuid);
                }
                if ($request->get('mileage')) {
                    $query->where('mileage', $request->get('mileage'));
                }
                if ($request->get('year')) {
                    $query->where('year', $request->get('year'));
                }

                if ($request->get('brand')) {
                    $query->where('brand_uuid', $request->get('brand'));
                }
                if ($request->get('model')) {
                    $query->where('model_uuid', $request->get('model'));
                }
                if ($request->get('engine')) {
                    $query->where('engine_uuid', $request->get('engine'));
                }
                if ($request->get('transmission')) {
                    $query->where('transmission_uuid', $request->get('transmission'));
                }
                if ($request->get('color_exterior')) {
                    $query->where('color_exterior_uuid', $request->get('color_exterior'));
                }
                if ($request->get('fueltype')) {
                    $query->where('fule_type_uuid', $request->get('fueltype'));
                }
                if ($request->get('color_interior')) {
                    $query->where('color_interior_uuid', $request->get('color_interior'));
                }
            })
            ->addIndexColumn()
            ->addColumn('action', function ($que) {
                $data_attr = '';
                $data_attr .= 'data-uuid="' . @$que->uuid . '" ';
                $data_attr .= 'data-price="' . @$que->price . '" ';
                $data_attr .= 'data-lat="' . @$que->lat . '" ';
                $data_attr .= 'data-lng="' . @$que->lng . '" ';
                $data_attr .= 'data-phone="' . @$que->phone . '" ';
                $data_attr .= 'data-mileage="' . @$que->mileage . '" ';
                $data_attr .= 'data-year="' . @$que->year . '" ';
                $data_attr .= 'data-brand_uuid="' . @$que->brand_uuid . '" ';
                $data_attr .= 'data-user="' . @$que->user_uuid . '" ';
                $data_attr .= 'data-brand_name="' . @$que->brand->name . '" ';
                $data_attr .= 'data-model_name="' . @$que->model->name . '" ';
                $data_attr .= 'data-model_uuid="' . @$que->model_uuid . '" ';
                $data_attr .= 'data-engine_uuid="' . @$que->engine_uuid . '" ';
                $data_attr .= 'data-fule_type_uuid="' . @$que->fule_type_uuid . '" ';
                $data_attr .= 'data-color_exterior_uuid="' . @$que->color_exterior_uuid . '" ';
                $data_attr .= 'data-color_interior_uuid="' . @$que->color_interior_uuid . '" ';
                $data_attr .= 'data-transmission_uuid="' . @$que->transmission_uuid . '" ';
                $string = '';
                $string .= '<button class="edit_btn btn btn-sm btn-outline-primary btn_edit" data-toggle="modal"
                    data-target="#edit_modal" ' . $data_attr . '>' . __('edit') . '</button>';
                $string .= ' <button type="button" class="btn btn-sm btn-outline-danger btn_delete" data-uuid="' . $que->uuid .
                    '">' . __('delete') . '</button>';
                $string .= ' <a href="' . url('ads/car/images') . '/' . $que->uuid . '" class="btn btn-sm btn-outline-danger"
                >' . __('details') . '</a>';

                return $string;
            })

            ->addColumn('color_exterior_car', function ($row) {
                return $row->color_exterior_car->color;
            })
            ->addColumn('color_interior_car', function ($row) {
                return $row->color_interior_car->color;
            })


            ->rawColumns(['action'])
            ->make(true);
    }


    public function showImages($uuid)
    {
        $uuid = $uuid;
        return view('admin.pages.adscar.details', compact('uuid'));
    }
    public function showCard(Request $request)
    {
        $data = Car::where('uuid', $request->uuid)->get()->pluck('ImagesCar')->flatten();
        return view('admin.pages.adscar.card-image', compact('data'))->render();
    }


    public function deleteimages($uuid, $idd)
    {
        $data = Image::findOrFail($idd);
        File::delete(public_path('uploads/' . $data->filename));
        $data->delete();
        return $this->sendResponse(null, null);
    }
    public function updateImages(Request $request)
    {

        $rules = [];
        $rules['car_image'] = 'required|image';
        $this->validate($request, $rules);
        $Car = Image::findOrFail($request->uuid);
        if ($Car) {
            UploadImage($request->car_image, null, 'App\Models\Car', $Car->imageable_id, true, $Car->uuid);
            return $this->sendResponse(null, __('item_edited'));
        }
    }
}
