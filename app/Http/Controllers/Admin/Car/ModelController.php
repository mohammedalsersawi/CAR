<?php

namespace App\Http\Controllers\Admin\Car;

use App\Http\Controllers\Controller;
use App\Models\ModelCar;
use Illuminate\Http\Request;

class ModelController extends Controller
{
    public function index()
    {
        return view('admin.pages.model');
    }

    public function store(Request $request)
    {
        $rules = [
        ];
        foreach (locales() as $key => $language) {
            $rules['name_' . $key] = 'required|string|max:255';
        }
        $this->validate($request, $rules);
        $ModelCar = new ModelCar();
        $translations = [
            'en' => $request->name_en,
            'ar' => $request->name_ar
        ];
        $ModelCar->setTranslations('name', $translations);
        $ModelCar->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $ModelCar->save();
        if ($request->ajax()) {
            return response()->json(['status' => true , 'message' => 'تم الحفظ بنجاح']);
        }

    }
}
