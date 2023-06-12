<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product_category;
use DB;

class HomeController extends Controller
{
	public function index(Request $request){
	 if($request->input('category')){
	 $products = DB::table('products')->where('product_category',$request->input('category'))->orderBy('id','DESC')->get();
	 }
	 else{
	 $products = DB::table('products')->orderBy('id','DESC')->get();
	 }
	 $categories = DB::table('product_categories')->get();
	 return view('frontend.product',compact('categories','products'));
	}
	
	public function product_detail($name){
	$id = substr($name, strrpos($name, '-') + 1);
	$products = DB::table('products')->where('id',$id)->first();
	return view('frontend/product-detail',compact('products'));
	}
	
	public function get_quotation(Request $request){
		if($request->file('file')){
          $file= $request->file('file');
          $filename= $file->getClientOriginalName();
          $file-> move(public_path('front/quotations'), $filename);
        }
		else{
		  $filename= null;	
		}
		$insert = DB::table("get_quotations")->
		 insert([
		 'name'				=>$request['fullname'],
		 'email'			=>$request['email'],
		 'phone'			=>$request['phone'],
		 'address'			=>$request['address'],
		 'area'				=>$request['area'],
		 'size'				=>$request['size'],
		 'product_id'		=>$request['product_id'],
		 'file'				=>$filename,
		 ]);
	   if($insert){
		return redirect()->back()->with('success', 'Quotation submitted successfully. Will get back you soon.');
        }else{
        return redirect()->back()->with('error', 'Something went wrong. Please try again later.');
       }
	}
	
}
