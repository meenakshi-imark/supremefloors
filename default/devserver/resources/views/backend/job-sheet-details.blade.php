@include("layouts.admin.header")

<main class="content-wrapper">
    <div class="container-fluid">
		@if (\Session::has('success'))
        <div class="alert alert-success">
         {!! \Session::get('success') !!}
        </div>
		@endif
		<div class="box-shadow account">

            <div class="main-heading d-flex justify-content-between">
                <div class="main-titles">
                    <h1>
                        Job Sheet Details
                    </h1>
                    <p>
                        The segment shows the ongoing job sheet details of Supreme Floor ERP.
                    </p>
                </div>
            </div>
			       <div id="sheet-detail" aria-labelledby="offcanvasExampleLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Job Sheet Details</h5>
                    </div>
                    <div class="offcanvas-body">
                        <div class="row row-cols-md-3 row-cols-1 gy-2 gy-md-0">
                            <div class="col">
                                <p><b>RO: </b> {{$ro->order_id}}</p>
                            </div>
                            <div class="col">
                                <p><b>ID </b> {{$ro->owner}}</p>
                            </div>
                            <div class="col">
                                <p><b>Postal Code/ Address </b> {{$ro->site_address}}</p>
                            </div>
                        </div>
                        <div class="row row-cols-md-3 row-cols-2 mt-4 mb-3">
                            <div class="col">
                                <p><b>Delivery Date:</b></p>
                            </div>
                            <div class="col">
                                <p>{{$jobsheets->delivery_date}}</p>
                            </div>
                        </div>
                        <div class="row row-cols-md-3 row-cols-2 my-3">
                            <div class="col">
                                <p><b>Driver</b></p>
                            </div>
							@if($drivers)
							@php $d_name=$drivers->name; @endphp
							@else
							@php $d_name=""; @endphp	
							@endif
							
                            <div class="col">
                                <p>{{$d_name}}</p>
                            </div>
                        </div>
                        <div class="row row-cols-md-3 row-cols-2 mt-md-5 mt-3 mb-3">
                            <div class="col">
                                <p><b>Installation Date:</b></p>
                            </div>
                            <div class="col">
                                <p>{{$jobsheets->installation_date}}</p>
                            </div>
                        </div>
							@if($installers)
							@php $i_name=$installers->name; @endphp
							@else
							@php $i_name=""; @endphp	
							@endif
                        <div class="row row-cols-md-3 row-cols-2 mb-md-5 mb-3">
                            <div class="col">
                                <p><b>Installer</b></p>
                            </div>
                            <div class="col">
                                <p>{{$i_name}}</p>
                            </div>
                        </div>
                        <div class="desc">
                            <strong>Description:</strong>
                            <p class="my-3">{{$jobsheets->description}}</p>
                        </div>
                        <div class="row row-cols-3 my-md-5 my-3">
                            <div class="col">
                                <div class="row row-cols-2">
                                    <div class="col">
                                        <p><b>C</b></p>
                                    </div>
                                    <div class="col">
                                        <p>{{$jobsheets->c}}</p>
                                    </div>
                                </div>
                                <div class="row row-cols-2">
                                    <div class="col">
                                        <p><b>PL</b></p>
                                    </div>
                                    <div class="col">
                                        <p>{{$jobsheets->pl}}</p>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="action-links">
                            <p><b>Actions</b></p>
                            <ul class="mt-3 p-0">
                                <li class="my-md-4 my-3" style="list-style-type: none;">
                                    <a href="/edit-jobsheet/{{$jobsheets->id}}" class="btn"><span>Edit</span>
                                        <i class="la la-angle-double-right"></i>
                                    </a>
                                </li>
                                <li class="my-md-4 my-3" style="list-style-type: none;">
                                    <a class="btn" data-toggle="modal" data-target="#myModal"><span>Send Reminders Driver & Installer</span>
                                        <i class="la la-angle-double-right"></i>
                                    </a>
                                </li>
                                <li class="my-md-4 my-3" style="list-style-type: none;">
                                    <a class="btn" data-toggle="modal" data-target="#myModal1"><span>Send Customer an Email Reminder</span>
                                        <i class="la la-angle-double-right"></i>
                                    </a>
                                </li>
                                <li class="my-md-4 my-3" style="list-style-type: none;">
                                    <a data-toggle="modal" data-target="#myInvoice" class="btn"><span>Create Invoice</span>
                                        <i class="la la-angle-double-right"></i>
                                    </a>
                                </li>
                                <li class="my-md-4 my-3" style="list-style-type: none;">
                                    <a href="/details-pdf/{{$jobsheets->id}}?download=pdf" class="btn"><span>Download as PDF</span>
                                        <i class="la la-angle-double-right"></i>
                                    </a>
                                </li>
                                <li class="my-md-4 my-3" style="list-style-type: none;">
                                    <a href="/delete-jobsheet/{{$jobsheets->id}}" class="btn"><span>Delete</span>
                                        <i class="la la-angle-double-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

	 </div>
	</div>
</main>


</div>
<form method="POST" id="sendreminder">

@if($jobsheets->jobsheet_status=="1")
@php $status="Completed"; @endphp
@elseif($jobsheets->jobsheet_status=="2")
@php $status="Not Started"; @endphp
@elseif($jobsheets->jobsheet_status=="3")
@php $status="Postponed"; @endphp
@elseif($jobsheets->jobsheet_status=="4")
@php $status="Installing"; @endphp
@else($jobsheets->jobsheet_status=="5")
@php $status="Installing"; @endphp
@endif
@php 




@endphp
 <div class="reminder modal fade" id="myModal" role="dialog">
 @csrf
     <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
       <div class="modal-header">
          <i class="fa fa-exclamation" aria-hidden="true"></i>
		  <h5 class="modal-title">Sending Notification Reminder</h5>
          <!-- <button type="button" class="btn-close" data-dismiss="modal"></button> -->
		  <?php
			$currentdate  =date('Y-m-d');
			$date1=date_create($jobsheets->delivery_date);
			$date2=date_create($currentdate);
			$diff=date_diff($date1,$date2);
			$date = $diff->format("%R%a days");
			?>

         </div>
        <div class="modal-body">
          <p>Job order {{$jobsheets->jobsheet_id}} status is {{$status}}. The due date is in {{abs($date)}} days.</p>
		  <input type="hidden" name="orderid" id="orderid" value="{{$jobsheets->jobsheet_id}}">
		  <input type="hidden" name="jobid" id="jobid"value="{{$jobsheets->id}}">
		  <input type="hidden" name="status" id="status"value="{{$status}}">
		  <input type="hidden" name="duedate" id="duedate" value="{{abs($date)}}">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-default" data-dismiss="modal" id="send">Send Now</button>
          <button type="button" class="btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>
      
    </div>
  </div>
 </form>


<!---Email Reminder--->
<form method="POST" id="sendmailreminder">
 <div class="email-reminder modal fade" id="myModal1" role="dialog">
 @csrf
     <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
       <div class="modal-header">
          <i class="fa fa-exclamation" aria-hidden="true"></i>
		  <h5 class="modal-title">Sending Email Reminder</h5>
         </div>
        <div class="modal-body">
		@php 
		$user= DB::table('users')->where('id',$ro->owner)->select('id','name','email')->first();
		@endphp
          <p>An Email Reminder will be send to the customer Click <a href="#" data-toggle="modal" data-dismiss="modal" data-target="#myView">here</a> to preview.</p>
		  <input type="hidden" name="email" id="email" value="{{$user->email}}">
		  <input type="hidden" name="userid" id="userid" value="{{$user->id}}">
		  <input type="hidden" name="installation_date" id="installation_date" value="{{$jobsheets->installation_date}}">
		  <input type="hidden" name="end_color" id="end_color" value="{{$ro->end_color}}">
		  <input type="hidden" name="area" id="area" value="{{$ro->area}}">
		  <input type="hidden" name="site_address" id="site_address" value="{{$ro->site_address}}">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-default" data-dismiss="modal" id="sendmail">Send Now</button>
          <button type="button" class="btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>
      
    </div>
  </div>
  </form>
<!---Email View--->


 <div class="email-view modal fade" id="myView" role="dialog">
     <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
       <div class="modal-header">
          <button type="button" class="btn-close" data-dismiss="modal"></button>
         </div>
        <div class="modal-body">
            <figure>
                <img src="{{asset('admin/images/logo.png')}}" alt="logo">
            </figure>
		@php 
		$user= DB::table('users')->where('id',$ro->owner)->select('id','name','email')->first();
		@endphp
          <p>Hi <b>{{$user->name}},</b><br>
		  Just A Friendly Reminder About Your Flooring Installation.</p>
          <div class="table-data">
            <div class="sub-data">
                <div class="summary">
                    <h5>Summary:</h5>
                    <ul>
                        <li>
                            <span>Installation Date:</span>
                            <span>{{$jobsheets->installation_date}}</span>
                        </li>
                        <li>
                            <span>Colour:</span>
                            <span>{{$ro->end_color}}</span>
                        </li>
                        <li>
                            <span>Area:</span>
                            <span>{{$ro->area}}</span>
                        </li>
                    </ul>
                </div>
                <div class="address">
                    <h5>Installation Address:</h5>
                    <ul>
                        <li>
                            <span>{{$ro->site_address}}</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="feel-free">
                <p>Have any questions? Feel free to drop us an email at <a href="mailto:wecare@supremefloors.com.sg">wecare@supremefloors.com.sg</a> or call us at <a href="tel:6587666817">(+65) 87666817</a></p>
            </div>
		      <!-- <table class="table">
    			  <thead>
    				<tr>
    				  <th scope="col">Summary</th>
    				  <th scope="col">Installation Address</th>
    				</tr>
    			  </thead>
    			  <tbody>
    				<tr>
    				  <td>Installation Date: {{$jobsheets->installation_date}}<br>
    					  Colour: {{$ro->end_color}}<br>
    					  Area: {{$ro->area}}
    					  </td>
    				  <td>{{$ro->site_address}}</td>
    				</tr>
    			  </tbody>
			</table> -->
          </div>
          <div class="copy-right">
              <p>Copyright © 2022</p>
              <p><b>Supreme Floor</b></p>
              <p>SINGAPORE’S LEADING VINYL FLOORING BRAND</p>
          </div>
		  <input type="hidden" name="email" id="user" value="{{$user->email}}">
		  <input type="hidden" name="userid" id="userid" value="{{$user->id}}">
		  <input type="hidden" name="installation_date" id="installation_date" value="{{$jobsheets->installation_date}}">
		  <input type="hidden" name="end_color" id="end_color" value="{{$ro->end_color}}">
		  <input type="hidden" name="area" id="area" value="{{$ro->area}}">
		  <input type="hidden" name="site_address" id="site_address" value="{{$ro->site_address}}">
        </div>
      </div>
      
    </div>
  </div>
  
<!---Create Invoice--->

<form method="POST" id="createinvoice">
@csrf
 <div class=" invoice modal fade" id="myInvoice" role="dialog">
     <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
       <div class="modal-header">
          <i class="fa fa-exclamation" aria-hidden="true"></i>
		  <h5 class="modal-title">Invoice</h5>
         </div>
        <div class="modal-body">
		  <p> Are You sure you want to create invoce?</p>
		  <input type="hidden" name="jobid" id="jobid"value="{{$jobsheets->id}}">
        </div>
		  <div class="modal-footer">
          <button type="submit" class="btn btn-default" data-dismiss="modal" id="invoice">Yes</button>
          <button type="button" class="btn-default" data-dismiss="modal">NO</button>
        </div>
      </div>
      
    </div>
  </div>
 </form>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<style>
.delivery-class{
    border: 1px solid #B8B8B8;
    border-radius: 6px;
    padding: 13px 10px;
    width: fit-content;
}
.modal.fade.in{
opacity: 1 !important;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// $.ajaxSetup({
// headers: {
// 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
// }
// });
$("#sendmail").click(function(){
var email= $("#email").val();
var userid= $("#userid").val();
var installation_date= $("#installation_date").val();
var end_color= $("#end_color").val();
var area= $("#area").val();
var site_address= $("#site_address").val();
	 $.ajax({
              url: "/send-email-reminder",
              type: "POST",
			  dataType: "json",
              data:{
				 "_token": "{{ csrf_token() }}",
				  email:email,
				  userid:userid,
				  installation_date:installation_date,
				  end_color:end_color,
				  area:area,
				  site_address:site_address,
				  },
             success:function(data){
			 Swal.fire(
			  'Reminder Sent',
			  'success'
			)
			}
          });
});	
$("#send").click(function(){
var orderid= $("#orderid").val();
var jobid= $("#jobid").val();
var status= $("#status").val();
var duedate= $("#duedate").val();
	 $.ajax({
              url: "/send-reminder",
              type: "POST",
			  dataType: "json",
              data:{
				 "_token": "{{ csrf_token() }}",
				  orderid:orderid,
				  jobid:jobid,
				  status:status,
				  duedate:duedate,
				  },
             success:function(data){
			 Swal.fire(
			  'Reminder Sent',
			  'success'
			)
			}
          });
});	
$("#invoice").click(function(){
var jobid= $("#jobid").val();
	 $.ajax({
              url: "/create-invoice",
              type: "POST",
			  dataType: "json",
              data:{
				 "_token": "{{ csrf_token() }}",
				  jobid:jobid,
				  },
             success:function(data){
			 if(data.status==1){
			  Swal.fire(
			  'Invoice Created.',
			  'success'
				)	
			} 
			else if(data.status==3){
			Swal.fire(
			  'Error!',
			  'To create invoice you first need to approve dispute status.',
			  'error'
				)	
				setTimeout(function(){
                     location.href = '/jobsheet';
                },1000);
			}
			
			 
			}
          });
});	
</script>
@include("layouts.admin.footer")
 
