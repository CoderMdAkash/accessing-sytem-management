<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\SubCategory;
use App\Models\Category;
use Str;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perpage = $data['perpage'] = $request->perpage ?? 10;
        $search = $data['search'] = $request->search ?? null;

        $data['subcategories'] = SubCategory::join('categories', 'categories.id', 'sub_categories.category_id')
            ->orderBy('sub_categories.id', 'desc')
            ->where(function ($query) use ($search){
                $query->where('sub_categories.subcategory_name', 'like', '%'.$search.'%')
                        ->where('categories.category_name', 'like', '%'.$search.'%');
            })
            ->select('sub_categories.*', 'categories.category_name')
            ->paginate($perpage);

        return view('admin.subcategory.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['categories'] = Category::all();
        return view('admin.subcategory.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'subcategory_name' => 'required|unique:sub_categories',
            'category_id' => 'required',
            'status'        => 'required',
        ]);

        if ($validator->passes()) {

            if($request->hasfile('image')){ 
                $validator =  Validator::make($request->all(), [
                    'image'         => 'required|image|mimes:jpeg,png,jpg|dimensions:width=120,height=120',
                ]);
                $imageName = Str::slug($request->input('subcategory_name')).'-'.date('d.m.Y.h.s').'.'.$request->image->extension();  
                $request->image->move(public_path('frontend/images/subcategory/'), $imageName);
            }

            $subcategory = new SubCategory();
            $subcategory->category_id = $request->category_id;
            $subcategory->subcategory_name = $request->subcategory_name;
            $subcategory->slug = Str::slug($request->subcategory_name);
            if(@$imageName){
                $subcategory->image = $imageName;
            }
            $subcategory->status = $request->status;
            $subcategory->save();

            return response()->json(['success' => true, 'mgs' => 'subCategory Successfully Created']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['categories'] = Category::all();
        $data['subcategory'] = SubCategory::findOrFail($id);
        return view('admin.subcategory.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator =  Validator::make($request->all(), [
            'category_id'      => 'required',
            'subcategory_name' => 'required',
            'status'           => 'required',
            'category_id'      => 'required',
        ]);

        if($request->image){
            $validator =  Validator::make($request->all(), [
                'image'         => 'required|image|mimes:jpeg,png,jpg|dimensions:width=120,height=120',
            ]);
        }

        if ($validator->passes()) {

            if($request->hasfile('image')){ 
                $imageName = Str::slug($request->input('subcategory_name')).'-'.date('d.m.Y.h.s').'.'.$request->image->extension();  
                $request->image->move(public_path('frontend/images/subcategory/'), $imageName);
            }

            $subcategory = SubCategory::findOrFail($id);
            $subcategory->subcategory_name = $request->subcategory_name;
            $subcategory->category_id = $request->category_id;
            $subcategory->slug = Str::slug($request->subcategory_name);
            if($request->image){
                if($subcategory->image){
                    @unlink('frontend/images/subcategory/'.$subcategory->image);
                }
                $subcategory->image = $imageName;
            }
            $subcategory->status = $request->status;
            $subcategory->save();

            return response()->json(['success' => true, 'mgs' => 'subCategory Successfully Updated']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if($id){
            SubCategory::find($id)->delete();
            return response()->json(['success' => true, 'mgs' => 'subCategory Successfully Deleted']);
        }
    }
}
