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
				<form action="/search" method="GET">
                <div class="form-group">
                    <div class="position-relative w-100 d-flex h-100">
                        <i class="la la-search"></i>
                        <input type="text" class="form-control me-5" name="search" placeholder="Search Quotation" required>
                        <button type="submit" class="btn me-5">Search</button>
						
                    </div>
                    <a href="javascript:void(0);" class="btn">
                        <i class="la la-filter"></i>
                        Filter
                    </a>
					</form>
                </div>
                <div class="tab-select">
                    <a href="javascript:void(0);">Sub Admin ({{ $all_accounts->where('role_id','2')->count() }})</a>
                    <a href="javascript:void(0);">Sales Staff ({{ $all_accounts->where('role_id','6')->count() }})</a>
                    <a href="javascript:void(0);">Sales Agent ({{ $all_accounts->where('role_id','4')->count() }})</a>
                    <a href="javascript:void(0);">Delivery ({{ $all_accounts->where('role_id','5')->count() }})</a>
                    <a href="javascript:void(0);">Installers ({{ $all_accounts->where('role_id','10')->count() }})</a>
                </div>
            </div>
			@if(count($all_accounts)>0)
            <div class="all-tabel table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Select</th>
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
                                    <input class="form-check-input" id="flexCheckDefault" type="checkbox" value="">
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
                                    <span>{{ $all_account->name }}</span>
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
                            <td>
                                <div class="dropdown">
                                    <button class=" dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                        <i class="la la-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="/internal-edit-account/{{ $all_account->id }}"><i class="la la-pencil-square-o" aria-hidden="true"></i>Edit</a></li>
                                        <li><a class="dropdown-item" href="/internal-delete-account/{{ $all_account->id }}"><i class="la la-trash"></i>Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
</style>
@include("layouts.admin.footer")