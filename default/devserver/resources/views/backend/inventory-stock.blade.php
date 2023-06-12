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
                <div class="form-group">
                    <div class="position-relative w-100 d-flex h-100">
                        <i class="la la-search"></i>
                        <input type="text" class="form-control me-xl-5 me-3" placeholder="Search Quotation" name="search">
                         <button type="submit" class="btn me-xl-5 me-3">Search</button>					
                    </div>
                    <a href="javascript:void(0);" class="btn">
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
							$po = DB::table('purchase_orders')->select('id','product_id','unit','quantity','estimated_arrival','status')->get();
							
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
                                            <input type="text" placeholder="3500" value="{{$arr['unit'][$val]}}">
                                        </div>
                                        @if($p->status=="1")
                                        <div class="form-group">
                                            <label>Packet</label>
                                            <input type="text" placeholder="20" value="{{$arr['quantity'][$val]}}">
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
										@php  $output = substr($name->person_name, 0, 2);  @endphp
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

@include("layouts.admin.footer")