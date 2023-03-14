<?php

namespace App\Http\Controllers\Admin\Deals;

use App\Http\Controllers\Admin\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\Deals;
use App\Models\Type;
use App\Models\User;
use App\Utils\ImageUpload;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DealsController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        $user=User::select(['phone','uuid','name'])->where('user_type_id',User::DISCOUNT_STORE)->get();
        $type=Type::select(['uuid','name'])->get();
        return view('admin.pages.deal.index',compact('user','type'));
    }
    public function store(Request $request)
    {
        $rules = [];
        $rules['image'] = 'required|image';
        $rules['deals'] = 'required|string|max:255';

        $this->validate($request, $rules);
        $data = [];
        $data['deals']= $request->get('deals');
        $data['user_uuid']=$request->user_uuid;
        $deals =  Deals::create($data);
        UploadImage($request->image, null, 'App\Models\Deals', $deals->uuid, false);
        return $this->sendResponse(null, __('item_added'));
    }
    public function update(Request $request)
    {
        $rules = [];
        $rules['deals'] = 'required|string|max:255';

        $rules['image'] = 'c|image';
        $this->validate($request, $rules);
        $data = [];
        $data['deals']= $request->get('deals');

        $data['user_uuid']=$request->user_uuid;

        $deals =Deals::findOrFail($request->uuid);

        $deals->update($data);
        if ($request->hasFile('image')) {
            UploadImage($request->image, null, 'App\Models\Deals', $deals->uuid, true);
        }
        return $this->sendResponse(null, __('item_edited'));

    }
    public function destroy($uuid)
    {
       Deals::destroy($uuid);
        return $this->sendResponse(null, null);
    }
    public function getData(Request $request)
    {
        $deals = Deals::query();
        return Datatables::of($deals)
            ->addIndexColumn()
            ->filter(function ($query) use ($request) {
                if ($request->get('user_uuid')) {
                    $user=User::where('name','like', "%{$request->get('user_uuid')}%")->pluck('uuid');
                    $query->whereIn('user_uuid', $user);
                }
                if ($request->get('deals')) {
                    $query->where('deals','like', "%{$request->get('deals')}%");
                }
                if ($request->get('discount_type_uuid')) {
                    $user=User::where('discount_type_uuid',$request->get('discount_type_uuid'))->pluck('uuid');
                    $query->whereIn('user_uuid',$user);
                }
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

}
