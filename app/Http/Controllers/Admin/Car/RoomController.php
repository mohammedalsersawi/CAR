<?php

namespace App\Http\Controllers\Admin\Car;

use App\Http\Controllers\Admin\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\RoomCar;
use App\Utils\ImageUpload;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\File;

class RoomController extends Controller
{
    use ResponseTrait;


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = RoomCar::query();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" class="btn btn-success btn_edit btn-sm" data-id="' . $row->id . '"
                                                    data-toggle="tooltip" title="تعديل">
                                                    <span class="fa fa-edit">تعديل</span>
                             </a>
                             <a href="javascript:void(0)" class="btn btn-danger btn_delete  btn-sm " data-id="' . $row->id . '"
                                                    data-toggle="tooltip" title="حذف">
                                                    <span class="fa fa fa-times">حذف</span>
                             </a>';
                    return $btn;
                })
                ->addColumn('image', function ($row) {
                    return 'http://127.0.0.1:8000/uploads/' . $row->avatar->full_small_path;
                })
                ->rawColumns(['image'])
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.pages.car.rooms');

    }
    public function store(Request $request){
        $rules = [];
        foreach (locales() as $key => $language) {
            $rules['name_' . $key] = 'required|string|max:45';
            $rules['city_' . $key] = 'required|string|max:45';
                 }
        if ($request->id){
            $rules['image'] = 'nullable';
            $this->validate($request, $rules);
            RoomCar::updateWithRooms($request);
            return $this->sendResponse(null, 'تم التعديل بنجاح ');
        }
        $rules['image'] = 'required|image';
        $this->validate($request, $rules);
        RoomCar::createWithRooms($request);
        return $this->sendResponse(null, 'تم الاضافة بنجاح');
    }





    public function edit($id){
        $brands = RoomCar::with('avatar')->find($id);
        return $this->sendResponse($brands, null);
    }
    public function destroy($id)
    {
        $Room = RoomCar::find($id);
        $Room->delete();
        return $this->sendResponse(null, 'تم الحذف بنجاح');
    }
}
