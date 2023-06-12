<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product_category;
use DB;

class CategoryController extends Controller
{
	public function index(){
	 return view('backend.create-category');
	}
	
	public function insert(Request $request){
	    $insert = DB::table("product_categories")->insert(['category_name'=>$request['category_name']]);
	    if($insert){ 
        	$arr = array('msg' => 'Category inserted successfully.', 'status' => true);
        }
        else{
			$arr = array('msg' => 'Something went wrong. Please try again later.', 'status' => false);
		}
		return Response()->json($arr);
	}
	
	public function show(){
	   $categories = DB::table("product_categories")->get();
	   return view('backend.category-all-category',compact('categories'));
	}
	
	public function edit($id){
	   $category = DB::table('product_categories')->find($id);
	   return view('backend.category-edit-category',compact('category'));
	}
	
	public function delete($id){
	    DB::table("product_categories")->where('id',$id)->delete();
        return redirect()->back()
                        ->with('success','Category deleted successfully.');
	}
	
	public function update(Request $request){
	   $update = DB::table("product_categories")->where('id',$request['id'])->update(['category_name'=>$request['category_name']]);
       $arr = array('msg' => 'Category updated successfully.', 'status' => true);
       return Response()->json($arr);
	}
}
