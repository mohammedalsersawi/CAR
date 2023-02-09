<?php

namespace App\Http\Controllers\Admin\Car;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Throwable;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brand=Brand::all();
        return view('admin.pages.brands.index',compact('brand'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|max:20',
            'image'=>'required'
        ]);
        if ($request->has('id')){
            DB::beginTransaction();
            try {
                $brand=Brand::findOrFail($request->id);
                $imagename=$brand->image;
                    if($request->has('image')){
                        File::delete(public_path('upload/images/brand/'.$brand->image));
                        $imagename = 'brand' . time() . '_' . $request->file('image')->getClientOriginalName();
                        $request->file('image')->move(public_path('upload/images/brand'), $imagename);
                    }

                $data=$request->except('image');
                $data['image']=$imagename;
                $brand->update($data);
                DB::commit();
                return response()->json([
                    'success' => 'true',
                ]);
            }catch (Throwable $e){
                DB::rollBack();
                return response()->json([
                    'error' => $e
                ]);
            }
        }else{
            DB::beginTransaction();
            try {

                $imagename = 'brand' . time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('upload/images/brand'), $imagename);
                $data=$request->except('image');
                $data['image']=$imagename;
                Brand::create($data);
                DB::commit();
                return response()->json([
                    'success' => 'true',
                ]);
            }catch (Throwable $e){
                DB::rollBack();
                return response()->json([
                    'error' => $e
                ]);
            }
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand=Brand::findOrFail($id);
        File::delete(public_path('upload/images/brand/'.$brand->image));
        $brand->delete();

    }
}
