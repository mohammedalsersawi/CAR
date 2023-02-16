<?php

namespace App\Http\Controllers\Admin\Car\Brand;

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
        return view('admin.pages.brand.index');
    }


    public function store(Request $request)
    {
        $rules = [];
        $rules['image'] = 'required|image';
        foreach (locales() as $key => $language) {
            $rules['name_' . $key] = 'required|string|max:255';
        }

        $this->validate($request, $rules);
        $data = [];
        foreach (locales() as $key => $language) {
            $data['name'][$key] = $request->get('name_' . $key);
        }
        $this->validate($request, $rules);
        $brands =   Brand::query()->create($data);
        if ($request->hasFile('image')) {
            ImageUpload::UploadImage($request->image, 'brands', $brands->id, null, null);
        }
        return $this->sendResponse(null, 'تم التعدييل بنجاح');
    }

    public function update(Request $request)
    {
        $rules = [];
        foreach (locales() as $key => $language) {
            $rules['name_' . $key] = 'required|string|max:255';
        }
        $rules['image'] = 'nullable|image';
        $this->validate($request, $rules);
        $data = [];
        foreach (locales() as $key => $language) {
            $data['name'][$key] = $request->get('name_' . $key);
        }
        $this->validate($request, $rules);
        $brands =   Brand::findOrFail($request->id);
        $brands->update($data);
        if ($request->hasFile('image')) {
            ImageUpload::UploadImage($request->image, 'brands', null, null, $brands->id);
        }
        return $this->sendResponse(null, 'تم التعدييل بنجاح');

    }

    public function destroy($id)
    {
        $brands = Brand::find($id);
        $brands->delete();
        return $this->sendResponse(null, 'تم الحذف بنجاح');
    }


    public function getData(Request $request)
    {
        $brands = Brand::query();
        return Datatables::of($brands)
            ->addIndexColumn()
            ->addColumn('action', function ($que) {
                $data_attr = '';
                $data_attr .= 'data-id="' . $que->id . '" ';
                $data_attr .= 'data-name="' . $que->name . '" ';
                $data_attr .= 'data-image="' . $que->avatar->full_small_path . '" ';
                foreach (locales() as $key => $value) {
                    $data_attr .= 'data-name_' . $key . '="' . $que->getTranslation('name', $key) . '" ';
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
                $imageData = $row->avatar->full_small_path;
                return $imageData;
            })
            ->rawColumns(['image'])
            ->rawColumns(['action'])
            ->make(true);
    }
}
