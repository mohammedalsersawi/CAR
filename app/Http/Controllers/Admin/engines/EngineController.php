<?php

namespace App\Http\Controllers\Admin\engines;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ResponseTrait;
use App\Models\Engine;
use DataTables;

class EngineController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Engine::query();
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
        return view('admin.pages.engines.index');
    }

    public function store(Request $request)
    {
        if (!$request->filled('id')) {
            $rules = [];
            foreach (locales() as $key => $language) {
                $rules['name_' . $key] = 'required|string|max:255';
            }
            $this->validate($request, $rules);
            Engine::create([
                'name'=>['en' => $request->name_en, 'ar' => $request->name_ar]
            ]);
            return $this->sendResponse(null, 'تم الاضافة بنجاح');
        } else {
            $rules = [];
            foreach (locales() as $key => $language) {
                $rules['name_' . $key] = 'required|string|max:255';
            }
            $this->validate($request, $rules);
            $engines = Engine::find($request->id);
            $translations = [
                'en' => $request->name_en,
                'ar' => $request->name_ar
            ];
            $engines->setTranslations('name', $translations);
            $engines->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $engines->save();
            return $this->sendResponse(null, 'تم التعدييل بنجاح');
        }
    }


    public function edit($id)
    {
        $engines = Engine::find($id);
        return $this->sendResponse($engines, null);

    }

    public function destroy($id)
    {
        $engines = Engine::find($id);
        $engines->delete();
        return $this->sendResponse(null, 'تم الحذف بنجاح');
    }
}
