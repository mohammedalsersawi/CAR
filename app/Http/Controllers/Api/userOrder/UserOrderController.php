<?php

namespace App\Http\Controllers\Api\userOrder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserOrderController extends Controller
{

    public function index()
    {
        return view('admin.pages.user_order.index');
    }
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'phone' => 'required|unique:user_orders,phone|between:12,14',
            'city_id' => 'required',
            'area_id' => 'required',
        ];
        $vaild = $request->all();
        $validator = Validator::make($vaild, $rules);
        if ($validator->fails()) {
            return mainResponse(false, __('order_failed'), [], $validator->errors()->messages(), 101);
        }
        $data = UserOrder::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'city_id' => $request->city_id,
            'area_id' => $request->area_id,
            'user_id' => Auth::guard('sanctum')->id(),
        ]);
        return mainResponse(true, __('order_successfully'), $data, [], 101);
    }


    public function getData(Request $request)
    {
        $userOrder = UserOrder::query();
        return Datatables::of($userOrder)
            // ->filter(function ($query) use ($request) {
            //     if ($request->get('search')) {
            //         $locale = app()->getLocale();
            //         $query->where('name->'.locale(), 'like', "%{$request->search['value']}%");
            //     }
            // })
            ->addIndexColumn()
            ->addColumn('action', function ($que) {
                $data_attr = '';
                $data_attr .= 'data-uuid="' . @$que->uuid . '" ';
                $data_attr .= 'data-name="' .@ $que->name . '" ';

                $string = '';
                $string .= '<button class="edit_btn btn btn-sm btn-outline-primary btn_edit" data-toggle="modal"
                    data-target="#edit_modal" ' . $data_attr . '>' . __('edit') . '</button>';
                $string .= ' <button type="button"  class="btn btn-sm btn-outline-danger btn_delete" data-id="' . @$que->uuid .
                    '">' . __('delete') . '  </button>';
                return $string;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
