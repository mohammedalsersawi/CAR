<?php

namespace App\Http\Controllers\Admin\Car;

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
        return view('admin.pages.model.mode-car');
    }

    public function store(Request $request)
    {
        $rules = [];
        foreach (locales() as $key => $language) {
            $rules['name_' . $key] = 'required|string|max:255';
        }
        $this->validate($request, $rules);
            $ModelCar = new ModelCar();
            $ModelCar->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $ModelCar->save();
            return $this->sendResponse(null, 'تم الاضافة بنجاح');

    }


    public function update(Request $request)
    {
        $rules = [];
        foreach (locales() as $key => $language) {
            $rules['name_' . $key] = 'required|string|max:255';
        }
        $this->validate($request, $rules);
        $ModelCar = ModelCar::find($request->id);
        $ModelCar->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $ModelCar->save();
        return $this->sendResponse(null, 'تم التعدييل بنجاح');

    }

    public function destroy($id)
    {
        $ModelCar = ModelCar::find($id);
        $ModelCar->delete();
        return $this->sendResponse(null, 'تم الحذف بنجاح');
    }


    public function getData()
    {
        $modelCars = ModelCar::query();
        return Datatables::of($modelCars)
            ->addIndexColumn()
            ->addColumn('action', function ($que) {
                $data_attr = '';
                $data_attr .= 'data-id="' . $que->id . '" ';
                $data_attr .= 'data-name="' . $que->name . '" ';
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
            ->rawColumns(['action'])
            ->make(true);
    }
}
