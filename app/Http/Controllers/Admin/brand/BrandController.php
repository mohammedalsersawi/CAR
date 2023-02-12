<?php

namespace App\Http\Controllers\Admin\brand;

use Throwable;
use App\Models\Brand;
use App\Utils\ImageUpload;
use Illuminate\Http\Request;
use DataTables;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ResponseTrait;

class BrandController extends Controller
{

    use ResponseTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Brand::query();
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
                ->addColumn('image', function ($row) {
                    return 'http://127.0.0.1:8000/uploads/'.$row->avatar->full_small_path;
                })
                ->rawColumns(['image'])
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.pages.brands.index');
    }

    public function store(Request $request)
    {
        $rules = [];
        foreach (locales() as $key => $language) {
            $rules['name_' . $key] = 'required|string|max:255';
        }
        if (!$request->filled('id')) {
            $rules['image'] = 'required|mimes:jpg,jpeg,png,gif';
                $this->validate($request, $rules);
                Brand::createWithRooms($request);
                return $this->sendResponse(null, 'تم الاضافة بنجاح');

        } else {
            $rules['image'] = 'nullable|mimes:jpg,jpeg,png,gif';
            $this->validate($request, $rules);
            Brand::updateWithRooms($request);

            return $this->sendResponse(null, 'تم التعدييل بنجاح');
        }
    }


    public function edit($id)
    {
        $brands = Brand::with('avatar')->find($id);
        return $this->sendResponse($brands, null);
    }

    public function destroy($id)
    {
        $brands = Brand::find($id);
        $brands->delete();
        return $this->sendResponse(null, 'تم الحذف بنجاح');
    }
}
