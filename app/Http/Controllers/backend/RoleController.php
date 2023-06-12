<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use DB;
class RoleController extends Controller
{

	public function index(){
		if(auth()->user()->role_id=="10"){
			 return redirect("delivery-order-table");  
		}
		if(auth()->user()->role_id=="11"){
			 return redirect("installer-order-table");  
		}
	    $getrole= DB::table('roles')->where('id',auth()->user()->role_id)->get();
        if(isset($getrole[0]->permission_id)){
	    $per = explode(",",$getrole[0]->permission_id);
        }else{
            $per =[];
        }
        if(isset($getrole[0]->access_id)){
	    $acc = explode(",",$getrole[0]->access_id);
        }else{
            $acc =[];
        }
	    if(in_array("1", $per) || auth()->user()->role_id=="1" || auth()->user()->role_id=="2") {
        $permissions = DB::table('permissions')->get();
    	$access = DB::table('permission_access')->get();
	    return view('backend.role-create-type',compact('permissions','access'));
	    }
        if(in_array("2", $per)){
          return redirect("internal-all-account");  
        }
        $permissions = DB::table('permissions')->get();
    	$access = DB::table('permission_access')->get();
        return view('backend.role-create-type',compact('permissions','access'));
		
	}
	
	public function create_role(Request $request){	
	    if($request['permission']){
		$permission = implode(",",$request['permission']);
	    }
	    else{
	        $permission = null;
	    }
	    if($request['permission']){
		$access = implode(",",$request['access']);
	    }
	    else{
	        $access=null;
	    }
		$checkrole= DB::table("roles")->where('name',$request['rolename'])->get();
		if(count($checkrole)<1){
		$insert = DB::table("roles")->insert(['name'=>$request['rolename'],'level'=>$request['level'],'permission_id'=>$permission,'access_id'=>$access,'status'=>'1',]);
		if($insert){ 
        	$arr = array('msg' => 'Form submitted successfully.', 'status' => true);
        }
		}
		else{
			$arr = array('msg' => 'Please enter a unique role name.', 'status' => false);
		}
        return Response()->json($arr);

	}
	
	public function showroles()
    {
        $roles = Role::all();
        $permissions= DB::table("permissions")->select("permissions.id","permissions.name","permission_access.name as accessname")->leftJoin("permission_access","permissions.id",'=',"permission_access.permission_id")->get();
      
        $get_per =DB::table("permissions")->get();
        return view('backend/role-all-role',compact('roles','permissions','get_per'));
    }

    public function edit_roles($id)
    {
        $roles = Role::find($id);
        $permissions = DB::table('permissions')->get();
        $access = DB::table('permission_access')->get();
        return view('backend/role-edit-type',compact('roles','permissions','access'));
    }

    public function update_roles(Request $request,$id)
    {       
            if($request['permission']){
            $permission = implode(",",$request['permission']);
            }
            else{
	        $permission = null;
	        }
            if($request['access']){
            $access = implode(",",$request['access']);
            }
            else{
             $access = null;  
            }
            $update = DB::table("roles")->where('id',$id)->update(['name'=>$request['rolename'],'level'=>$request['level'],'permission_id'=>$permission,'access_id'=>$access,'status'=>'1',]);
            $arr = array('msg' => 'Form submitted successfully.', 'status' => true);
            
            
            return Response()->json($arr);
    }

    public function destroy_roles($id)
    {
        $roles = Role::find($id);
        $roles->delete();
        return redirect()->back()->with('success', 'Role deleted successfully.');
    }
    
    public function duplicate($id){
        $chk =  Role::find($id);
        $insert = Role::insert(['name'=>$chk->name. "(1)",'level'=>$chk->level,'permission_id'=>$chk->permission_id,'access_id'=>$chk->access_id,'status'=>'1',]);
        return redirect()->back()->with('success', 'Role duplicated successfully.');
    }
	
	public function deleteallrole(Request $request){
	if($request->id){
    DB::table("roles")->whereIn('id',$request->id)->delete();
    return redirect()->back()->with('success', 'Records are deleted successfully.'); 
	}
	else{
	return redirect()->back()->with('error', 'Please select atleast one role.'); 
	}
	}
	
}
