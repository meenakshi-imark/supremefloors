@include("layouts.admin.header")
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
$(document).ready(function(){ 
		$('#addproducts').click(function(e) {  
		var numItems = $('.price').length;
		$("#append").append('<div class="row">'+
                        '<div class="col-lg-6">'+
                            '<div class="form-group form-select-group w-100">'+
                                '<label class="form-label">Product</label>'+
								'<select class="form-select pro-select1" aria-label="Default select example" name="product[]" required>'+
								 '<option value="">Select</option>'+
								 @foreach($products as $p)
                                    '<option value="{{$p->id}}">{{$p->product_name}}</option>'+
								@endforeach
                                '</select>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-lg-6">'+
                            '<div class="form-group">'+
                               '<label class="form-label">No. Packet</label>'+
                                '<input type="number"  id="quantity'+numItems+'" name="quantity[]" class="form-control quantity" placeholder="5"required>'+
                           '</div>'+
                        '</div>'+
                        '<div class="col-lg-6">'+
                            '<div class="form-group form-select-group w-100">'+
                                '<label class="form-label">Unit Price</label>'+
                                '<input type="text" name="unitprice[]" id="price'+numItems+'" class="form-control price" placeholder="Unit Price"required> '+
                            '</div>'+
                        '</div>'+
                        '<div class="col-lg-6">'+
                            '<div class="form-group">'+
                                '<label class="form-label">Sub Total</label>'+
                                '<input type="text" id="totalprice'+numItems+'" name="price[]" name="subtotal" class="form-control totalprice" placeholder="Sub Total"required>'+
                            '</div>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<a id="addproducts"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Product</a>'+
                        '</div>'+
                    '</div>');  
    });
$(document).on('change', '.pro-select1', function() {
  var pid = $(this).val();
  var numItems = $('.price').length;
  var classname = numItems-1 ;
  var newclass = "#price"+classname;
  var quantity = "#quantity"+classname;
  var totalprice = "#totalprice"+classname;	 
  $.ajax({
         url: "/get-price",
         type: 'GET',
         data: { pid : pid },
	     success:function(data){
			$(newclass).attr("value", '$'+data); 
		}
        });	
		
  $(quantity).on("keyup change", function(e) {

    // $(".total1").val(sum);
	
    var price = $(newclass).val();
    var quantity =   this.value;
	 $.ajax({
            url: "/total-price",
            type: 'GET',
            data: { price : price,quantity:quantity },
			success:function(data){
			 $(totalprice).attr("value", '$'+data);
				var sum = 0;
				$("input[class *= 'totalprice']").each(function(){
					var avoid = "$";
					var value = $(this).val();
					// var price1 = $('#totalprice').val();
					var newval = value.replace(avoid, '');
					// var totalval=price1.replace(avoid, '');
					// var newtotal = parseInt(totalval, 10)+parseInt(newval,10);
					sum += +newval;
					// var total = sum+parseInt(totalval,10);
					// alert(total);
					$('#total_price').attr("value", sum);
					$('#final').attr("value", sum);
				});
			}
       }); 
	
});

});	
});	



</script>
<script src="{{asset('admin/js/append.js')}}"></script> 
<main class="content-wrapper">
    <div class="container-fluid">

        <div class="box-shadow role">

            <div class="main-heading">
                <h1>
                    Create Release Order
                </h1>
                <p>
                    This segment is to Create a Release Order. Release order is required to make a reservation.
                </p>
            </div>
			@if(session()->has('success'))
                 <div class="alert alert-success alert-dismissible fade show" role="alert">
                         <strong>Success!</strong> {{session()->get('success')}}
                         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                       </div>
                 @endif 
                 @if(session()->has('error'))
                 <div class="alert alert-danger alert-dismissible fade show" role="alert">
                         <strong>Error!</strong> {{session()->get('error')}}
                         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                       </div>
                 @endif 

            <div class="form mw-100">
                <form method="POST" action="/update-ro">
				@csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Release Order Number</label>
                                <input type="number" class="form-control" placeholder="5954484" name="orderid" value="{{$orders->order_id}}">
								<input type="hidden" name="id" value="{{$orders->id}}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Estimate Installation</label>
                                <input type="date" name="installation_date"class="form-control" placeholder="30-05-2022" value="{{$orders->estimate_date}}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                     <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Key</label>
                                <input type="text" name="key"class="form-control" value="{{$orders->ro_key}}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-select-group w-100">
                                <div class="with-radio">
                                    <label class="form-label">Role</label>
                                </div>
                                <div class="search-it">
                                    <i class="la la-search"></i>
                                    <select class="form-select" aria-label="Default select example" name="roles" required>
                                        <option value="Sales Agent"  @if($orders->role=="Sales Agent") selected @endif>Sales Agent</option>
                                        <option value="Sales Agent1" @if($orders->role=="Sales Agent1") selected @endif>Sales Agent1</option>
                                        <option value="Sales Agent2" @if($orders->role=="Sales Agent2") selected @endif>Sales Agent2</option>
                                        <option value="Sales Agent3" @if($orders->role=="Sales Agent3") selected @endif>Sales Agent3</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                     <div class="col-lg-6">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Company Name</label>
                                <select class="form-select" aria-label="Default select example" name="company_name"required>
                                    <option value="">Select</option>
									@foreach($company as $co)
                                    <option value="{{$co->id}}" @if($orders->company_id==$co->id) selected @endif>{{$co->company_name}}</option>
									@endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-select-group w-100">
                                <div class="with-radio">
                                    <label class="form-label">Sales Agent/Owner</label>
                                </div>
                                <div class="search-it">
                                    <i class="la la-search"></i>
                                    <select class="form-select" aria-label="Default select example" name="owner" required>
                                        <option value="">Select</option>
										@foreach($users as $user)
                                        <option value="{{$user->id}}" @if($orders->owner==$user->id) selected @endif>{{$user->name}}</option>
										@endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Mobile Phone</label>
                                <input type="number" class="form-control" placeholder="26516515623" name="phonenumber" value="{{$orders->phone_number}}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Site Address</label>
                                <input type="text" class="form-control" placeholder="Site Address"  id="address" name="siteaddress" value="{{$orders->site_address}}">
                            </div>
							<div id="map"></div>
							@if($orders->site_address==NULL)
							@php $address = "Canberra Community Club"; @endphp
							@else
							@php $address = $orders->site_address; @endphp
							@endif
							<iframe id="addressmap"src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBIipfS2ZXDWqKMdgRqu5H-U_-p6oV0Ako&q={{$address}}" width="100%" height="472" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Area to Install</label>
                                <input type="text" class="form-control" placeholder="Area to Install" name="areatoinstall"  value="{{$orders->area}}">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label">Floor Size</label>
                                <input type="number" class="form-control" placeholder="25" name="floorsize"  value="{{$orders->floor_size}}">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Unit</label>
                                <select class="form-select" aria-label="Default select example" name="unitsize" >
                                    <option value="square feet" @if($orders->unit=="square feet") selected @endif>Square feet</option>
                                    <option value="square meter" @if($orders->unit=="5 Square Meter") selected @endif>Square meter</option>
                                </select>
                            </div>
                        </div>
                    </div>
					
					@if($orders->image!=null)
                       


                       <div class="row" id="imghide">
                           <div class="col-12">
                               <div class="form-group user-img" style="height:153px;width:153px">
                               <a href="#" id="hideimg" data-id="{{$orders->id}}"><i class="fa fa-times"></i></a>
                               <img src="{{asset('uploads/'.$orders->image)}}">
                               </div>
                           </div>
                       </div>
                      @endif
                       
                       @if($orders->image!=null)
                       @php $style="display:none"; @endphp
                       @else
                       @php $style="display:block"; @endphp
                       @endif
                    <div class="row" id="imgshow" style="{{$style}}">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Photo</label>

                                  <div class="upload">
                                    <input type="file" name="image" class="form-control" placeholder="" onchange="readURL(this);">
                                    <div class="upload-txt">
                                    <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                    <p>Click here or drag and drop files to upload</p>
									<img id="blah" src="#" alt="your image" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                        <div class="col-12">
                            <ul class="readit">
                                <li><span>Photo requirement:</span> Maximum 500 KB</li>
                                <li><span>Format accepted:</span> PNG & JPEG</li>
                            </ul>
                        </div>
                    </div>
                    </div>

                    <div class="row align-center mt-4">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Lift Level</label>
                                <input type="number" name="liftlevel"class="form-control" placeholder="8" value="{{$orders->lift_level}}">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <div class="chooseing">
                                    <label class="form-label">H/S:</label>
                                    <span>
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="hs" value="yes" @if($orders->hs=="yes") checked @endif>
                                            <span>Yes</span>
											</label>
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="hs" value="no" @if($orders->hs=="no") checked @endif>
                                            <span>No</span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <div class="chooseing">
                                    <label class="form-label">C/D:</label>
                                    <span>
                                        <label class="form-check-label cd">
                                            <input class="form-check-input" type="radio" name="cd" value="yes"  @if($orders->cs=="yes") checked @endif>
                                            <span>Yes</span>
                                        </label>
                                        <label class="form-check-label cd">
                                            <input class="form-check-input" type="radio" name="cd" value="no"  @if($orders->cs=="no") checked @endif>
                                            <span>No</span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
					@for($i=0;$i<count($arr['products']);$i++)
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Product</label>
								<select class="form-select pro-select" aria-label="Default select example" name="product[]" required>
								 <option value="">Select</option>
								 @foreach($products as $p)
                                    <option value="{{$p->id}}" @if($p->id== $arr['products'][$i]) selected @endif>{{$p->product_name}}</option>
								@endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">No. Packet</label>
                                <input type="number" id="quantity" name="quantity[]" class="form-control" placeholder="5" value="{{$arr['product_qty'][$i]}}"required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Unit Price</label>
                                <input type="text" name="unitprice[]" id="price" class="form-control" placeholder="Unit Price" required value="${{$arr['unit_price'][$i]}}"> 
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Sub Total</label>
                                <input type="text" id="totalprice" name="price[]" name="subtotal" class="form-control totalprice" placeholder="Sub Total" required value="${{$arr['unit_price'][$i]}}">
                            </div>
                        </div>
                       
                    </div>
					@endfor
					
					 <div class="form-group">
                            <a id="addproducts"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Product</a>
                        </div>
					<div id="append">
						
					</div>
					@for($i=0;$i<count($arr1['skirting']);$i++)
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Skirting</label>
                                <input type="text" name="skirting[]" class="form-control" placeholder="Enter Skirting" value="{{$arr1['skirtingqty'][$i]}}"> 
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">No. Packet</label>
                                <input type="number" class="form-control" name="skirtingqty[]" placeholder="5" value="${{$arr1['skirtingqty'][$i]}}">
                            </div>
                        </div>
                    </div>
					@endfor
                    <div class="form-group">
                     <a id="addskirting"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Skirting</a>
                    </div>
					<div id="appendskirting">
						
					</div>

                    <hr>
					<div class="accordion" id="accordionExample">
					  <div class="accordion-item">
						   <label class="form-label d-flex align-items-center">
							<input type="checkbox" class="form-check-input mt-0"  data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" @if($arr2['end'][0]=="yes") checked @endif>
							<span>End</span>
							</label>
						<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
						  @for($i=0;$i<count($arr2['end_qty']);$i++)
						  <div class="row">
							<div class="col-lg-6">
							<div class="form-group form-select-group w-100">
								<label class="form-label">Colour</label>
								<input type="text" name="endcolour[]" class="form-control" placeholder="Enter colour" value="{{$arr2['end_color'][$i]}}"> 
							</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
								<label class="form-label">Quantity</label>
								<input type="number" name="endqty[]"class="form-control" placeholder="5" value="{{$arr2['end_qty'][$i]}}">
								</div>
							</div>
							</div>
							@endfor
							<div class="form-group">
									<a id="appendend"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add End</a>
							</div>
							<div id="appendend_form">
								
							</div>
						</div>
					  </div>
					   <hr>
					  
				  <div class="accordion-item">
						<label class="form-label d-flex align-items-center">
							<input type="checkbox" class="form-check-input mt-0"  data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" @if($arr3['contact'][0]=="yes") checked @endif>
							<span>Contact</span>
							</label>
					<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
					  <div class="accordion-body">
					   @for($i=0;$i<count($arr3['contact_color']);$i++)
						<div class="row">
                        <div class="col-lg-6">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Colour</label>
                               <input type="text" name="contactcolour[]" class="form-control" placeholder="Enter colour" value="{{$arr3['contact_color'][$i]}}"> 
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Quantity</label>
                                <input type="number" name="contactqty[]"class="form-control" placeholder="5" value="{{$arr3['contact_qty'][$i]}}">
                            </div>
                        </div>
                    </div>
					@endfor
                    <div class="form-group">
                     <a id="appendcontact"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Contact</a>
                    </div>
					<div id="append_contact">
								
					</div>
					  </div>
					</div>
				</div> <hr>
	
					  <div class="accordion-item">
						  <label class="form-label d-flex align-items-center">
							<input type="checkbox" class="form-check-input mt-0"  data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree" @if($arr4['adaptor'][0]=="yes") checked @endif>
							 <span>Adaptor</span>
							</label>
						<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
						  <div class="accordion-body">
						  @for($i=0;$i<count($arr4['adaptor_color']);$i++)
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group form-select-group w-100">
										<label class="form-label">Colour</label>
										<input type="text" name="adaptorcolour[]" class="form-control" placeholder="Enter colour"value="{{$arr4['adaptor_color'][$i]}}"> 
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label class="form-label">Quantity</label>
										<input type="number" name="adaptorqty[]"class="form-control" placeholder="5"value="{{$arr4['adaptor_qty'][$i]}}">
									</div>
								</div>
							</div>
							@endfor
							<div class="form-group">
							<a id="appendadaptor"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Adaptor</a>
							</div>
							<div id="append_adaptor">
								
							</div>
						  </div>
						</div>
					  </div> <hr>
					  <div class="accordion-item">
						  <label class="form-label d-flex align-items-center">
							<input type="checkbox" class="form-check-input mt-0"  data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour" @if($arr5['lcapping'][0]=="yes") checked @endif>
							 <span>L - Capping</span>
							</label>
						<div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
						  <div class="accordion-body">
						  
						   @for($i=0;$i<count($arr5['lcapping_color']);$i++)
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group form-select-group w-100">
										<label class="form-label">Colour</label>
										<input type="text" name="cappingcolour[]" class="form-control" placeholder="Enter colour"value="{{$arr5['lcapping_color'][$i]}}"> 
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label class="form-label">Quantity</label>
										<input type="number"name="cappingqty[]" class="form-control" placeholder="5"value="{{$arr5['lcapping_qty'][$i]}}">
									</div>
								</div>
							</div>
							@endfor
							
							<div class="form-group">
								<a id="appendcapping"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Adaptor</a>
							</div>
							<div id="append_capping">
								
							</div>
						  </div>
						</div>
					  </div><hr>
					  <div class="accordion-item">
						  <label class="form-label d-flex align-items-center">
							<input type="checkbox" class="form-check-input mt-0"  data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive" @if($orders->plywood=="yes") checked @endif>
							 <span>Plywood</span>
							</label>
						<div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
						  <div class="accordion-body">
						  
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group form-select-group w-100">
										<label class="form-label">Quantity</label>
										<input type="text" name="plywood_qty1" class="form-control" placeholder="5+1"value="{{$orders->plywood_qty}}"> 
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label class="form-label">Quantity</label>
										<input type="number"name="plywood_qty2" class="form-control" placeholder="3+1"value="{{$orders->plywood_qty2}}">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label class="form-label">Quantity</label>
										<input type="number"name="plywood_qty3" class="form-control" placeholder="2+1"value="{{$orders->plywood_qty3}}">
									</div>
								</div>
							</div>
						  </div>
						</div>
					  </div>
					 </div>
                    
                    <hr>
					@for($i=0;$i<count($arr6['corrugated']);$i++)
                    <div class="row row-cols-2 mt-5">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Corrugated Paper</label>
                                <input type="number" name="paper[]"class="form-control" placeholder="1"value="{{$arr6['corrugated'][$i]}}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Quantity</label>
                                <input type="number"name="paperqty[]" class="form-control" placeholder="5"value="{{$arr6['corrugated_qty'][$i]}}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Plastic</label>
                                <input type="number" name="plastic[]" class="form-control" placeholder="4"value="{{$arr6['plastic'][$i]}}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Quantity</label>
                                <input type="number" name="plasticqty[]" class="form-control" placeholder="5"value="{{$arr6['pastic_qty'][$i]}}">
                            </div>
                        </div>

                    </div>
					@endfor
					
                    <div class="col-12">
                          <div class="form-group">
                              <a id="appendpaper"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Item</a>
                          </div>
                     </div>
					<div id="append_paper">
								
					</div>
                    <hr>
					
                    <div class="total-detail mt-5">
                         <div class="form-group" style="margin-bottom: 10px;">
						 <label class="form-label">Total:</label>
						 <input type="text" class="form-control"id="total_price" name="totalprice" value="{{$orders->total}}">
						 </div>
                        <div class="form-group">
                            <label class="form-label">Rebates:</label>
                            <input type="text" name="rebates" id="rebates" class="form-control" placeholder="10%" value="{{$orders->rebates}}">
                        </div>
						<div class="form-group" style="margin-bottom: 10px;">
						 <label class="form-label">Final amount without GST:</label>
						 <input type="text" class="form-control"id="final" name="final" style="max-width: 126px;" value="{{$orders->final_amount}}">
						 </div>
                        
                    </div>

                    <hr>

                    <div class="row row-cols-12 mt-4">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Remarks</label>
                                <input type="text" class="form-control" name="remarks" placeholder="Remarks" value="{{$orders->remarks}}">
                            </div>
                        </div>
                    </div>

					
		
                    <div class="d-flex btn-grid">
						 <button type="submit" class="btn">Update</button>
                        <button type="reset" class="btn btn-white">Clear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCtZNVT318F-HYweBrZWJBM5k0KgSiMDKc&callback=initMap&libraries=places&v=weekly" defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<style>
#map {
 height: 400px;;
}
#infowindow-content .title {
  font-weight: bold;
}

#infowindow-content {
  display: none;
}

#map #infowindow-content {
  display: inline;
}
.user-img { position: relative;width:150px; }
.user-img img { display: block;}
.user-img .fa-download { position: absolute; bottom:0; left:0; }
.fa-times:before {
    color: red;
}

</style>
<script>
$("#hideimg").click(function() {
   
 $("#imghide").hide();
 $("#imgshow").show();
 $("#hidetxt").show();
 var id = $('#hideimg').attr("data-id");
 $.ajax({
	 url: "/delete_roimg",
     type:"GET",
     data:{
     "_token": "{{ csrf_token() }}",
	  id:id,
      },
	  
})
});
 $(document).ready(function() {
$("#map").hide();
$('#address').on("input", function() {
    $("#addressmap").hide();
    $("#map").show();
});
});     
  function initMap() {
  const map = new google.maps.Map(document.getElementById("map"), {
      center: { lat: 40.749933, lng: -73.98633 },
    zoom: 13,
    mapTypeControl: false,
  });
  const card = document.getElementById("pac-card");
  const input = document.getElementById("address");
  const options = {
    fields: ["formatted_address", "geometry", "name"],
    strictBounds: false,
    types: ["establishment"],
  };



  const autocomplete = new google.maps.places.Autocomplete(input, options);

  // Bind the map's bounds (viewport) property to the autocomplete object,
  // so that the autocomplete requests use the current map bounds for the
  // bounds option in the request.
  autocomplete.bindTo("bounds", map);

  const infowindow = new google.maps.InfoWindow();
  const infowindowContent = document.getElementById("infowindow-content");

  infowindow.setContent(infowindowContent);

  const marker = new google.maps.Marker({
    map,
    anchorPoint: new google.maps.Point(0, -29),
  });

  autocomplete.addListener("place_changed", () => {
    infowindow.close();
    marker.setVisible(false);

    const place = autocomplete.getPlace();

    if (!place.geometry || !place.geometry.location) {
      // User entered the name of a Place that was not suggested and
      // pressed the Enter key, or the Place Details request failed.
      window.alert("No details available for input: '" + place.name + "'");
      return;
    }

    // If the place has a geometry, then present it on a map.
    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(17);
    }

    marker.setPosition(place.geometry.location);
    marker.setVisible(true);
    infowindowContent.children["place-name"].textContent = place.name;
    infowindowContent.children["place-address"].textContent =
      place.formatted_address;
    infowindow.open(map, marker);
  });

  // Sets a listener on a radio button to change the filter type on Places
  // Autocomplete.
  function setupClickListener(id, types) {
    const radioButton = document.getElementById(id);

    radioButton.addEventListener("click", () => {
      autocomplete.setTypes(types);
      input.value = "";
    });
  }

 
}

window.initMap = initMap;

</script>
<script>
$( document ).ready(function() {
$("#blah").hide();
});
function readURL(input) {
if (input.files && input.files[0]) {
var reader = new FileReader();
reader.onload = function (e) {
$("#blah").show();	
$('#blah')
.attr('src', e.target.result)
.width(150)
.height(200);
};

reader.readAsDataURL(input.files[0]);
}
}	
$(document).on("keyup change", ".totalprice", function() {
    var sum = 0;
    $("input[class *= 'totalprice']").each(function(){
		var avoid = "$";
		var value = $(this).val();
		var newval = value.replace(avoid, '');
        sum += +newval;
		// alert(sum);
		$('#total_price').attr("value", sum);
		$('#final').attr("value", sum);
    });
    // $(".total1").val(sum);
	 // var price = $('#totalprice').val();
	 
});
	
	
$('.pro-select').change(function(){ 
var pid = $(this).val();
  $.ajax({
            url: "/get-price",
            type: 'GET',
            data: { pid : pid },
			success:function(data){
			 $('#price').attr("value", '$'+data);
			}
          });
});	

$("#quantity").on("keyup change", function(e) {
    var price = $('#price').val();
    var quantity =   this.value;
	 $.ajax({
            url: "/total-price",
            type: 'GET',
            data: { price : price,quantity:quantity },
			success:function(data){
			 $('#totalprice').attr("value", '$'+data);
			 $('#total_price').attr("value", '$'+data);
			 $('#final').attr("value", '$'+data);

			}
       }); 
	
})
$(document).on("keyup", "#total_price", function() {
 var subtotal = $('#total_price').val();
$('#final').attr("value", '$'+subtotal);
});
$(document).on("keyup", "#rebates", function() {
 var subtotal = $('#total_price').val();
 var rebates = $('#rebates').val();
 var avoid = "$";
 var avoid1 = "-";
 var new_subtotal = subtotal.replace(avoid, '');
 var quotient = Math.floor(new_subtotal*rebates)/100; 
 var total = subtotal-parseFloat(quotient);

 
 // var val = parseInt(new_subtotal,10)+quotient;
$('#final').attr("value", '$'+total);
});
</script>
@include("layouts.admin.footer")