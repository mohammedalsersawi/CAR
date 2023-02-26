<?php

namespace App\Http\Controllers\Admin\order;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use App\Models\UserOrder;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserOrderController extends Controller
{
    public function index()
    {
        $cities=City::select(['name','id'])->get();
        $area=Area::select(['id','name'])->get();
        return view('admin.pages.user_order.index',compact('cities','area'));
    }
    public function getData(Request $request)
    {
        $userOrder = UserOrder::query();
        return Datatables::of($userOrder)
             ->filter(function ($query) use ($request) {
                 if ($request->get('name')) {
                     $query->where('name', 'like', "%{$request->name}%");
                 }
                 if ($request->get('phone')) {
                     $query->where('phone', 'like', "%{$request->phone}%");
                 }
                 if ($request->get('city_id')) {
                     $query->where('city_id', $request->city_id);
                 }
                 if ($request->get('area_id')) {
                     $query->where('area_id', $request->area_id);
                 }
                 if ($request->get('status')) {
                     $query->where('status', $request->status);
                 }
             })
            ->addIndexColumn()
            ->addColumn('action', function ($que) {
                $data_attr = '';
                $data_attr .= 'data-uuid="' . @$que->uuid . '" ';
                $data_attr .= 'data-name="' .@$que->name . '" ';
                $data_attr .= 'data-user="' .@$que->user . '" ';
                $data_attr .= 'data-phone="' .@$que->phone . '" ';
                $data_attr .= 'data-area="' .@$que->area . '" ';
                $data_attr .= 'data-city="' .@$que->city . '" ';
                $data_attr .= 'data-status="' .@$que->status . '" ';
                $string = '';
                $string .= ' <button type="button"  class="btn btn-sm btn-outline-danger btn_delete" data-id="' . @$que->uuid .
                    '">' . __('delete') . '  </button>';
                return $string;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
