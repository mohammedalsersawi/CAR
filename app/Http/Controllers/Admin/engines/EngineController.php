<?php

namespace App\Http\Controllers\Admin\engines;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ResponseTrait;
use App\Models\Engine;

class EngineController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {

        return view('admin.pages.engines.index');
    }

    public function store(Request $request)
    {
        if (!$request->filled('id')) {
            $rules = [];
            foreach (locales() as $key => $language) {
                $rules['name_' . $key] = 'required|string|max:255';
            }
            $this->validate($request, $rules);
            $engines = new Engine();
            $translations = [
                'en' => $request->name_en,
                'ar' => $request->name_ar
            ];
            $engines->setTranslations('name', $translations);
            $engines->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $engines->save();
            return $this->sendResponse(null, 'تم الاضافة بنجاح');
        } else {
            $rules = [];
            foreach (locales() as $key => $language) {
                $rules['name_' . $key] = 'required|string|max:255';
            }
            $this->validate($request, $rules);
            $engines = Engine::find($request->id);
            $translations = [
                'en' => $request->name_en,
                'ar' => $request->name_ar
            ];
            $engines->setTranslations('name', $translations);
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
        $ModelCar = Engine::find($id);
        $ModelCar->delete();
        return $this->sendResponse(null, 'تم الحذف بنجاح');
    }
}
