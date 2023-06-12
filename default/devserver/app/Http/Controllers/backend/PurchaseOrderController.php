<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use DB;
use Mail;
use Illuminate\Support\Facades\Storage;


class PurchaseOrderController extends Controller
{
	public function index(){
		 $suppliers = DB::table('suppliers')->get();
		 $products = DB::table("products")->select('id','product_name')->get();
		 return view('backend.purchase-order-create-po',compact('suppliers','products'));
	}
	
	public function autocomplete(Request $request)
    {
        $data = Product::select("product_name as value", "id")->where('product_name', 'LIKE', '%'. $request->get('search'). '%')
                    ->get();
    
        return response()->json($data);
    }
	
	
	public function getprice(Request $request){
		$getprice = Product::select("min_cost")->where('id',$request->pid)->get();
		$price = $getprice[0]->min_cost;
		return Response($price);
	}
	
	public function totalprice(Request $request){
		$price = trim($request->price,"$");
		$qty = intval($request->quantity);
		$p = intval($request->price);
		$total = intval($price)*intval($request->quantity);

		return Response($total);
	}
	
	public function insert(Request $request){
		$product_id = implode(",",$request['product']);
		$unit = implode(",",$request['unit']);
		$quantity = implode(",",$request['quantity']);
		$unit_price = implode(",",$request['unitprice']);	
		$price = implode(",",$request['price']);	
		$unnitprice = trim(str_replace("$","",$unit_price));
		$price1 = trim(str_replace("$","",$price));
		$ordernumber = rand(0, 999999);
		
		 $insert = DB::table("purchase_orders")->
		 insert([
		 'order_no'				=>$ordernumber,
		 'supplier_id'			=>$request['supplier'],
		 'product_id'			=>$product_id,
		 'unit'					=>$unit,
		 'unit_price'			=>$unnitprice,
		 'quantity'				=>$quantity,
		 'price'				=>$price1,
		 'days_before_arrival'	=>$request['days'],
		 'estimated_arrival'	=>$request['date'],
		 'total_price'			=>trim($request['totalprice'],"$"),
		 'status'				=>'1',
		 'approval'				=>'pending',
		 ]);
	 if($insert){
		return redirect('/purchase-order-list')->with('success', 'Purchase order created successfully.');
        }else{
        return redirect()->back()->with('error', 'Something went wrong. Please try again later.');
       }
	}
	
	public function show(Request $request){
		if($request->input('search')){
		$search = $request->input('search');
		$orderlist = DB::table("purchase_orders")->where('order_no', 'LIKE',"%{$search}%")->orderBy('id','DESC')->paginate(10);
		$orderlist->appends(['search' => $search]);
		}
		else{
		$orderlist = DB::table("purchase_orders")->orderBy('id','DESC')->paginate(10);
		}
		return view('backend.purchase-order-list',compact('orderlist'));
	}
	
	public function update_approval($id , $approval){
		  $getpo  = DB::table('purchase_orders')->where('id',$id)->first();
		  $chk_supplier = DB::table('suppliers')->where('id',$getpo->supplier_id)->first();
		  $update = DB::table("purchase_orders")->where('id',$id)->update(['approval'=>$approval]);
		  if($update=="1" && $approval=="approved"){
		  $email =$chk_supplier->email;  
		  $data = array('name'=>$chk_supplier->person_name);
		  Mail::send('backend.mail.approvedmail', $data, function($message)use($email) {
          $message->to($email, 'PO Approval Mail')->subject
          ('PO Approval Mail.');
          $message->from('meenakshi.nanta@imarkinfotech.com','Supreme');
           });
	  }
		return redirect()->back()->with('success', 'Approval updated successfully.'); 
		
	}
	
	public function update_status($id){
	   $chkstatus = DB::table('purchase_orders')->find($id);
	   if($chkstatus->status=="1"){
	   $arr1 = explode(",",$chkstatus->product_id);
	   $arr2 = explode(",",$chkstatus->quantity);
	   
	   $get = DB::table("products")->select('id','total_inventry')->whereIn('id',$arr1)->get();
	   foreach($get as $total_inventry){
	   $key = array_search($total_inventry->id, $arr1);
	  
	   $total_in = $total_inventry->total_inventry+$arr2[$key];
	   $update_stock = DB::table("products")->where('id',$total_inventry->id)->update(['total_inventry'=>$total_in]);
	   }
	   $update = DB::table("purchase_orders")->where('id',$id)->update(['status'=>'2']);
       }
       else{
       $update = DB::table("purchase_orders")->where('id',$id)->update(['status'=>'1']);
       }
       return redirect()->back()->with('success', 'Status updated successfully.'); 	
	}
	
	public function deleteall(Request $request){
		if($request->id){
		DB::table("purchase_orders")->whereIn('id',$request->id)->delete();
		return redirect()->back()->with('success', 'Records are deleted successfully.'); 
		}
		else{
		return redirect()->back()->with('error', 'Please select atleast one order.'); 
		}
	}
	
	public function delete($id){
		$orders = DB::table('purchase_orders')->where('id',$id)->delete();
		return redirect()->back()->with('success', 'Order deleted successfully.');	
	}
	
	public function edit($id){
		$suppliers = DB::table('suppliers')->get();
		$products = DB::table("products")->select('id','product_name')->get();
		$orders = DB::table('purchase_orders')->find($id);
		$getproducts['products'] = explode(",",$orders->product_id);
		$getunit['unit'] = explode(",",$orders->unit);
		$getunit_price['unitprice'] = explode(",",$orders->unit_price);
		$getquantity['quantity'] = explode(",",$orders->quantity);
		$getprice['price'] = explode(",",$orders->price);
		$arr = array_merge($getproducts,$getunit,$getunit_price,$getquantity,$getprice);
		// echo"<pre>";print_r($arr);echo"</pre>";exit();
		return view('backend.purchase-order-edit-po',compact('suppliers','orders','products','arr'));	
	}
	
	public function update(Request $request){
		$product_id = implode(",",$request['product']);
		$unit = implode(",",$request['unit']);
		$quantity = implode(",",$request['quantity']);
		$unit_price = implode(",",$request['unitprice']);	
		$price = implode(",",$request['price']);	
		$unnitprice = trim(str_replace("$","",$unit_price));
		$price1 = trim(str_replace("$","",$price));
		$update = DB::table("purchase_orders")->where('id',$request['id'])->update([
		'supplier_id'=>$request['supplier'],
		'product_id'=>$product_id,
		'unit'=>$unit,
		'unit_price'=>$unnitprice,
		'quantity'=>$quantity,
		'price'=>$price1,
		'days_before_arrival'=>$request['days'],
		'estimated_arrival'=>$request['date'],
		'total_price'=>trim($request['totalprice'],"$"),
		]);
		return redirect()->back()->with('success', 'Records updated successfully.'); 			
	}
	
	public function print_po(Request $request){
		$id = $request['id'];
		$suppliers = DB::table('suppliers')->get();
		$products = DB::table("products")->select('id','product_name')->get();
		$orders = DB::table('purchase_orders')->find($id);
		$getproducts['products'] = explode(",",$orders->product_id);
		$getunit['unit'] = explode(",",$orders->unit);
		$getunit_price['unitprice'] = explode(",",$orders->unit_price);
		$getquantity['quantity'] = explode(",",$orders->quantity);
		$getprice['price'] = explode(",",$orders->price);
		$arr = array_merge($getproducts,$getunit,$getunit_price,$getquantity,$getprice);
		$sup = DB::table('suppliers')->where('id',$orders->product_id)->first();
		$count =1;
		$result="";
		
		$result.='<b>Purchase Order Number: #'.$orders->order_no.'</b></br>
				 <b>Supplier: '.$sup->person_name.'</b></br>
				 <table class="table table-striped">
				  <thead>
					<tr>
					  <th scope="col">Product</th>
					  <th scope="col">Unit</th>
					  <th scope="col">Unit Price</th>
					  <th scope="col">Quantity</th>
					  <th scope="col">Price</th>
					</tr>
				  </thead>
				  <tbody>';
				  for($i=0;$i<count($arr['products']);$i++){
					  $product = DB::table('products')->where('id',$arr['products'][$i])->first();
					$result.='<tr>
					  <td>'.$product->product_name.'</td>
					  <td>'.$arr['unit'][$i].'</td>
					  <td>$'.$arr['unitprice'][$i].'</td>
					  <td>'.$arr['quantity'][$i].'</td>
					  <td>$'.$arr['price'][$i].'</td>
					</tr>';
				  }

				  $result.='</tbody>
				</table>
				<b>Estimated Days Before Arrival: '.$orders->days_before_arrival.' days</b></br>
				<b>Estimated Arrival: '.$orders->estimated_arrival.'</b></br>
				<b>Total Price: $'.$orders->total_price.'</b></br>';
		
		
		return Response($result);
		// return view('backend.purchase-order-print-po',compact('suppliers','orders','products','arr'));
	}
	
}
