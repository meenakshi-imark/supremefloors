<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Welcome | Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('front/favicon.png')}}" sizes="32x32" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('admin/css/dashboard.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/loklok-dashboard.css')}}">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<style>
    .side_logout{
    display: inline-flex;
    color: #fff;
    pointer-events: none;
    }
</style>

<body>

    <header id="header" class="bg-sitecolor">
        <div class="header-area">
            <div class="site-m-logo d-lg-none">
                <div class="site-menu">
                    <i class="las la-bars"></i>
                    <i class="las la-times"></i>
                </div>
                <a href="#">
                    <img src="{{asset('admin/images/logo.png')}}" alt="logo">
                </a>
            </div>
            <div class="notify">
                <a href="/commission" class="">
                    <figure>
                        <img src="{{asset('admin/images/discount.png')}}">
                    </figure>
                </a>
            </div>
				@php 
				$result = DB::table('reminders')->select('reminders.id','reminders.order_id','reminders.status','reminders.daysleft','reminders.reminder','jobsheets.jobsheet_id','jobsheets.delivery_date')
				->leftJoin('jobsheets','reminders.job_id','=','jobsheets.id')->where('reminders.reminder_status','0')->
				where('jobsheets.installer',auth()->user()->id)->OrWhere('jobsheets.driver',auth()->user()->id)->get();
				$count = count($result);
				@endphp
            <div class="notify">
                <a href="javascript:void(0)" class="active">
                    <i class="fa fa-bell-o" aria-hidden="true">
                        <span>{{$count}}</span>
                    </i>
                </a>
				
                <div class="notices">
				
				@if(count($result)>0)
				@foreach($result as $res)
				@php 
				$currentdate  =date('Y-m-d');
				$date1=date_create($res->delivery_date);
				$date2=date_create($currentdate);
				$diff=date_diff($date1,$date2);
				$date = $diff->format("%R%a days");
				@endphp
                    <div class="notices-txt">
                        <div class="notice-head">
                            <i class="fa fa-exclamation" aria-hidden="true"></i>
                            <h6>{{$res->reminder}}</h6>
                        </div>
                        <div class="view">
                            <a href="javascript:void(0)">VIEW</a>
                            <a href="/reminder_status/{{$res->id}}"><i class="la la-times"></i></a>
                        </div>
                    </div>
				@endforeach
				@else
				<p>No new notification.</p>
				@endif
                </div>
            </div>
            <div class="profile-action">
                <!-- <div id="mSearch" class="m-search-icon d-md-none">
                    <i class="las la-search"></i>
                    <i class="las la-times"></i>
                </div> -->
                <a>
                    @if(auth()->user()->image!="")
                     <div class="user-img" style="background-image: url('{{asset('uploads/'.auth()->user()->image)}}');"></div>
            
		            	@else
		            	 <div class="user-img" style="background-image: url('{{asset('uploads/dummy-profile-pic.jpg')}}');"></div>
			
		            	@endif
                    <h6>{{Auth::user()->name}}</h6><i class="fa fa-angle-down" aria-hidden="true"></i>
                </a>
                <div class="drop-area">
                    <ul>
                        <li>
                            <a href="#">
                                <i class="fa fa-user-o" aria-hidden="true"></i> <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            
                                
                                <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                                <span>Logout</span>
                            </x-dropdown-link>
                        </form>
                                
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </header>

    <div class="layer"></div>

    <aside class="main-sidebar bg-sitecolor">
        <div class="site-logo d-none d-lg-flex">
            <a href="#">
                <img src="{{asset('admin/images/logo.png')}}" alt="logo-dashboard">
            </a>
        </div>
        <div class="dash-profile text-center">
            @if(auth()->user()->image!="")
            <div class="user-img" style="background-image: url('{{asset('uploads/'.auth()->user()->image)}}');"></div>
            
			@else
			 <div class="user-img" style="background-image: url('{{asset('uploads/dummy-profile-pic.jpg')}}');"></div>
			
			@endif
            <h6>{{Auth::user()->name}}</h6>
        </div>
        <section class="sidebar card">
            <!-- <ul>
                <li class="active">
                    <a href="index.php">
                        <i class="las la-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="owner-profile.php">
                        <i class="las la-user"></i>
                        <span>Post Jobs</span>
                    </a>
                </li>
                <li>
                    <a href="owner-my-property.php">
                        <i class="las la-home"></i>
                        <span>Subscription</span>
                    </a>
                </li>
                <li>
                    <a href="owner-booking-history.php">
                        <i class="las la-history"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void()">
                        <i class="las la-sign-out-alt"></i>
                        <span>Settings</span>
                    </a>
                </li>
            </ul> -->

             <?php 
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
			  ?>
            <ul class="nav flex-column" id="nav_accordion">
               @if(in_array("1", $per) || auth()->user()->role_id=="1" || auth()->user()->role_id=="2")
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#">
                        <figure>
                            <img src="{{asset('admin/images/avatar.png')}}">
                        </figure>
                        <span>Roles</span><i class="fa fa-angle-right" aria-hidden="true"></i>
                    </a>
                    <ul class="submenu collapse">
                        <li><a class="nav-link active" href="{{ url('role-create-type')}}">Create Type</a></li>
                        <li><a class="nav-link" href="{{ url('role-all-role')}}">All Roles</a></li>
                       
                    </ul>
                </li>
                @endif
				@if(in_array("2", $per) || auth()->user()->role_id=="1" || auth()->user()->role_id=="2")
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#">
                        <figure>
                            <img src="{{asset('admin/images/avatar.png')}}">
                        </figure>
                        <span>Internal Account</span><i class="fa fa-angle-right" aria-hidden="true"></i>
                    </a>
                    <ul class="submenu collapse">
                        @if(in_array("5", $acc)|| auth()->user()->role_id=="1" || auth()->user()->role_id=="2")
                        <li><a class="nav-link" href="{{url('internal-create-account')}}">create account</a></li>
                        @endif
						@if(in_array("6", $acc)|| auth()->user()->role_id=="1" || auth()->user()->role_id=="2")
                        <li><a class="nav-link" href="{{url('internal-all-account')}}">all Account</a></li>
                        @endif
                    </ul>

                </li>
                @endif
                @if(in_array("3", $per) || auth()->user()->role_id=="1" || auth()->user()->role_id=="2")
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#">
                        <figure>
                            <img src="{{asset('admin/images/customer.png')}}">
                        </figure>
                        <span>Customer</span><i class="fa fa-angle-right" aria-hidden="true"></i>
                    </a>
                    <ul class="submenu collapse">
                         @if(in_array("9", $acc)|| auth()->user()->role_id=="1" || auth()->user()->role_id=="2")
                        <li><a class="nav-link" href="{{url('customer-create-type')}}">Create Type</a></li>
                         @endif
                         @if(in_array("10", $acc)|| auth()->user()->role_id=="1" || auth()->user()->role_id=="2")
                        <li><a class="nav-link" href="{{url('customer-create-account')}}">create account</a></li>
                        @endif
                        @if(in_array("13", $acc)|| auth()->user()->role_id=="1" || auth()->user()->role_id=="2")
                        <li><a class="nav-link" href="{{url('customer-all-type')}}">all type</a></li>
                        @endif
                        @if(in_array("14", $acc)|| auth()->user()->role_id=="1" || auth()->user()->role_id=="2")
                        <li><a class="nav-link" href="{{url('customer-all-account')}}">all accounts</a></li>
                        @endif
                    </ul>
                </li>
                @endif
				@if(in_array("4", $per) || auth()->user()->role_id=="1" || auth()->user()->role_id=="2")
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#">
                        <figure>
                            <img src="{{asset('admin/images/warehouse.png')}}">
                        </figure>
                        <span>Warehouse</span><i class="fa fa-angle-right" aria-hidden="true"></i>
                    </a>
                    <ul class="submenu collapse">
                        <li><a class="nav-link" href="{{url('warehouse-create-warehouse')}}">Create Warehouse</a></li>
                        <li><a class="nav-link" href="{{url('warehouse-all-warehouse')}}">All Warehouse</a></li>
                    </ul>
                </li>
                @endif
				@if(in_array("5", $per) || auth()->user()->role_id=="1" || auth()->user()->role_id=="2")
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#">
                        <figure>
                            <img src="{{asset('admin/images/inventory.png')}}">
                        </figure>
                        <span>Inventory</span><i class="fa fa-angle-right" aria-hidden="true"></i>
                    </a>
                    <ul class="submenu collapse">
                        <li><a class="nav-link" href="{{url('inventory-stock')}}">Stock</a></li>
                    </ul>
                </li>
                @endif
                @if(auth()->user()->role_id=="1" || auth()->user()->role_id=="2")
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#">
                        <figure>
                            <img src="{{asset('admin/images/purchase-order.png')}}">
                        </figure>
                        <span>Category</span><i class="fa fa-angle-right" aria-hidden="true"></i>
                    </a>
                    <ul class="submenu collapse">
                        <li><a class="nav-link" href="{{url('create-category')}}">create Category</a></li>
                        <li><a class="nav-link" href="{{url('all-categories')}}">All Category</a></li>
                    </ul>
                </li>
                @endif
				@if(in_array("6", $per) || auth()->user()->role_id=="1" || auth()->user()->role_id=="2")
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#">
                        <figure>
                            <img src="{{asset('admin/images/purchase-order.png')}}">
                        </figure>
                        <span>Product</span><i class="fa fa-angle-right" aria-hidden="true"></i>
                    </a>
                    <ul class="submenu collapse">
                        <li><a class="nav-link" href="{{url('product-create-product')}}">create Product</a></li>
                        <li><a class="nav-link" href="{{url('product-all-products')}}">All Product</a></li>
                    </ul>
                </li>
                @endif
				@if(in_array("7", $per) || auth()->user()->role_id=="1" || auth()->user()->role_id=="2")
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#">
                        <figure>
                            <img src="{{asset('admin/images/purchase-order.png')}}">
                        </figure>
                        <span>Supplier</span><i class="fa fa-angle-right" aria-hidden="true"></i>
                    </a>
                    <ul class="submenu collapse">
                        <li><a class="nav-link" href="{{url('supplier-create-new-supplier')}}">create Supplier</a></li>
                        <li><a class="nav-link" href="{{url('suppliers')}}">All Supplier</a></li>
                    </ul>
                </li>
                @endif
				@if(in_array("8", $per) || auth()->user()->role_id=="1" || auth()->user()->role_id=="2")
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#">
                        <figure>
                            <img src="{{asset('admin/images/purchase-order.png')}}">
                        </figure>
                        <span>Purchase order</span><i class="fa fa-angle-right" aria-hidden="true"></i>
                    </a>
                    <ul class="submenu collapse">
                        <li><a class="nav-link" href="{{url('purchase-order-create-po')}}">create PO</a></li>
                        <li><a class="nav-link" href="{{url('purchase-order-list')}}">All PO</a></li>
                    </ul>
                </li>
                @endif
				@if(in_array("9", $per) || auth()->user()->role_id=="1" || auth()->user()->role_id=="2")
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#">
                        <figure>
                            <img src="{{asset('admin/images/purchase-order.png')}}">
                        </figure>
                        <span>Sales</span><i class="fa fa-angle-right" aria-hidden="true"></i>
                    </a>
                    <ul class="submenu collapse">
                        <li><a class="nav-link" href="{{url('sales-dashboard')}}">Sales dashboard</a></li>
                        <li><a class="nav-link" href="{{url('quotation-create-quotation')}}">Create Quotation</a></li>
                        <li><a class="nav-link" href="{{url('sales-all-quotation')}}">All Quotation</a></li>
                        <li><a class="nav-link" href="{{url('sales-invoice')}}">Create invoice</a></li>
                        <li><a class="nav-link" href="{{url('all-invoice')}}">All invoice</a></li>
                    </ul>
                </li>
                @endif
				@if(in_array("10", $per) || auth()->user()->role_id=="1" || auth()->user()->role_id=="2")
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#">
                        <figure>
                            <img src="{{asset('admin/images/sent.png')}}">
                        </figure>
                        <span>Release Order</span><i class="fa fa-angle-right" aria-hidden="true"></i>
                    </a>
                    <ul class="submenu collapse">
                        <li>
                            <a class="nav-link" href="{{url('release-order-create-ro')}}">create RO</a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{url('release-order-list')}}">All RO</a>
                        </li>
                    </ul>
                </li>
                
                @endif
				@if(auth()->user()->role_id=="1")
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#">
                        <figure>
                            <img src="{{asset('admin/images/sent.png')}}">
                        </figure>
                        <span>Jobsheet</span><i class="fa fa-angle-right" aria-hidden="true"></i>
                    </a>
                    <ul class="submenu collapse">
                        <li>
                            <a class="nav-link" href="{{url('jobsheet')}}">Jobsheet</a>
                        </li>
                    </ul>
                </li>
				@endif
				@if(auth()->user()->role_id=="1" || auth()->user()->role_id=="10")
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#">
                        <figure>
                            <img src="{{asset('admin/images/sent.png')}}">
                        </figure>
                        <span>Delivery Order</span><i class="fa fa-angle-right" aria-hidden="true"></i>
                    </a>
                    <ul class="submenu collapse">
                        <li>
                            <a class="nav-link" href="{{url('delivery-order-table')}}">Delivery Order</a>
                        </li>
                    </ul>
                </li>
				@endif
				@if(auth()->user()->role_id=="1" || auth()->user()->role_id=="11")
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#">
                        <figure>
                            <img src="{{asset('admin/images/sent.png')}}">
                        </figure>
                        <span>Installer Order</span><i class="fa fa-angle-right" aria-hidden="true"></i>
                    </a>
                    <ul class="submenu collapse">
                        <li>
                            <a class="nav-link" href="{{url('installer-order-table')}}">Installer Order</a>
                        </li>
                    </ul>
                </li>
                @endif
                @if(auth()->user()->role_id=="1" || auth()->user()->role_id=="2")
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#">
                        <figure>
                            <img src="{{asset('admin/images/sent.png')}}">
                        </figure>
                        <span>Recent Logs</span><i class="fa fa-angle-right" aria-hidden="true"></i>
                    </a>
                    <ul class="submenu collapse">
                        <li>
                            <a class="nav-link" href="/recent-logs">Recent Logs</a>
                        </li>
                    </ul>
                </li>
                @endif
                <li class="nav-item has-submenu">
                    
                    <form method="POST" action="{{ route('logout') }}">
                            @csrf
                        
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                            <figure>
                                <img src="{{asset('admin/images/log-out.png')}}">
                                <span class="nav-link side_logout">{{ __('Log Out') }}</span>
                            </figure>
                                
                            </x-dropdown-link>
                    </form>
                        
                   
                </li>

            </ul>




        </section>
        <div class="side-copy text-center">
            <p>Copyright © <?php echo date("Y"); ?> by Supreme Floors.</p>
        </div>
    </aside>