<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product_category;
use DB;
use Mail;
use App\Mail\WarrantyMail;

class WarrantyController extends Controller
{
	public function index(){
	 return view('frontend.warranty-check');
	}

	public function search(){
		$address = DB::table('users')->select('address')->where('customer_type','!=','NULL')->orderBy('address',"ASC")->get();
		return view('frontend.warranty-check-search',compact('address'));
	}

	public function getaddress(Request $request){
		$data = DB::table('users')->select("address as value", "id")->where('address', 'LIKE', '%'. $request->get('search'). '%')->get();

	  return response()->json($data);
	}
	
	public function insert(Request $request){
		// dd($_POST);
		$insert = DB::table('warranty_check')->insert([
			'userid' 		 => $request->userid, 
			'name'   		 => $request->name,
			'email'   		 => $request->email,
			'phone'   		 => $request->phone,
			'housing_unit'   => $request->housing_unit
		]);

		$email = DB::table('users')->select('name','email')->where('id',$request['userid'])->first();
		Mail::to($request['email'])->send(new WarrantyMail($request->all()));
		if($insert){
		return redirect()->back()->with('success','Warranty check request submitted successfully.');
		}else{
			return redirect()->back()->with('error','Warranty check request not submitted successfully.');
		}
	}
	
}
