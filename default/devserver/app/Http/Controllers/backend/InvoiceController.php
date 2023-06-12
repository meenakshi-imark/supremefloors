<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warehouse;
use DB;
use Illuminate\Support\Facades\Storage;
use PDF;
use Mail;
use App\Mail\InvoiceReminder;


class InvoiceController extends Controller
{
	public function index(){
		$suppliers = DB::table('suppliers')->select('id','person_name')->orderBy('person_name','ASC')->get();
		$products = DB::table('products')->select('id','product_name','product_category')->orderBy('product_name','ASC')->get();
		return view('backend.sales-invoice',compact('suppliers','products'));
		
	}
	
	public function insert(Request $request){
		$product_id = implode(",",$request['product']);
		$quantity = implode(",",$request['quantity']);
		$unit = implode(",",$request['unit']);
		$unit_price = implode(",",$request['unitprice']);	
		$price = implode(",",$request['price']);	
		$services = implode(",",$request['services']);	
		$serviceprice = implode(",",$request['serviceprice']);	
		$unnitprice = trim(str_replace("$","",$unit_price));
		$price1 = trim(str_replace("$","",$price));
		$invoice_id = rand(0, 999999);
		
		 $insert = DB::table("invoices")->
		 insert([
		 'invoice_id'			=>$request['invoiceid'],
		 'company'				=>$request['owner'],
		 'address'				=>$request['address'],
		 'attention_to'			=>$request['supplierid'],
		 'phone'				=>$request['phone'],
		 'email'				=>$request['email'],
		 'due_date'				=>$request['duedate'],
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
		 'status'				=>'pending',
		 ]);
	 if($insert){
		return redirect('/all-invoice')->with('success', 'Invoice created successfully.');
        }else{
        return redirect()->back()->with('error', 'Something went wrong. Please try again later.');
       }
	}
	
	public function show(Request $request){
		if($request->input('search')){
		$search = $request->input('search');
		$invoices = DB::table("invoices")->where('invoice_id', 'LIKE',"%{$search}%")->orderBy('id','DESC')->paginate(10);
		}
		else{
		$invoices = DB::table('invoices')->orderBy('id','DESC')->paginate(10);
		}
		return view('backend.all-invoice',compact('invoices'));
	}
	
	public function deleteall(Request $request){
		if($request->id){
		DB::table("invoices")->whereIn('id',$request->id)->delete();
		return redirect()->back()->with('success', 'Records are deleted successfully.'); 
		}
		else{
		return redirect()->back()->with('error', 'Please select atleast one record.'); 
		}
	}
	
	public function status_change($id , $approval){
		  $getpo  = DB::table('invoices')->where('id',$id)->first();
		  $update = DB::table("invoices")->where('id',$id)->update(['status'=>$approval,'completed_at'=>date('Y-m-d')]);
		  $users = DB::table('users')->select('email')->where('id',$getpo->attention_to)->first();
		  Mail::to($users->email)->send(new InvoiceReminder($approval));

		  return redirect()->back()->with('success', 'Status updated successfully.'); 
	}
	
	public function delete($id){
	   $orders = DB::table('invoices')->where('id',$id)->delete();
	   return redirect()->back()->with('success', 'Invoice deleted successfully.');	
	}
	
		
	public function pdf($id, Request $request){
		if($request->has('download')){  
		 $invoice = DB::table('invoices')->where('id',$id)->first();
		 $getproducts['products'] = explode(",",$invoice->product_id);
		 $getquantity['quantity'] = explode(",",$invoice->quantity);
		 $getunit['unit'] = explode(",",$invoice->unit);
		 $getunit_price['price'] = explode(",",$invoice->unit_price);
		 $getprice['amount'] = explode(",",$invoice->amount);
		 $arr = array_merge($getproducts,$getquantity,$getunit,$getunit_price,$getprice);
         $pdf = PDF::loadView('backend.invoice-pdf',compact('invoice','arr'));  
         return $pdf->download('invoice.pdf');  
        } 	
	}
	
	public function edit($id){
		$products = DB::table('products')->select('id','product_name','product_category')->orderBy('product_name','ASC')->get();
		$invoice = DB::table('invoices')->where('id',$id)->first();
		$suppliers = DB::table('users')->select('id','name')->where('id',$invoice->attention_to)->get();
		$getproducts['products'] = explode(",",$invoice->product_id);
		$getquantity['quantity'] = explode(",",$invoice->quantity);
		$getunit['unit'] = explode(",",$invoice->unit);
		$getunit_price['price'] = explode(",",$invoice->unit_price);
		$getprice['amount'] = explode(",",$invoice->amount);
		$sevices['sevices'] = explode(",",$invoice->services);
		$serviceprice['serviceprice'] = explode(",",$invoice->serviceprice);
		$arr = array_merge($getproducts,$getquantity,$getunit,$getunit_price,$getprice,$sevices,$serviceprice);
		return view('backend.invoice-edit-invoice',compact('suppliers','products','invoice','arr'));
	}
	
	public function update(Request $request){
		$product_id = implode(",",$request['product']);
		$quantity = implode(",",$request['quantity']);
		$unit = implode(",",$request['unit']);
		$unit_price = implode(",",$request['unitprice']);	
		$price = implode(",",$request['price']);	
		$services = implode(",",$request['services']);	
		$serviceprice = implode(",",$request['serviceprice']);	
		$unnitprice = trim(str_replace("$","",$unit_price));
		$price1 = trim(str_replace("$","",$price));
		$update = DB::table("invoices")->where('id',$request['id'])->update([
		 'invoice_id'			=>$request['invoiceid'],
		 'company'				=>$request['owner'],
		 'address'				=>$request['address'],
		 'attention_to'			=>$request['supplierid'],
		 'phone'				=>$request['phone'],
		 'email'				=>$request['email'],
		 'due_date'				=>$request['duedate'],
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
		]);
		return redirect()->back()->with('success', 'Invoice updated successfully.');	
	}
	
	public function getdetails(Request $request){
		$data = DB::table('users')->select("email", "phone")->where('id',$request['supid'])->get();
		return response()->json(['results' => $data]);
	}

	public function searchcustomer(Request $request){
		 $data = DB::table('users')->select("name as value", "id")->where('name', 'LIKE', '%'. $request->get('search'). '%')->where('customer_type','!=','NULL')
                    ->get();
    
        return response()->json($data);
	}
	
	public function print_invoice($id){
		$invoice = DB::table('invoices')->where('id',$id)->first();
		$getproducts['products'] = explode(",",$invoice->product_id);
		$getquantity['quantity'] = explode(",",$invoice->quantity);
		$getunit['unit'] = explode(",",$invoice->unit);
		$getunit_price['price'] = explode(",",$invoice->unit_price);
		$getprice['amount'] = explode(",",$invoice->amount);
		$arr = array_merge($getproducts,$getquantity,$getunit,$getunit_price,$getprice);
		return view('backend.invoice-pdf',compact('invoice','arr')); 
		
	}

}
