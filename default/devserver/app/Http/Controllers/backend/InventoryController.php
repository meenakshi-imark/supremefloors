<?php
	
namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;


class InventoryController extends Controller
{ 
	public function index(Request $request){
	 if($request->input('search')){
	 $search = $request->input('search');
	 $products = Product::where('product_no', 'LIKE',"%{$search}%")->orWhere('product_name', 'LIKE',"%{$search}%")->orderBy('id','DESC')->paginate(10);
	 $products->appends(['search' => $search]);
	 }else{
	 $products = Product::orderBy('id','DESC')->paginate(10);
	 }
	 return view('backend.inventory-stock',compact('products'));
	}

	
}
