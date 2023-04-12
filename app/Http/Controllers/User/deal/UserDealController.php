<?php

namespace App\Http\Controllers\User\deal;

use App\Http\Controllers\Admin\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\Deals;
use App\Models\Image;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class UserDealController extends Controller
{
    use ResponseTrait;
    public function index(){
        Gate::authorize('DISCOUNT_STORE');
        $deals = Deals::all();
       $type= Type::all();

        return view('user.deal.index',compact('deals','type'));
    }
    public function getData(Request $request)
    {
        $user= Auth::guard('user')->user();
        $Deals = Deals::query()->Where('user_uuid',$user->uuid);

        return Datatables::of($Deals)
            ->filter(function ($query) use ($request) {

                if ($request->get('deals')) {
                    $query->where('deals','like', "%{$request->get('deals')}%");
                }
            })
            ->addColumn('checkbox',function ($que){
                return $que->uuid;
            })
            ->addColumn('action', function ($que) {
                $data_attr = '';
                $data_attr .= 'data-uuid="' . $que->uuid . '" ';
                $data_attr .= 'data-deals="' . $que->deals . '" ';
                $data_attr .= 'data-user_uuid="' . $que->user_uuid . '" ';
                $data_attr .= 'data-discount_store_type="' . $que->discount_store_type . '" ';
                $data_attr .= 'data-image="' . @$que->image->filename . '" ';
                $string = '';
                $string .= '<button class="edit_btn btn btn-sm btn-outline-primary btn_edit" data-toggle="modal"
                    data-target="#edit_modal" ' . $data_attr . '>' . __('edit') . '</button>';
                $string .= ' <button type="button"  class="btn btn-sm btn-outline-danger btn_delete" data-uuid="' . $que->uuid .
                    '">' . __('delete') . '  </button>';
                return $string;
            })
            ->addColumn('image', function ($row) {
                $imageData = @$row->imageDeal->filename;
                return @$imageData;
            })
            ->rawColumns(['image'])
            ->rawColumns(['action'])
            ->make(true);
    }
    public function store(Request $request)
    {
        Gate::authorize('DISCOUNT_STORE');
        $user= Auth::guard('user')->user();

        $rules = [];
        $rules['image'] = 'required|image';
        $rules['deals'] = 'required|string|max:255';

        $this->validate($request, $rules);
        $data = [];
        $data['deals']= $request->get('deals');
        $data['user_uuid']=$user->uuid;
        $deals =  Deals::create($data);
        UploadImage($request->image, null, 'App\Models\Deals', $deals->uuid, false,null,Image::IMAGE);
        return $this->sendResponse(null, __('item_added'));
    }
    public function update(Request $request)
    {
        Gate::authorize('DISCOUNT_STORE');
        $user= Auth::guard('user')->user();

        $rules = [];
        $rules['deals'] = 'required|string|max:255';

        $rules['image'] = 'nullable|image';
        $this->validate($request, $rules);
        $data = [];
        $data['deals']= $request->get('deals');

        $data['user_uuid']=$user->uuid;

        $deals =Deals::findOrFail($request->uuid);

        $deals->update($data);
        if ($request->hasFile('image')) {
            UploadImage($request->image, null, 'App\Models\Deals', $deals->uuid, true,null,Image::IMAGE);
        }
        return $this->sendResponse(null, __('item_edited'));

    }
    public function destroy($uuid)
    {
        Gate::authorize('DISCOUNT_STORE');
        $uuids=explode(',', $uuid);
        Deals::whereIn('uuid', $uuids)->delete();
        return $this->sendResponse(null, null);
    }
}
