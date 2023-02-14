<?php

namespace App\Http\Controllers\Admin\Car;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ResponseTrait;
use App\Models\Engine;
use Yajra\DataTables\Facades\DataTables;

class EngineController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {

        return view('admin.pages.car.engines');
    }

    public function store(Request $request)
    {
        $rules = [];
        foreach (locales() as $key => $language) {
            $rules['name_' . $key] = 'required|string|max:255';
        }
        $this->validate($request, $rules);

        if (!$request->filled('id')) {
            Engine::create([
                'name' => ['en' => $request->name_en, 'ar' => $request->name_ar]
            ]);
            return $this->sendResponse(null, 'تم الاضافة بنجاح');
        } else {
            $engines = Engine::find($request->id);
            $engines->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $engines->save();
            return $this->sendResponse(null, 'تم التعدييل بنجاح');
        }
    }


    public function edit($id)
    {
        $engines = Engine::find($id);
        return $this->sendResponse($engines, null);
    }

    public function destroy($id)
    {
        $engines = Engine::find($id);
        $engines->delete();
        return $this->sendResponse(null, 'تم الحذف بنجاح');
    }

    public function getData(Request $request)
    {
        $engines = Engine::query();
        return Datatables::of($engines)
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
