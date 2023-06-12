<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warehouse;
use DB;
use Illuminate\Support\Facades\Storage;
use Hash;


class CustomerController extends Controller
{
	public function index(){
	 return view('backend.customer-create-account');
	}
	
	public function insert(Request $request){
        $request->validate([
            'fullname'  => 'required',
            'type'  	=> 'required',
            'gender'  	=> 'required',
            'dob'  		=> 'required',
            'email' 	=> 'required|email|unique:users',
            'address'	=> 'required',
            'number'  	=> 'required|numeric',
            'group'  	=> 'required',
            'staff_name'=> 'required',
            'staff_id' => 'required',
        ]);
		if($request['type']=="2"){
			$request->validate([
            'company_name'  	=> 'required',
            'user_name'  		=> 'required',
            'password' 			=> 'required',
			'confirm_password' 	=> 'required_with:password|same:password',
			'staff_name'=> 'required',
            'staff_id' => 'required',
			]);
		}
		if($request->file('image')){
        $file = $request->file('image');
        $filename = time().'_'.$file->getClientOriginalName();
	    $extension = $file->getClientOriginalExtension();
	    $location = 'uploads';
		$file->move($location,$filename);
		$filepath = url('uploads/'.$filename);
        }
		else{
		$filename=NULL;	
		}
		if($request['type']=="1"){
			$status ="2";
			$password = Hash::make("12345678");
		}
		else{
			$status ="1";
			$password = Hash::make($request['password']);
		}
		$staff_id = rand(0, 999999);
		$insert = DB::table("users")->
		 insert([
		 'staff_id'				=>$request['staff_id'],
		 'name'				    =>$request['fullname'],
		 'customer_type'		=>$request['type'],
		 'gender'				=>$request['gender'],
		 'dob'					=>$request['dob'],
		 'email'				=>$request['email'],
		 'address'				=>$request['address'],
		 'phone'				=>$request['number'],
		 'salary'				=>$request['salary'],
		 'customer_group'		=>$request['group'],
		 'image'				=>$filename,
		 'company_name'			=>$request['company_name'],
		 'username'				=>$request['user_name'],
		 'password'				=>$password,
		 'remarks'				=>$request['remarks'],
		 'membership'			=>$request['membership'],
		 'status'				=>$status,
		 'creator_id'			=>auth()->user()->id,
		 ]);
		if($insert){
		return redirect('/customer-all-account')->with('success', 'Customer is created successfully.');
        }else{
        return redirect()->back()->with('error', 'Something went wrong. Please try again later.');
       }
	}
	
	public function show(Request $request){
		if($request->input('search')){
		$search = $request->input('search');
		$customers = DB::table('users')->where('customer_type','!=','NULL')->where('name', 'LIKE',"%{$search}%")->orWhere('staff_id', 'LIKE', "%{$search}%")->orderBy('id',"DESC")->paginate(10);
		$customers->appends(['search' => $search]);
		}
		else{
		$customers = DB::table('users')->where('customer_type','!=','NULL')->orderBy('id',"DESC")->paginate(10);
		}
		return view('backend.customer-all-account',compact('customers'));
	}
	
	public function deleteall(Request $request){
		if($request->id){
		DB::table("users")->whereIn('id',$request->id)->delete();
		return redirect()->back()->with('success', 'Records are deleted successfully.'); 
		}
		else{
		return redirect()->back()->with('error', 'Please select atleast one record.'); 
		}
	}
	
	public function delete($id){
	   $orders = DB::table('users')->where('id',$id)->delete();
	   return redirect()->back()->with('success', 'Customer deleted successfully.');	
	}
	
	public function edit($id){
		$customer= DB::table('users')->where('id',$id)->first();
		return view('backend.customer-edit-account',compact('customer'));
	}
	
	public function update(Request $request){
		$request->validate([
            'fullname'  => 'required',
            'type'  	=> 'required',
            'gender'  	=> 'required',
            'dob' 	 	=> 'required',
            'email' 	=> 'required|email',
            'address'	=> 'required',
            'number'  	=> 'required|numeric',
            'group'  	=> 'required',
			'staff_name'=> 'required',
            'staff_id' => 'required',
        ]);
		if($request['type']=="2"){
			$request->validate([
            'company_name'  	=> 'required',
            'user_name'  		=> 'required',
            'password' 			=> 'required',
			'confirm_password' 	=> 'required_with:password|same:password',
			'staff_name'=> 'required',
            'staff_id' => 'required',
			]);
		}
		if($request->file('image')){
        $file = $request->file('image');
        $filename = time().'_'.$file->getClientOriginalName();
	    $extension = $file->getClientOriginalExtension();
	    $location = 'uploads';
		$file->move($location,$filename);
		$filepath = url('uploads/'.$filename);
        }
		else{
		$filename=NULL;	
		}
		if($request['type']=="1"){
			$status ="2";
			$password = Hash::make("12345678");
		}
		else{
			$status ="1";
			$password = Hash::make($request['password']);
		}
		$update = DB::table("users")->where('id',$request->id)->update([
		 'staff_id'				=>$request['staff_id'],
		 'name'				    =>$request['fullname'],
		 'customer_type'		=>$request['type'],
		 'gender'				=>$request['gender'],
		 'dob'					=>$request['dob'],
		 'email'				=>$request['email'],
		 'address'				=>$request['address'],
		 'phone'				=>$request['number'],
		 'salary'				=>$request['salary'],
		 'customer_group'		=>$request['group'],
		 'image'				=>$filename,
		 'company_name'			=>$request['company_name'],
		 'username'				=>$request['user_name'],
		 'password'				=>$password,
		 'remarks'				=>$request['remarks'],
		 'membership'			=>$request['membership'],
		]);
		return redirect()->back()->with('success', 'Customer updated successfully.');	
	}
	


}
