@include("layouts.admin.header")

<main class="content-wrapper">
    <div class="container-fluid">
         @if (\Session::has('success'))
        <div class="alert alert-success">
            <ul>
                <li>{!! \Session::get('success') !!}</li>
            </ul>
        </div>
		@endif
		 @if (\Session::has('error'))
        <div class="alert alert-danger">
            <ul>
                <li>{!! \Session::get('error') !!}</li>
            </ul>
        </div>
		@endif
        <div class="box-shadow account">

            <div class="main-heading d-flex justify-content-between">
                <div class="main-titles">
                    <h1>
                    Activity Log
                    </h1>
                    <p>
                    The segment shows the logs of all activity in Supreme Floor ERP.
                    </p>
                </div>
                <!--div class="tabs-change">
                    <a href="javascript:void(0);" class="active">
                        <i class="la la-table"></i>
                        <span>Table</span>
                    </a>
                    <a href="javascript:void(0);">
                        <i class="la la-calendar"></i>
                        <span>Calendar</span>
                    </a>
                </div-->
            </div>
            <?php if(isset($_GET['search'])){
            $search =$_GET['search'];
            }
            else{
                $search ="";
            }?>
            <div class="filter">
            <form action="/recent-logs" method="GET">
                <div class="form-group">
                    <div class="position-relative w-100 d-flex h-100">
                        <i class="la la-search"></i>
                        <input type="text" class="form-control me-5" placeholder="Search" name="search" value="{{$search}}"required>
                        <button type="submit" class="btn me-5">Search</button>
                        <a href="/recent-logs"class="btn me-5 btn-white" style="color: #13582E;background-color: #fff;">Reset</a>
                    </div>
                    <!--a href="javascript:void(0);" class="btn">
                        <i class="la la-filter"></i>
                        Filter
                    </a-->
                </div>
            </form>
            </div>
            @if(count($logs)>0)
            <form method="POST" action="/delete-all-logs"> 
			<!--div id="selectval1">
			<button type="submit" class="btn me-5 mb-2">Delete</button>
			</div-->
			@csrf
            <div class="all-tabel table-responsive">
                <table>
                    <thead>
                        <tr>
                            <!--th>Select All</br>
							<input class="form-check-input" type="checkbox" id="ckbCheckAll" /></th>-->
                            <th>Account</th>
                            <th>Timestamp</th>
                            <th>Activity</th>
                            <!--th>Action</th-->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                        <tr>
                            <!--td>
                                <label class="form-check-label">
                                    <input class="form-check-input selectid" id="flexCheckDefault" name="id[]" type="checkbox" value="{{$log->userid}}">
                                </label>
                            </td-->
                            <td>
                            @php 
                            $user = DB::table('users')->select('name')->where('id',$log->userid)->first();  
                            @endphp
                            {{$user->name}}
                            </td>
                            <td>
                            {{$log->timestamp}}
                            </td>
                            <td>
                            {{$log->activity}}
                            </td>
                            <!--td>
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                        <i class="la la-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <a class="dropdown-item" href="/delete-log/{{$log->id}}">
                                                <i class="la la-trash"></i>
                                                Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </td-->
                        </tr>
                        @endforeach

                        
                    </tbody>
                </table>
                {!! $logs->render() !!}
            </div>
            </form>
            @else
            <p>No result found.</p>
            @endif
        </div>
    </div>
</main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function () {
$("#ckbCheckAll").click(function () {
$(".selectid").prop('checked', $(this).prop('checked'));
});
});
</script>
@include("layouts.admin.footer")