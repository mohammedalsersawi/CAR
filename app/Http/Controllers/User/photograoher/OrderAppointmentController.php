<?php

namespace App\Http\Controllers\User\photograoher;

use App\Http\Controllers\Admin\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Car;
use App\Models\ColorCar;
use App\Models\Engine;
use App\Models\FuelType;
use App\Models\Image;
use App\Models\ModelCar;
use App\Models\OrderAppointment;
use App\Models\Specification;
use App\Models\Transmission;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class OrderAppointmentController extends Controller
{
    use ResponseTrait;
    public function index(){
        $Brand = Brand::select(['name', 'uuid'])->get();
        $Engine = Engine::select(['name', 'uuid'])->get();
        $ModelCar = ModelCar::select(['name', 'uuid'])->get();
        $FuelType = FuelType::select(['name', 'uuid'])->get();
        $Transmission = Transmission::select(['name', 'uuid'])->get();
        $ColorCar = ColorCar::select(['name', 'uuid', 'color'])->get();
        $year = Year::query()->firstOrFail();
        return view('user.photographer.orderappointment',compact('Brand','Engine','ModelCar','FuelType','Transmission','ColorCar','year',));
    }
    public function getData(Request $request)
    {
        $user= Auth::guard('user')->user();
        $OrderAppointment = OrderAppointment::query()->Where(function ($query) use ($user){
            $query->Where('photographer_uuid', $user->uuid)->orWhere('status', OrderAppointment::pending)->where('area_uuid', $user->area_uuid);
        });

        return Datatables::of($OrderAppointment)
            ->filter(function ($query) use ($request) {

                if ($request->get('city_uuid')) {
                    $query->where('city_uuid', $request->get('city_uuid'));
                }
                if ($request->get('area_uuid')) {
                    $query->where('area_uuid', $request->get('area_uuid'));
                }
                if ($request->get('phone')) {
                    $query->where('phone', $request->get('phone'));
                }
                if ($request->get('date')) {
                    $query->where('date', $request->get('date'));
                }
                if ($request->get('status')) {
                    $query->Where('status', $request->get('status'));
                }
            })
            ->addIndexColumn()
            ->addColumn('StatusAppointment',function ($que){
                $string = '';
                $data_attr = 'data-uuid="'. $que->uuid .'"  data-area="' . $que->area_uuid . '" data-city="' . $que->city_uuid . '"';
                if ($que->status==OrderAppointment::pending){
                    $string .= ' <button type="button" class="btn btn-sm btn-outline-danger btn_accept" data-toggle="modal"
                    data-target="#add-car" '. $data_attr .'>' . __('accept') . '    </button>';
                    return "$string";
                }elseif ($que->status==OrderAppointment::accept){
                    $string .= ' <button type="button"  class="btn btn-sm btn-outline-danger add-car" data-toggle="modal"
                    data-target="#add-car" data-uuid="'. $que->uuid .'">' . __('add car') . '  </button>';
                    return "$string";
                }else{
                    return $que->status_appointment;
                }

            })

            ->rawColumns(['StatusAppointment'])
            ->make(true);
    }
    public function accept(Request $request)
    {
        Gate::authorize('PHOTOGRAPHER');


        $rules = [];
        $rules['uuid'] = 'required|exists:order_appointments,uuid';
        $this->validate($request, $rules);
        $Appointment = OrderAppointment::find($request->uuid);
        if (!$Appointment->status != OrderAppointment::pending) {
            $Appointment->update([
                'photographer_uuid' =>Auth::guard('user')->id(),
                'status' => OrderAppointment::accept
            ]);
        }

    }
    public function store(Request $request)
    {
//        Gate::authorize('ads.create');
        $rules = [];
//        $rules['lat'] = 'nullable';
//        $rules['lng'] = 'nullable';
        $rules['year'] = 'required';
        $rules['phone'] = 'required';
        $rules['price'] = 'required';
        $rules['mileage'] = 'required';
        $rules['image'] = 'required';
        $rules['brand_uuid'] = 'required|exists:brands,uuid';
        $rules['appointment_uuid'] = 'nullable|exists:order_appointments,uuid';
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
            'showroom_uuid',
            'appointment_uuid',
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

        if ($request->hasFile('image')){
            foreach ($request->File('image') as $file) {
                UploadImage($file, null, 'App\Models\Car', $Car->uuid, false,null,Image::IMAGE);
            }
        }
        if ($request->hasFile('video')) {

            foreach ($request->File('video') as $file) {
                UploadImage($file, null, 'App\Models\Car', $Car->uuid, false, null, Image::VIDEO);
            }
        }
        $i=0;
        foreach ($request->specification as $item){
            Specification::create([
                'name'=>$request->specification[$i],
                'car_uuid'=>$Car->uuid,
            ]);
            $i++;
        }
            OrderAppointment::find($request->appointment_uuid)->update([
                'status'=>OrderAppointment::complete
            ]);

        return $this->sendResponse(null, __('item_added'));
    }
}
