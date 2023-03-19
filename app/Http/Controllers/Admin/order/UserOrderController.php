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
        $cities = City::select(['name', 'uuid'])->get();

//        return UserOrder::select('uuid')->get();
        return view('admin.pages.user_order.index', compact('cities'));
    }

    public function destroy($uuid)
    {
        $uuid_user=explode(',', $uuid);
        $count = UserOrder::whereIn('uuid',$uuid_user )->where('status',UserOrder::pending)->count();
            event(new CountUserOrderEvent($count));
         UserOrder::whereIn('uuid', $uuid_user)->delete();

return $this->sendResponse(null, null);

    }
    public function accepted($uuid){
       $useroreder= UserOrder::findOrFail($uuid);
       User::where('uuid',$useroreder->user_uuid)->update([
           'name'=>$useroreder->name,
           'city_uuid'=>$useroreder->city_uuid,
           'area_uuid'=>$useroreder->area_uuid,
           'user_type_id'=>User::PHOTOGRAPHER,
           'phone'=>$useroreder->phone
       ]);
        $useroreder->update([
            'status'=>1
        ]);
       //sms
        event(new CountUserOrderEvent(1));
        return $this->sendResponse(null, __('item_added'));

    }
    public function rejected($uuid){
        $useroreder= UserOrder::findOrFail($uuid);
        $useroreder->update([
            'status'=>2
        ]);
        //sms
        event(new CountUserOrderEvent(1));
        return $this->sendResponse(null, __('item_added'));

    }


    public function getData(Request $request)
    {
        $userOrder = UserOrder::query();
        return Datatables::of($userOrder)
             ->filter(function ($query) use ($request) {
                 if ($request->get('phone')) {
                     $query->where('phone', 'like', "%{$request->phone}%");
                 }
                 if ($request->get('city_uuid')) {
                     $query->where('city_uuid', $request->city_uuid);
                 }
                 if ($request->get('area_uuid')) {
                     $query->where('area_uuid', $request->area_uuid);
                 }
                 if ($request->get('status')) {
                     $query->where('status', $request->status);
                 }
             })
            ->addColumn('checkbox',function ($que){
                return $que->uuid;
            })
            ->addColumn('action', function ($que) {
                $string = '';
                if ($que->status == UserOrder::pending){

                    $string .= ' <button type="button"  class="btn btn-sm btn-outline-danger btn-success" data-uuid="' . $que->uuid .
                        '">' . __('accepted') . '  </button> <span>  </span>';

                    $string .= ' <button type="button"     class="btn btn-sm btn-outline-danger  btn-warning" data-uuid="' . $que->uuid .
                        '">' . __('rejected') . '  </button>';
                }else{
                   $string .=($que->status==UserOrder::rejected)?__('rejected'):__('accepted');
                }
                return $string;
            })
            ->addColumn('delete',function ($que){
                $string = '';
                $string .= ' <button type="button"    class="btn btn-sm btn-outline-danger btn_delete" data-uuid="' . $que->uuid .
                    '">' . __('delete') . '  </button>';
                return $string;
            })
            ->rawColumns(['action','delete'])
            ->make(true);
    }
}
