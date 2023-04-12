<?php

namespace App\Http\Controllers\Admin\UserTyue;

use App\Http\Controllers\Admin\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class TypeController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        Gate::authorize('user.view');
        return view('admin.pages.usertype.Type');
    }
    public function store(Request $request)
    {
        Gate::authorize('user.create');
        $rules = [];
        foreach (locales() as $key => $language) {
            $rules['name_' . $key] = 'required|string|max:255';
        }
        $this->validate($request, $rules);
        $data = [];
        foreach (locales() as $key => $language) {
            $data['name'][$key] = $request->get('name_' . $key);
        }
       Type::create($data);
        return $this->sendResponse(null, __('item_added'));
    }
    public function update(Request $request)
    {
        Gate::authorize('user.update');
        $rules = [];
        foreach (locales() as $key => $language) {
            $rules['name_' . $key] = 'required|string|max:255';
        }        $this->validate($request, $rules);

        $data = [];
        foreach (locales() as $key => $language) {
            $data['name'][$key] = $request->get('name_' . $key);
        }
        $deals =Type::findOrFail($request->uuid);
        $deals->update($data);
        return $this->sendResponse(null, __('item_edited'));

    }
    public function destroy($uuid)
    {
        Gate::authorize('user.delete');
        $uuids=explode(',', $uuid);
        Type::whereIn('uuid', $uuids)->delete();
        return $this->sendResponse(null, null);
    }
    public function getData(Request $request)
    {
        $deals = Type::query();

        return Datatables::of($deals)

            ->addColumn('checkbox',function ($que){
                return $que->uuid;
            })
            ->addColumn('action', function ($que) {
                $data_attr = '';
                $data_attr .= 'data-uuid="' . $que->uuid . '" ';
                foreach (locales() as $key => $value) {
                    $data_attr .= 'data-name_' . $key . '="' . $que->getTranslation('name', $key) . '" ';
                }
                $string = '';
                $string .= '<button class="edit_btn btn btn-sm btn-outline-primary btn_edit" data-toggle="modal"
                    data-target="#edit_modal" ' . $data_attr . '>' . __('edit') . '</button>';
                $string .= ' <button type="button"  class="btn btn-sm btn-outline-danger btn_delete" data-uuid="' . $que->uuid .
                    '">' . __('delete') . '  </button>';
                return $string;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
