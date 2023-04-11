<?php

namespace App\Http\Controllers\Admin\Role;

use App\Http\Controllers\Controller;
use App\Models\Role;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
{
    public function index(){
        Gate::authorize('role.view');

        $role=Role::all();
        return view('admin.pages.role.index',compact('role'));
    }
    public function create(){
        Gate::authorize('role.create');

        return view('admin.pages.role.add',[
            'role'=>new Role(),
        ]);
    }
    public function store(Request $request){
        Gate::authorize('role.create');
        $validator=  Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'abilities' => 'required|array',

        ]);
        if ($validator->fails()){
            toastr()->error($validator->getMessageBag()->first(), 'Admin');
            return redirect()->back();
        }
        Role::createWithAbilities($request);
        toastr()->success('Data has been ADD successfully!', 'Roles');

        return view('admin.pages.role.add',[
            'role'=>new Role(),
        ]);
    }
    public function edit(Role $role){
        Gate::authorize('role.update');
        $role_abilities = $role->abilities()->pluck('type', 'ablity')->toArray();
        return view('admin.pages.role.edit',compact('role','role_abilities'));

    }
    public function update(Request $request,Role $role){
        Gate::authorize('role.update');
        $request->validate([
            'name' => 'required|string|max:255',
            'abilities' => 'required|array',
        ]);
        $role->updateWithAbilities($request);
        return redirect()
            ->route('role.index');
    }
    public function destroy($id)
    {
        Gate::authorize('role.delete');
        Role::destroy($id);
        return  response()->json(
            [
                "msg"=>"done"
            ]
        );


    }
}
