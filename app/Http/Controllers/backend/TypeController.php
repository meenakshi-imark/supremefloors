<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warehouse;
use DB;
use Illuminate\Support\Facades\Storage;


class TypeController extends Controller
{
	public function index(){
	 return view('backend.customer-create-type');
	}
	
	public function insert(Request $request){
		$insert = DB::table("customer_type")->
		 insert([
		 'type_name'			=>$request['type'],
		 'description'				=>$request['description'],
		 ]);
	 if($insert){
		return redirect('/customer-all-type')->with('success', 'Customer type created successfully.');
        }else{
        return redirect()->back()->with('error', 'Something went wrong. Please try again later.');
       }
	}
	
	public function show(){
		$types = DB::table('customer_type')->orderBy('id','DESC')->get();
		return view('backend.customer-all-type',compact('types'));
	}
	
	public function deleteall(Request $request){
		if($request->id){
		DB::table("customer_type")->whereIn('id',$request->id)->delete();
		return redirect()->back()->with('success', 'Records are deleted successfully.'); 
		}
		else{
		return redirect()->back()->with('error', 'Please select atleast one record.'); 
		}
	}
	
	public function delete($id){
	   $orders = DB::table('customer_type')->where('id',$id)->delete();
	   return redirect()->back()->with('success', 'Type deleted successfully.');	
	}
	
	public function edit($id){
		$type = DB::table('customer_type')->where('id',$id)->first();
		return view('backend.customer-edit-create-type',compact('type'));
	}
	
	public function update(Request $request){
		$update = DB::table("customer_type")->where('id',$request->id)->update([
		 'type_name'			=>$request['type_name'],
		 'description'			=>$request['description'],
		]);
		return redirect()->back()->with('success', 'Customer type updated successfully.');		
		
	}


}
