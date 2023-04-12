<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Admin\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\video;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SettingController extends Controller

{
    use ResponseTrait;

    public function getyear()
    {
        Gate::authorize('setting.view');
        $year = Year::query()->first();
        return view('admin.pages.setting.year.index',compact('year'));
    }

    public function year(Request $request)
    {
        Gate::authorize('setting.view');
        $rules = [
            'from' => 'required',
            'to' => 'required',
        ];
        $this->validate($request, $rules);
        Year::query()->updateOrCreate(
            ['uuid'=>1],
            [
            'from'=>$request->from,
            'to'=>$request->to
        ]);
        return $this->sendResponse(null, __('item_added'));
    }

    public function video(Request $request)
    {
        Gate::authorize('setting.view');
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
