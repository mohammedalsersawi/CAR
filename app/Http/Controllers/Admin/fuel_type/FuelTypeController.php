<?php

namespace App\Http\Controllers\Admin\fuel_type;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ResponseTrait;
use App\Models\FuelType;
use DataTables;

class FuelTypeController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = FuelType::query();
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
        return view('admin.pages.fuel_type.index');
    }

    public function store(Request $request)
    {
        if (!$request->filled('id')) {
            $rules = [];
            foreach (locales() as $key => $language) {
                $rules['name_' . $key] = 'required|string|max:255';
            }
            $this->validate($request, $rules);
            $fuel_type = new FuelType();
            $translations = [
                'en' => $request->name_en,
                'ar' => $request->name_ar
            ];
            $fuel_type->setTranslations('name', $translations);
            $fuel_type->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $fuel_type->save();
            return $this->sendResponse(null, 'تم الاضافة بنجاح');
        } else {
            $rules = [];
            foreach (locales() as $key => $language) {
                $rules['name_' . $key] = 'required|string|max:255';
            }
            $this->validate($request, $rules);
            $fuel_type = FuelType::find($request->id);
            $translations = [
                'en' => $request->name_en,
                'ar' => $request->name_ar
            ];
            $fuel_type->setTranslations('name', $translations);
            $fuel_type->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $fuel_type->save();
            return $this->sendResponse(null, 'تم التعدييل بنجاح');
        }
    }


    public function edit($id)
    {
        $fuel_type = FuelType::find($id);
        return $this->sendResponse($fuel_type, null);

    }

    public function destroy($id)
    {
        $fuel_type = FuelType::find($id);
        $fuel_type->delete();
        return $this->sendResponse(null, 'تم الحذف بنجاح');
    }
}
