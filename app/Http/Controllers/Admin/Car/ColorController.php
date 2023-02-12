<?php

namespace App\Http\Controllers\Admin\Car;

use App\Http\Controllers\Admin\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\ColorCar;
use Illuminate\Http\Request;
use DataTables;

class ColorController extends Controller
{

    use ResponseTrait;
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ColorCar::query();
            return Datatables::of($data)->addIndexColumn()
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
//                ->editColumn('color','coulm')
//                ->rawColumns(['color'])
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.pages.color.index');
    }


    public function store(Request $request)
    {
        $rules = [];
        foreach (locales() as $key => $language) {
            $rules['name_' . $key] = 'required|string|max:255';
        }
        $this->validate($request, $rules);

        if (!$request->filled('id')) {
            ColorCar::create([
                'name'=>['en' => $request->name_en, 'ar' => $request->name_ar],
                'color'=>$request->color
            ]);
            return $this->sendResponse(null, 'تم الاضافة بنجاح');
        } else {
            $Color = ColorCar::find($request->id);
            $Color->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $Color->color=$request->color;
            $Color->save();
            return $this->sendResponse(null, 'تم التعدييل بنجاح');
        }
    }


    public function edit($id)
    {
        $engines = ColorCar::find($id);
        return $this->sendResponse($engines, null);

    }

    public function destroy($id)
    {
        $engines = Engine::find($id);
        $engines->delete();
        return $this->sendResponse(null, 'تم الحذف بنجاح');
    }

}
