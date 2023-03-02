<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Admin\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\video;
use App\Models\Year;
use Illuminate\Http\Request;

class SettingController extends Controller

{
    use ResponseTrait;

    public function getyear()
    {
        return view('admin.pages.setting.year.index');
    }

    public function year(Request $request)
    {
        $rules = [
            'from' => 'required',
            'to' => 'required',
        ];
        $this->validate($request, $rules);
        $year = Year::query()->firstOrFail();
        $year?->update($request->only('from', 'to'));
        return $this->sendResponse(null, __('item_added'));
    }

    public function video(Request $request)
    {
        $rules = [
            'video' => 'required'
        ];
        $this->validate($request, $rules);
        $imagename = uniqid() . '.' . $request->video->getClientOriginalExtension();
        $request->video->move(public_path('uploads/'), $imagename);
        video::create(['video' => $imagename]);
        return $this->sendResponse(null, __('item_added'));
    }
}
