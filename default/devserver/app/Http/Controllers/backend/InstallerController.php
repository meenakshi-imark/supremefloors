<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warehouse;
use DB;
use Illuminate\Support\Facades\Storage;
use PDF; 


class InstallerController extends Controller
{
	public function index(Request $request){
		
		/*Installer*/
		if(auth()->user()->role_id=="11"){
		if($request->input('search')){
		$search = $request->input('search');
		$installer = DB::table('jobsheets')->
		leftJoin('release_orders','jobsheets.ro_id','=','release_orders.id')->where('jobsheets.installer','!=','NULL')->where('release_orders.order_id', 'LIKE',"%{$search}%")->where('jobsheets.installer',auth()->user()->id)->orderBy('jobsheets.id','DESC')->paginate(10);
		$installer->appends(['search' => $search]);
		}
		else{
		$installer = DB::table('jobsheets')->where('installer',auth()->user()->id)->orderBy('id','DESC')->paginate(10);
		}	
		}
		/*Admin*/
		else{
		if($request->input('search')){
		$search = $request->input('search');
		$installer = DB::table('jobsheets')->
		leftJoin('release_orders','jobsheets.ro_id','=','release_orders.id')->where('jobsheets.installer','!=','NULL')->where('release_orders.order_id', 'LIKE',"%{$search}%")->orderBy('jobsheets.id','DESC')->paginate(10);
		$installer->appends(['search' => $search]);
		}
		else{
		$installer = DB::table('jobsheets')->where('installer','!=','NULL')->orderBy('id','DESC')->paginate(10);
		}
		}
		
		return view('backend.installer-order-table',compact('installer'));
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
	
	public function installation_status($id, $status){
		$update = DB::table("jobsheets")->where('id',$id)->update([
		 'installation_status'		=>$status,
		]);
		return redirect()->back()->with('success', 'Status updated successfully.'); 
	}
	
	public function order_calendar(Request $request){
		if(auth()->user()->role_id=="11"){
		if($request->input('search')){
		$search = $request->input('search');
		$installer = DB::table('jobsheets')->select('jobsheets.id','jobsheets.jobsheet_id','jobsheets.delivery_status','jobsheets.created_at','jobsheets.ro_id','jobsheets.jobsheet_status','jobsheets.description','jobsheets.installation_date','jobsheets.installer','jobsheets.delivery_date','jobsheets.installer','jobsheets.c','jobsheets.pl')->leftJoin('release_orders', 'jobsheets.ro_id', '=', 'release_orders.id')->where('jobsheets.installer',auth()->user()->id)->where('release_orders.order_id', 'LIKE',"%{$search}%")->orderBy('jobsheets.id','DESC')->get();	
		}
		else{
		$installer = DB::table('jobsheets')->where('installer',auth()->user()->id)->orderBy('id','DESC')->get();
		}	
		}
		else{
		if($request->input('search')){
		$search = $request->input('search');
		$installer = DB::table('jobsheets')->select('jobsheets.id','jobsheets.jobsheet_id','jobsheets.delivery_status','jobsheets.created_at','jobsheets.ro_id','jobsheets.jobsheet_status','jobsheets.description','jobsheets.installation_date','jobsheets.installer','jobsheets.delivery_date','jobsheets.installer','jobsheets.c','jobsheets.pl')->leftJoin('release_orders', 'jobsheets.ro_id', '=', 'release_orders.id')->where('jobsheets.installer','!=','NULL')->where('release_orders.order_id', 'LIKE',"%{$search}%")->orderBy('jobsheets.id','DESC')->get();	
		}
		else{
		$installer = DB::table('jobsheets')->where('installer','!=','NULL')->orderBy('id','DESC')->get();
		}
		}
		// echo"<pre>";print_r($installer);echo"</pre>";exit();
		return view("backend.installer-order-calendar",compact("installer"));
	}
	
	public function details(Request $request){
		$delivery = DB::table('jobsheets')->where('id',$request['id'])->first();
		$get_images = DB::table('dispute_images')->select('image')->where('job_id',$request['id'])->where('image_type','1')->get();
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
                        </div>';

						if(count($get_images)>0){
							foreach($get_images as $images){
							$result.='<div class="form-group pic-upload mb-4" style="width: 141px;">
							<div class="upload"><img src="'.asset("uploads/".$images->image).'"></div>
							</div>';
							}
						}
						else{
						$result.='<div class="form-group pic-upload mb-4">
                            <label class="">Upload Photo</label>
                            <div class="upload">
                                <input type="file" name="installer_img[]"class="form-control" placeholder="" onchange="readURL(this);" multiple>
                                <div class="upload-txt">
                                    <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                    <p>Click here or drag and drop files to upload</p>
									<img id="blah" src="#" alt="your image" />
                                </div>
                            </div>
							</div>';
							}
                        
						
                    $result.='
                        <div class="d-flex btn-grid">
                        <input type="submit" class="btn" value="Save">
						<button type="button" class="btn" data-bs-dismiss="offcanvas" aria-label="Close">Close</button>
                    </div>
					<script>$( document ).ready(function() {
					$("#blah").hide();
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
					</script>';
		return Response($result);
	}
	
	public function installer_status($id, $status){
		$update = DB::table("jobsheets")->where('id',$id)->update([
		 'installation_status'=>$status,
		]);		
		return redirect()->back()->with('success', 'Installer Status updated successfully.'); 
	}
	
	public function pdf($id, Request $request){
		if($request->has('download')){  
		 $jobsheets = DB::table('jobsheets')->where('id',$id)->first();
		 $ro = DB::table('release_orders')->where('id',$jobsheets->ro_id)->first();
	     $installers = DB::table('users')->select('id','name')->where('id',$jobsheets->installer)->orderBy('name','ASC')->first();
		 $getproducts['products'] = explode(",",$ro->product);
		 $getquantity['quantity'] = explode(",",$ro->product_qty);
		 $getskirting['skirting'] = explode(",",$ro->skirting);
		 $getskirtingqty['skirtingqty'] = explode(",",$ro->skirtingqty);
		 $arr = array_merge($getproducts,$getquantity,$getskirting,$getskirtingqty);
         $pdf = PDF::loadView('backend.installer-pdf',compact('jobsheets','ro','installers','arr'));  
         return $pdf->download('installer-order.pdf');  
        } 	
	}
	
	public function print_order($id){
			$jobsheets = DB::table('jobsheets')->where('id',$id)->first();
			$ro = DB::table('release_orders')->where('id',$jobsheets->ro_id)->first();
			$installers = DB::table('users')->select('id','name')->where('id',$jobsheets->installer)->orderBy('name','ASC')->first();
			$getproducts['products'] = explode(",",$ro->product);
			$getquantity['quantity'] = explode(",",$ro->product_qty);
			$getskirting['skirting'] = explode(",",$ro->skirting);
			$getskirtingqty['skirtingqty'] = explode(",",$ro->skirtingqty);
			$arr = array_merge($getproducts,$getquantity,$getskirting,$getskirtingqty);
			return view("backend.installer-pdf",compact('jobsheets','ro','installers','arr'));

	}
	
	public function installer_update(Request $request){	
		if($request->file('installer_img')){
		foreach ($request->file('installer_img') as $installer) {
			$file = $installer;
			$installer_img = time().'_'.$file->getClientOriginalName();
			$extension = $file->getClientOriginalExtension();
			$location = 'uploads';
			$file->move($location,$installer_img);
			DB::table('dispute_images')->insert([
			'image'			=>$installer_img,
			'job_id'		=>$request['jobid'],
			'image_type'	=>'1',
			]);
		 }
		return redirect()->back()->with('success', 'Image updated successfully!'); 
		}
		return redirect()->back()->with('error', 'Please upload an image.'); 
		
	}

	public function next_date(Request $request){
			if(auth()->user()->role_id=="11"){
			if($request->input('search')){
			$search = $request->input('search');
			$installer = DB::table('jobsheets')->select('jobsheets.id','jobsheets.jobsheet_id','jobsheets.delivery_status','jobsheets.created_at','jobsheets.ro_id','jobsheets.jobsheet_status','jobsheets.description','jobsheets.installation_date','jobsheets.installer','jobsheets.delivery_date','jobsheets.installer','jobsheets.c','jobsheets.pl')->leftJoin('release_orders', 'jobsheets.ro_id', '=', 'release_orders.id')->where('jobsheets.installer',auth()->user()->id)->where('release_orders.order_id', 'LIKE',"%{$search}%")->orderBy('jobsheets.id','DESC')->get();	
			}
			else{
			$installer = DB::table('jobsheets')->where('installer',auth()->user()->id)->orderBy('id','DESC')->get();
			}	
			}
			else{
			if($request->input('search')){
			$search = $request->input('search');
			$installer = DB::table('jobsheets')->select('jobsheets.id','jobsheets.jobsheet_id','jobsheets.delivery_status','jobsheets.created_at','jobsheets.ro_id','jobsheets.jobsheet_status','jobsheets.description','jobsheets.installation_date','jobsheets.installer','jobsheets.delivery_date','jobsheets.installer','jobsheets.c','jobsheets.pl')->leftJoin('release_orders', 'jobsheets.ro_id', '=', 'release_orders.id')->where('jobsheets.installer','!=','NULL')->where('release_orders.order_id', 'LIKE',"%{$search}%")->orderBy('jobsheets.id','DESC')->get();	
			}
			else{
			$installer = DB::table('jobsheets')->where('installer','!=','NULL')->orderBy('id','DESC')->get();
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
					foreach($installer as $install){
					$adate  =  strtotime($install->installation_date);
					$ro = DB::table('release_orders')->where('id',$install->ro_id)->first();
					
					if($adate==$timestamp){
					$installername = DB::table('users')->select('name')->where('id',$install->installer)->first();
		$result .= '<li><div class="date-order">
					<table>
					<tr>
                        <th>RO</th>
                        <td>#'.$ro->order_id.'</td>
                        <th>'.$install->jobsheet_id.'</th>
                    </tr>
					<tr>
					<th></th>
					<td>
					<a href="#job-detail" class="details" data-id="'.$install->id.'" role="button" aria-controls="offcanvasExample" data-bs-toggle="offcanvas">'.$installername->name.'</a>
					</td>
					<th></th>
					<th></th>
					</tr>
					</table>';
					if($install->installation_status=="3"){
					$select ="text-success";
					}
					elseif($install->installation_status=="2"){
					$select ="text-warning";
					}
					elseif($install->installation_status=="4"){
					$select ="text-danger";
					}
					else{
					$select ="text-info";
					}
					if($install->installation_status=="2"){
						$not_sel ="selected";
					}
					else{
						$not_sel ="";
					}
					if($install->installation_status=="1"){
						$in_sel ="selected";
					}
					else{
						$in_sel ="";
					}
					if($install->installation_status=="3"){
						$com_sel ="selected";
					}
					else{
						$com_sel ="";
					}
					if($install->installation_status=="4"){
						$po_sel ="selected";
					}
					else{
						$po_sel ="";
					}
		$result .= '<select class="form-select '.$select.'" aria-label="Default select example" onchange="location = this.value;">
					<option value="/installation_status/'.$install->id.'/2" '.$not_sel.' >Not Started</option>
					<option value="/installation_status/'.$install->id.'/1" '.$in_sel.'>Installing</option>
					<option value="/installation_status/'.$install->id.'/3" '.$com_sel.'>Completed</option>
					<option value="/installation_status/'.$install->id.'/4" '.$po_sel.'>Postponed</option>
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
									url: "/next-date",
									type: "GET",
									data: { date : date },
									success:function(data){
									$(".new-calander").html(data);
									}
								});
					}
					function previous_date(date){

						$.ajax({
								url: "/previous-date",
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
									  url: "/installation-details",
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

	public function previous_date(Request $request){
		if(auth()->user()->role_id=="11"){
			if($request->input('search')){
			$search = $request->input('search');
			$installer = DB::table('jobsheets')->select('jobsheets.id','jobsheets.jobsheet_id','jobsheets.delivery_status','jobsheets.created_at','jobsheets.ro_id','jobsheets.jobsheet_status','jobsheets.description','jobsheets.installation_date','jobsheets.installer','jobsheets.delivery_date','jobsheets.installer','jobsheets.c','jobsheets.pl')->leftJoin('release_orders', 'jobsheets.ro_id', '=', 'release_orders.id')->where('jobsheets.installer',auth()->user()->id)->where('release_orders.order_id', 'LIKE',"%{$search}%")->orderBy('jobsheets.id','DESC')->get();	
			}
			else{
			$installer = DB::table('jobsheets')->where('installer',auth()->user()->id)->orderBy('id','DESC')->get();
			}	
			}
			else{
			if($request->input('search')){
			$search = $request->input('search');
			$installer = DB::table('jobsheets')->select('jobsheets.id','jobsheets.jobsheet_id','jobsheets.delivery_status','jobsheets.created_at','jobsheets.ro_id','jobsheets.jobsheet_status','jobsheets.description','jobsheets.installation_date','jobsheets.installer','jobsheets.delivery_date','jobsheets.installer','jobsheets.c','jobsheets.pl')->leftJoin('release_orders', 'jobsheets.ro_id', '=', 'release_orders.id')->where('jobsheets.installer','!=','NULL')->where('release_orders.order_id', 'LIKE',"%{$search}%")->orderBy('jobsheets.id','DESC')->get();	
			}
			else{
			$installer = DB::table('jobsheets')->where('installer','!=','NULL')->orderBy('id','DESC')->get();
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
					foreach($installer as $install){
					$adate  =  strtotime($install->installation_date);
					$ro = DB::table('release_orders')->where('id',$install->ro_id)->first();
					
					if($adate==$timestamp){
					$installername = DB::table('users')->select('name')->where('id',$install->installer)->first();
		$result .= '<li><div class="date-order">
					<table>
					<tr>
                        <th>RO</th>
                        <td>#'.$ro->order_id.'</td>
                        <th>'.$install->jobsheet_id.'</th>
                    </tr>
					<tr>
					<th></th>
					<td>
					<a href="#job-detail" class="details" data-id="'.$install->id.'" role="button" aria-controls="offcanvasExample" data-bs-toggle="offcanvas">'.$installername->name.'</a>
					</td>
					<th></th>
					<th></th>
					</tr>
					</table>';
					if($install->installation_status=="3"){
					$select ="text-success";
					}
					elseif($install->installation_status=="2"){
					$select ="text-warning";
					}
					elseif($install->installation_status=="4"){
					$select ="text-danger";
					}
					else{
					$select ="text-info";
					}
					if($install->installation_status=="2"){
						$not_sel ="selected";
					}
					else{
						$not_sel ="";
					}
					if($install->installation_status=="1"){
						$in_sel ="selected";
					}
					else{
						$in_sel ="";
					}
					if($install->installation_status=="3"){
						$com_sel ="selected";
					}
					else{
						$com_sel ="";
					}
					if($install->installation_status=="4"){
						$po_sel ="selected";
					}
					else{
						$po_sel ="";
					}
		$result .= '<select class="form-select '.$select.'" aria-label="Default select example" onchange="location = this.value;">
					<option value="/installation_status/'.$install->id.'/2" '.$not_sel.' >Not Started</option>
					<option value="/installation_status/'.$install->id.'/1" '.$in_sel.'>Installing</option>
					<option value="/installation_status/'.$install->id.'/3" '.$com_sel.'>Completed</option>
					<option value="/installation_status/'.$install->id.'/4" '.$po_sel.'>Postponed</option>
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
									url: "/next-date",
									type: "GET",
									data: { date : date },
									success:function(data){
									$(".new-calander").html(data);
									}
								});
					}
					function previous_date(date){

						$.ajax({
								url: "/previous-date",
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
								  url: "/installation-details",
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
