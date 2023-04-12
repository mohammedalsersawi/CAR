<?php

namespace App\Http\Controllers\Admin\Admins;

use App\Http\Controllers\Admin\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    use ResponseTrait;
    public function index(){
        Gate::authorize('admin.view');
        $roles=Role::all();
        return view('admin.pages.admin.index',compact('roles'));
    }
    public function store(Request $request){
        Gate::authorize('admin.create');
        $request->validate([
           'name'=>'required',
           'email'=>'required|email|unique:admins',
            'password'=>'required|min:6',
        ]);
        $data=$request->only([
            'name',
            'email',

        ]);
        $data['password']=Hash::make($request->password);

        $admin= Admin::create($data);
        $admin->roles()->attach($request->roles);
        return $this->sendResponse(null, __('item_added'));
    }
    public function edit($uuid){
        Gate::authorize('admin.update');
        $admin=Admin::findOrFail($uuid);
        $roles=Role::all();
        $role_admin=$admin->roles->pluck('uuid')->toArray();
        return view('admin.pages.admin.edit',compact('role_admin','admin','roles'));
    }
    public function update(Request $request){
        Gate::authorize('admin.update');
        $request->validate([
            'name'=>'required',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('admins','email')->ignore($request->uuid,'uuid'),
            ],
            'password'=>'nullable|min:6',
        ]);
        $admin=Admin::findOrFail($request->uuid);
        $data=$request->only([
            'name',
            'email',

        ]);
        $data['password']=Hash::make($request->password);
           $admin->update($data);
        $admin->roles()->sync($request->roles);
        toastr()->success('Data has been Updated successfully!', 'Admin');
        return redirect()->route('admin.index');

    }
    public function destroy($uuid){
        Gate::authorize('admin.delete');
        $uuid_admin=explode(',', $uuid);
        Admin::whereIn('uuid',$uuid_admin)->delete();
        return $this->sendResponse(null, __('item_deleted'));

    }
    public function getData(Request $request)
    {


        $user = Admin::query();
        return Datatables::of($user)

            ->addColumn('checkbox',function ($que){
                return $que->uuid;
            })
            ->addColumn('action', function ($que) {
                $data_attr = 'data-uuid="' . @$que->uuid . '" ';
                $data_attr .= 'data-name="' .@ $que->name . '" ';
                $data_attr .= 'data-email="' .@ $que->email . '" ';
                $string = '';
                        if (Gate::allows('admin.update')){
                            $route=url('/admins/edit/'.$que->uuid);
                            $string .= '<a class="edit_btn btn btn-sm btn-outline-primary" href="'.$route.'" >' . __('edit') . '</a>';
        }

                if (Gate::allows('admin.delete')){

                    $string .= ' <button type="button" class="btn btn-sm btn-outline-danger btn_delete" data-uuid="' . $que->uuid .
                        '">' . __('delete') . '</button>';
                }

                return $string;
            })
            ->addColumn('status', function ($que) {
                $currentUrl = url('/');
                return '<div class="checkbox">
                <input class="activate-row"  url="' . $currentUrl . "/admins/activate/" . $que->uuid . '" type="checkbox" id="checkbox' . $que->uuid . '" ' .
                    ($que->status ? 'checked' : '')
                    . '>
                <label for="checkbox' . $que->uuid . '"><span class="checkbox-icon"></span> </label>
            </div>';
            })
            ->rawColumns(['status','Type','action'])
            ->make(true);
    }

    public function activate($uuid)
    {
        Gate::authorize('admin.update');
        $activate =  Admin::findOrFail($uuid);
        $activate->status = !$activate->status;
        if (isset($activate) && $activate->save()) {
            return $this->sendResponse(null, __('item_edited'));
        }
    }

    public function getRoleForOneAdmin($uuid){
        $admin=Admin::findOrFail($uuid);
                              $role_admin=$admin->roles->pluck('uuid')->toArray();
     return $role_admin;

    }
}
