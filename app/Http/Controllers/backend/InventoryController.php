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
		if($request->input('categories')){
		$products = Product::where('product_no', 'LIKE',"%{$search}%")->orWhere('product_name', 'LIKE',"%{$search}%")->whereIn('product_category',$request->input('categories'))->orderBy('updated_at','DESC')->paginate(10);
	 	$products->appends(['search' => $search]);
		}
		else{
		$products = Product::where('product_no', 'LIKE',"%{$search}%")->orWhere('product_name', 'LIKE',"%{$search}%")->orderBy('updated_at','DESC')->paginate(10);
	 	$products->appends(['search' => $search]);
		}
	 }
	 else{
		if($request->input('categories')){
	 	$products = Product::whereIn('product_category',$request->input('categories'))->orderBy('updated_at','DESC')->paginate(1);
		$products->appends(['categories' => $request->input('categories')]);
		}
		else{
		$products = Product::orderBy('updated_at','DESC')->paginate(10);
		}
	 
	 }
	
	 $categories = DB::table('product_categories')->select('category_name','id')->get();
	 return view('backend.inventory-stock',compact('products','categories'));
	}

	public function updatepacket(Request $request){
		$get = DB::table('purchase_orders')->where('id',$request['poid'])->first();
		$arr1 = explode(",",$get->product_id);
		$arr2 = explode(",",$get->quantity);
		$key = array_search($request['pid'], $arr1);
		$qty = $arr2[$key];
		$newqty = $request['val'];
		$arr2[$key]=$newqty;
		$new_arr = implode(",",$arr2);
		$update_qty = DB::table('purchase_orders')->where('id', $request['poid'])
        ->update([
           'quantity' => $new_arr
        ]); 
		$response['message'] = "success";
		echo json_encode($response);
		

	}

	
}
