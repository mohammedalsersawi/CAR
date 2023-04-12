<?php

namespace App\Http\Controllers\Admin\profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index(){
        $user= Auth::guard('web')->user();
        return view('admin.pages.profile.index',compact('user'));
    }
}
