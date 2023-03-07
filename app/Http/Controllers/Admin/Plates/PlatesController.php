<?php

namespace App\Http\Controllers\Admin\Plates;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlatesController extends Controller
{
    public function index()
    {
        return view('admin.pages.Plates.index');
    }
}
