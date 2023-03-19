<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use App\Models\ModelCar;
use Illuminate\Http\Request;

class DataController extends Controller
{
//    public function area($id)
//    {
//        $area = Area::where("city_id", $id)->pluck("name", "id");
//        return $area;
//    }
//
//    public function country($id)
//    {
//        $country = City::where("country_id", $id)->pluck("name", "id");
//        return $country;
//    }

    public function model($id)
    {
        $ModelCar = ModelCar::where("brand_uuid", $id)->pluck("name","uuid");
        return $ModelCar;
    }
}
