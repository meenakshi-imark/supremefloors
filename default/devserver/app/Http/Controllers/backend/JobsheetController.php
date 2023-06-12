<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warehouse;
use DB;
use Illuminate\Support\Facades\Storage;
use PDF; 
use Mail;
use App\Mail\MailReminder;


class JobsheetController extends Controller
{
	public function index(Request $request){

	 if($request->input('filter')){ 
		if($request->input('filter')=="completed"){
		$filter ="1";	
		}
		elseif($request->input('filter')=="not-started"){
		$filter ="2";	
		}
		elseif($request->input('filter')=="postponed"){
		$filter ="3";	
		}
		elseif($request->input('filter')=="installing"){
		$filter ="4";	
		}
		elseif($request->input('filter')=="delivered"){
		$filter ="5";	
		}
		else{
		$filter ="";	
		}
		$assigned = DB::table('jobsheets')->where('jobsheet_status',$filter)->where('status',"2")->orderBy('id','DESC')->get();
		$job_not_assigned = DB::table('jobsheets')->where('status','1')->orderBy('id','DESC')->get();
	 }
	 // else{
	 // $assigned = DB::table('jobsheets')->where('status','2')->orderBy('id','DESC')->get();
	 // $job_not_assigned = DB::table('jobsheets')->where('status','1')->orderBy('id','DESC')->get();
	 // }
	 
	 elseif($request->input('search')){
	    $search =$request->input('search');
		$assigned = DB::table('jobsheets')->select('jobsheets.id','jobsheets.ro_id','jobsheets.jobsheet_status','jobsheets.description','jobsheets.installation_date','jobsheets.installer','jobsheets.delivery_date','jobsheets.driver','jobsheets.c','jobsheets.pl')
		->leftJoin('release_orders', 'jobsheets.ro_id', '=', 'release_orders.id')
		->where('release_orders.order_id', 'LIKE',"%{$search}%")->where('status','2')->orderBy('jobsheets.id','DESC')->get();
					
		$job_not_assigned = DB::table('jobsheets')->select('jobsheets.id','jobsheets.ro_id','jobsheets.jobsheet_status','jobsheets.description','jobsheets.installation_date','jobsheets.installer','jobsheets.delivery_date','jobsheets.driver','jobsheets.c','jobsheets.pl')
		->leftJoin('release_orders', 'jobsheets.ro_id', '=', 'release_orders.id')
		->where('release_orders.order_id', 'LIKE',"%{$search}%")->where('status','1')->orderBy('jobsheets.id','DESC')->get();
	 }
	 else{
		$assigned = DB::table('jobsheets')->where('status','2')->orderBy('id','DESC')->get();
		$job_not_assigned = DB::table('jobsheets')->where('status','1')->orderBy('id','DESC')->get();
	 }
	 // echo"<pre>";print_r($assigned);echo"</pre>";exit();
	 return view('backend.job-sheet-table',compact('job_not_assigned','assigned'));
	}
	
	public function assign_delivery(Request $request){
		$update = DB::table('jobsheets')->where('id',$request['id'])->update([
		 'delivery_date'		=>$request['val'],
		]);
		$response['status'] = 1;
		$response['msg'] = 'Delivery date assigned successfully';
		echo json_encode($response); 
	}
	
	public function assign_installation(Request $request){
		$update = DB::table('jobsheets')->where('id',$request['id'])->update([
		 'installation_date'		=>$request['val'],
		]);
		$response['status'] = 1;
		$response['msg'] = 'Installation date assigned successfully';
		echo json_encode($response); 
	}
	
	public function edit($id){
	$jobsheets = DB::table('jobsheets')->where('id',$id)->first();
	$ro = DB::table('release_orders')->where('id',$jobsheets->ro_id)->first();
	$drivers = DB::table('users')->select('id','name')->where('role_id','10')->orderBy('name','ASC')->get();
	$installers = DB::table('users')->select('id','name')->where('role_id','11')->orderBy('name','ASC')->get();
	return view('backend.jobsheet-edit',compact('jobsheets','ro','drivers','installers'));	
	}
	
	public function update(Request $request){
		
		$update = DB::table("jobsheets")->where('id',$request['id'])->update([
		 'delivery_date'		=>$request['delivery_date'],
		 'driver'				=>$request['driver'],
		 'installation_date'	=>$request['installation_date'],
		 'installer'			=>$request['installer'],
		 'description'			=>$request['description'],
		 'c'					=>$request['c'],
		 'pl'					=>$request['pl'],
		]);
		if($update==true){
		$update1 = DB::table("jobsheets")->where('id',$request['id'])->update([
		 'status'				=>'2',
		 'jobsheet_status'		=>'2',
		]);
		}
		if($request['delivery_date'] && $request['driver'] && $request['installation_date'] && $request['installer']){
		return redirect('/jobsheet')->with('success', 'Records updated successfully.'); 	
		}
		else{
		return redirect('/jobsheet?status=notassigned')->with('success', 'Records updated successfully.'); 	
		}
				
	}
	
	public function delete($id){
		$orders = DB::table('jobsheets')->where('id',$id)->delete();
		return redirect()->back()->with('success', 'Record deleted successfully.');	
	}
	
	public function jobsheet_status($id, $status){
		$update = DB::table("jobsheets")->where('id',$id)->update([
		 'jobsheet_status'		=>$status,
		]);
		return redirect()->back()->with('success', 'Status updated successfully.'); 
	}
	
	public function deleteall(Request $request){
		if($request->id){
		DB::table("jobsheets")->whereIn('id',$request->id)->delete();
		return redirect()->back()->with('success', 'Records are deleted successfully.'); 
		}
		elseif($request->idd){ 
		DB::table("jobsheets")->whereIn('id',$request->idd)->delete();
		return redirect()->back()->with('success', 'Records are deleted successfully.'); 	
		}
		else{
		return redirect()->back()->with('error', 'Please select atleast one order.'); 
		}
	}
	
	public function create(){
		$drivers = DB::table('users')->select('id','name')->where('role_id','10')->orderBy('name','ASC')->get();
		$installers = DB::table('users')->select('id','name')->where('role_id','11')->orderBy('name','ASC')->get();
		return view('backend.create-jobsheet-create',compact('drivers','installers'));	
		
	}
	
	public function autocomplete(Request $request){
        $data = DB::table('release_orders')->select("order_id as value", "id","owner","site_address")->where('order_id', 'LIKE', '%'. $request->get('search'). '%')
                    ->get();
        return response()->json($data);
    }
	
	public function insert(Request $request){
		 $jobsheet_id = rand(0, 999999);
		 if($request['delivery_date'] && $request['driver'] && $request['installation_date'] && $request['installer']){
		 $status ="2";	 
		 }
		 else{
		 $status ="1";	 
		 }
		 $insert = DB::table("jobsheets")->
		 insertGetId([
		 'jobsheet_id'			=>$jobsheet_id,
		 'ro_id'				=>$request['roid'],
		 'delivery_date'		=>$request['delivery_date'],
		 'driver'				=>$request['driver'],
		 'installation_date'	=>$request['installation_date'],
		 'installer'			=>$request['installer'],
		 'description'			=>$request['description'],
		 'c'					=>$request['c'],
		 'pl'					=>$request['pl'],
		 'status'				=>$status,
		 'jobsheet_status'		=>"2",
		 ]);
	 if($insert){
		return redirect('/jobsheet')->with('success', 'Jobsheet created successfully.');
        }else{
        return redirect()->back()->with('error', 'Something went wrong. Please try again later.');
       }
	}
	
	public function view_calendar(Request $request){
		if($request->input('search')){
	    $search =$request->input('search');
		$assigned = DB::table('jobsheets')->select('jobsheets.id','jobsheets.created_at','jobsheets.jobsheet_id','jobsheets.ro_id','jobsheets.jobsheet_status','jobsheets.description','jobsheets.installation_date','jobsheets.installer','jobsheets.delivery_date','jobsheets.driver','jobsheets.c','jobsheets.pl')
		->leftJoin('release_orders', 'jobsheets.ro_id', '=', 'release_orders.id')
		->where('release_orders.order_id', 'LIKE',"%{$search}%")->where('status','2')->orderBy('jobsheets.id','DESC')->get();
					
		$job_not_assigned = DB::table('jobsheets')->select('jobsheets.id','jobsheets.created_at','jobsheets.jobsheet_id','jobsheets.ro_id','jobsheets.jobsheet_status','jobsheets.description','jobsheets.installation_date','jobsheets.installer','jobsheets.delivery_date','jobsheets.driver','jobsheets.c','jobsheets.pl')
		->leftJoin('release_orders', 'jobsheets.ro_id', '=', 'release_orders.id')
		->where('release_orders.order_id', 'LIKE',"%{$search}%")->where('status','1')->orderBy('jobsheets.id','DESC')->get();
		}
		else{
		$assigned = DB::table('jobsheets')->where('status','2')->orderBy('id','DESC')->get();
		$job_not_assigned = DB::table('jobsheets')->where('status','1')->orderBy('id','DESC')->get();
		}
		return view('backend.job-sheet-calendar',compact('assigned','job_not_assigned'));	
	}
	
	public function view($id){
		$jobsheets = DB::table('jobsheets')->where('id',$id)->first();
		$ro = DB::table('release_orders')->where('id',$jobsheets->ro_id)->first();
		$drivers = DB::table('users')->select('id','name')->where('id',$jobsheets->driver)->first();
		$installers = DB::table('users')->select('id','name')->where('id',$jobsheets->installer)->first();
		return view('backend.job-sheet-details',compact('jobsheets','ro','drivers','installers'));		
	}
	
	public function pdf($id, Request $request){
		if($request->has('download')){  
		 $jobsheets = DB::table('jobsheets')->where('id',$id)->first();
		 $ro = DB::table('release_orders')->where('id',$jobsheets->ro_id)->first();
		 $drivers = DB::table('users')->select('id','name')->where('id',$jobsheets->driver)->orderBy('name','ASC')->first();
		 $installers = DB::table('users')->select('id','name')->where('id',$jobsheets->installer)->orderBy('name','ASC')->first();
         $pdf = PDF::loadView('backend.details-pdf',compact('jobsheets','ro','drivers','installers'));  
         return $pdf->download('jobsheet_details.pdf');  
        } 	
	} 
	
	public function send_reminder(Request $request){
		$insert = DB::table("reminders")->
		 insert([
		 'job_id'			=>$request['jobid'],
		 'order_id'			=>$request['orderid'],
		 'status'			=>$request['status'],
		 'daysleft'			=>$request['duedate'],
		 'reminder'			=>'Job Order '.$request['orderid'] .'Status is '.$request['status'] .'The Due Date Is '.$request['duedate'].' Days', 
		 ]);
		if($insert=="1"){
			$response['status'] = 1;
			$response['msg'] = 'Data submitted successfully.'; 
		 }
		 else{
		   $response['status'] = 2;
		   $response['msg'] = 'Something went wrong. Please try again later.';
		 }
		  echo json_encode($response);
	}
	
	public function reminder_status($id){
		$update = DB::table("reminders")->where('id',$id)->update([
		 'reminder_status'		=>"1",
		]);
		return redirect()->back(); 	
	}
	
	public function send_email_reminder(Request $request){	
		$email = $request->email;
		Mail::to($email)->send(new MailReminder($request->all()));	
		$response['status'] = 1;
		$response['msg'] = 'Data submitted successfully.'; 
		echo json_encode($response);
	}
	
	public function create_invoice(Request $request){
		$jobsheet= DB::table('jobsheets')->where('id',$request['jobid'])->first();
		if($jobsheet->dispute_status=="1"){
		$response['status'] = 3;
		$response['msg'] = 'status error.';	
		}
		else{
		$ro= DB::table('release_orders')->where('id',$jobsheet->ro_id)->first();
		$owner = DB::table('users')->select('email')->where('id',$ro->owner)->first();
		$services = DB::table('quotations')->select('ro_number','services','serviceprice')->where('ro_number',$ro->order_id)->first();
		if($services){
		if($services->ro_number==$ro->order_id){
		$service =	$services->services;
		$serviceprice =	$services->serviceprice;
		}
		else{
		$service =	NULL;
		$serviceprice =	NULL;
		}}
		else{
		$service =	NULL;
		$serviceprice =	NULL;
		}
		 $invoice_id = rand(0, 999999);
		 $insert = DB::table("invoices")->
		 insert([
		 'invoice_id'			=>$invoice_id,
		 'company'				=>$ro->company_id,
		 'address'				=>$ro->site_address,
		 'attention_to'			=>$ro->owner,
		 'phone'				=>$ro->phone_number,
		 'email'				=>$owner->email,
		 'due_date'				=>$jobsheet->delivery_date,
		 'installer'			=>$jobsheet->installer,
		 'product_id'			=>$ro->product,
		 'quantity'				=>$ro->product_qty,
		 'unit'					=>$ro->unit,
		 'unit_price'			=>$ro->unit_price,
		 'amount'				=>$ro->subtotal,
		 'services'				=>$service,
		 'serviceprice'			=>$serviceprice,
		 'site_address'			=>$ro->site_address,
		 'invoice'				=>$jobsheet->description,
		 'rebates'				=>$ro->rebates,
		 'subtotal'				=>$ro->total,
		 'total'				=>$ro->final_amount,
		 'status'				=>'pending',
		 ]);
		 if($insert){
			$response['status'] = 1;
			$response['msg'] = 'Data submitted successfully.';
		}
		else{
			$response['status'] = 2;
			$response['msg'] = 'error.';
			}
		}
		echo json_encode($response);
	}
	
	public function print_jobsheet($id){
			 $jobsheets = DB::table('jobsheets')->where('id',$id)->first();
			 $ro = DB::table('release_orders')->where('id',$jobsheets->ro_id)->first();
			 $drivers = DB::table('users')->select('id','name')->where('id',$jobsheets->driver)->orderBy('name','ASC')->first();
			 $installers = DB::table('users')->select('id','name')->where('id',$jobsheets->installer)->orderBy('name','ASC')->first();
			 return view('backend.details-pdf',compact('jobsheets','ro','drivers','installers'));	
 
	}

	public function next_date(Request $request){
		if($request->input('search')){
			$search =$request->input('search');
			$assigned = DB::table('jobsheets')->select('jobsheets.id','jobsheets.created_at','jobsheets.jobsheet_id','jobsheets.ro_id','jobsheets.jobsheet_status','jobsheets.description','jobsheets.installation_date','jobsheets.installer','jobsheets.delivery_date','jobsheets.driver','jobsheets.c','jobsheets.pl')
			->leftJoin('release_orders', 'jobsheets.ro_id', '=', 'release_orders.id')
			->where('release_orders.order_id', 'LIKE',"%{$search}%")->where('status','2')->orderBy('jobsheets.id','DESC')->get();		
			}
			else{
			$assigned = DB::table('jobsheets')->where('status','2')->orderBy('id','DESC')->get();
			}

		$current = $request['date'];
		$new_date = date('Y-m-d', strtotime($current. ' + 1 months'));
		
		$datenew = date('Y', strtotime($new_date));
		$monthnew = date('m', strtotime($new_date));
		$month_name = date("M Y", strtotime($current. ' + 1 months'));
		$month_end = date("t", strtotime($new_date));
		
		$result="";
		$result .='<div class="assign-cal" id="notassign-cal"><div class="cal-month">
				<a href="javascript:void(0);" class="me-3"><i class="fa fa-angle-left" aria-hidden="true" id="'.$new_date.'" onClick="assigned_previous_date(this.id)"></i></a>
				<h5>'.$month_name. '</h5>
				<a href="javascript:void(0);" class="ms-3"><i class="fa fa-angle-right" aria-hidden="true" id="'.$new_date.'" onClick="assigned_next_date(this.id)"></i></a>
				</div>
				<div class="assign-cla-data row row-cols-5">';
				for($i=1;$i<=$month_end;$i++){
					
					$date = $datenew.'-'.$monthnew.'-'.$i;
					$timestamp = strtotime($date);
					$day = date('D', $timestamp);
					$currentdate =  date('Y-m-d');
					$current_date = strtotime($currentdate);
					if($current_date==$timestamp){
						$class="";
					}
					else{
						$class="";
					}
		$result .= '<div class="dates '.$class.'">
					<p>'.$day.'<br>'.$i.'</p><ul>';
					foreach($assigned as $assign){
					$date1  =  strstr($assign->created_at, ' ', true);
					$adate  =  strtotime($date1);
					$ro = DB::table('release_orders')->where('id',$assign->ro_id)->first();
					
					if($adate==$timestamp){
		$result .= '<li><div class="date-order">
					<table>
					<tr>
						<th>RO</th>
						<td>#'.$ro->order_id.'</td>
						<th>'.$assign->jobsheet_id.'</th>
					</tr>
					<tr>
					<th></th>
					</tr>
					</table>';
					if($assign->jobsheet_status=="1" || $assign->jobsheet_status=="5"){
					$select ="text-success";
					}
					elseif($assign->jobsheet_status=="2"){
					$select ="text-warning";
					}
					elseif($assign->jobsheet_status=="3"){
					$select ="text-danger";
					}
					else{
					$select ="text-info";
					}


					if($assign->jobsheet_status=="2"){
						$not_sel ="selected";
					}
					else{
						$not_sel ="";
					}
					if($assign->jobsheet_status=="1"){
						$in_sel ="selected";
					}
					else{
						$in_sel ="";
					}
					if($assign->jobsheet_status=="3"){
						$com_sel ="selected";
					}
					else{
						$com_sel ="";
					}
					if($assign->jobsheet_status=="4"){
						$po_sel ="selected";
					}
					else{
						$po_sel ="";
					}

					if($assign->jobsheet_status=="5"){
						$sel ="selected";
					}
					else{
						$sel ="";
					}
		$result .= '<select class="form-select '.$select.'" aria-label="Default select example" onchange="location = this.value;">
					<option value="/jobsheet_status/'.$assign->id.'/1" '.$in_sel.'>Completed</option>
					<option value="/jobsheet_status/'.$assign->id.'/5" '.$sel.'>Delivered</option>
					<option value="/jobsheet_status/'.$assign->id.'/2" '.$not_sel.' >Not Started</option>
					<option value="/jobsheet_status/'.$assign->id.'/3" '.$com_sel.'>Postponed</option>
					<option value="/jobsheet_status/'.$assign->id.'/4" '.$po_sel.'>Installing</option>
				</select>
					</div></li>';	
					}
					}
		$result .='</ul></div>';

		}

		$result.= '</div></div>
					<script>
					function assigned_next_date(date){
							$.ajax({
									url: "/assigned-next-date",
									type: "GET",
									data: { date : date },
									success:function(data){
									$("#notassign-cal").html(data);
									}
								});
					}
					function assigned_previous_date(date){

						$.ajax({
								url: "/assigned-previous-date",
								type: "GET",
								data: { date : date },
								success:function(data){
								$("#notassign-cal").html(data);
								}
							});
					}
					</script>
					';


		return Response($result);

	}

	public function previous_date(Request $request){
		if($request->input('search')){
			$search =$request->input('search');
			$assigned = DB::table('jobsheets')->select('jobsheets.id','jobsheets.created_at','jobsheets.jobsheet_id','jobsheets.ro_id','jobsheets.jobsheet_status','jobsheets.description','jobsheets.installation_date','jobsheets.installer','jobsheets.delivery_date','jobsheets.driver','jobsheets.c','jobsheets.pl')
			->leftJoin('release_orders', 'jobsheets.ro_id', '=', 'release_orders.id')
			->where('release_orders.order_id', 'LIKE',"%{$search}%")->where('status','2')->orderBy('jobsheets.id','DESC')->get();		
			}
			else{
			$assigned = DB::table('jobsheets')->where('status','2')->orderBy('id','DESC')->get();
			}

		$current = $request['date'];
		$new_date = date('Y-m-d', strtotime($current. ' - 1 months'));
		
		$datenew = date('Y', strtotime($new_date));
		$monthnew = date('m', strtotime($new_date));
		$month_name = date("M Y", strtotime($current. ' - 1 months'));
		$month_end = date("t", strtotime($new_date));
		
		$result="";
		$result .='<div class="assign-cal" id="assign-cal"><div class="cal-month">
				<a href="javascript:void(0);" class="me-3"><i class="fa fa-angle-left" aria-hidden="true" id="'.$new_date.'" onClick="assigned_previous_date(this.id)"></i></a>
				<h5>'.$month_name. '</h5>
				<a href="javascript:void(0);" class="ms-3"><i class="fa fa-angle-right" aria-hidden="true" id="'.$new_date.'" onClick="assigned_next_date(this.id)"></i></a>
				</div>
				<div class="assign-cla-data row row-cols-5">';
				for($i=1;$i<=$month_end;$i++){
					
					$date = $datenew.'-'.$monthnew.'-'.$i;
					$timestamp = strtotime($date);
					$day = date('D', $timestamp);
					$currentdate =  date('Y-m-d');
					$current_date = strtotime($currentdate);
					if($current_date==$timestamp){
						$class="";
					}
					else{
						$class="";
					}
		$result .= '<div class="dates '.$class.'">
					<p>'.$day.'<br>'.$i.'</p><ul>';
					foreach($assigned as $assign){
					$date1  =  strstr($assign->created_at, ' ', true);
					$adate  =  strtotime($date1);
					$ro = DB::table('release_orders')->where('id',$assign->ro_id)->first();
					
					if($adate==$timestamp){
		$result .= '<li><div class="date-order">
					<table>
					<tr>
						<th>RO</th>
						<td>#'.$ro->order_id.'</td>
						<th>'.$assign->jobsheet_id.'</th>
					</tr>
					<tr>
					<th></th>
					</tr>
					</table>';
					if($assign->jobsheet_status=="1" || $assign->jobsheet_status=="5"){
					$select ="text-success";
					}
					elseif($assign->jobsheet_status=="2"){
					$select ="text-warning";
					}
					elseif($assign->jobsheet_status=="3"){
					$select ="text-danger";
					}
					else{
					$select ="text-info";
					}


					if($assign->jobsheet_status=="2"){
						$not_sel ="selected";
					}
					else{
						$not_sel ="";
					}
					if($assign->jobsheet_status=="1"){
						$in_sel ="selected";
					}
					else{
						$in_sel ="";
					}
					if($assign->jobsheet_status=="3"){
						$com_sel ="selected";
					}
					else{
						$com_sel ="";
					}
					if($assign->jobsheet_status=="4"){
						$po_sel ="selected";
					}
					else{
						$po_sel ="";
					}

					if($assign->jobsheet_status=="5"){
						$sel ="selected";
					}
					else{
						$sel ="";
					}
		$result .= '<select class="form-select '.$select.'" aria-label="Default select example" onchange="location = this.value;">
					<option value="/jobsheet_status/'.$assign->id.'/1" '.$in_sel.'>Completed</option>
					<option value="/jobsheet_status/'.$assign->id.'/5" '.$sel.'>Delivered</option>
					<option value="/jobsheet_status/'.$assign->id.'/2" '.$not_sel.' >Not Started</option>
					<option value="/jobsheet_status/'.$assign->id.'/3" '.$com_sel.'>Postponed</option>
					<option value="/jobsheet_status/'.$assign->id.'/4" '.$po_sel.'>Installing</option>
				</select>
					</div></li>';	
					}
					}
		$result .='</ul></div>';

		}

		$result.= '</div></div>
					<script>
					function assigned_next_date(date){
							$.ajax({
									url: "/assigned-next-date",
									type: "GET",
									data: { date : date },
									success:function(data){
									$("#assign-cal").html(data);
									}
								});
					}
					function assigned_previous_date(date){

						$.ajax({
								url: "/assigned-previous-date",
								type: "GET",
								data: { date : date },
								success:function(data){
								$("#assign-cal").html(data);
								}
							});
					}
					</script>
					';


		return Response($result);

	}


	public function not_next_date(Request $request){
		if($request->input('search')){
			$search =$request->input('search');						
			$job_not_assigned = DB::table('jobsheets')->select('jobsheets.id','jobsheets.created_at','jobsheets.jobsheet_id','jobsheets.ro_id','jobsheets.jobsheet_status','jobsheets.description','jobsheets.installation_date','jobsheets.installer','jobsheets.delivery_date','jobsheets.driver','jobsheets.c','jobsheets.pl')
			->leftJoin('release_orders', 'jobsheets.ro_id', '=', 'release_orders.id')
			->where('release_orders.order_id', 'LIKE',"%{$search}%")->where('status','1')->orderBy('jobsheets.id','DESC')->get();
			}
			else{
			$job_not_assigned = DB::table('jobsheets')->where('status','1')->orderBy('id','DESC')->get();
			}

		$current = $request['date'];
		$new_date = date('Y-m-d', strtotime($current. ' + 1 months'));
		
		$datenew = date('Y', strtotime($new_date));
		$monthnew = date('m', strtotime($new_date));
		$month_name = date("M Y", strtotime($current. ' + 1 months'));
		$month_end = date("t", strtotime($new_date));
		
		$result="";
		$result .='<div class="assign-cal" id="notassign-cal"><div class="cal-month">
				<a href="javascript:void(0);" class="me-3"><i class="fa fa-angle-left" aria-hidden="true" id="'.$new_date.'" onClick="not_previous_date(this.id)"></i></a>
				<h5>'.$month_name. '</h5>
				<a href="javascript:void(0);" class="ms-3"><i class="fa fa-angle-right" aria-hidden="true" id="'.$new_date.'" onClick="not_next_date(this.id)"></i></a>
				</div>
				<div class="assign-cla-data row row-cols-5">';
				for($i=1;$i<=$month_end;$i++){
					
					$date = $datenew.'-'.$monthnew.'-'.$i;
					$timestamp = strtotime($date);
					$day = date('D', $timestamp);
					$currentdate =  date('Y-m-d');
					$current_date = strtotime($currentdate);
					if($current_date==$timestamp){
						$class="";
					}
					else{
						$class="";
					}
		$result .= '<div class="dates '.$class.'">
					<p>'.$day.'<br>'.$i.'</p><ul>';
					foreach($job_not_assigned as $notassign){
					$date1  =  strstr($notassign->created_at, ' ', true);
					$adate  =  strtotime($date1);
					$ro = DB::table('release_orders')->where('id',$notassign->ro_id)->first();
					
					if($adate==$timestamp){
		$result .= '<li><div class="date-order">
					<table>
					<tr>
						<th>RO</th>
						<td>#'.$ro->order_id.'</td>
						<th>'.$notassign->jobsheet_id.'</th>
					</tr>
					<tr>
					<th></th>
					</tr>
					</table>
					<p><a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#not-assign-select">'.$notassign->description.'</a></p>
					<div class="form-group">
                        <label>Assign Delivery</label>
                         <input type="text" id="delivery'.$notassign->id .'" class="delivery-class delivery" placeholder="Assign Delivery" data-id="'.$notassign->id.'" value="'.$notassign->delivery_date.'" onclick="DeliveryAssign('. $notassign->id .');">						
                    </div>
                    <div class="form-group">
                        <label>Assign Installation</label>
                        <input type="text" id="installation'.$not_assigned->id .'" class="delivery-class installation" placeholder="Assign Installation" data-id="'.$notassign->id.'" value="'.$notassign->installation_date.'" onclick="NotAssign('. $notassign->id .');">
                    </div>';
					
					


				
		$result .= '</div></li>';	
					}
					}
		$result .='</ul></div>';

		}

		$result.= '</div></div>
					<script>
					function not_next_date(date){
							$.ajax({
									url: "/not-next-date",
									type: "GET",
									data: { date : date },
									success:function(data){
									$("#notassign-cal").html(data);
									}
								});
					}
					function not_previous_date(date){

						$.ajax({
								url: "/not-previous-date",
								type: "GET",
								data: { date : date },
								success:function(data){
								$("#notassign-cal").html(data);
								}
							});
					}

					$( ".delivery" ).datepicker({ dateFormat: "yy-mm-dd" });
					function DeliveryAssign(id){
					$("#delivery"+id).on("change",function(){
					var val = $(this).val();
					var id = $(this).attr("data-id");
					$.ajax({
							url: "/assign-delivery",
							type: "POST",
							data: { val : val, id :id },
							success:function(data){
							Swal.fire("Delivery Date assigned successfully.");
							setTimeout(function(){
							location.reload();
							},1000);  
							}
						});
					});
				}
					
				$(".installation" ).datepicker({ dateFormat: "yy-mm-dd" });
					function NotAssign(id){
					$("#installation"+id).on("change",function(){
					var val = $(this).val();
					var id = $(this).attr("data-id");
					$.ajax({
							url: "/assign-installation",
							type: "POST",
							data: { val : val, id :id },
							success:function(data){
							Swal.fire("Installation Date assigned successfully.");
							setTimeout(function(){
							location.reload();
							},1000);  
							}
						});
					});
					}
					</script>';


		return Response($result);

	}


	public function not_previous_date(Request $request){
		if($request->input('search')){
			$search =$request->input('search');						
			$job_not_assigned = DB::table('jobsheets')->select('jobsheets.id','jobsheets.created_at','jobsheets.jobsheet_id','jobsheets.ro_id','jobsheets.jobsheet_status','jobsheets.description','jobsheets.installation_date','jobsheets.installer','jobsheets.delivery_date','jobsheets.driver','jobsheets.c','jobsheets.pl')
			->leftJoin('release_orders', 'jobsheets.ro_id', '=', 'release_orders.id')
			->where('release_orders.order_id', 'LIKE',"%{$search}%")->where('status','1')->orderBy('jobsheets.id','DESC')->get();
			}
			else{
			$job_not_assigned = DB::table('jobsheets')->where('status','1')->orderBy('id','DESC')->get();
			}

		$current = $request['date'];
		$new_date = date('Y-m-d', strtotime($current. ' - 1 months'));
		
		$datenew = date('Y', strtotime($new_date));
		$monthnew = date('m', strtotime($new_date));
		$month_name = date("M Y", strtotime($current. ' - 1 months'));
		$month_end = date("t", strtotime($new_date));
		
		$result="";
		$result .='<div class="assign-cal" id="notassign-cal"><div class="cal-month">
				<a href="javascript:void(0);" class="me-3"><i class="fa fa-angle-left" aria-hidden="true" id="'.$new_date.'" onClick="not_previous_date(this.id)"></i></a>
				<h5>'.$month_name. '</h5>
				<a href="javascript:void(0);" class="ms-3"><i class="fa fa-angle-right" aria-hidden="true" id="'.$new_date.'" onClick="not_next_date(this.id)"></i></a>
				</div>
				<div class="assign-cla-data row row-cols-5">';
				for($i=1;$i<=$month_end;$i++){
					
					$date = $datenew.'-'.$monthnew.'-'.$i;
					$timestamp = strtotime($date);
					$day = date('D', $timestamp);
					$currentdate =  date('Y-m-d');
					$current_date = strtotime($currentdate);
					if($current_date==$timestamp){
						$class="";
					}
					else{
						$class="";
					}
		$result .= '<div class="dates '.$class.'">
					<p>'.$day.'<br>'.$i.'</p><ul>';
					foreach($job_not_assigned as $notassign){
					$date1  =  strstr($notassign->created_at, ' ', true);
					$adate  =  strtotime($date1);
					$ro = DB::table('release_orders')->where('id',$notassign->ro_id)->first();
					
					if($adate==$timestamp){
		$result .= '<li><div class="date-order">
					<table>
					<tr>
						<th>RO</th>
						<td>#'.$ro->order_id.'</td>
						<th>'.$notassign->jobsheet_id.'</th>
					</tr>
					<tr>
					<th></th>
					</tr>
					</table>
					<p><a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#not-assign-select">'.$notassign->description.'</a></p>
					<div class="form-group">
                        <label>Assign Delivery</label>
                         <input type="text" id="delivery'.$notassign->id .'" class="delivery-class delivery" placeholder="Assign Delivery" data-id="'.$notassign->id.'" value="'.$notassign->delivery_date.'" onclick="DeliveryAssign('. $notassign->id .');">						
                    </div>
                    <div class="form-group">
                        <label>Assign Installation</label>
                        <input type="text" id="installation'.$notassign->id .'" class="delivery-class installation" placeholder="Assign Installation" data-id="'.$notassign->id.'" value="'.$notassign->installation_date.'" onclick="NotAssign('. $notassign->id .');">
                    </div>';
					
					


				
		$result .= '</div></li>';	
					}
				}
		$result .='</ul></div>';

		}

		$result.= '</div></div>
					<script>
					function not_next_date(date){
							$.ajax({
									url: "/not-next-date",
									type: "GET",
									data: { date : date },
									success:function(data){
									$("#notassign-cal").html(data);
									}
								});
					}
					function not_previous_date(date){

						$.ajax({
								url: "/not-previous-date",
								type: "GET",
								data: { date : date },
								success:function(data){
								$("#notassign-cal").html(data);
								}
							});
					}

					$( ".delivery" ).datepicker({ dateFormat: "yy-mm-dd" });
					function DeliveryAssign(id){
					$("#delivery"+id).on("change",function(){
					var val = $(this).val();
					var id = $(this).attr("data-id");
					$.ajax({
							url: "/assign-delivery",
							type: "POST",
							data: { val : val, id :id },
							success:function(data){
							Swal.fire("Delivery Date assigned successfully.");
							setTimeout(function(){
							location.reload();
							},1000);  
							}
						});
					});
				}
					
				$(".installation" ).datepicker({ dateFormat: "yy-mm-dd" });
					function NotAssign(id){
					$("#installation"+id).on("change",function(){
					var val = $(this).val();
					var id = $(this).attr("data-id");
					$.ajax({
							url: "/assign-installation",
							type: "POST",
							data: { val : val, id :id },
							success:function(data){
							Swal.fire("Installation Date assigned successfully.");
							setTimeout(function(){
							location.reload();
							},1000);  
							}
						});
					});
					}
					</script>';


		return Response($result);

	}

	
}
