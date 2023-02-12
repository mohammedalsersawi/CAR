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


    public function getData(Request $request)
    {
        $brands = Brand::query();
        return Datatables::of($brands)
            ->filter(function ($query) use ($request) {
                $name = (urlencode($request->get('name')));
                if ($request->get('name')) {
                    $query->where('name->' . locales(), 'like', "%{$request->get('name')}%");
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
                $imageData = $row->avatar->full_small_path;
                return $imageData;
            })
            ->rawColumns(['image'])
            ->rawColumns(['action'])
            ->make(true);
    }
}
