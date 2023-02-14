<?php

namespace App\Http\Controllers\Admin\Car;

use App\Http\Controllers\Admin\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\RoomCar;
use App\Utils\ImageUpload;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;

class RoomController extends Controller
{
    use ResponseTrait;


    public function index()
    {

        return view('admin.pages.room.rooms');
    }
    public function store(Request $request)
    {
        $rules = [];
        foreach (locales() as $key => $language) {
            $rules['name_' . $key] = 'required|string|max:45';
            $rules['city_' . $key] = 'required|string|max:45';
        }

        $rules['image'] = 'required|image';
        $this->validate($request, $rules);
        RoomCar::createWithRooms($request);
        return $this->sendResponse(null, 'تم الاضافة بنجاح');
    }

    public function update(Request $request)
    {
        $rules = [];
        foreach (locales() as $key => $language) {
            $rules['name_' . $key] = 'required|string|max:45';
            $rules['city_' . $key] = 'required|string|max:45';
        }
        $rules['image'] = 'nullable|image';
        $this->validate($request, $rules);
        RoomCar::updateWithRooms($request);
        return $this->sendResponse(null, 'تم التعديل بنجاح ');
    }
    public function destroy($id)
    {
        $Room = RoomCar::find($id);
        $Room->delete();
        return $this->sendResponse(null, 'تم الحذف بنجاح');
    }
    public function getData()
    {
        $data = RoomCar::query();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($que) {
                $data_attr = '';
                $data_attr .= 'data-id="' . $que->id . '" ';
                $data_attr .= 'data-name="' . $que->name . '" ';
                $data_attr .= 'data-image="' . $que->avatar->full_small_path . '" ';
                foreach (locales() as $key => $value) {
                    $data_attr .= 'data-name_' . $key . '="' . $que->getTranslation('name', $key) . '" ';
                }
                foreach (locales() as $key => $value) {
                    $data_attr .= 'data-city_' . $key . '="' . $que->getTranslation('city', $key) . '" ';
                }
                $string = '';
                $delete_route = "{{route('brand.delete',$que->id)}}";
                $string .= '<button class="edit_btn btn btn-sm btn-outline-primary btn_edit" data-toggle="modal"
                    data-target="#edit_modal" ' . $data_attr . '>' . __('edit') . '</button>';
                $string .= ' <button type="button"  class="btn btn-sm btn-outline-danger btn_delete" data-id="' . $que->id .
                    '">' . __('delete') . '  </button>';
                return $string;
            })
            ->addColumn('image', function ($row) {
                return 'http://127.0.0.1:8000/uploads/' . $row->avatar->full_small_path;
            })
            ->rawColumns(['image'])
            ->rawColumns(['action'])
            ->make(true);
    }
}
