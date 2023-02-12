<?php

namespace App\Http\Controllers\Admin\brand;

use Throwable;
use App\Models\Brand;
use App\Models\Upload;
use App\Utils\ImageUpload;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Admin\ResponseTrait;

class BrandController extends Controller
{

    use ResponseTrait;

    public function index(Request $request)
    {
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
            ImageUpload::UploadImage($request->image, 'brands', $brands->id);
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
            if ($request->hasFile('image')) {
                ImageUpload::UploadImage($request->image, 'brands', null, null, $request->id);
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

        $fileData = Upload::where(['relation_id' => $id, 'file_type' => 'brands'])->first();
        File::delete(public_path('uploads/' . $fileData->full_small_path));
        $fileData->delete();
        $brands = Brand::find($id);
        $brands->delete();
        return $this->sendResponse(null, 'تم الحذف بنجاح');
    }


    public function indexTable(Request $request)
    {
        $brands = Brand::query();
        return Datatables::of($brands)
            ->filter(function ($query) use ($request) {
                $name = (urlencode($request->get('name')));
                if ($request->get('name')) {
                    $query->where('name->' . locale(), 'like', "%{$request->get('name')}%");
                }
            })->addColumn('action', function ($que) {
                $data_attr = '';
                $data_attr .= 'data-id="' . $que->id . '" ';
                $data_attr .= 'data-name="' . $que->name . '" ';
                $data_attr .= 'data-image="' . $que->avatar->full_small_path . '" ';
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
            ->addColumn('image', function ($row) {
            //    return '{!! asset("uploads/'.$row->avatar->full_small_path.'") !!}';
               $image='<div>
                <img src="'.asset('uploads/'.$row->avatar->full_small_path).'" alt="..." class="img-thumbnail">
                 </div>
                                  ';
             return 'http://127.0.0.1:8000/uploads/'.$row->avatar->full_small_path;

            })
            ->rawColumns(['image'])
            ->rawColumns(['action'])
            ->make(true);
    }
}
