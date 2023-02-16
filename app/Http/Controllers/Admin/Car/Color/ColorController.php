<?php

namespace App\Http\Controllers\Admin\Car\Color;

use App\Http\Controllers\Admin\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\ColorCar;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ColorController extends Controller
{

    use ResponseTrait;
    public function index(Request $request)
    {
        return view('admin.pages.color.color');
    }


    public function store(Request $request)
    {
        $rules = [];
        foreach (locales() as $key => $language) {
            $rules['name_' . $key] = 'required|string|max:255';
        }
        $rules['color'] = 'required|string';

        $this->validate($request, $rules);
        $data = [];
        foreach (locales() as $key => $language) {
            $data['name'][$key] = $request->get('name_' . $key);
        }
        $data['color'] = $request->color;
        $this->validate($request, $rules);
        ColorCar::query()->create($data);
        return $this->sendResponse(null, 'تم الاضافة بنجاح');
    }


    public function update(Request $request)
    {
        $rules = [];
        foreach (locales() as $key => $language) {
            $rules['name_' . $key] = 'required|string|max:255';
        }
        $this->validate($request, $rules);
        $data = [];
        foreach (locales() as $key => $language) {
            $data['name'][$key] = $request->get('name_' . $key);
        }
        $data['color'] = $request->color;
        $colorCar =   ColorCar::findOrFail($request->id);
        $colorCar->update($data);
        return $this->sendResponse(null, 'تم التعدييل بنجاح');
    }

    public function destroy($id)
    {
        $Color = ColorCar::find($id);
        $Color->delete();
        return $this->sendResponse(null, 'تم الحذف بنجاح');
    }


    public function getData()
    {
        $modelCars = ColorCar::query();
        return Datatables::of($modelCars)
            ->addIndexColumn()
            ->addColumn('action', function ($que) {
                $data_attr = '';
                $data_attr .= 'data-id="' . $que->id . '" ';
                $data_attr .= 'data-color="' . $que->color . '" ';
                $data_attr .= 'data-name="' . $que->name . '" ';
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
            ->rawColumns(['action'])
            ->make(true);
    }
}
