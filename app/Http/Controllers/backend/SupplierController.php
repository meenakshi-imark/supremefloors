<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Role;
use DB;
class SupplierController extends Controller
{
	public function index(){
	 return view('backend.supplier-create-new-supplier');
	}
	
	public function create_supplier(Request $request){ 
		$insert = DB::table("suppliers")->insert(['company_name'=>$request['company_name'],'email'=>$request['email'],'address'=>$request['address'],'person_name'=>$request['person_name'],'phone'=>$request['phone'],'website'=>$request['website'],'country'=>$request['country'],'remarks'=>$request['remarks']]);
		$arr = array('msg' => 'Successful.', 'status' => true);
		return Response()->json($arr);
	}
	
	public function show(Request $request){
		if($request->input('search')){
		$search = $request->input('search');
		$get = DB::table("suppliers")->where('company_name', 'LIKE',"%{$search}%")->orWhere('email', 'LIKE',"%{$search}%")->orWhere('person_name', 'LIKE',"%{$search}%")->orderBy('id','DESC')->paginate(10);
		$get->appends(['search' => $search]);
		}
		else{
	    $get = DB::table("suppliers")->orderBy('id','DESC')->paginate(10);
		}
	    return view('backend.all-suppliers',compact('get'));
	}
	
	public function delete_suppliers($id){
	    DB::table("suppliers")->where('id',$id)->delete();
        return redirect()->back()
                        ->with('success','Supplier deleted successfully.');
	}
	
	public function edit($id){
	    $supplier = DB::table('suppliers')->find($id);
	    return view('backend.edit-supplier',compact('supplier'));
	}
	
	public function update_supplier(Request $request){
	     $update = DB::table("suppliers")->where('id',$request['id'])->update(['company_name'=>$request['company_name'],'email'=>$request['email'],'address'=>$request['address'],'person_name'=>$request['person_name'],'phone'=>$request['phone'],'website'=>$request['website'],'country'=>$request['country'],'remarks'=>$request['remarks']]);
             $arr = array('msg' => 'Supplier updated successfully.', 'status' => true);
         return Response()->json($arr);
	}
}
