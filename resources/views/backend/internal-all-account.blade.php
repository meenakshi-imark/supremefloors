@include("layouts.admin.header")

<main class="content-wrapper">
    <div class="container-fluid">
    @if (\Session::has('success'))
        <div class="alert alert-success">
		{!! \Session::get('success') !!}
        </div>
    @endif
    @if (\Session::has('error'))
        <div class="alert alert-danger">
		{!! \Session::get('error') !!}
        </div>
    @endif 
	<div class="box-shadow account">

            <div class="main-heading">
                <h1>
                    All Accounts
                </h1>
                <p>
                    This segment shows the existing role types in Supreme Floor ERP.
                </p>
            </div>
            <div class="filter">
                <form action="/internal-all-account" method="GET">
                <div class="form-group">
                    <div class="position-relative w-100 d-flex h-100">
                        <i class="la la-search"></i>
                        <input type="text" class="form-control me-xl-5 me-3" name="search" placeholder="Search Account" required>
                        <button type="submit" class="btn me-xl-5">Search</button>
						
                    </div>
					</form>
					</div>
                <div class="tab-select">
                    <a href="internal-all-account?filter=2">Sub Admin ({{$subacount}})</a>
                    <a href="internal-all-account?filter=6">Sales Staff ({{$staffcount}})</a>
                    <a href="internal-all-account?filter=9">Sales Agent ({{$agentcount}})</a>
                    <a href="internal-all-account?filter=10">Delivery ({{$delcount}})</a>
                    <a href="internal-all-account?filter=11">Installers ({{$intcount}})</a>
                </div>
            </div>
			
            @if(count($all_accounts)>0)
				
			<form method="POST" action="/delete-all">
			<div id="selectval1">
			<button type="submit" class="btn me-5 mb-2">Delete</button>
			</div>
            <div class="all-tabel table-responsive">
				@csrf
                <table>
                    <thead>
                        <tr>
                            <th>Select All <br>
							<input class="form-check-input" type="checkbox" id="ckbCheckAll" /></th>
                            <th>Full Name</th>
                            <th>Level</th>
                            <th>Sales Staff ID</th>
                            <th>Role Type</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>BOD</th>
                            <th>Gender</th>
                            <th>Address</th>
                            <th>Username</th>
                            <th>remarks</th>
                            <th>status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($all_accounts as $all_account)
                        <tr>
                            <td>
                                <label class="form-check-label">
                                    <input class="form-check-input selectid" name="id[]"type="checkbox" value="{{$all_account->id}}">
                                </label>
                            </td>
                            <td>
                                <div class="id-name">
                                    <figure>
                                        @if($all_account->image==null)
                                        <img src="{{asset('uploads/no-image.png')}}">
                                        @else
                                        <img src="{{asset('uploads/'.$all_account->image)}}">
                                        @endif
                                    </figure>
                                    
                                    <span @if($all_account->status == 2) style="color:red"@endif>{{ $all_account->name }}</span>
                                </div>
                            </td>
                            <td>
                                {{ $all_account->level }}
                            </td>
                            <td>
                                {{ $all_account->staff_id }}                                
                            </td>
                            <td>
                                {{ $all_account->rolename }}
                            </td>
                            <td>
                                {{ $all_account->email }}
                            </td>
                            <td>
                                {{ $all_account->phone }}
                            </td>
                            <td>
                                {{ date('d-m-Y', strtotime($all_account->dob)); }}
                            </td>
                            <td>
                                @if($all_account->gender == 1)
                                Male
                                @elseif($all_account->gender == 2)
                                Female
                                @endif
                            </td>
                            <td>
                               {{ $all_account->address }} 
                            </td>
                            <td>
                               {{ $all_account->username }}                                
                            </td>
                            <td>
                               {{ $all_account->remarks }} 
                            </td>
                            <td>
                               @if($all_account->status == 1)
                                <a href="/update_status/{{$all_account->id}}" class="statusactive">Active</a>
                                @elseif($all_account->status == 2)
                                <a href="/update_status/{{$all_account->id}}" class="statusinactive">Inactive</a>
                                @endif
                            </td>
                            <!-- Modal -->
                                <div class="password-change modal fade" id="mod{{ $all_account->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      <form action="/change_pass/{{ $all_account->id }}" method="POST">
                                        @csrf
                                        @method('put')
                                      <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <input type="password" name="old_password" class="form-control" placeholder="Old Password*">
                                                    
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <input type="password" name="new_password" class="form-control" placeholder="New Password*">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="submit" class="btn btn-secondary w-100" >Change</button>
                                        
                                      </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                            <td>
                                <?php 
                    			  $getrole= DB::table('roles')->where('id',auth()->user()->role_id)->get();
                    			  $per = explode(",",$getrole[0]->permission_id);
                    			  $acc = explode(",",$getrole[0]->access_id);
                    			  ?>
                    			@if(in_array("7", $acc) || auth()->user()->role_id=="1" || auth()->user()->role_id=="2")
                                <div class="dropdown">
                                    <button class=" dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                        <i class="la la-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="/internal-edit-account/{{ $all_account->id }}"><i class="la la-pencil-square-o" aria-hidden="true"></i>Edit</a></li>
                                       	@if(in_array("8", $acc) || auth()->user()->role_id=="1" || auth()->user()->role_id=="2")
                                        <li><a class="dropdown-item" href="/internal-delete-account/{{ $all_account->id }}"><i class="la la-trash"></i>Delete</a></li>
                                        @endif
                                        <li><a class="dropdown-item" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#mod{{ $all_account->id }}"><i class="la la-lock"></i>Change Password</a></li>
                                    </ul>
                                </div>
                                @endif
                                
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
			</form>
            {!! $all_accounts->render() !!}
            @else
            <p>No result found.</p>
            @endif
        </div>
    </div>
</main>
<style>
.statusactive{
    border: 1px solid #13582E;
    background-color: transparent;
    padding: 10px 20px;
    width: 124px;
    color: #13582E;
    border-radius: 6px;
}
.statusinactive{
    border: 1px solid #f03e34;
    background-color: transparent;
    padding: 10px 20px;
    width: 124px;
    color: #f03e34;
    border-radius: 6px;
}

.pagination{margin-top:10px;}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function () {
    $("#ckbCheckAll").click(function () {
        $(".selectid").prop('checked', $(this).prop('checked'));
    });
});	
	
	
/* $(".selectid").change(function() {
var data = []
$.each($("input[name='id']:checked"), function(){
data.push($(this).val());
});
 $("#selectval").append('<input type="text" name="input[]" value="'+data+'">')
$('#selectval').val($('#selectval').val() + 'more text');

});	 */


	
</script>
@include("layouts.admin.footer")