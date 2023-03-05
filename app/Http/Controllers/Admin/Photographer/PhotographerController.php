<?php

namespace App\Http\Controllers\Admin\Photographer;

use App\Http\Controllers\Admin\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use App\Models\Photographer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PhotographerController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        $cities=City::select(['name','id'])->get();
        $country=Country::select(['name','id'])->get();
        return view('admin.pages.photographer.index',compact('country','cities'));
    }
    public function store(Request $request)
    {
        $rules = [];
        $rules['image'] = 'required|image';
        $rules['city_id'] = 'nullable|exists:cities,id';
        $rules['user_id'] = 'required|exists:users,id';
        $rules ['area_id']=
            ['nullable',
                Rule::exists(Area::class, 'id')->where(function ($query) use ($request) {
                    $query->where('city_id',$request->city_id);
                }),
            ];
        $rules['time'] = 'required';
        $rules['date'] = 'required';

        $this->validate($request, $rules);

        $photographer =  Photographer::create($request->only(['user_id','city_id','area_id','time','date']));
        UploadImage($request->image, null, Photographer::class, $photographer->uuid, false);
        return $this->sendResponse(null, __('item_added'));
    }
    public function update(Request $request)
    {
        $rules = [];
        foreach (locales() as $key => $language) {
            $rules['deals_' . $key] = 'required|string|max:255';
        }
        $rules['image'] = 'c|image';
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
                if ($request->get('discount_type_id')) {
                    $user=User::where('discount_type_id',$request->get('discount_type_id'))->pluck('id');
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
                $data_attr .= 'data-discount_store_type="' . $que->discount_store_type . '" ';
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
