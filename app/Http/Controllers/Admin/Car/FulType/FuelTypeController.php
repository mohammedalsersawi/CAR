<?php

namespace App\Http\Controllers\Admin\Car\FulType;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ResponseTrait;
use App\Models\FuelType;
use Yajra\DataTables\Facades\DataTables;

class FuelTypeController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        return view('admin.pages.fuelType.fuelType');
    }

    public function store(Request $request)
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
        FuelType::query()->create($data);
        return $this->sendResponse(null, __('item_added'));
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
        $fuelType =   FuelType::findOrFail($request->id);
        $fuelType->update($data);
        return $this->sendResponse(null, __('item_edited'));
    }

    public function destroy($id)
    {
        $fuel_type = FuelType::find($id);
        $fuel_type->delete();
        return $this->sendResponse(null, null);
    }

    public function getData(Request $request)
    {
        $fuel_type = FuelType::query();
        return Datatables::of($fuel_type)
            ->addIndexColumn()
            ->addColumn('action', function ($que) {
                $data_attr = '';
                $data_attr .= 'data-id="' . $que->id . '" ';
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