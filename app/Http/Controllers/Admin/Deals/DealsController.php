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
        $user=User::select(['phone','id','name'])->get();
        $type=Type::select(['id','name'])->get();
        return view('admin.pages.deal.index',compact('user','type'));
    }
    public function store(Request $request)
    {
        $rules = [];
        $rules['image'] = 'required|image';
        foreach (locales() as $key => $language) {
            $rules['deals_' . $key] = 'required|string|max:255';
        }

        $this->validate($request, $rules);
        $data = [];
        foreach (locales() as $key => $language) {
            $data['deals'][$key] = $request->get('deals_' . $key);
        }
        $data['user_id']=$request->user_id;
        $deals =  Deals::create($data);
        UploadImage($request->image, null, 'App\Models\Deals', $deals->uuid, false);
        return $this->sendResponse(null, __('item_added'));
    }
    public function update(Request $request)
    {
        $rules = [];

        foreach (locales() as $key => $language) {
            $rules['deals_' . $key] = 'required|string|max:255';
        }
        $rules['image'] = 'nullable|image';
        $this->validate($request, $rules);
        $data = [];

        foreach (locales() as $key => $language) {
            $data['deals'][$key] = $request->get('deals_' . $key);
        }

        $data['user_id']=$request->user_id;

        $deals =Deals::findOrFail($request->uuid);

        $deals->update($data);
        if ($request->hasFile('image')) {
            UploadImage($request->image, null, 'App\Models\Deals', $deals->uuid, true);
        }
        return $this->sendResponse(null, __('item_edited'));

    }
    public function destroy($uuid)
    {
        $deals =Deals::destroy($uuid);
        return $this->sendResponse(null, null);
    }
    public function getData(Request $request)
    {
        $deals = Deals::query();

        return Datatables::of($deals)

            ->addIndexColumn()
            ->filter(function ($query) use ($request) {
                if ($request->get('user_id')) {
                    $user=User::where('name','like', "%{$request->get('user_id')}%")->pluck('id');
                    $query->whereIn('user_id', $user);
                }
                if ($request->get('deals')) {
                    $query->where('deals->'.locale(),'like', "%{$request->get('deals')}%");
                }
                if ($request->get('type_id')) {
                    $user=User::where('type_id',$request->get('type_id'))->pluck('id');
                    $query->whereIn('user_id',$user);
                }
//                if ($request->get('search')) {
//                    $locale = app()->getLocale();
//                    $query->where('deals->'.locale(), 'like', "%{$request->search['value']}%");
//                }
            })
            ->addColumn('action', function ($que) {
                $data_attr = '';
                $data_attr .= 'data-uuid="' . $que->uuid . '" ';
                $data_attr .= 'data-deals="' . $que->deals . '" ';
                $data_attr .= 'data-user_id="' . $que->user_id . '" ';
                $data_attr .= 'data-type_id="' . $que->type_id . '" ';
                $data_attr .= 'data-image="' . @$que->image->filename . '" ';
                foreach (locales() as $key => $value) {
                    $data_attr .= 'data-deals_' . $key . '="' . $que->getTranslation('deals', $key) . '" ';
                }
                $string = '';
                $string .= '<button class="edit_btn btn btn-sm btn-outline-primary btn_edit" data-toggle="modal"
                    data-target="#edit_modal" ' . $data_attr . '>' . __('edit') . '</button>';
                $string .= ' <button type="button"  class="btn btn-sm btn-outline-danger btn_delete" data-id="' . $que->uuid .
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
