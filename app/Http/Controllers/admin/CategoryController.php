<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Category;
use Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perpage = $data['perpage'] = $request->perpage ?? 10;
        $search = $data['search'] = $request->search ?? '';
        $data['categories'] = Category::orderBy('id', 'desc')
            ->where(function ($query) use ($search){
                $query->where('category_name', 'like', '%'.$search.'%');
            })
            ->paginate($perpage);

        return view('admin.category.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'category_name' => 'required|unique:categories',
            'image'         => 'required|image|mimes:jpeg,png,jpg|dimensions:width=120,height=120',
            'status'        => 'required',
        ]);

        if ($validator->passes()) {

            if($request->hasfile('image')){ 
                $imageName = Str::slug($request->input('category_name')).'-'.date('d.m.Y.h.s').'.'.$request->image->extension();  
                $request->image->move(public_path('frontend/images/category/'), $imageName);
            }

            $category = new Category();
            $category->category_name = $request->category_name;
            $category->slug = Str::slug($request->category_name);
            $category->image = $imageName;
            $category->status = $request->status;
            $category->save();

            return response()->json(['success' => true, 'mgs' => 'Category Successfully Created']);
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
        $data['category'] = Category::findOrFail($id);
        return view('admin.category.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator =  Validator::make($request->all(), [
            'category_name' => 'required',
            'status'        => 'required',
        ]);

        if($request->image){
            $validator =  Validator::make($request->all(), [
                'image'         => 'required|image|mimes:jpeg,png,jpg|dimensions:width=120,height=120',
            ]);
        }

        if ($validator->passes()) {

            if($request->hasfile('image')){ 
                $imageName = Str::slug($request->input('category_name')).'-'.date('d.m.Y.h.s').'.'.$request->image->extension();  
                $request->image->move(public_path('frontend/images/category/'), $imageName);
            }

            $category = Category::findOrFail($id);
            $category->category_name = $request->category_name;
            $category->slug = Str::slug($request->category_name);
            if($request->image){
                if($category->image){
                    @unlink('frontend/images/category/'.$category->image);
                }
                $category->image = $imageName;
            }
            $category->status = $request->status;
            $category->save();

            return response()->json(['success' => true, 'mgs' => 'Category Successfully Updated']);
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
            Category::find($id)->delete();
            return response()->json(['success' => true, 'mgs' => 'Category Successfully Deleted']);
        }
    }
}
