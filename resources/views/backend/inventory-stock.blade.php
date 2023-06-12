@include("layouts.admin.header")

<main class="content-wrapper">
    <div class="container-fluid">

        <div class="box-shadow account">

            <div class="main-heading">
                <h1>
                    Inventory
                </h1>
                <p>
                    This segment shows the inventory in Supreme Floor ERP.
                </p>
            </div>
            <div class="filter">
			<form action="/inventory-stock" method="GET">
            @if(isset($_GET['search']))
            @php $searhval =$_GET['search'] @endphp 
            @else
            @php $searhval ="" @endphp 
            @endif
                <div class="form-group">
                    <div class="position-relative w-100 d-flex h-100">
                        <i class="la la-search"></i>
                        <input type="text" class="form-control me-xl-5 me-3" placeholder="Search Quotation" name="search" value="{{$searhval}}">
                         <button type="submit" class="btn me-xl-5 me-3">Search</button>					
                    </div>
               
                   
                    <a  class="btn" data-toggle="modal" data-target="#myModal">
                        <i class="la la-filter"></i>
                        Filter
                    </a>
                   
                </div>
			  </form>
            </div>
			@if(count($products)>0)
            <div class="all-tabel table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>In Stock</th>
                            <th>Incoming Stock</th>
                            <th>Approved Quotation</th>
                        </tr>
                    </thead>
                    <tbody>
						@foreach($products as $product)
                        <tr>
                            <td>
                                <figure>
                                      @if($product->p_image==null)
                                        <img src="{{asset('uploads/no-image.png')}}">
                                        @else
                                        <img src="{{asset('admin/productimage/'.$product->p_image)}}" style="width:163px;">
                                        @endif
                                </figure>
                            </td>
                            <td>
							{{$product->product_no}} - {{$product->product_name}}
                            </td>
                            <td>
							{{$product->total_inventry}}
                            </td>
                            <td>
							 <div class="inc-stock">
							@php
							$po = DB::table('purchase_orders')->select('id','product_id','unit','quantity','estimated_arrival','status')->where('status','1')->orderBy('id','DESC')->get();
							
							@endphp
							@foreach($po as $p)
							@php 
							$pid = explode(",",$p->product_id);
							@endphp
							@if(in_array($product->id, $pid))
							
							@php 
							$getid['id'] = explode(",",$p->product_id);
							$getunit['unit'] = explode(",",$p->unit);
							$getquantity['quantity'] = explode(",",$p->quantity);
							$arr = array_merge($getid,$getunit,$getquantity);
							@endphp
							@for($a=0;$a<count($pid);$a++)
								
								@if($pid[$a]==$product->id)
										
									@php $val =  array_search($pid[$a], $arr['id']); @endphp
                                    <div class="area">
                                        <p>{{$p->estimated_arrival}}</p>
                                        <div class="form-group">
                                            <label>Area</label>
                                            <input type="text" placeholder="3500" value="{{$arr['unit'][$val]}}" readonly>
                                        </div>
                                        @if($p->status=="1")
                                        <div class="form-group">
                                            <label>Packet</label>
                                           
                                            <input type="text" id="inventory{{$p->id}}{{$arr['id'][$a]}}" onkeyup="UpdatePacket({{$p->id}},{{$arr['id'][$a]}})"  placeholder="20" value="{{$arr['quantity'][$val]}}">
                                           
                                        </div>
                                        @endif
                                    </div>
							@endif
							
							
							@endfor
						
							
							@endif
							
							@endforeach
                              </div> 
                            </td>
                            <td>
                                <div class="apv-quot">
								@php
								$ro = DB::table('release_orders')->select('id','company_id','product_qty','estimate_date','product','created_at')->get();
								@endphp
								
								@foreach($ro as $r)
								@php 
								$name = DB::table('suppliers')->select('person_name')->where('id',$r->company_id)->first();
									
								$rid = explode(",",$r->product);
								@endphp
								@if(in_array($product->id, $rid))
								@php 
								$getid['id'] = explode(",",$r->product);
								$getquantity['quantity'] = explode(",",$r->product_qty);
								$arr = array_merge($getid,$getquantity);
								@endphp	
								
								@for($a=0;$a<count($rid);$a++)
								@if($rid[$a]==$product->id)
								@php $val =  array_search($rid[$a], $arr['id']); @endphp
								
                                    <div class="approved-date">
									@php
									$date = $r->created_at;
									$str=substr($date, 0, strrpos($date, ' '));
									
									@endphp
                                        <p>{{$str}}</p>
										@php
										if($name == ""){
										$output ="--";
										}else{
										$output = substr($name->person_name, 0, 2);  
									}
										@endphp
                                        <span>{{$output}}</span>
                                        <p>{{$arr['quantity'][$val]}}</p>
                                    </div>
									
								@endif
								
								@endfor
								
								
								
								@endif
								@endforeach
								
								
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
			{!! $products->render() !!}
			@else
			<p>No result found.</p>
			@endif
			
        </div>
    </div>
</main>
<div class="reminder modal fade" id="myModal" role="dialog">
<form action="/inventory-stock" method="GET">
     <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
       <div class="modal-header">
          <i class="la la-filter" aria-hidden="true"></i>
		  <h5 class="modal-title">Category filter</h5>
                                    
         </div>
        <div class="modal-body">
          <p>Choose Category </p>
          @if(isset($_GET['search']))
          <input type="hidden" name="search" value="{{$_GET['search']}}">
          @endif
          @if(isset($_GET['categories']))
          @php $category= $_GET['categories'];@endphp
          @else
          @php $category = array(); @endphp
          @endif
       
          @foreach($categories as $cat)
        <?php 
        if(in_array($cat->id,$category)){
            $chk="checked";
        }
        else{
            $chk="";
        }
        ?>
          <div class="check-grid">
            <label class="form-check-label">
            <input class="form-check-input checkall1" id="flexCheckDefault" type="checkbox" name="categories[]" value="{{$cat->id}}" {{$chk}}>
            <span>{{$cat->category_name}}</span>
            </label>
         </div>
        @endforeach
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-default">Filter</button>
          <button type="button" class="btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>
      
    </div>
    </form>
  </div>
  <style>
    input#flexCheckDefault {
    padding: 10px 10px;
    margin-bottom: 7px;
    }   
    .check-grid span {
    padding-left: 10px;
    }
    .modal.fade.in{
    opacity: 1 !important;
    }
  </style>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script>
function UpdatePacket(poid,pid){
    var val = $("#inventory"+poid+pid).val();
    $.ajax({
            url: "/update-packet",
            type: 'GET',
            data: { val : val,poid:poid,pid:pid },
			success:function(data){
			
			}
       }); 
}
</script>
@include("layouts.admin.footer")