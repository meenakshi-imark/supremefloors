<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warehouse;
use DB;
use Illuminate\Support\Facades\Storage;


class WarehouseController extends Controller
{
	public function index(){
	 $categories = DB::table('product_categories')->get();
	 $products = DB::table("products")->select('id','product_name','product_category','product_code','p_image')->get();
	 return view('backend.warehouse-create-warehouse',compact('categories','products'));
	}

	public function store(Request $request){
		if($request['pro_cat']){
		$pro_cat = implode(",",$request['pro_cat']);
	    }
	    else{
	        $pro_cat = null;
	    }

	    if($request['pro_cat']){
		$pro_id = implode(",",$request['pro_id']);
	    }
	    else{
	        $pro_id = null;
	    }

	    $insert = DB::table("warehouses")->insert(['name'=>$request['name'],'address'=>$request['address'],'pro_cat'=>$pro_cat,'pro_id'=>$pro_id,]);

	    if($insert){ 
        	$arr = array('msg' => 'Form submitted successfully.', 'status' => true);
        }
        else{
			$arr = array('msg' => 'Please enter a unique role name.', 'status' => false);
		}
        return Response()->json($arr);
    }

      public function show(){
      	$warehouses = DB::table("warehouses")->orderBy('id','DESC')->paginate(10);
    	if (count($warehouses) <=0){
    		if (! is_null($warehouses->previousPageUrl())) {
    			return redirect()->to($warehouses->previousPageUrl())->with('success', 'Warehouse deleted successfully.');
    		}
    	}
    	foreach($warehouses as $warehouse){
		$product_categories = DB::table("product_categories")->select('id','category_name')->limit(10)->get();
		$pid = explode(',', $warehouse->pro_id);
		$products = DB::table("products")->whereIn('id',$pid)->where('product_category',$product_categories[0]->id)->get();   
		$products1 = DB::table("products")->whereIn('id',$pid)->where('product_category',$product_categories[1]->id)->get();  
		$getproducts[] = $products;
		
		$getproducts1[] = $products1;
		return view('backend.warehouse-all-warehouse', compact('warehouses','product_categories','getproducts','getproducts1'));
	    }
	}

    public function edit($id){
    	$edit_warehouse = DB::table('warehouses')->where('id',$id)->first();
    	$product_categories = DB::table("product_categories")->select('id','category_name')->get();
	    $products = DB::table("products")->select('id','product_name','product_category','product_code','p_image')->get();
	    return view('backend.warehouse-edit-warehouse',compact('edit_warehouse','product_categories','products'));
    }

    public function update(Request $request){
    	if($request['pro_cat']){
		$pro_cat = implode(",",$request['pro_cat']);
	    }
	    else{
	        $pro_cat = null;
	    }

	    if($request['pro_cat']){
		$pro_id = implode(",",$request['pro_id']);
	    }
	    else{
	        $pro_id = null;
	    }

        $update = DB::table("warehouses")->where('id',$request['id'])->update(['name'=>$request['name'],'address'=>$request['address'],'pro_cat'=>$pro_cat,'pro_id'=>$pro_id]);
        $arr = array('msg' => 'warehouse created successfully.', 'status' => true);
        return Response()->json($arr);
    }
    public function destroy($id){
        $delete = Warehouse::Where('id',$id)->first();
        $delete->delete();
        return redirect()->back()->with('success', 'Warehouse deleted successfully.');
    }
    
    public function duplicate($id){
        $dep_entry = Warehouse::Where('id',$id)->first();
        $create_dup = DB::table("warehouses")->insert([
        	'name'=>$dep_entry['name'].'(1)',
        	'address'=>$dep_entry['address'],
        	'pro_cat'=>$dep_entry['pro_cat'],
        	'pro_id'=>$dep_entry['pro_id'],
        ]);
        return redirect()->back()->with('success', 'Warehouse duplicated successfully.');
    }
	
	public function deleteallwarehouse(Request $request){
	if($request->id){
    DB::table("warehouses")->whereIn('id',$request->id)->delete();
    return redirect()->back()->with('success', 'Records are deleted successfully.'); 
	}
	else{
	return redirect()->back()->with('error', 'Please select atleast one role.'); 
	}
	}
}
