<?php

namespace App\Http\Controllers\Admin\Car;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;
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
        $validator = Validator($request->all(),[
            'name'=>'required|max:20|unique:brands',
            'image'=>'required'
        ]);
        if ($validator->fails()){
            return response()->json([
                'error' =>$validator->getMessageBag()->first(), 'Brand'
            ]);
        }

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

            }catch (Throwable $e){
                DB::rollBack();
                return response()->json([
                    'error' => $e
                ]);
            }
        }else{

//            DB::beginTransaction();
//            try {

                $imagename = 'brand' . time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('upload/images/brand'), $imagename);


            $brands=   Brand::create([
                    'name' => ['en' => $request->name_en, 'ar' => $request->name],
                    'image'=>$imagename
                ]);
//            if ($brands) {
                    $brand=Brand::all();
                return view('admin.pages.brands.inclode',compact('brand'))->render();

//            }else{
//                return response()->json([
//                    'message' => $brands ? "Created Successfully" : "Failed to Create"
//                ], $brands ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
//            }
//                DB::commit();

//                if ($brands){
//                    $brand=Brand::all();
//                    return view('admin.pages.brands.inclode',compact('brand'))->render();
//                }else{
//                    return response()->json([
//                        'error' => 'ddd'
//                    ],Response::HTTP_BAD_REQUEST);
//                }

//            }catch (Throwable $e){
//                DB::rollBack();

//            }
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $brand = Brand::findOrFail($request->id);
            File::delete(public_path('upload/images/brand/'.$brand->image));
            $brand->delete();
            DB::commit();
            return response()->json([
                'true' => 'Deleted successfully'
            ]);
        }catch (Throwable $e){
            DB::rollBack();
            return response()->json([
                'error' => $e
            ]);
        }

    }
}
