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
//                    $image='<div>
//                         <img src="'.asset('uploads/'.$row->avatar->full_small_path).'" alt="..." class="img-thumbnail">
//
//                           </div>
//                   ';
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
        if (!$request->filled('id')) {
                $rules = [];
                foreach (locales() as $key => $language) {
                    $rules['name_' . $key] = 'required|string|max:255';
                    $rules['image'] = 'required|mimes:jpg,jpeg,png,gif';
                }
                $this->validate($request, $rules);
                $brands = new Brand();
                $translations = [
                    'en' => $request->name_en,
                    'ar' => $request->name_ar
                ];
                $brands->setTranslations('name', $translations);
                $brands->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
                $brands->save();
                ImageUpload::UploadImage($request->image, 'brands', $brands->id , 17);
                return $this->sendResponse(null, 'تم الاضافة بنجاح');

        } else {
            $rules = [];
            foreach (locales() as $key => $language) {
                $rules['name_' . $key] = 'required|string|max:255';
            }
            $this->validate($request, $rules);
            $brands = Brand::find($request->id);
            $translations = [
                'en' => $request->name_en,
                'ar' => $request->name_ar
            ];
            $brands->setTranslations('name', $translations);
            $brands->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            
            $brands->save();
            if($request->hasFile('image')){
                ImageUpload::UploadImage($request->image, 'brands' ,null, null ,1);

            }

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
