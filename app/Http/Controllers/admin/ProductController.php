<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\Category;
use App\Models\SubCategory;
use Validator;
use Str;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perpage = $data['perpage'] = $request->perpage ?? 10;
        $search = $data['search'] = $request->search ?? null;

        $data['products'] = Product::join('categories', 'categories.id', 'products.category_id')
            ->join('sub_categories', 'sub_categories.id', 'products.subcategory_id')
            ->orderBy('products.id', 'desc')
            ->where(function ($query) use ($search){
                $query->where('products.product_name', 'like', '%'.$search.'%')
                        ->where('categories.category_name', 'like', '%'.$search.'%');
            })
            ->select('products.*', 'categories.category_name', 'sub_categories.subcategory_name')
            ->paginate($perpage);

        return view('admin.product.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['categories'] = Category::all();
        return view('admin.product.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'product_name'   => 'required|unique:products',
            'category_id'    => 'required',
            'subcategory_id' => 'required',
            'images.*'       => 'required|image|mimes:jpeg,png,jpg|dimensions:width=350,height=350',
            'status'         => 'required',
        ]);
        if ($validator->passes()) {

            $product = new Product();
            $product->product_name = $request->product_name;
            $product->slug = Str::slug($request->product_name);
            $product->category_id = $request->category_id;
            $product->subcategory_id = $request->subcategory_id;
            $product->description = $request->description;
            $product->subcategory_id = $request->subcategory_id;
            $product->status = $request->status;
            $product->save();

            $product_id = DB::getPdo()->lastInsertId();

            foreach($request->images as $key => $image){
                if($request->images[$key]){ 
                    
                    $imageName = Str::slug($request->product_name).'-'.$key.'-'.date('d.m.Y.h.s').'.'.$request->images[$key]->extension();  
                    $request->images[$key]->move(public_path('frontend/images/product/'), $imageName);

                    $image = new ProductImages();
                    $image->product_id = $product_id;
                    $image->image = $product_id;
                    $image->image = $imageName;
                    $image->save();
                }
            }

            return response()->json(['success' => true, 'mgs' => 'Product Successfully Created']);
        }else{
            return response()->json(['error' => true, $validator->errors()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['images'] = ProductImages::where('product_id', $id)->get();
        return view('admin.product.product_images', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['categories'] = Category::all();
        $data['product'] = $product = Product::find($id);
        $data['subcategories'] = SubCategory::where('category_id', $product->category_id)->get();
        $data['product_images'] = ProductImages::where('product_id', $id)->get();

        return view('admin.product.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator =  Validator::make($request->all(), [
            'product_name'   => 'required',
            'category_id'    => 'required',
            'subcategory_id' => 'required',
            'status'         => 'required',
        ]);
        if($request->images){
            $validator =  Validator::make($request->all(), [
                'images.*'       => 'required|image|mimes:jpeg,png,jpg|dimensions:width=350,height=350',
            ]);
        }
        if ($validator->passes()) {

            $product = Product::find($id);
            $product->product_name = $request->product_name;
            $product->slug = Str::slug($request->product_name);
            $product->category_id = $request->category_id;
            $product->subcategory_id = $request->subcategory_id;
            $product->description = $request->description;
            $product->subcategory_id = $request->subcategory_id;
            $product->status = $request->status;
            $product->save();

            if($request->images){
                $product_images = ProductImages::where('product_id', $id)->get();
                ProductImages::where('product_id', $id)->delete();
                foreach($product_images as $img){
                    @unlink('frontend/images/product/'.$img->image);
                }
                
                foreach($request->images as $key => $image){
                    if($request->images[$key]){ 
                        
                        $imageName = Str::slug($request->product_name).'-'.$key.'-'.date('d.m.Y.h.s').'.'.$request->images[$key]->extension();  
                        $request->images[$key]->move(public_path('frontend/images/product/'), $imageName);
    
                        $image = new ProductImages();
                        $image->product_id = $id;
                        $image->image = $imageName;
                        $image->save();
                    }
                }
            }

            return response()->json(['success' => true, 'mgs' => 'Product Successfully Updated']);
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
            Product::find($id)->delete();
            $product_images = ProductImages::where('product_id', $id)->get();
            ProductImages::where('product_id', $id)->delete();
            foreach($product_images as $img){
                @unlink('frontend/images/product/'.$img->image);
            }
            return response()->json(['success' => true, 'mgs' => 'Product Successfully Deleted']);
        }
    }
}
