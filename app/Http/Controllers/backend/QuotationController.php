<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warehouse;
use DB;
use Illuminate\Support\Facades\Storage;
use PDF; 

class QuotationController extends Controller
{
	public function index(){
		$products = DB::table('products')->select('id','product_name','product_category')->orderBy('product_name','ASC')->get();
		return view('backend.quotation-create-quotation',compact('products'));
	}
	
	public function show(Request $request){ 
		if($request->input('search')){
		$search = $request->input('search');
		$quotations = DB::table("quotations")->where('quotation_id', 'LIKE',"%{$search}%")->orderBy('id','DESC')->paginate(10);
		$quotations->appends(['search' => $search]);
		}
		else{
		$quotations = DB::table('quotations')->orderBy('id','DESC')->paginate(10);
		}
		return view('backend.sales-all-quotation',compact('quotations'));	
	}
	
	public function insert(Request $request){	
		// $validated = $request->validate([
		// 	'owner' => 'required',
		// 	'supplierid' => 'required',
		// ]);
		$product_id = implode(",",$request['product']);
		$quantity = implode(",",$request['quantity']);
		$unit = implode(",",$request['unit']);
		$unit_price = implode(",",$request['unitprice']);	
		$price = implode(",",$request['price']);	
		$services = implode(",",$request['services']);	
		$serviceprice = implode(",",$request['serviceprice']);	
		$unnitprice = trim(str_replace("$","",$unit_price));
		$price1 = trim(str_replace("$","",$price));
		// $quotation_id = rand(0, 999999);
		 $quotation_id = $request['ro'];
		
		$sum_min =0;
		foreach($request['min_cost'] as $mincost){
			$sum_min+=$mincost;
		}
		$sum_unit =0;
		foreach($request['unitprice'] as $unitprice){
		$unnit = trim(str_replace("$","",$unitprice));
		$sum_unit+=$unnit;	
		}
		if($sum_unit<$sum_min){
			$status ="pending";
		}
		else{
			$orderid= rand(0, 999999);
			$insertro = DB::table("release_orders")->
			 insert([
			 'order_id'				=>$orderid,
			 'estimate_date'		=>$request['duedate'],
			 'company_id'			=>$request['owner'],
			 'owner'				=>$request['supplierid'],
			 'phone_number'			=>$request['phone'],
			 'site_address'			=>$request['site_address'],
			 'product'				=>$product_id,
			 'product_qty'			=>$quantity,
			 'unit_price'			=>$unnitprice,
			 'subtotal'				=>$price1,
			 'total'				=>trim(str_replace("$","",$request['totalamt'])),
			 'final_amount'			=>trim(str_replace("$","",$request['totalamt'])),
			 'approval'				=>"1",
			 ]);
			$status ="approved";
		}
		
		 $insert = DB::table("quotations")->
		 insert([
		 'quotation_id'			=>$quotation_id,
		 'ro_number'			=>$request['ro'],
		 'company'				=>$request['owner'],
		 'address'				=>$request['address'],
		 'email'				=>$request['email'],
		 'attention_to'			=>$request['supplierid'],
		 'phone'				=>$request['phone'],
		 'installer'			=>$request['installer'],
		 'product_id'			=>$product_id,
		 'quantity'				=>$quantity,
		 'unit'					=>$unit,
		 'unit_price'			=>$unnitprice,
		 'amount'				=>$price1,
		 'services'				=>$services,
		 'serviceprice'			=>$serviceprice,
		 'site_address'			=>$request['site_address'],
		 'invoice'				=>$request['description'],
		 'gst'					=>$request['gst'],
		 'rebates'				=>$request['rebates'],
		 'subtotal'				=>trim(str_replace("$","",$request['subtotal'])),
		 'total'				=>trim(str_replace("$","",$request['totalamt'])),
		 'status'				=>$status,
		 'due_date'		        =>$request['duedate'],
		 ]);
	 if($insert){
		\LogActivity::addToLog('Create new quotation.');
		return redirect('/sales-all-quotation')->with('success', 'Quotation created successfully.');
        }else{
        return redirect()->back()->with('error', 'Something went wrong. Please try again later.');
       }
	}
	
	public function quotation_approval($id , $approval){ 
		  $update = DB::table("quotations")->where('id',$id)->update(['status'=>$approval]);
		  \LogActivity::addToLog('Update quotation status.');
		  $getpo  = DB::table('quotations')->where('id',$id)->first();
		  if($update==true){
		  if($approval=="approved"){
		  $insert = DB::table("release_orders")->
		  insert([
			'order_id'				=>$getpo->ro_number,
			'phone_number'			=>$getpo->phone,
			'company_id'			=>$getpo->company,
			'owner'					=>$getpo->attention_to,
			'site_address'			=>$getpo->address,
			'total'					=>$getpo->total,
			'approval'				=>"1",
			]);
			\LogActivity::addToLog('Create new RO.');
			}
			
			}
			
		  return redirect()->back()->with('success', 'Status updated successfully.'); 
	}
	
	public function deleteall(Request $request){
		if($request->id){
		DB::table("quotations")->whereIn('id',$request->id)->delete();
		return redirect()->back()->with('success', 'Records are deleted successfully.'); 
		}
		else{
		return redirect()->back()->with('error', 'Please select atleast one record.'); 
		}
	}
	
	public function delete($id){
	   $orders = DB::table('quotations')->where('id',$id)->delete();
	   return redirect()->back()->with('success', 'Quotation deleted successfully.');	
	}
	
	public function edit($id){
		$products = DB::table('products')->select('id','product_name','product_category')->orderBy('product_name','ASC')->get();
		$quotations = DB::table('quotations')->where('id',$id)->first();
		$suppliers = DB::table('users')->select('id','name')->where('id',$quotations->attention_to)->get();
		$getproducts['products'] = explode(",",$quotations->product_id);
		$getquantity['quantity'] = explode(",",$quotations->quantity);
		$getunit['unit'] = explode(",",$quotations->unit);
		$getunit_price['price'] = explode(",",$quotations->unit_price);
		$getprice['amount'] = explode(",",$quotations->amount);
		$sevices['sevices'] = explode(",",$quotations->services);
		$serviceprice['serviceprice'] = explode(",",$quotations->serviceprice);
		$arr = array_merge($getproducts,$getquantity,$getunit,$getunit_price,$getprice,$sevices,$serviceprice);
		
		
		return view('backend.quotation-edit-quotation',compact('suppliers','products','quotations','arr'));	
	}
	
	public function update(Request $request){
		$product_id = implode(",",$request['product']);
		$quantity = implode(",",$request['quantity']);
		$unit = implode(",",$request['unit']);
		$unit_price = implode(",",$request['unitprice']);	
		$price = implode(",",$request['price']);	
		$unnitprice = trim(str_replace("$","",$unit_price));
		$price1 = trim(str_replace("$","",$price));
		$services = implode(",",$request['services']);	
		$serviceprice = implode(",",$request['serviceprice']);	
		$update = DB::table("quotations")->where('id',$request['id'])->update([
		 'ro_number'			=>$request['ro'],
		 'company'				=>$request['owner'],
		 'address'				=>$request['address'],
		 'attention_to'			=>$request['supplierid'],
		 'phone'				=>$request['phone'],
		 'email'				=>$request['email'],
		 'installer'			=>$request['installer'],
		 'product_id'			=>$product_id,
		 'quantity'				=>$quantity,
		 'unit'					=>$unit,
		 'unit_price'			=>$unnitprice,
		 'amount'				=>$price1,
		 'services'				=>$services,
		 'serviceprice'		    =>$serviceprice,
		 'site_address'			=>$request['site_address'],
		 'invoice'				=>$request['description'],
		 'gst'					=>$request['gst'],
		 'rebates'				=>$request['rebates'],
		 'subtotal'				=>trim(str_replace("$","",$request['subtotal'])),
		 'total'				=>trim(str_replace("$","",$request['totalamt'])),
		]);
		return redirect()->back()->with('success', 'Quotation updated successfully.');	
		
	}
	
	public function pdf($id, Request $request){
		if($request->has('download')){  
		 $quotation = DB::table('quotations')->where('id',$id)->first();
		 $getproducts['products'] = explode(",",$quotation->product_id);
		 $getquantity['quantity'] = explode(",",$quotation->quantity);
		 $getunit['unit'] = explode(",",$quotation->unit);
		 $getunit_price['price'] = explode(",",$quotation->unit_price);
		 $getprice['amount'] = explode(",",$quotation->amount);
		 $arr = array_merge($getproducts,$getquantity,$getunit,$getunit_price,$getprice);
         $pdf = PDF::loadView('backend.quotation-pdf',compact('quotation','arr'));  
         return $pdf->download('quotation.pdf');  
        } 	
	}
	
	
	public function searchsupplier(Request $request)
    {
        $data = DB::table('suppliers')->select("person_name as value", "id")->where('person_name', 'LIKE', '%'. $request->get('search'). '%')
                    ->get();
    
        return response()->json($data);
    }
	
	public function attention_to(Request $request)
    {
        $data = DB::table('users')->select("name as value", "id",'address')->where('customer_type',"!=",NULL)->where('name', 'LIKE', '%'. $request->get('search'). '%')
                    ->get();
    
        return response()->json($data);
    }
	
	public function getdetails(Request $request){
		$data = DB::table('users')->select("email", "phone")->where('id',$request['qid'])->get();
		return response()->json(['results' => $data]);
	}
	
	public function print_quotation($id){
		$quotation = DB::table('quotations')->where('id',$id)->first();
		$getproducts['products'] = explode(",",$quotation->product_id);
		$getquantity['quantity'] = explode(",",$quotation->quantity);
		$getunit['unit'] = explode(",",$quotation->unit);
		$getunit_price['price'] = explode(",",$quotation->unit_price);
		$getprice['amount'] = explode(",",$quotation->amount);
		$arr = array_merge($getproducts,$getquantity,$getunit,$getunit_price,$getprice);
		return view('backend.quotation-pdf',compact('quotation','arr'));	

	}

	public function get_owners(Request $request){
		$data = DB::table('suppliers')->select("company_name as value", "id",'address')->where('person_name', 'LIKE', '%'. $request->get('search'). '%')->orWhere('company_name', 'LIKE', '%'. $request->get('search'). '%')
                    ->get();
    
        return response()->json($data);

	}
	
	
	

	
}
