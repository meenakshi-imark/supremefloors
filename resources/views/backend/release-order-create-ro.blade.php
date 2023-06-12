@include("layouts.admin.header")
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
$(document).ready(function(){ 
		$('#addproducts').click(function(e) {  
		var numItems = $('.price').length;
		$("#append").append('<div class="row appenddiv">'+
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
                                '<input type="text"  id="quantity'+numItems+'" name="quantity[]" class="form-control quantity" placeholder="5"required>'+
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
						'<div class="form-group remove" style="margin-top:6%;">'+
                        '<a class="remove" style="text-align:left;"><i class="fa fa-minus-square" aria-hidden="true"></i> Remove Product</a>'+
						'</div>'+
                    '</div>');  
$('.remove').on('click', function () {
	$(this).closest('.appenddiv').remove();
});					
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
			<?php
			if (isset($_GET['quotation'])) {
			$quotation = DB::table('quotations')->where('id',$_GET['quotation'])->first();
			$q = (array) $quotation;
            $pid = explode(",",$quotation->product_id);
            $product = DB::table('products')->select('id','product_name')->whereIn('id',$pid)->get();
			}	
			else{
				$q['ro_number']="";
				$q['phone']="";
				$q['attention_to']="";
				$q['address']="";
				$q['due_date']="";
				$q['company']="";
                $product=[];
			}
			?>
            <div class="form mw-100">
                <form method="POST" action="/insert-release-order">
				@csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Release Order Number</label>
                                <input type="number" class="form-control" placeholder="5954484" name="orderid" value="{{$q['ro_number']}}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Estimate Installation</label>
                                <input type="date" name="installation_date"class="form-control" placeholder="30-05-2022" value="{{$q['due_date']}}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                         <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Key</label>
                                <input type="text" name="key"class="form-control" value="">
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
                                        <option value="Sales Agent">Sales Agent</option>
                                        <option value="Sales Agent1">Sales Agent1</option>
                                        <option value="Sales Agent2">Sales Agent2</option>
                                        <option value="Sales Agent3">Sales Agent3</option>
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
                                    <option value="{{$co->id}}"@if($q['company']==$co->id)selected @endif>{{$co->company_name}}</option>
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
                                        <option value="{{$user->id}}" @if($q['attention_to']==$user->id)selected @endif>{{$user->name}}</option>
										@endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                         <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Mobile Phone</label>
                                <input type="number" class="form-control" placeholder="26516515623" name="phonenumber" value="{{$q['phone']}}"required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Site Address</label>
                                <input type="text" class="form-control" placeholder="Site Address"  id="address" name="siteaddress" value="{{$q['address']}}">
								<div id="map" ></div>
								@if($q['address']==NULL)
								@php $address = "Canberra Community Club"; @endphp
								@else
								@php $address = $q['address']; @endphp
								@endif
                                <div class="map">
								    <iframe id="addressmap"src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBIipfS2ZXDWqKMdgRqu5H-U_-p6oV0Ako&q={{$address}}" width="100%" height="472" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Area to Install</label>
                                <input type="text" class="form-control" placeholder="Area to Install" name="areatoinstall">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label">Floor Size</label>
                                <input type="number" class="form-control" placeholder="25" name="floorsize">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Unit</label>
                                <select class="form-select" aria-label="Default select example" name="unitsize">
                                    <option value="square feet">Square feet</option>
                                    <option value="square meter">Square meter</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
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
                        <div class="col-12">
                            <ul class="readit">
                                <li><span>Photo requirement:</span> Maximum 500 KB</li>
                                <li><span>Format accepted:</span> PNG & JPEG</li>
                            </ul>
                        </div>
                    </div>

                    <div class="row align-center mt-4">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Lift Level</label>
                                <input type="number" name="liftlevel"class="form-control" placeholder="8">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <div class="chooseing">
                                    <label class="form-label">H/S:</label>
                                    <span>
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="hs" value="yes">
                                            <span>Yes</span>
											</label>
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="hs" value="no">
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
                                            <input class="form-check-input" type="radio" name="cd" value="yes">
                                            <span>Yes</span>
                                        </label>
                                        <label class="form-check-label cd">
                                            <input class="form-check-input" type="radio" name="cd" value="no">
                                            <span>No</span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(count($product)<=0)                      
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Product</label>
								<select class="form-select pro-select" aria-label="Default select example" name="product[]" required>
								 <option value="">Select</option>
								 @foreach($products as $p)
                                    <option value="{{$p->id}}">{{$p->product_name}}</option>
								@endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">No. Packet</label>
                                <input type="text" id="quantity" name="quantity[]" class="form-control" placeholder="5" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Unit Price</label>
                                <input type="text" name="unitprice[]" id="price" class="form-control" placeholder="Unit Price" required> 
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Sub Total</label>
                                <input type="text" id="totalprice" name="price[]" name="subtotal" class="form-control totalprice" placeholder="Sub Total" required>
                            </div>
                        </div>
                    </div>
                    @else
                    
                    @for($i=0;$i<count($product);$i++) 
                    <div class="row q_product{{$i}}">
                        <div class="col-lg-6">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Product</label>
								<select class="form-select pro-select" aria-label="Default select example"required>
								 <option value="">Select</option>
								 @foreach($products as $p)
                                    <option value="{{$p->id}}" @if($product[$i]->id==$p->id) selected @endif>{{$p->product_name}}</option>
								@endforeach
                                </select>
                                <input type="hidden" name="product[]" value="{{$p->id}}">
                            </div>
                        </div>
                        <?php 
                        $qty = explode(",",$quotation->quantity);
                        $unit_price = explode(",",$quotation->unit_price);
                        $amount = explode(",",$quotation->amount);
                        //print_r($qty);
                        ?>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">No. Packet</label>

                                <input type="text" id="quantity" name="quantity[]" class="form-control q_qty{{$i}}" onkeyup="q_qty({{$i}})" placeholder="5" value="{{$qty[$i]}}"required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Unit Price</label>
                                <input type="text" name="unitprice[]" id="price" class="form-control q_unit{{$i}}"  placeholder="Unit Price" value="{{$unit_price[$i]}}"required> 
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Sub Total</label>
                                <input type="text" id="totalprice" name="price[]" name="subtotal" class="form-control totalprice q_sub{{$i}}" placeholder="Sub Total" value="{{$amount[$i]}}"required>
                            </div>
                        </div>
                    </div>
                   
                    <a class="remove_product product_remove{{$i}}" pid="{{$i}}" style="text-align:left;color: #13582E;font-weight: 500;"><i class="fa fa-minus-square" aria-hidden="true"></i> Remove Product</a>
					
                    @endfor
                    @endif

					<div id="append">
						
					</div>
					
                        <div class="form-group">
                            <a id="addproducts"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Product</a>
                        </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Skirting</label>
                                <input type="text" name="skirting[]" class="form-control" placeholder="Enter Skirting"> 
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">No. Packet</label>
                                <input type="text" class="form-control" name="skirtingqty[]" placeholder="5">
                            </div>
                        </div>
                        <div class="form-group">
                            <a id="addskirting"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Skirting</a>
                        </div>
                    </div>
					<div id="appendskirting">
						
					</div>

                    <hr>
					<div class="accordion" id="accordionExample">
					  <div class="accordion-item">
						   <label class="form-label d-flex align-items-center">
							<input type="checkbox" class="form-check-input mt-0"  data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
							<span>End</span>
							</label>
						<div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
						  <div class="row">
							<div class="col-lg-6">
							<div class="form-group form-select-group w-100">
								<label class="form-label">Colour</label>
								<input type="text" name="endcolour[]" class="form-control" placeholder="Enter colour"> 
							</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
								<label class="form-label">Quantity</label>
								<input type="number" name="endqty[]"class="form-control" placeholder="5">
								</div>
							</div>
								<div class="form-group">
									<a id="appendend"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add End</a>
								</div>
							</div>
							<div id="appendend_form">
								
							</div>
						</div>
					  </div>
					   <hr>
					  
				  <div class="accordion-item">
						<label class="form-label d-flex align-items-center">
							<input type="checkbox" class="form-check-input mt-0"  data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
							<span>Contact</span>
							</label>
					<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
					  <div class="accordion-body">
						<div class="row">
                        <div class="col-lg-6">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Colour</label>
                               <input type="text" name="contactcolour[]" class="form-control" placeholder="Enter colour"> 
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Quantity</label>
                                <input type="number" name="contactqty[]"class="form-control" placeholder="5">
                            </div>
                        </div>
                        <div class="form-group">
                            <a id="appendcontact"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Contact</a>
                        </div>
                    </div>
					<div id="append_contact">
								
					</div>
					  </div>
					</div>
				</div> <hr>
	
					  <div class="accordion-item">
						  <label class="form-label d-flex align-items-center">
							<input type="checkbox" class="form-check-input mt-0"  data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
							 <span>Adaptor</span>
							</label>
						<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
						  <div class="accordion-body">
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group form-select-group w-100">
										<label class="form-label">Colour</label>
										<input type="text" name="adaptorcolour[]" class="form-control" placeholder="Enter colour"> 
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label class="form-label">Quantity</label>
										<input type="number" name="adaptorqty[]"class="form-control" placeholder="5">
									</div>
								</div>
								<div class="form-group">
									<a id="appendadaptor"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Adaptor</a>
								</div>
							</div>
							<div id="append_adaptor">
								
							</div>
						  </div>
						</div>
					  </div> <hr>
					  <div class="accordion-item">
						  <label class="form-label d-flex align-items-center">
							<input type="checkbox" class="form-check-input mt-0"  data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
							 <span>L - Capping</span>
							</label>
						<div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
						  <div class="accordion-body">
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group form-select-group w-100">
										<label class="form-label">Colour</label>
										<input type="text" name="cappingcolour[]" class="form-control" placeholder="Enter colour"> 
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label class="form-label">Quantity</label>
										<input type="number"name="cappingqty[]" class="form-control" placeholder="5">
									</div>
								</div>
								<div class="form-group">
									<a id="appendcapping"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Adaptor</a>
								</div>
							</div>
							<div id="append_capping">
								
							</div>
						  </div>
						</div>
					  </div><hr>
					  <div class="accordion-item">
						  <label class="form-label d-flex align-items-center">
							<input type="checkbox" class="form-check-input mt-0"  data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
							 <span>Plywood</span>
							</label>
						<div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
						  <div class="accordion-body">
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label class="form-label">Quantity</label>
										<input type="number"name="plywood_qty1" class="form-control" placeholder="5+1">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label class="form-label">Quantity</label>
										<input type="number"name="plywood_qty2" class="form-control" placeholder="3+1">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label class="form-label">Quantity</label>
										<input type="number"name="plywood_qty3" class="form-control" placeholder="2+1">
									</div>
								</div>
							</div>
						  </div>
						</div>
					  </div>
					 </div>
                    
                    <hr>
                    <div class="row row-cols-2 mt-lg-5">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Corrugated Paper</label>
                                <input type="number" name="paper[]"class="form-control" placeholder="1">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Quantity</label>
                                <input type="number"name="paperqty[]" class="form-control" placeholder="5">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Plastic</label>
                                <input type="number" name="plastic[]" class="form-control" placeholder="4">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Quantity</label>
                                <input type="number" name="plasticqty[]" class="form-control" placeholder="5">
                            </div>
                        </div>
                        <!--div class="col">
                            <div class="form-group">
                                <label class="form-label">Plywood</label>
                                <input type="number" name="plywood[]"class="form-control" placeholder="5">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Quantity</label>
                                <input type="text" name="plywoodqty[]" class="form-control" placeholder="5">
                            </div>
                        </div-->
                        <!--div class="col-12">
                            <div class="form-group">
                                <a id="appendpaper"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Item</a>
                            </div>
                        </div-->
                    </div>
					<div id="append_paper">
								
					</div>
                    <hr>
				
                    <div class="prices total-detail">
                        <div class="s-total d-flex justify-content-between">
                            <p><span>Total</span></p>
                            <input type="text" class="form-control subtotal-ro" id="total_price" name="totalprice" value="" placeholder="total">
                        </div>
                

                        <div class="s-total d-flex justify-content-between">
                                <label class="form-label">Rebates:</label>
                            <input type="text" class="form-control subtotal-ro" name="rebates" id="rebates" value="" placeholder="Rebates">
                        </div>
                        <div class="s-total d-flex justify-content-between">
                            <p><span>Final amount without GST:</span></p>
                            <input type="text" class="form-control subtotal-ro" name="final" id="final" value="" placeholder="Final Total" required>
                        </div>
                    </div>
                    <hr>

                    <div class="row row-cols-12 mt-4">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Remarks</label>
                                <input type="text" class="form-control" name="remarks" placeholder="Remarks">
                            </div>
                        </div>
                    </div>

					
		
                    <div class="d-flex btn-grid">
						 <button type="submit" class="btn">Create</button>
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

.form-control.subtotal-ro {
    width: 120px;
    margin-top: 12px;
}

</style>
<script>
$(document).ready(function() {
    $('.changetype').attr('type', 'number');
});

$('.remove_product').on('click', function () {
var pid = $(this).attr("pid");
$(".q_product"+pid).remove();
$(".product_remove"+pid).remove();
var sum = 0;
$("input[class *= 'totalprice']").each(function(){
var avoid = "$";
var value = $(this).val();
var newval = value.replace(avoid, '');
sum += +newval;
$('#total_price').attr("value", sum);
});

});


function q_qty(id){
var q_unitprice = $(".q_unit"+id).val();
var q_quantity= $(".q_qty"+id).val();
var final_sub = q_unitprice*q_quantity;
$('.q_sub'+id).attr("value", '$'+final_sub);
var sum = 0;
$("input[class *= 'totalprice']").each(function(){
var avoid = "$";
var value = $(this).val();
var newval = value.replace(avoid, '');
sum += +newval;
$('#total_price').attr("value", sum);

});

}
$(document).ready(function() {
var sum = 0;
$("input[class *= 'totalprice']").each(function(){
var avoid = "$";
var value = $(this).val();
var newval = value.replace(avoid, '');
sum += +newval;
$('#total_price').attr("value", sum);
$('#final').attr("value", sum);
});
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
 var total = new_subtotal-parseFloat(quotient);

 
 // var val = parseInt(new_subtotal,10)+quotient;
$('#final').attr("value", '$'+total);
});
</script>
@include("layouts.admin.footer")