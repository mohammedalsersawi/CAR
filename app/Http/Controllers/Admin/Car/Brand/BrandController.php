<?php

namespace App\Http\Controllers\Admin\Car\Brand;

use App\Models\Image;
use Throwable;
use App\Models\Brand;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $brands =  Brand::create($data);
        if ($request->hasFile('image')) {
            UploadImage($request->image, null, 'App\Models\Brand', $brands->uuid, false, null, Image::IMAGE);
        }
        return $this->sendResponse(null, __('item_added'));
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
        $brands =   Brand::findOrFail($request->uuid);
        $brands->update($data);
        if ($request->hasFile('image')) {
            UploadImage($request->image, null, 'App\Models\Brand', $brands->uuid, true, null, Image::IMAGE);
        }
        return $this->sendResponse(null, __('item_edited'));
    }

    public function destroy($uuid)
    {
        Brand::destroy($uuid);
        return $this->sendResponse(null, null);
    }


    public function getData(Request $request)
    {
        $brands = Brand::query();
        return Datatables::of($brands)
            ->filter(function ($query) use ($request) {
                if ($request->get('search')) {
                    $query->where('name->' . locale(), 'like', "%{$request->search['value']}%");
                    foreach (locales() as $key => $value) {
                        if ($key != locale())
                            $query->orWhere('name->' . $key, 'like', "%{$request->search['value']}%");
                    }
                }
            })
            ->addIndexColumn()
            ->addColumn('action', function ($que) {
                $data_attr = '';
                $data_attr .= 'data-uuid="' . @$que->uuid . '" ';
                $data_attr .= 'data-name="' . @$que->name . '" ';
                $data_attr .= 'data-image="' . @$que->image . '" ';
                foreach (locales() as $key => $value) {
                    $data_attr .= 'data-name_' . $key . '="' . $que->getTranslation('name', $key) . '" ';
                }
                $string = '';
                $delete_route = "{{route('brand.delete',$que->uuid)}}";
                $string .= '<button class="edit_btn btn btn-sm btn-outline-primary btn_edit" data-toggle="modal"
                    data-target="#edit_modal" ' . $data_attr . '>' . __('edit') . '</button>';
                $string .= ' <button type="button"  class="btn btn-sm btn-outline-danger btn_delete" data-uuid="' . $que->uuid .
                    '">' . __('delete') . '  </button>';
                return $string;
            })
            ->addColumn('image', function ($row) {
                $imageData = @$row->imageBrand->filename;
                return @$imageData;
            })
            ->addColumn('status', function ($que) {
                $currentUrl = url('/');
                return '<div class="checkbox">
                <input class="activate-row"  url="' . $currentUrl . "/brand/activate/" . $que->uuid . '" type="checkbox" id="checkbox' . $que->id . '" ' .
                    ($que->status ? 'checked' : '')
                    . '>
                <label for="checkbox' . $que->uuid . '"><span class="checkbox-icon"></span> </label>
            </div>';
            })
            ->rawColumns(['action', 'status', 'image'])->toJson();
    }
    public function activate($uuid)
    {
        $activate =  Brand::findOrFail($uuid);
        $activate->status = !$activate->status;
        if (isset($activate) && $activate->save()) {
            return $this->sendResponse(null, __('item_edited'));
        }
    }
}
