<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warehouse;
use DB;
use Illuminate\Support\Facades\Storage;
use PDF; 


class ReleaseOrderController extends Controller
{
	public function index(){
	 $company = DB::table('suppliers')->select('id','company_name')->orderBy('company_name','ASC')->get();
	 $products = DB::table("products")->select('id','product_name')->get();
	 $users = DB::table("users")->where('customer_type',"!=",NULL)->orderBy('name','DESC')->get();
	 return view('backend.release-order-create-ro',compact('company','products','users'));
	}
	
	public function insert(Request $request){
	  if($request->file('image')){
        $file = $request->file('image');
        $filename = time().'_'.$file->getClientOriginalName();
	    $extension = $file->getClientOriginalExtension();
	    $location = 'uploads';
		$file->move($location,$filename);
		$filepath = url('uploads/'.$filename);
        }
		else{
			$filename=null;
		}
		if(!($request['orderid'])){
		$orderid= rand(0, 999999);	
		}
		else{
		$orderid= $request['orderid'];		
		}
		if($request['endcolour'][0]!=NULL || $request['endqty'][0]!=NULL){
		$end ="yes";	
		}
		else{
		$end ="no";	
		}
		if($request['contactcolour'][0]!=NULL || $request['contactqty'][0]!=NULL){
		$contact ="yes";	
		}
		else{
		$contact ="no";	
		}
		if($request['adaptorcolour'][0]!=NULL || $request['adaptorqty'][0]!=NULL){
		$adaptor ="yes";	
		}
		else{
		$adaptor ="no";	
		}
		if($request['cappingcolour'][0]!=NULL || $request['cappingqty'][0]!=NULL ){
		$lcapping ="yes";	
		}
		else{
		$lcapping ="no";	
		}
		
		if($request['plywood_qty1'] || $request['plywood_qty2'] || $request['plywood_qty3']){
		$plywood ="yes";	
		}
		else{
		$plywood ="no";	
		}

		if($request->skirtingqty){
			$skirting_qty = implode(",",$request['skirtingqty']);
		}else{
			$skirting_qty = "";
		}
		$product_id = implode(",",$request['product']);
		$quantity = implode(",",$request['quantity']);
		$unitprice = implode(",",$request['unitprice']);
		$unnitprice = trim(str_replace("$","",$unitprice));
		$subtotal = implode(",",$request['price']);
		$subtotal1 = trim(str_replace("$","",$subtotal));
		$skirting = implode(",",$request['skirting']);
		$skirtingqty = $skirting_qty;
		$endcolour = implode(",",$request['endcolour']);
		$endqty = implode(",",$request['endqty']);
		$contactcolour = implode(",",$request['contactcolour']);
		$contactqty = implode(",",$request['contactqty']);
		$adaptorcolour = implode(",",$request['adaptorcolour']);
		$adaptorqty = implode(",",$request['adaptorqty']);
		$cappingcolour = implode(",",$request['cappingcolour']);
		$cappingqty = implode(",",$request['cappingqty']);
		$paper = implode(",",$request['paper']);
		$paperqty = implode(",",$request['paperqty']);
		$plastic = implode(",",$request['plastic']);
		$plasticqty = implode(",",$request['plasticqty']);
		// $plywood = implode(",",$request['plywood']);
		// $plywoodqty = implode(",",$request['plywoodqty']);
		DB::enableQueryLog();
		$insert = DB::table("release_orders")->
		 insert([
		 'order_id'				=>$orderid,
		 'estimate_date'		=>$request['installation_date'],
		 'ro_key'				=>$request['key'],
		 'role'					=>$request['roles'],
		 'company_id'			=>$request['company_name'],
		 'owner'				=>$request['owner'],
		 'phone_number'			=>$request['phonenumber'],
		 'site_address'			=>$request['siteaddress'],
		 'area'					=>$request['areatoinstall'],
		 'floor_size'			=>$request['floorsize'],
		 'unit'					=>$request['unitsize'],
		 'image'				=>$filename,
		 'lift_level'			=>$request['liftlevel'],
		 'hs'					=>$request['hs'],
		 'cs'					=>$request['cd'],
		 'product'				=>$product_id,
		 'product_qty'			=>$quantity,
		 'unit_price'			=>$unnitprice,
		 'subtotal'				=>$subtotal1,
		 'skirting'				=>$skirting,
		 'skirtingqty'			=>$skirtingqty,
		 'end'					=>$end,
		 'end_color'			=>$endcolour,
		 'end_qty'				=>$endqty,
		 'contact'				=>$contact,
		 'contact_color'		=>$contactcolour,
		 'contact_qty'			=>$contactqty,
		 'adaptor'				=>$adaptor,
		 'adaptor_color'		=>$adaptorcolour,
		 'adaptor_qty'			=>$adaptorqty,
		 'lcapping'				=>$lcapping,
		 'lcapping_color'		=>$cappingcolour,
		 'lcapping_qty'			=>$cappingqty,
		 'corrugated'			=>$paper,
		 'corrugated_qty'		=>$paperqty,
		 'plastic'				=>$plastic,
		 'pastic_qty'			=>$plasticqty,
		 'plywood'				=>$plywood,
		 'plywood_qty'			=>$request['plywood_qty1'],
		 'plywood_qty2'			=>$request['plywood_qty2'],
		 'plywood_qty3'			=>$request['plywood_qty3'],
		 'total'				=>trim($request['totalprice'],"$"),
		 'rebates'				=>$request['rebates'],
		 'final_amount'			=>trim($request['final'],"$"),
		 'remarks'				=>$request['remarks'],
		 'approval'				=>"1",
		 ]);
		if($insert){
		\LogActivity::addToLog('Create new RO.');
		return redirect('/release-order-list')->with('success', 'Release order created successfully.');
        }else{
        return redirect()->back()->with('error', 'Something went wrong. Please try again later.');
       }
	}
	
	public function show(Request $request){
		if($request->input('search')){
		$search = $request->input('search');
		$orders = DB::table("release_orders")->where('order_id', 'LIKE',"%{$search}%")->orderBy('id','DESC')->paginate(10);
		$orders->appends(['search' => $search]);
		}
		else{
		$orders = DB::table("release_orders")->orderBy('id','DESC')->paginate(10);
		}
		return view('backend.release-order-list',compact('orders'));
	}
	
	public function deleteall(Request $request){
		if($request->id){
		DB::table("release_orders")->whereIn('id',$request->id)->delete();
		return redirect()->back()->with('success', 'Records are deleted successfully.'); 
		}
		else{
		return redirect()->back()->with('error', 'Please select atleast one order.'); 
		}
	}
	
	public function delete($id){
		$orders = DB::table('release_orders')->where('id',$id)->delete();
		return redirect()->back()->with('success', 'Order deleted successfully.');	
	}
	
	public function edit($id){ 
	 $company = DB::table('suppliers')->select('id','company_name')->orderBy('company_name','ASC')->get();
	 $products = DB::table("products")->select('id','product_name')->get();
	 $users = DB::table("users")->where('customer_type',"!=",NULL)->orderBy('company_name','DESC')->get();
	 $orders = DB::table('release_orders')->where('id',$id)->first();
	 
	 $getproducts['products'] = explode(",",$orders->product);
	 $product_qty['product_qty'] = explode(",",$orders->product_qty);
	 $unit_price['unit_price'] = explode(",",$orders->unit_price);
	 $subtotal['subtotal'] = explode(",",$orders->subtotal);
	 $arr = array_merge($getproducts,$product_qty,$unit_price,$subtotal);
	 /*Skirting*/
	 $skirting['skirting'] = explode(",",$orders->skirting);
	 $skirtingqty['skirtingqty'] = explode(",",$orders->skirtingqty);
	 $arr1 = array_merge($skirting,$skirtingqty);
	 
	 /*end*/
	 $end['end'] = explode(",",$orders->end);
	 $end_color['end_color'] = explode(",",$orders->end_color);
	 $end_qty['end_qty'] = explode(",",$orders->end_qty);
	 $arr2 = array_merge($end,$end_color,$end_qty);
	 
	 /*Contact*/
	 $contact['contact'] = explode(",",$orders->contact);
	 $contact_color['contact_color'] = explode(",",$orders->contact_color);
	 $contact_qty['contact_qty'] = explode(",",$orders->contact_qty);
	 $arr3 = array_merge($contact,$contact_color,$contact_qty);
	 
	 /*Adaptor*/
	 $adaptor['adaptor'] = explode(",",$orders->adaptor);
	 $adaptor_color['adaptor_color'] = explode(",",$orders->adaptor_color);
	 $adaptor_qty['adaptor_qty'] = explode(",",$orders->adaptor_qty);
	 $arr4 = array_merge($adaptor,$adaptor_color,$adaptor_qty);
	 
	 /*L - Capping*/
	 $lcapping['lcapping'] = explode(",",$orders->lcapping);
	 $lcapping_color['lcapping_color'] = explode(",",$orders->lcapping_color);
	 $lcapping_qty['lcapping_qty'] = explode(",",$orders->lcapping_qty);
	 $arr5 = array_merge($lcapping,$lcapping_color,$lcapping_qty);
	 
	 
	 /*Paper*/
	 $corrugated['corrugated'] = explode(",",$orders->corrugated);
	 $corrugated_qty['corrugated_qty'] = explode(",",$orders->corrugated_qty);
	 $plastic['plastic'] = explode(",",$orders->plastic);
	 $pastic_qty['pastic_qty'] = explode(",",$orders->pastic_qty);
	 // $plywood['plywood'] = explode(",",$orders->plywood);
	 // $plywood_qty['plywood_qty'] = explode(",",$orders->plywood_qty);
	 
	 /***Plywood***/
	 $plywood['plywood'] = $orders->plywood;
	 $plywood_qty['plywood_qty'] = $orders->plywood_qty;
	 $plywood_qty2['plywood_qty2'] = $orders->plywood_qty2;
	 $plywood_qty3['plywood_qty3'] = $orders->plywood_qty3;
	 $arr7 = array_merge($plywood,$plywood_qty,$plywood_qty2,$plywood_qty3);
	 
	 $arr6 = array_merge($corrugated,$corrugated_qty,$plastic,$pastic_qty);
	 return view('backend.release-order-edit-ro',compact('company','products','orders','arr','arr1','arr2','arr3','arr4','arr5','arr6','arr7','users'));
	}
	
    public function delete_roimg(Request $request){
        $image = DB::table('release_orders')->where('id', $request->id)
        ->update([
           'image' => null
        ]);
         return Response()->json(array('msg' => 'Image deleted successfully.', 'status' => true));
    }
	
	public function update(Request $request){
	    if($request->file('image')){
        $file = $request->file('image');
        $filename = time().'_'.$file->getClientOriginalName();
	    $extension = $file->getClientOriginalExtension();
	    $location = 'uploads';
		$file->move($location,$filename);
		$filepath = url('uploads/'.$filename);
        }
		else{
			$filename="";
			}
		if(!($request['orderid'])){
		$orderid= rand(0, 999999);	
		}
		else{
		$orderid= $request['orderid'];		
		}

		if($request['endcolour'][0]!=null || $request['endqty'][0]!=null){
		$end ="yes";	
		}
		else{
		$end ="no";	
		}
		if($request['contactcolour'][0]!=null || $request['contactqty'][0]!=null){
		$contact ="yes";	
		}
		else{
		$contact ="no";	
		}
		if($request['adaptorcolour'][0]!=null || $request['adaptorqty'][0]!=null){
		$adaptor ="yes";	
		}
		else{
		$adaptor ="no";	
		}
		if($request['cappingcolour'][0]!=null || $request['cappingqty'][0]!=null){
		$lcapping ="yes";	
		}
		else{
		$lcapping ="no";	
		}
		if($request['plywood_qty1'] || $request['plywood_qty2'] || $request['plywood_qty3']){
		$plywood ="yes";	
		}
		else{
		$plywood ="no";	
		}
	    $product_id = implode(",",$request['product']);
		$quantity = implode(",",$request['quantity']);
		$unitprice = implode(",",$request['unitprice']);
		$unnitprice = trim(str_replace("$","",$unitprice));
		$subtotal = implode(",",$request['price']);
		$subtotal1 = trim(str_replace("$","",$subtotal));
		$skirting = implode(",",$request['skirting']);
		$skirtingqty = implode(",",$request['skirtingqty']);
		$endcolour = implode(",",$request['endcolour']);
		$endqty = implode(",",$request['endqty']);
		$contactcolour = implode(",",$request['contactcolour']);
		$contactqty = implode(",",$request['contactqty']);
		$adaptorcolour = implode(",",$request['adaptorcolour']);
		$adaptorqty = implode(",",$request['adaptorqty']);
		$cappingcolour = implode(",",$request['cappingcolour']);
		$cappingqty = implode(",",$request['cappingqty']);
		$paper = implode(",",$request['paper']);
		$paperqty = implode(",",$request['paperqty']);
		$plastic = implode(",",$request['plastic']);
		$plasticqty = implode(",",$request['plasticqty']);
		// $plywood = implode(",",$request['plywood']);
		// $plywoodqty = implode(",",$request['plywoodqty']);
		$update = DB::table("release_orders")->where('id',$request['id'])->update([
		 'order_id'				=>$orderid,
		 'estimate_date'		=>$request['installation_date'],
		 'ro_key'				=>$request['key'],
		 'role'					=>$request['roles'],
		 'company_id'			=>$request['company_name'],
		 'owner'				=>$request['owner'],
		 'phone_number'			=>$request['phonenumber'],
		 'site_address'			=>$request['siteaddress'],
		 'area'					=>$request['areatoinstall'],
		 'floor_size'			=>$request['floorsize'],
		 'unit'					=>$request['unitsize'],
		 'image'				=>$filename,
		 'lift_level'			=>$request['liftlevel'],
		 'hs'					=>$request['hs'],
		 'cs'					=>$request['cd'],
		 'product'				=>$product_id,
		 'product_qty'			=>$quantity,
		 'unit_price'			=>$unnitprice,
		 'subtotal'				=>$subtotal1,
		 'skirting'				=>$skirting,
		 'skirtingqty'			=>$skirtingqty,
		 'end'					=>$end,
		 'end_color'			=>$endcolour,
		 'end_qty'				=>$endqty,
		 'contact'				=>$contact,
		 'contact_color'		=>$contactcolour,
		 'contact_qty'			=>$contactqty,
		 'adaptor'				=>$adaptor,
		 'adaptor_color'		=>$adaptorcolour,
		 'adaptor_qty'			=>$adaptorqty,
		 'lcapping'				=>$lcapping,
		 'lcapping_color'		=>$cappingcolour,
		 'lcapping_qty'			=>$cappingqty,
		 'corrugated'			=>$paper,
		 'corrugated_qty'		=>$paperqty,
		 'plastic'				=>$plastic,
		 'pastic_qty'			=>$plasticqty,
		 'plywood'				=>$plywood,
		 'plywood_qty'			=>$request['plywood_qty1'],
		 'plywood_qty2'			=>$request['plywood_qty2'],
		 'plywood_qty3'			=>$request['plywood_qty3'],
		 'total'				=>trim($request['totalprice'],"$"),
		 'rebates'				=>$request['rebates'],
		 'final_amount'			=>trim($request['final'],"$"),
		 'remarks'				=>$request['remarks'],
		]);
		return redirect()->back()->with('success', 'Records updated successfully.'); 			
	}
	
		
	public function approval($id , $approval){

		  $getpo  = DB::table('release_orders')->where('id',$id)->first();
		  $update = DB::table("release_orders")->where('id',$id)->update(['approval'=>$approval]);
		  \LogActivity::addToLog('Update RO status.');
		  if($approval=="2" && $update=="1"){
		  $jobsheetid= rand(0, 999999);	
		  $insert = DB::table("jobsheets")->
		  insert([
		  'jobsheet_id'			=>$jobsheetid,
		  'ro_id'				=>$getpo->id,
		  'status'				=>'1',
		  ]);  
		  }
		  else{
		  $delete = DB::table('jobsheets')->where('ro_id',$getpo->id)->delete();  
		  }
		  
		  
		  return redirect()->back()->with('success', 'Status updated successfully.'); 
	}
	
	public function pdf($id, Request $request){
		if($request->has('download')){  
		 $orders = DB::table("release_orders")->where('id',$id)->first();
		 $getproducts['products'] = explode(",",$orders->product);
		 $getquantity['quantity'] = explode(",",$orders->product_qty);
		 $getunit['unit'] = explode(",",$orders->unit);
		 $getunit_price['price'] = explode(",",$orders->unit_price);
		 $getprice['amount'] = explode(",",$orders->subtotal);
		 $getskirting['skirting'] = explode(",",$orders->skirting);
		 $getskirtingqty['skirtingqty'] = explode(",",$orders->skirtingqty);
		 $arr = array_merge($getproducts,$getquantity,$getunit,$getunit_price,$getprice,$getskirting,$getskirtingqty);
         $pdf = PDF::loadView('backend.print-ro',compact('orders','arr'));    
         return $pdf->download('release_order.pdf');  
		}
	}
	
	public function print_ro($id){
		$orders = DB::table("release_orders")->where('id',$id)->first();
		$getproducts['products'] = explode(",",$orders->product);
		$getquantity['quantity'] = explode(",",$orders->product_qty);
		$getunit['unit'] = explode(",",$orders->unit);
		$getunit_price['price'] = explode(",",$orders->unit_price);
		$getprice['amount'] = explode(",",$orders->subtotal);
		$getskirting['skirting'] = explode(",",$orders->skirting);
		$getskirtingqty['skirtingqty'] = explode(",",$orders->skirtingqty);
		$arr = array_merge($getproducts,$getquantity,$getunit,$getunit_price,$getprice,$getskirting,$getskirtingqty);
		return view('backend.print-ro',compact('orders','arr')); 
	}
    


}
