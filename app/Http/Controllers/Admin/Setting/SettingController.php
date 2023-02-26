<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function year(Request $request){
        $rule=[
          'to'=>'required',
          'from'=>'required'
        ];
        
    }
}
