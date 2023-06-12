<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warehouse;
use DB;
use Illuminate\Support\Facades\Storage;
use PDF; 


class DeliveryController extends Controller
{
	public function index(Request $request){
		if(auth()->user()->role_id=="10"){
		if($request->input('search')){
		$search = $request->input('search');
		$delivery = DB::table('jobsheets')->
		leftJoin('release_orders','jobsheets.ro_id','=','release_orders.id')->where('jobsheets.driver',auth()->user->id)->where('release_orders.order_id', 'LIKE',"%{$search}%")->orderBy('jobsheets.id','DESC')->paginate(10);
		$delivery->appends(['search' => $search]);
		}
		else{
		$delivery = DB::table('jobsheets')->where('driver',auth()->user->id)->orderBy('id','DESC')->paginate(10);
		}
		}
		else{
		if($request->input('search')){
		$search = $request->input('search');
		$delivery = DB::table('jobsheets')->
		leftJoin('release_orders','jobsheets.ro_id','=','release_orders.id')->where('jobsheets.driver','!=','NULL')->where('release_orders.order_id', 'LIKE',"%{$search}%")->orderBy('jobsheets.id','DESC')->paginate(10);
		$delivery->appends(['search' => $search]);
		}
		else{
		$delivery = DB::table('jobsheets')->where('driver','!=','NULL')->orderBy('id','DESC')->paginate(10);
		}
		}
		return view('backend.delivery-order-table',compact('delivery'));
	}
	
	public function deleteall(Request $request){
		if($request->id){
		DB::table("jobsheets")->whereIn('id',$request->id)->delete();
		return redirect()->back()->with('success', 'Records are deleted successfully.'); 
		}
		else{
		return redirect()->back()->with('error', 'Please select atleast one record.'); 
		}
	}
	
	public function delete($id){
	   $orders = DB::table('jobsheets')->where('id',$id)->delete();
	   return redirect()->back()->with('success', 'Order deleted successfully.');	
	}
	
	public function delivery_status($id, $status){
		$update = DB::table("jobsheets")->where('id',$id)->update([
		 'delivery_status'		=>$status,
		]);
		return redirect()->back()->with('success', 'Status updated successfully.'); 
	}
	
	public function order_calendar(Request $request){
		if($request->input('search')){
		$search = $request->input('search');
		$delivery = DB::table('jobsheets')->select('jobsheets.id','jobsheets.jobsheet_id','jobsheets.delivery_status','jobsheets.created_at','jobsheets.ro_id','jobsheets.jobsheet_status','jobsheets.description','jobsheets.installation_date','jobsheets.installer','jobsheets.delivery_date','jobsheets.driver','jobsheets.c','jobsheets.pl')->leftJoin('release_orders', 'jobsheets.ro_id', '=', 'release_orders.id')->where('jobsheets.driver','!=','NULL')->where('release_orders.order_id', 'LIKE',"%{$search}%")->orderBy('jobsheets.id','DESC')->get();	
		}
		else{
		$delivery = DB::table('jobsheets')->where('driver','!=','NULL')->orderBy('id','DESC')->get();
		}
		return view("backend.delivery-order-calendar",compact("delivery"));
	}
	
	public function details(Request $request){
		$delivery = DB::table('jobsheets')->where('id',$request['id'])->first();
		$ro = DB::table('release_orders')->select('order_id','owner','site_address')->where('id',$delivery->ro_id)->first();
		$installer = DB::table('users')->select('name')->where('id',$delivery->installer)->first();
		if($delivery->installation_status=="1"){
		$selected1 ="selected";
		}
		else{
		$selected1 ="";
		}
		if($delivery->installation_status=="2"){
		$selected2 ="selected";
		}
		else{
		$selected2 ="";
		}
		if($delivery->installation_status=="3"){
		$selected3 ="selected";
		}
		else{
		$selected3 ="";
		}
		if($delivery->installation_status=="4"){
		$selected4 ="selected";
		}
		else{
		$selected4 ="";
		}
		
		$result="";
		$result.='<div class="row row-cols-3">
							<input type="hidden" name="jobid" value="'.$delivery->id.'">
							<input type="hidden" name="installer" value="'.$delivery->installer.'">
							<input type="hidden" name="jobsheet_id" value="'.$delivery->jobsheet_id.'">
                            <div class="col-md-2">
                                <p><b>RO: </b> '.$ro->order_id.'</p>
                            </div>
                            <div class="col-md-2">
                                <p><b>ID: </b> '.$ro->owner.'</p>
                            </div>
                            <div class="col-md-8">
                                <p><b>Postal/ Address: </b> '.$ro->site_address.'</p>
                            </div>
                        </div>
						
						
                        <div class="row row-cols-3 mt-5 mb-3">
                            <div class="col">
                                <p><b>Installation Date:</b></p>
                            </div>
                            <div class="col">
                                <p>'.$delivery->installation_date.'</p>
                            </div>
                        </div>
                        <div class="row row-cols-3 mb-5">
                            <div class="col">
                                <p><b>Installer</b></p>
                            </div>
                            <div class="col">
                                <p>'.$installer->name.'</p>
                            </div>
                        </div>
                        <div class="desc">
                            <strong>Description:</strong>
                            <p class="my-3">'.$delivery->description.'</p>
                        </div>
                        <div class="form-group my-5">
                            <label>Select Update</label>
                            <select class="form-select text-info" aria-label="Default select example" onchange="location = this.value;">
                                <option value="/installer_status/'.$delivery->id.'/1"'.$selected1.'>Installing</option>
                                <option value="/installer_status/'.$delivery->id.'/2"'.$selected2.'>Not Started</option>
                                <option value="/installer_status/'.$delivery->id.'/3"'.$selected3.'>Completed</option>
                                <option value="/installer_status/'.$delivery->id.'/4"'.$selected4.'>Postponed</option>
                            </select>
                        </div>
                        <div class="form-group pic-upload mb-4">
                            <label class="">Upload Photo</label>
                            <div class="upload">
                                <input type="file" class="form-control" placeholder="">
                                <div class="upload-txt">
                                    <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                    <p>Click here or drag and drop files to upload</p>
                                    <input type="file" name="image" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="" rows="8" name="description"></textarea>
                        </div>
                        <div class="d-flex btn-grid">
                        <button type="submit" class="btn" id="">Dispute</button>
                    </div>
                    ';
		return Response($result);
	}
	
	public function deliverydetails(Request $request){
		$delivery = DB::table('jobsheets')->where('id',$request['id'])->first();
		$ro = DB::table('release_orders')->select('order_id','owner','site_address')->where('id',$delivery->ro_id)->first();
		$send_images = DB::table('dispute_images')->select('image')->where('job_id',$request['id'])->where('image_type','2')->get();
		$pickup_images = DB::table('dispute_images')->select('image')->Where('image_type','3')->get();
		$driver = DB::table('users')->select('name')->where('id',$delivery->driver)->first();
		if($delivery->delivery_status=="1"){
		$selected1 ="selected";
		}
		else{
		$selected1 ="";
		}
		if($delivery->delivery_status=="2"){
		$selected2 ="selected";
		}
		else{
		$selected2 ="";
		}
		if($delivery->delivery_status=="3"){
		$selected3 ="selected";
		}
		else{
		$selected3 ="";
		}
		if($delivery->delivery_status=="4"){
		$selected4 ="selected";
		}
		else{
		$selected4 ="";
		}
		
		$result="";
		$result.='<div class="row row-cols-3">
							<input type="hidden" name="jobid" value="'.$delivery->id.'">
							<input type="hidden" name="installer" value="'.$delivery->driver.'">
							<input type="hidden" name="jobsheet_id" value="'.$delivery->jobsheet_id.'">
                            <div class="col-md-2">
                                <p><b>RO: </b> '.$ro->order_id.'</p>
                            </div>
                            <div class="col-md-2">
                                <p><b>ID: </b> '.$ro->owner.'</p>
                            </div>
                            <div class="col-md-8">
                                <p><b>Postal/ Address: </b> '.$ro->site_address.'</p>
                            </div>
                        </div>
						
						
                        <div class="row row-cols-3 mt-5 mb-3">
                            <div class="col">
                                <p><b>Installation Date:</b></p>
                            </div>
                            <div class="col">
                                <p>'.$delivery->delivery_date.'</p>
                            </div>
                        </div>
                        <div class="row row-cols-3 mb-5">
                            <div class="col">
                                <p><b>Driver</b></p>
                            </div>
                            <div class="col">
                                <p>'.$driver->name.'</p>
                            </div>
                        </div>
                        <div class="desc">
                            <strong>Description:</strong>
                            <p class="my-3">'.$delivery->description.'</p>
                        </div>
                        <div class="form-group my-5">
                            <label>Select Update</label>
                            <select class="form-select text-info" aria-label="Default select example" onchange="location = this.value;">
                                <option value="/del_status/'.$delivery->id.'/1"'.$selected1.'>Delivered</option>
                                <option value="/del_status/'.$delivery->id.'/2"'.$selected2.'>Pending</option>
                                <option value="/del_status/'.$delivery->id.'/3"'.$selected3.'>Missed</option>
                                <option value="/del_status/'.$delivery->id.'/4"'.$selected4.'>Pickup</option>
                            </select>
                        </div>';
						if(count($send_images)>0 ){
							$result.='<div class="form-group pic-upload mb-4" style="width: 141px;"> <label class="">Image (Send)</label>';
							foreach($send_images as $send){
							$result.='<div class="upload"><img src="'.asset("uploads/".$send->image).'"></div>';
							}
							$result.='</div>';
						}
						else{
						$result.='<div class="form-group pic-upload mb-4">
                            <label class="">Upload Photo (Send)</label>
                            <div class="upload">
                                <input type="file" name="send[]" class="form-control" placeholder="" onchange="readURL(this);" multiple>
                                <div class="upload-txt">
                                    <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                    <p>Click here or drag and drop files to upload</p>
									<img id="blah" src="#" alt="your image" />
                                </div>
                                </div>
                            </div>';
						}
						if(count($pickup_images)>0){
							$result.='<div class="form-group pic-upload mb-4" style="width: 141px;"> <label class="">Image (Pick up)</label>';
							foreach($pickup_images as $pickup){
							$result.='<div class="upload"><img src="'.asset("uploads/".$pickup->image).'"></div>';
							}
							$result.='</div>';
						}

						else{
							$result.='<div class="form-group pic-upload mb-4"><label class="">Upload Photo (Pick up)</label>
                            <div class="upload">
                                <input type="file" name="pickup[]"class="form-control" placeholder="" onchange="readURL1(this);" multiple>
                                <div class="upload-txt">
                                    <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                    <p>Click here or drag and drop files to upload</p>
									<img id="blah1" src="#" alt="your image" />
                                </div>
                            </div>
							</div>';
							$result.='<div class="form-group pic-upload mb-4" style="width: 141px;">
							<div class="upload"><img src="'.asset("uploads/".$delivery->pickup_img).'"></div>
							</div>';
						}
							
                        
						
                    $result.='
                        <div class="d-flex btn-grid">
                        <input type="submit" class="btn" value="Save">
                    </div>
					<script>$( document ).ready(function() {
					$("#blah").hide();
					$("#blah1").hide();
					});	
					function readURL(input) {
					if (input.files && input.files[0]) {
					var reader = new FileReader();
					reader.onload = function (e) {
					$("#blah").show();	
					$("#blah")
					.attr("src", e.target.result)
					.width(150)
					.height(200);
					};

					reader.readAsDataURL(input.files[0]);
					}
					}
					function readURL1(input) {
					if (input.files && input.files[0]) {
					var reader = new FileReader();
					reader.onload = function (e) {
					$("#blah1").show();	
					$("#blah1")
					.attr("src", e.target.result)
					.width(150)
					.height(200);
					};

					reader.readAsDataURL(input.files[0]);
					}
					}
					</script>
                    ';
		return Response($result);
	}
	
	public function installer_status($id, $status){
		$update = DB::table("jobsheets")->where('id',$id)->update([
		 'installation_status'=>$status,
		]);		
		return redirect()->back()->with('success', 'Installer Status updated successfully.'); 
	}
	public function del_status($id, $status){
		$update = DB::table("jobsheets")->where('id',$id)->update([
		 'delivery_status'=>$status,
		]);		
		return redirect()->back()->with('success', 'Status updated successfully.'); 
	}
	
	public function create_dispute(Request $request){
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
		$get = DB::table("disputes")->where('job_id',$request['jobid'])->first();
		if($get){
		$update_dispute = DB::table("disputes")->where('id',$get->id)->update(['description'=>$request['description'],]);
		return redirect()->back()->with('success', 'Dispute updated successfully.');
		}
		else{
		$create_dispute = DB::table("disputes")->
		 insert([
		 'job_id'			=>$request['jobid'],
		 'installer_id'		=>$request['installer'],
		 'images'			=>$filename,
		 'description'		=>$request['description'],
		 'created_at'		=>date('Y-m-d'),
		 ]);
		 
		if($create_dispute==true){
		$update = DB::table("jobsheets")->where('id',$request['jobid'])->update(['dispute_status'=>'1']);
		$insert = DB::table("reminders")->
		 insert([
		 'job_id'			=>$request['jobid'],
		 'order_id'			=>$request['jobsheet_id'],
		 'reminder'			=>'You have a new dispute request by order id '.$request['jobsheet_id'],
		 ]);
		
		 if($insert){
			return redirect()->back()->with('success', 'Dispute created successfully.'); 	 
			}
		else{
			return redirect()->back()->with('error', 'Something went wrong.'); 
			}
		}
	}
		return redirect()->back()->with('error', 'Something went wrong.'); 
	}
	
	public function approve_dispute($id, $status){
		$update = DB::table("jobsheets")->where('id',$id)->update([
		 'dispute_status'=>$status,
		]);		
		return redirect("/job-sheet-details/".$id)->with('success', 'Status approved successfully. Now you are able to create invoice.'); 
	}
	
	public function pdf($id, Request $request){
		if($request->has('download')){  
		 $jobsheets = DB::table('jobsheets')->where('id',$id)->first();
		 $ro = DB::table('release_orders')->where('id',$jobsheets->ro_id)->first();
		 $drivers = DB::table('users')->select('id','name')->where('id',$jobsheets->driver)->orderBy('name','ASC')->first();
		 $getproducts['products'] = explode(",",$ro->product);
		 $getquantity['quantity'] = explode(",",$ro->product_qty);
		 $getskirting['skirting'] = explode(",",$ro->skirting);
		 $getskirtingqty['skirtingqty'] = explode(",",$ro->skirtingqty);
		 $arr = array_merge($getproducts,$getquantity,$getskirting,$getskirtingqty);
         $pdf = PDF::loadView('backend.delivery-pdf',compact('jobsheets','ro','drivers','arr'));  
         return $pdf->download('delivery_order.pdf');  
        } 	
	}
	
	public function print_order($id){

			$jobsheets = DB::table('jobsheets')->where('id',$id)->first();
			$ro = DB::table('release_orders')->where('id',$jobsheets->ro_id)->first();
			$drivers = DB::table('users')->select('id','name')->where('id',$jobsheets->driver)->orderBy('name','ASC')->first();
			$getproducts['products'] = explode(",",$ro->product);
			$getquantity['quantity'] = explode(",",$ro->product_qty);
			$getskirting['skirting'] = explode(",",$ro->skirting);
			$getskirtingqty['skirtingqty'] = explode(",",$ro->skirtingqty);
			$arr = array_merge($getproducts,$getquantity,$getskirting,$getskirtingqty);
			return view("backend.delivery-pdf",compact('jobsheets','ro','drivers','arr'));

	}
	
	public function delivery_update(Request $request){
		if($request->file('send') || $request->file('pickup')){
			foreach ($request->file('send') as $del_send) {
				$file = $del_send;
				$send_img = time().'_'.$file->getClientOriginalName();
				$extension = $file->getClientOriginalExtension();
				$location = 'uploads';
				$file->move($location,$send_img);
				DB::table('dispute_images')->insert([
				'image'			=>$send_img,
				'job_id'		=>$request['jobid'],
				'image_type'	=>'2',
				]);
			 }

			foreach ($request->file('pickup') as $del_pickup) {
				$file = $del_pickup;
				$pickup_img = time().'_'.$file->getClientOriginalName();
				$extension = $file->getClientOriginalExtension();
				$location = 'uploads';
				$file->move($location,$pickup_img);
				DB::table('dispute_images')->insert([
				'image'			=>$pickup_img,
				'job_id'		=>$request['jobid'],
				'image_type'	=>'3',
				]);
			 }
			 return redirect()->back()->with('success', 'Image updated successfully!'); 
        }
		else{
			return redirect()->back()->with('error', 'Please upload an image!'); 
		}
		

	}

	public function next_date(Request $request){
		if(auth()->user()->role_id=="10"){
			if($request->input('search')){
			$search = $request->input('search');
			$delivery = DB::table('jobsheets')->
			leftJoin('release_orders','jobsheets.ro_id','=','release_orders.id')->where('jobsheets.driver',auth()->user->id)->where('release_orders.order_id', 'LIKE',"%{$search}%")->orderBy('jobsheets.id','DESC')->paginate(10);
			$delivery->appends(['search' => $search]);
			}
			else{
			$delivery = DB::table('jobsheets')->where('driver',auth()->user->id)->orderBy('id','DESC')->paginate(10);
			}
			}
			else{
			if($request->input('search')){
			$search = $request->input('search');
			$delivery = DB::table('jobsheets')->
			leftJoin('release_orders','jobsheets.ro_id','=','release_orders.id')->where('jobsheets.driver','!=','NULL')->where('release_orders.order_id', 'LIKE',"%{$search}%")->orderBy('jobsheets.id','DESC')->paginate(10);
			$delivery->appends(['search' => $search]);
			}
			else{
			$delivery = DB::table('jobsheets')->where('driver','!=','NULL')->orderBy('id','DESC')->paginate(10);
			}
		}
		$current = $request['date'];
		$new_date = date('Y-m-d', strtotime($current. ' + 1 months'));
		
		$datenew = date('Y', strtotime($new_date));
		$monthnew = date('m', strtotime($new_date));
		$month_name = date("M Y", strtotime($current. ' + 1 months'));
		$month_end = date("t", strtotime($new_date));
		
		$result="";
		$result .='<div class="new-calander"><div class="cal-month">
				<a href="javascript:void(0);" class="me-3"><i class="fa fa-angle-left" aria-hidden="true" id="'.$new_date.'" onClick="previous_date(this.id)"></i></a>
				<h5>'.$month_name. '</h5>
				<a href="javascript:void(0);" class="ms-3"><i class="fa fa-angle-right" aria-hidden="true" id="'.$new_date.'" onClick="new_date(this.id)"></i></a>
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
					foreach($delivery as $del){
					$adate  =  strtotime($del->delivery_date);
					$ro = DB::table('release_orders')->where('id',$del->ro_id)->first();
					
					if($adate==$timestamp){
					$driver = DB::table('users')->select('name')->where('id',$del->driver)->first();
		$result .= '<li><div class="date-order">
					<table>
					<tr>
						<th>RO</th>
						<td>#'.$ro->order_id.'</td>
						<th>'.$del->jobsheet_id.'</th>
					</tr>
					<tr>
					<th></th>
					<td>
					<a href="#job-detail" class="details" data-id="'.$del->id.'" role="button" aria-controls="offcanvasExample" data-bs-toggle="offcanvas">'.$driver->name.'</a>
					</td>
					<th></th>
					<th></th>
					</tr>
					</table>';
					if($del->delivery_status=="3"){
					$select ="text-danger";
					}
					elseif($del->delivery_status=="2"){
					$select ="text-warning";
					}
					elseif($del->delivery_status=="4"){
					$select ="text-info";
					}
					else{
					$select ="text-success";
					}


					if($del->delivery_status=="2"){
						$not_sel ="selected";
					}
					else{
						$not_sel ="";
					}
					if($del->delivery_status=="1"){
						$in_sel ="selected";
					}
					else{
						$in_sel ="";
					}
					if($del->delivery_status=="3"){
						$com_sel ="selected";
					}
					else{
						$com_sel ="";
					}
					if($del->delivery_status=="4"){
						$po_sel ="selected";
					}
					else{
						$po_sel ="";
					}
		$result .= '<select class="form-select '.$select.'" aria-label="Default select example" onchange="location = this.value;">
					<option value="/delivery_status/'.$del->id.'/2" '.$not_sel.' >Pending</option>
					<option value="/delivery_status/'.$del->id.'/1" '.$in_sel.'>Delivered</option>
					<option value="/delivery_status/'.$del->id.'/3" '.$com_sel.'>Missed</option>
					<option value="/delivery_status/'.$del->id.'/4" '.$po_sel.'>Picked Up</option>
				</select>
					</div></li>';	
					}
					}
		$result .='</ul></div>';

		}

		$result.= '</div></div>
					<script>
					function new_date(date){

							$.ajax({
									url: "/del-next-date",
									type: "GET",
									data: { date : date },
									success:function(data){
									$(".new-calander").html(data);
									}
								});
					}
					function previous_date(date){

						$.ajax({
								url: "/del-previous-date",
								type: "GET",
								data: { date : date },
								success:function(data){
								$(".new-calander").html(data);
								}
							});
					}
					$(".details").click(function(){
						var id= $(this).attr("data-id");
						 $.ajax({
								  url: "/delivery-details",
								  type: "GET",
								  data: { id : id },
								 success:function(data){
								 $("#getdetails").html(data);
								}
					});
					</script>
					';


		return Response($result);

	}
	

	public function previous_date(Request $request){
		if(auth()->user()->role_id=="10"){
			if($request->input('search')){
			$search = $request->input('search');
			$delivery = DB::table('jobsheets')->
			leftJoin('release_orders','jobsheets.ro_id','=','release_orders.id')->where('jobsheets.driver',auth()->user->id)->where('release_orders.order_id', 'LIKE',"%{$search}%")->orderBy('jobsheets.id','DESC')->paginate(10);
			$delivery->appends(['search' => $search]);
			}
			else{
			$delivery = DB::table('jobsheets')->where('driver',auth()->user->id)->orderBy('id','DESC')->paginate(10);
			}
			}
			else{
			if($request->input('search')){
			$search = $request->input('search');
			$delivery = DB::table('jobsheets')->
			leftJoin('release_orders','jobsheets.ro_id','=','release_orders.id')->where('jobsheets.driver','!=','NULL')->where('release_orders.order_id', 'LIKE',"%{$search}%")->orderBy('jobsheets.id','DESC')->paginate(10);
			$delivery->appends(['search' => $search]);
			}
			else{
			$delivery = DB::table('jobsheets')->where('driver','!=','NULL')->orderBy('id','DESC')->paginate(10);
			}
		}
		$current = $request['date'];
		$new_date = date('Y-m-d', strtotime($current. ' - 1 months'));
		
		$datenew = date('Y', strtotime($new_date));
		$monthnew = date('m', strtotime($new_date));
		$month_name = date("M Y", strtotime($current. ' - 1 months'));
		$month_end = date("t", strtotime($new_date));
		
		$result="";
		$result .='<div class="new-calander"><div class="cal-month">
				<a href="javascript:void(0);" class="me-3"><i class="fa fa-angle-left" aria-hidden="true" id="'.$new_date.'" onClick="previous_date(this.id)"></i></a>
				<h5>'.$month_name. '</h5>
				<a href="javascript:void(0);" class="ms-3"><i class="fa fa-angle-right" aria-hidden="true" id="'.$new_date.'" onClick="new_date(this.id)"></i></a>
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
					foreach($delivery as $del){
					$adate  =  strtotime($del->delivery_date);
					$ro = DB::table('release_orders')->where('id',$del->ro_id)->first();
					
					if($adate==$timestamp){
					$driver = DB::table('users')->select('name')->where('id',$del->driver)->first();
		$result .= '<li><div class="date-order">
					<table>
					<tr>
						<th>RO</th>
						<td>#'.$ro->order_id.'</td>
						<th>'.$del->jobsheet_id.'</th>
					</tr>
					<tr>
					<th></th>
					<td>
					<a href="#job-detail" class="details" data-id="'.$del->id.'" role="button" aria-controls="offcanvasExample" data-bs-toggle="offcanvas">'.$driver->name.'</a>
					</td>
					<th></th>
					<th></th>
					</tr>
					</table>';
					if($del->delivery_status=="3"){
					$select ="text-danger";
					}
					elseif($del->delivery_status=="2"){
					$select ="text-warning";
					}
					elseif($del->delivery_status=="4"){
					$select ="text-info";
					}
					else{
					$select ="text-success";
					}


					if($del->delivery_status=="2"){
						$not_sel ="selected";
					}
					else{
						$not_sel ="";
					}
					if($del->delivery_status=="1"){
						$in_sel ="selected";
					}
					else{
						$in_sel ="";
					}
					if($del->delivery_status=="3"){
						$com_sel ="selected";
					}
					else{
						$com_sel ="";
					}
					if($del->delivery_status=="4"){
						$po_sel ="selected";
					}
					else{
						$po_sel ="";
					}
		$result .= '<select class="form-select '.$select.'" aria-label="Default select example" onchange="location = this.value;">
					<option value="/delivery_status/'.$del->id.'/2" '.$not_sel.' >Pending</option>
					<option value="/delivery_status/'.$del->id.'/1" '.$in_sel.'>Delivered</option>
					<option value="/delivery_status/'.$del->id.'/3" '.$com_sel.'>Missed</option>
					<option value="/delivery_status/'.$del->id.'/4" '.$po_sel.'>Picked Up</option>
				</select>
					</div></li>';	
					}
					}
		$result .='</ul></div>';

		}

		$result.= '</div></div>
					<script>
					function new_date(date){

							$.ajax({
									url: "/del-next-date",
									type: "GET",
									data: { date : date },
									success:function(data){
									$(".new-calander").html(data);
									}
								});
					}
					function previous_date(date){

						$.ajax({
								url: "/del-previous-date",
								type: "GET",
								data: { date : date },
								success:function(data){
								$(".new-calander").html(data);
								}
							});
				}
					$(".details").click(function(){
						var id= $(this).attr("data-id");
						 $.ajax({
								  url: "/delivery-details",
								  type: "GET",
								  data: { id : id },
								 success:function(data){
								 $("#getdetails").html(data);
								}
					});
						
					});
					</script>
					';


		return Response($result);

	}
}
