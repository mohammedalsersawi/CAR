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
                    $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm">View</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.pages.model');
    }

    public function store(Request $request)
    {
        if (!$request->filled('id')) {
            $rules = [];
            foreach (locales() as $key => $language) {
                $rules['name_' . $key] = 'required|string|max:255';
            }
            $this->validate($request, $rules);
            $ModelCar = new ModelCar();
            $translations = [
                'en' => $request->name_en,
                'ar' => $request->name_ar
            ];
            $ModelCar->setTranslations('name', $translations);
            $ModelCar->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $ModelCar->save();
            return $this->sendResponse(null, 'تم الاضافة بنجاح');
        } else {
            $rules = [];
            foreach (locales() as $key => $language) {
                $rules['name_' . $key] = 'required|string|max:255';
            }
            $this->validate($request, $rules);
            $ModelCar = ModelCar::find($request->id);
            $translations = [
                'en' => $request->name_en,
                'ar' => $request->name_ar
            ];
            $ModelCar->setTranslations('name', $translations);
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
