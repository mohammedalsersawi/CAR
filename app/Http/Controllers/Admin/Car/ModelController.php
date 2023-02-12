<?php

namespace App\Http\Controllers\Admin\Car;

use DataTables;
use App\Models\ModelCar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ResponseTrait;



class ModelController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ModelCar::query();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" class="btn btn-success btn_edit btn-sm" data-id="'.$row->id.'"
                                                    data-toggle="tooltip" title="تعديل">
                                                    <span class="fa fa-edit">تعديل</span>
                             </a>
                             <a href="javascript:void(0)" class="btn btn-danger btn_delete  btn-sm " data-id="'.$row->id.'"
                                                    data-toggle="tooltip" title="حذف">
                                                    <span class="fa fa fa-times">حذف</span>
                             </a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.pages.model-car.index');
    }

    public function store(Request $request)
    {
        $rules = [];
        foreach (locales() as $key => $language) {
            $rules['name_' . $key] = 'required|string|max:255';
        }
        $this->validate($request, $rules);

        if (!$request->filled('id')) {
            $ModelCar = new ModelCar();
            $ModelCar->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $ModelCar->save();
            return $this->sendResponse(null, 'تم الاضافة بنجاح');
        } else {
            $ModelCar = ModelCar::find($request->id);
            $ModelCar->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $ModelCar->save();
            return $this->sendResponse(null, 'تم التعدييل بنجاح');
        }
    }


    public function edit($id)
    {
        $ModelCar = ModelCar::find($id);
        return response()->json(['status' => true, 'data' => $ModelCar]);
        return $this->sendResponse($ModelCar, null);

    }

    public function destroy($id)
    {
        $ModelCar = ModelCar::find($id);
        $ModelCar->delete();
        return $this->sendResponse(null, 'تم الحذف بنجاح');
    }
}
