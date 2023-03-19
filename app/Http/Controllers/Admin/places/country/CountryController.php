<?php

namespace App\Http\Controllers\Admin\places\country;

use App\Http\Controllers\Admin\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CountryController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {

        return view('admin.pages.country.index');
    }

    public function store(Request $request)
    {
        $rules = [];
        foreach (locales() as $key => $language) {
            $rules['name_' . $key] = 'required|string|max:255';
        }
        $data = [];
        foreach (locales() as $key => $language) {
            $data['name'][$key] = $request->get('name_' . $key);
        }
        $this->validate($request, $rules);
        Country::query()->create($data);
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
        $engines = Country::findOrFail($request->uuid);
        $engines->update($data);
        return $this->sendResponse(null, __('item_edited'));
    }

    public function destroy($uuid)
    {
        $uuids=explode(',', $uuid);
        Country::whereIn('uuid', $uuids)->delete();
        return $this->sendResponse(null, null);
    }

    public function getData(Request $request)
    {
        $countrys = Country::query();
        return Datatables::of($countrys)
            ->filter(function ($query) use ($request) {
                if ($request->get('search')) {
                    $query->where('name->' . locale(), 'like', "%{$request->search['value']}%");
                    foreach (locales() as $key => $value) {
                        if ($key != locale())
                            $query->orWhere('name->' . $key, 'like', "%{$request->search['value']}%");
                    }

                }
            })
            ->addColumn('checkbox',function ($que){
                return $que->uuid;
            })
            ->addColumn('action', function ($que) {
                $data_attr = '';
                $data_attr .= 'data-uuid="' . $que->uuid . '" ';
                $data_attr .= 'data-name="' . $que->name . '" ';
                foreach (locales() as $key => $value) {
                    $data_attr .= 'data-name_' . $key . '="' . $que->getTranslation('name', $key) . '" ';
                }
                $string = '';
                $string .= '<button class="edit_btn btn btn-sm btn-outline-primary btn_edit" data-toggle="modal"
                    data-target="#edit_modal" ' . $data_attr . '>' . __('edit') . '</button>';
                $string .= ' <button type="button" class="btn btn-sm btn-outline-danger btn_delete" data-uuid="' . $que->uuid .
                    '">' . __('delete') . '</button>';
                return $string;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
