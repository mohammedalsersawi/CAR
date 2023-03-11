<?php

namespace App\Http\Controllers\Admin\order;

use App\Events\CountUserOrderEvent;
use App\Http\Controllers\Admin\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\User;
use App\Models\UserOrder;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserOrderController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $cities=City::select(['name','id'])->get();

//        return UserOrder::select('uuid')->get();
        return view('admin.pages.user_order.index',compact('cities'));
    }
    public function destroy($uuid){
       $userorder= UserOrder::where('uuid',$uuid)->first();
        if ($userorder->status==UserOrder::pending){
            event(new CountUserOrderEvent());
        }

        $userorder->delete();

        return $this->sendResponse(null, null);
    }
    public function accepted($uuid){
       $useroreder= UserOrder::findOrFail($uuid);
       User::where('id',$useroreder->user_id)->update([
           'name'=>$useroreder->name,
           'city_id'=>$useroreder->city_id,
           'area_id'=>$useroreder->area_id,
           'user_type_id'=>User::PHOTOGRAPHER,
           'phone'=>$useroreder->phone
       ]);
        $useroreder->update([
            'status'=>1
        ]);
       //sms
        event(new CountUserOrderEvent());
        return $this->sendResponse(null, __('item_added'));

    }
    public function rejected($uuid){
        $useroreder= UserOrder::findOrFail($uuid);
        $useroreder->update([
            'status'=>2
        ]);
        //sms
        event(new CountUserOrderEvent());
        return $this->sendResponse(null, __('item_added'));

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
                $string = '';
                if ($que->status == UserOrder::pending){

                    $string .= ' <button type="button"  class="btn btn-sm btn-outline-danger btn-success" data-id="' . $que->uuid .
                        '">' . __('accepted') . '  </button> <span>  </span>';

                    $string .= ' <button type="button"     class="btn btn-sm btn-outline-danger  btn-warning" data-id="' . $que->uuid .
                        '">' . __('rejected') . '  </button>';
                }else{
                   $string .=($que->status==UserOrder::rejected)?__('rejected'):__('accepted');
                }
                return $string;
            })
            ->addColumn('delete',function ($que){
                $string = '';
                $string .= ' <button type="button"    class="btn btn-sm btn-outline-danger btn_delete" data-id="' . $que->uuid .
                    '">' . __('delete') . '  </button>';
                return $string;
            })
            ->rawColumns(['action','delete'])
            ->make(true);
    }
}
