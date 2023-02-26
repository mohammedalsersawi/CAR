<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Admin\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\Year;
use Illuminate\Http\Request;

class SettingController extends Controller

{
    use ResponseTrait;
public function getyear(){
    return view('admin.pages.setting.year.index');
}
    public function year(Request $request){
        $rules=[
          'to'=>'required',
          'from'=>'required'
        ];
        $this->validate($request, $rules);
        Year::create($request->only('to','from'));
        return $this->sendResponse(null, __('item_added'));
    }
}
