<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Crypt;
use Illuminate\Http\Request;
Use App\Models\Internal_cre_account;
use Hash;
use Mail;
Use DB; 

class Internal_create_account extends Controller
{
    public function index(){
        $roles = DB::table('roles')->where('status','1')->get();
        return view('backend.internal-create-account',compact('roles'));
    }

    public function store(Request $request){

        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users',
            'address'=> 'required',
            'phone'  => 'required|numeric',
            'username'=> 'required|string|max:255',
            'password' => 'required',
			'confirm_password' => 'required_with:password|same:password',
			'image' => 'mimes:jpeg,png|max:500',
        ]);

        // $image = 'test';
        if($request->role=="2"){
		$rol_id = 2;
		}
        else{
        $request->validate([
        'role'  => 'required',
        ]);
		$rol_id = $request->role;
		}
        $staff_id = random_int(0, 999999);
        $staff_id = str_pad($staff_id, 6, 0, STR_PAD_LEFT);
        $chkemail = DB::table('users')->where('email',$request->email)->count();
        if($chkemail<1){
        $internal_cre_account = new Internal_cre_account;
        $internal_cre_account->name = $request->name;
        $internal_cre_account->staff_id = 'SUP-'.$staff_id;
        // $internal_cre_account->role_id = $request->role_id; 
        $internal_cre_account->role_id = $rol_id;        

        $internal_cre_account->gender = $request->gender;
        $internal_cre_account->dob = $request->dob;
        $internal_cre_account->email = $request->email;
        $internal_cre_account->address = $request->address;
        $internal_cre_account->phone = $request->phone;
        $internal_cre_account->username = $request->username;        
        $internal_cre_account->password = Hash::make($request->password);
        $internal_cre_account->remarks = $request->remarks;
        $internal_cre_account->status = "1";
        $internal_cre_account->creator_id = auth()->user()->id;
        if($request->file('image')){
        $file = $request->file('image');
        $filename = time().'_'.$file->getClientOriginalName();
	    $extension = $file->getClientOriginalExtension();
	    $location = 'uploads';
		$file->move($location,$filename);
		$filepath = url('uploads/'.$filename);
        $internal_cre_account->image = $filename;
        }

        $internal_cre_account->save();
        
        $subject=$request->email;
        $data = array('name'=>$request->name,'email'=>$request->email,'password'=>$request->password);
		Mail::send('backend.mail.mail', $data, function($message)use($subject) {
        $message->to($subject, 'Registration mail')->subject
        ('Registration mail.');
        $message->from('meenakshi.nanta@imarkinfotech.com','Supreme');
         });
         
         
        }
        return redirect('/internal-all-account')->with('success', 'Record created successfully.');
    }

    public function show(Request $request){
       if(auth()->user()->role_id=="1"||auth()->user()->role_id=="2"){
		$subacount = DB::table('users')->where('role_id','2')->count();
        $staffcount= DB::table('users')->where('role_id','6')->count();
        $agentcount= DB::table('users')->Where('role_id','9')->count();
        $delcount= DB::table('users')->where('role_id','10')->count();
        $intcount= DB::table('users')->where('role_id','11')->count();
		if($request->input('search')){
        $search = $request->input('search');
    	$all_accounts = DB::table('users')->select('users.id','users.name','users.email','users.staff_id','users.username','users.gender','users.status','roles.name as rolename','roles.level','users.image','users.role_id','users.phone','users.dob','users.address','users.remarks')->leftJoin('roles', 'users.role_id', '=', 'roles.id')->where('users.name', 'LIKE',"%{$search}%")->orWhere('users.email', 'LIKE', "%{$search}%")->orWhere('users.username', 'LIKE', "%{$search}%")->orWhere('users.staff_id', 'LIKE', "%{$search}%")->paginate(10);
    	$all_accounts->appends(['search' => $search]);
        }
        elseif($request->input('filter')){
         $search = $request->input('filter');  
         $all_accounts = DB::table('users')->select('users.id','users.name','users.email','users.staff_id','users.username','users.gender','users.status','roles.name as rolename','roles.level','users.image','users.role_id','users.phone','users.dob','users.address','users.remarks')->leftJoin('roles', 'users.role_id', '=', 'roles.id')->where('users.role_id', $search)->paginate(10);
         $all_accounts->appends(['filter' => $search]);
        }
		else{
		$all_accounts = DB::table('users')->select('users.id','users.name','users.email','users.staff_id','users.username','users.gender','users.status','roles.name as rolename','roles.level','users.image','users.role_id','users.phone','users.dob','users.address','users.remarks')->leftJoin('roles', 'users.role_id', '=', 'roles.id')->paginate(10);
		}
		}
		else{
		$subacount = DB::table('users')->where('role_id','2')->where('users.creator_id',auth()->user()->id)->count();
        $staffcount= DB::table('users')->where('role_id','6')->where('users.creator_id',auth()->user()->id)->count();
        $agentcount= DB::table('users')->Where('role_id','9')->where('users.creator_id',auth()->user()->id)->count();
        $delcount= DB::table('users')->where('role_id','10')->where('users.creator_id',auth()->user()->id)->count();
        $intcount= DB::table('users')->where('role_id','11')->where('users.creator_id',auth()->user()->id)->count();
		if($request->input('search')){
        $search = $request->input('search');
    	$all_accounts = DB::table('users')->select('users.id','users.name','users.creator_id','users.email','users.staff_id','users.username','users.gender','users.status','roles.name as rolename','roles.level','users.image','users.role_id','users.phone','users.dob','users.address','users.remarks')->leftJoin('roles', 'users.role_id', '=', 'roles.id')->where('users.creator_id',auth()->user()->id)->where('users.name', 'LIKE',"%{$search}%")->paginate(10);
    	 $all_accounts->appends(['search' => $search]);
        }	
		elseif($request->input('filter')){
         $search = $request->input('filter');  
         $all_accounts = DB::table('users')->select('users.id','users.name','users.email','users.staff_id','users.username','users.gender','users.status','roles.name as rolename','roles.level','users.image','users.role_id','users.phone','users.dob','users.address','users.remarks')->leftJoin('roles', 'users.role_id', '=', 'roles.id')->where('users.role_id', $search)->where('users.creator_id',auth()->user()->id)->paginate(10);
          $all_accounts->appends(['filter' => $search]);
        }	
		else{
		$all_accounts = DB::table('users')->select('users.id','users.name','users.creator_id','users.email','users.staff_id','users.username','users.gender','users.status','roles.name as rolename','roles.level','users.image','users.role_id','users.phone','users.dob','users.address','users.remarks')->leftJoin('roles', 'users.role_id', '=', 'roles.id')->where('users.creator_id',auth()->user()->id)->paginate(10);
		}
		}
        
		
        return view('backend.internal-all-account',['all_accounts'=>$all_accounts,'subacount'=>$subacount,'staffcount'=>$staffcount,'agentcount'=>$agentcount,'delcount'=>$delcount,'intcount'=>$intcount]);
    }

    public function edit($id){
       // dd($id);
        $edit = Internal_cre_account::where('id',$id)->first();
        $roles = DB::table('roles')->where('status','1')->get();
        return view('backend.internal-edit-account',['edit'=>$edit,'roles'=>$roles]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email',
            'address'=> 'required',
            'phone'  => 'required|numeric',
            'username'=> 'required|string|max:255',
			'image' => 'mimes:jpeg,png|max:500'
        ]);
        $update = Internal_cre_account::where('id',$id)->first();
        if($request->roleid=="2"){
		$rol_id = 2;
		}
        else{
        $request->validate([
        'role'  => 'required',
        ]);
		$rol_id = $request->role;
		}


        $update->name = $request->name;
        $update->role_id = $rol_id;        
        $update->gender = $request->gender;
        $update->dob = $request->dob;
        $update->email = $request->email;
        $update->address = $request->address;
        $update->phone = $request->phone;
        $update->username = $request->username;    
        
        if($request->file('image')){
        $file = $request->file('image');
        $filename = time().'_'.$file->getClientOriginalName();
	    $extension = $file->getClientOriginalExtension();
	    $location = 'uploads';
		$file->move($location,$filename);
		$filepath = url('uploads/'.$filename);
        $update->image = $filename;
        }

        //$internal_edit_account->title = $request->title;
        $update->save();
        return redirect('/internal-all-account')->with('success', 'Record updated successfully.');
    }

    public function destroy($id){
        $internal_cre_account = Internal_cre_account::where('id',$id)->first();
        $internal_cre_account->delete();
         return redirect()->back()->with('success', 'Record deleted successfully.');
    }
    
    public function change_pass(Request $request, $id){

        $updat = Internal_cre_account::all()->where('id',$id)->first();
        $old = Hash::make($request->old_password);
        $pass = Hash::make($request->new_password);
        
        if (!Hash::check($request['old_password'], $updat->password)) {
            return redirect('/internal-all-account')->with('error', 'Old password is wrong. Please enter a correct password.');
             }
        
        else{
            
         $update = DB::table('users')->where('id', $id)
       ->update([
           'password' => $pass
        ]);
        return redirect('/internal-all-account')->with('success', 'Record created successfully.');
        }
       
        
    }
    
    public function update_status($id){
        $chkstatus = DB::table('users')->select('status')->where('id',$id)->get();
        if($chkstatus[0]->status=="1"){
        $update = DB::table("users")->where('id', $id)
       ->update([
           'status' => "2"
        ]);
        }
        else{
        $update = DB::table("users")->where('id', $id)
       ->update([
           'status' => "1"
        ]);
        }
        return redirect()->back()->with('success', 'Status updated successfully.');  
    }
    
    public function search(Request $request){
        $search = $request->input('search');
    	$all_accounts = DB::table('users')->select('users.id','users.name','users.email','users.staff_id','users.username','users.gender','users.status','roles.name as rolename','roles.level','users.image','users.role_id','users.phone','users.dob','users.address','users.remarks')->leftJoin('roles', 'users.role_id', '=', 'roles.id')->where('users.name', 'LIKE',"%{$search}%")->orWhere('users.email', 'LIKE', "%{$search}%")->orWhere('users.username', 'LIKE', "%{$search}%")->orWhere('users.staff_id', 'LIKE', "%{$search}%")->get();
        //echo"<pre>";print_r($all_accounts);echo"</pre>";exit();
        return view('backend.search',['all_accounts'=>$all_accounts]);
    }
    
    public function delete_img(Request $request){
        $image = DB::table("users")->where('id', $request->id)
        ->update([
           'image' => null
        ]);
         return Response()->json(array('msg' => 'Image deleted successfully.', 'status' => true));
    }
	
	public function deleteall(Request $request){
	if($request->id){
     DB::table("users")->whereIn('id',$request->id)->delete();
     return redirect()->back()->with('success', 'Records are deleted successfully.'); 
	}
	else{
	return redirect()->back()->with('error', 'Please select atleast one account.'); 
	}
	}
    
}
