<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubCategory;

class CommonController extends Controller
{
    public function category_wise_sub_category($id){
        $data['subcategories'] = SubCategory::where('category_id', $id)->get();
        return view('admin.product.category_wise_sub_category', $data);
    }
}
