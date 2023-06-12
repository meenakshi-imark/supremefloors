@include("layouts.admin.header")
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<style>
a#remove {
	text-align:left !important;
}
</style>
<script>
	$(document).ready(function(){  
	 $('#addmore').click(function(e) {  
	 var numItems = $('.price').length;
     $("#append").append('<div class="row row-cols-xl-4 row-cols-md-3 row-cols-1 appenddiv" >'+
                        '<div class="col">'+
                            '<div class="form-group form-select-group w-100">'+
                                '<label class="form-label">Product / Job Quoted*</label>'+
								'<select class="form-select pro-select1 "  aria-label="Default select example" name="product[]" id="product'+numItems+'" required>'+
									'<option value="">Select</option>'+
									@foreach($products as $p)
                                    '<option value="{{$p->id}}">{{$p->product_name}}</option>'+
									@endforeach
									'</select>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col">'+
                            '<div class="form-group">'+
                                '<label class="form-label">Quantity*</label>'+
                                '<input type="number" id="quantity'+numItems+'" name="quantity[]" class="form-control quantity" placeholder="1" required>'+
                            '</div>'+
                        '</div>'+
						'<div class="col">'+
                            '<div class="form-group form-select-group w-100">'+
                                '<label class="form-label">Unit*</label>'+
                                '<select class="form-select" aria-label="Default select example" name="unit[]" id="unit'+numItems+'" required>'+
                                    '<option value="No Unit">No Unit</option>'+
                                    '<option value="Square Feet">Square Feet</option>'+
                                    '<option value="Square Meter">Square Meter</option>'+
                                '</select>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col">'+
                            '<div class="form-group">'+
                                '<label class="form-label">Unit Price*</label>'+
                                '<input type="text" class="form-control price" value="" id="price'+numItems+'"name="unitprice[]"  required>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col">'+
                            '<div class="form-group">'+
                                '<label class="form-label">Amount*</label>'+
                                '<input type="text" id="totalprice'+numItems+'" name="price[]" class="form-control totalprice" placeholder="$1000.00"  required >'+
                            '</div>'+
                        '</div>'+
						  '<div class="col">'+
                            '<div class="form-group">'+
                                '<label class="form-label">Services</label>'+
                                '<input type="text" id="services'+numItems+'" class="form-control services" placeholder="" name="services[]">'+
                            '</div>'+
                        '</div>'+
                        '<div class="col">'+
                            '<div class="form-group">'+
                                '<label class="form-label">Service Price</label>'+
                                '<input type="text" id="serviceprice'+numItems+'" class="form-control serviceprice" placeholder="" name="serviceprice[]">'+
                            '</div>'+
                        '</div>'+
						'<div class="form-group remove" style="margin-top:6%;">'+
                        '<a class="remove" style="text-align:left;"><i class="fa fa-minus-square" aria-hidden="true"></i> Remove Product</a>'+
						'</div>'+
						'</div>');  
$('.remove').on('click', function () {
	$(this).closest('.appenddiv').remove();
});		

  
 /*Validation*/
    $("#product"+numItems).focus();
    $("#product"+numItems).blur(function () {
        var products_val = $("#product"+numItems).val();
        if (products_val.length == 0) {
            $("#product"+numItems).next('div.red').remove();
			$("#product"+numItems).addClass('red-border');
            $("#product"+numItems).after('<div class="red">Product is required</div>');
        } else {
            $(this).next('div.red').remove();
			$("#product"+numItems).removeClass('red-border');
            return true;
        }
    });
    $("#quantity"+numItems).blur(function () {
        var quantity_val = $("#quantity"+numItems).val();
        if (quantity_val.length == 0) {
            $("#quantity"+numItems).next('div.red').remove();
			$("#quantity"+numItems).addClass('red-border');
            $("#quantity"+numItems).after('<div class="red">Quantity is required</div>');
        } else {
            $(this).next('div.red').remove();
			$("#quantity"+numItems).removeClass('red-border');
            return true;
        }
    });
	
    $("#unit"+numItems).blur(function () {
        var unit_val = $("#unit"+numItems).val();
        if (unit_val.length == 0) {
            $("#unit"+numItems).next('div.red').remove();
			$("#unit"+numItems).addClass('red-border');
            $("#unit"+numItems).after('<div class="red">Unit is required</div>');
        } else {
            $(this).next('div.red').remove();
			$("#unit"+numItems).removeClass('red-border');
            return true;
        }
    });
	
    $("#price"+numItems).blur(function () {
        var unit_val = $("#price"+numItems).val();
        if (unit_val.length == 0) {
            $("#price"+numItems).next('div.red').remove();
			$("#price"+numItems).addClass('red-border');
            $("#price"+numItems).after('<div class="red">Unit Price is required</div>');
        } else {
            $(this).next('div.red').remove();
			$("#price"+numItems).removeClass('red-border');
            return true;
        }
    });
	
    $("#totalprice"+numItems).blur(function () {
        var unit_val = $("#totalprice"+numItems).val();
        if (unit_val.length == 0) {
            $("#totalprice"+numItems).next('div.red').remove();
			$("#totalprice"+numItems).addClass('red-border');
            $("#totalprice"+numItems).after('<div class="red">Amount is required</div>');
        } else {
            $(this).next('div.red').remove();
			$("#totalprice"+numItems).removeClass('red-border');
            return true;
        }
    });
	
    });  
	

$(document).on('change', '.pro-select1', function() {
  var pid = $(this).val();
  var numItems = $('.price').length;
  var classname = numItems-1 ;
  var newclass = "#price"+classname;
  var quantity = "#quantity"+classname;
  var totalprice = "#totalprice"+classname;	 
  var productname = $(this).find(":selected").text();
  var count_td=   $('.pname1').length+1;
  var serviceprice = "#serviceprice"+classname;	 
  var services = "#services"+classname;	 

  $(serviceprice).on("keyup", function(e) {
  var service1 = $(serviceprice).val();
    if(service1 != ''){
        var serviceprice1 = service1;
    }else{
        var serviceprice1 = 0;
    }
    var gst = $('#gstval').val();
    if(gst!=''){
        var gstval = gst.replace('$','');
    }else{
        var gstval = 0;
    }
    var rebate =$('#rebatesval').val();
    if(rebate!=''){
        var rebateval = rebate.replace('$','');
        var rebatevalue = rebateval.replace('-','');
    }else{
        var rebatevalue = 0;
    }
  var totalprice_val = $("#total_price_new").val();
  var totalprice_val1 = $(totalprice).val();
  var avoid_sign = "$";
  var new_totalprice1 = totalprice_val1.replace(avoid_sign, '');
  var totalprice_new = parseInt(serviceprice1,10)+parseInt(new_totalprice1,10);


  $('td.qty1-total'+count_td+'').html('$'+totalprice_new);
  var sum = 0;
        $('td.ptotal').each(function(){
            var avoid = "$";
    
            var currentRow=$(this).closest("tr"); 
            var value=currentRow.find("td:eq(3)").text();
            var newval = value.replace(avoid, '');
            if(newval.trim().length == 0){
                var newval = '0';
            }
            sum += +newval;   
            $('#total_price_new').attr("value", '$'+sum);
            $('#total_price_new').val('$'+sum);
            
            var main_totalprice = sum+parseInt(gstval)+parseInt(rebatevalue);
           
            $('#total').attr("value", '$'+main_totalprice);
            $('#total').val('$'+main_totalprice);
        });
 
});	
  $.ajax({
         url: "/get-price",
         type: 'GET',
         data: { pid : pid },
	     success:function(data){
			$(newclass).attr("value", '$'+data); 
			$(".bill").show();
			$("#append-products").append('<tr>'+
                                        '<td class="pname1">'+productname+'</td>'+
                                        '<td class="qty'+count_td+'"></td>'+
                                        '<td class="qty1-price'+count_td+'"></td>'+
                                        '<td class="qty1-total'+count_td+' ptotal"></td>'+
                                    '</tr>');
		}
        });	
		
$(services).on("keyup", function(e) {
var services_val =   this.value;
$("td.pname1").html(productname+"/"+services_val)
})
	
$(totalprice).on("keyup", function(e) {
    // custom
    var serviceprice1 = $(serviceprice).val();
    if(serviceprice1==""){
        var totalservice = 0;
    }
    else{
        var totalservice = serviceprice1;
    }
    var gst = $('#gstval').val();
    if(gst!=''){
        var gstval = gst.replace('$','');
    }else{
        var gstval = 0;
    }
    var rebate =$('#rebatesval').val();
    if(rebate!=''){
        var rebateval = rebate.replace('$','');
        var rebatevalue = rebateval.replace('-','');
    }else{
        var rebatevalue = 0;
    }
    var totalprice_val =  this.value;

    if(totalprice_val!=""){
    var total_p = $('#total_price_new').val();
    var avoid = "$";
    var new_totalprice = totalprice_val.replace(avoid, '');
    var totalprice_new1 = parseInt(totalservice)+parseInt(new_totalprice);

    $('td.qty1-total'+count_td+'').html('$'+totalprice_new1);
    var new_totalp = total_p.replace(avoid, '');
}else{
        $('td.qty1-total'+count_td+'').html('');
    }

    var sum = 0;
				// $("input[class *= 'totalprice']").each(function(){
				// 	var avoid = "$";
				// 	var value = $(this).val();
                $('td.ptotal').each(function(){
                    var avoid = "$";
                    var currentRow=$(this).closest("tr"); 
                    var value=currentRow.find("td:eq(3)").text();
                    var newval = value.replace(avoid, '');
                    if(newval.trim().length == 0){
                        var newval = '0';
                    }
					sum += +newval;  
                	$('#total_price_new').attr("value", '$'+sum);
					$('#total_price_new').val('$'+sum);
					// $('#total').attr("value", '$'+sum);
                    var main_totalprice = sum+parseInt(gstval)+parseInt(rebatevalue);
           
                    $('#total').attr("value", '$'+main_totalprice);
                    $('#total').val('$'+main_totalprice);
				});
});

$(quantity).on("keyup", function(e) {
    // $(".total1").val(sum);
	
    var price = $(newclass).val();
    var quantity =   this.value;
    var gst = $('#gstval').val();
    if(gst!=''){
        var gstval = gst.replace('$','');
    }else{
        var gstval = 0;
    }
    var rebate =$('#rebatesval').val();
    if(rebate!=''){
        var rebateval = rebate.replace('$','');
        var rebatevalue = rebateval.replace('-','');
    }else{
        var rebatevalue = 0;
    }
	$('td.qty'+count_td+'').html(quantity);
	$('td.qty1-price'+count_td+'').html(price);
    var numItems = $('.price').length;
	 $.ajax({
            url: "/total-price",
            type: 'GET',
            data: { price : price,quantity:quantity },
			success:function(data){
			 $(totalprice).attr("value", '$'+data);
			 $(totalprice).val('$'+data);
			  var t = $(totalprice).val().replace('$','');

              var service = $(serviceprice).val();
              if(service != ''){
                var servicetotal = parseInt(t)+parseInt(service);
              }else{
                var servicetotal = t;
              }
         
                  $('td.qty1-total'+count_td+'').html('$'+servicetotal);
				var sum = 0;
				// $("input[class *= 'totalprice']").each(function(){
				// 	var avoid = "$";
				// 	var value = $(this).val();
                    $('td.ptotal').each(function(){
                    var avoid = "$";
                    var currentRow=$(this).closest("tr"); 
                    var value=currentRow.find("td:eq(3)").text();
                
                    var newval = value.replace(avoid, '');
                    if(newval.trim().length == 0){
                        var newval = '0';
                    }
					sum += +newval;   
					$('#total_price_new').attr("value", '$'+sum);
					$('#total_price_new').val('$'+sum);
					// $('#total').attr("value", '$'+sum);
					// $('#total').val('$'+sum);
                    var main_totalprice = sum+parseInt(gstval)+parseInt(rebatevalue);
           
                    $('#total').attr("value", '$'+main_totalprice);
                    $('#total').val('$'+main_totalprice);
					
				});
			}
       }); 
	
});

$(newclass).on("keyup", function(e) {
    var price =   this.value.replace('$','');
    var quantity1 =   $(quantity).val();
    var serviceprice1 = $(serviceprice).val();
    if(serviceprice1 !=""){
        var service1 = serviceprice1;
    }
    else{
        var service1 = 0;
    }
    var gst = $('#gstval').val();
    if(gst!=''){
        var gstval = gst.replace('$','');
    }else{
        var gstval = 0;
    }
    var rebate =$('#rebatesval').val();
    if(rebate!=''){
        var rebateval = rebate.replace('$','');
        var rebatevalue = rebateval.replace('-','');
    }else{
        var rebatevalue = 0;
    }
    var unit_price = price*quantity1;
    var new_unit_price = (price*quantity1)+parseInt(service1);          
			var t = $(totalprice).val();  
            $('td.qty1-total'+count_td+'').html('$'+new_unit_price);     
			$(totalprice).attr("value", '$'+unit_price);
            $(totalprice).val('$'+unit_price);
              
				var sum = 0;
				// $("input[class *= 'totalprice']").each(function(){
				// 	var avoid = "$";
				// 	var value = $(this).val();
                $('td.ptotal').each(function(){
                    var avoid = "$";
                    var currentRow=$(this).closest("tr"); 
                    var value=currentRow.find("td:eq(3)").text();
                    var newval = value.replace(avoid, '');
            
                    if(newval.trim().length == 0){
                        var newval = '0';
                    }
					sum += +newval;   
					$('#total_price_new').attr("value", '$'+sum);
					$('#total_price_new').val('$'+sum);
					// $('#total').attr("value", '$'+sum);
					// $('#total').val('$'+sum);
                    var main_totalprice = sum+parseInt(gstval)+parseInt(rebatevalue);
           
                    $('#total').attr("value", '$'+main_totalprice);
                    $('#total').val('$'+main_totalprice);
                    $('td.qty1-price'+count_td+'').html('$'+price);
				});
	
});

});
});  

</script>


<main class="content-wrapper">
    <div class="container-fluid">
		@if (\Session::has('success'))
        <div class="alert alert-success">
            <ul>
                <li>{!! \Session::get('success') !!}</li>
            </ul>
        </div>
		@endif
         @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Error!</strong> {{session()->get('error')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
               </div>
         @endif 		
        <div class="box-shadow role">

            <div class="main-heading">
                <h1>
                    Quotation
                </h1>
                <p>
                    This segment is to update an Quotation in Supreme Floor ERP.
                </p>
            </div>

            <div class="form mw-100">
                <form method="POST" action="/update-quotation">
				@csrf
                    <div class="row row-cols-md-2 row-cols-1">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Quotation ID</label>
                                <input type="hidden" name="id" value="{{$quotations->id}}">
                                <input type="number" name="ro" class="form-control" placeholder="XXXXXX" value="{{$quotations->ro_number}}" id="ro" required readonly>
                            </div>
                        </div>
                        <div class="col">
						@php 
						$company = DB::table('suppliers')->select('id','company_name')->where('id',$quotations->company)->orderBy('company_name','ASC')->first();

						@endphp
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Owner / Company*</label>
                                <div class="search-it">
                                    <i class="la la-search"></i>
                                    <input type="text" class="form-control" placeholder="Search" id="owner" value="{{$company->company_name}}"  required>
                                    <input type="hidden" id ="ownerid" name="owner" value="{{$quotations->company}}"  required>
                                </div>
                                <div class="red" id="red"style="display:none">Invalid Owner/Company Name</div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Address*</label>
                                <input type="text" class="form-control" placeholder="Calle Socrates Nolasco #6-B, Ens. Naco" id="address"name="address" value="{{$quotations->address}}" required>
                            </div>
                        </div>
						<?php 
							if(count($suppliers)>0){
								$p_name =$suppliers[0]->name;
								}
							else{
								$p_name ="";
								}
						?>
                        <div class="col">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Attention To*</label>
                                <div class="search-it">
                                    <i class="la la-search"></i>
                                    <div class="search-it">
                                    <i class="la la-search"></i>
									<input type="text" class="form-control" id="search" name="attentionto" placeholder="Search" required value="{{$p_name}}" >
									<input id="supplierid" type="hidden" value="{{$quotations->attention_to}}" name="supplierid" >
                                </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Phone*</label>
                                <input type="number" class="form-control" placeholder="(450) 297-1007" name="phone" value="{{$quotations->phone}}" id="mobile"required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Email*</label>
                                <input type="email" class="form-control" placeholder="davidsmith89@gmail.com" name="email" value="{{$quotations->email}}" id="email"required>
                            </div>
                        </div>

                        <!--div class="col">
                            <div class="form-group">
                                <label class="form-label">Due Date</label>
                                <input type="date" class="form-control" placeholder="mm/dd/yy" name="duedate" id="duedate" value="{{$quotations->due_date}}"required>
                            </div>
                        </div-->
                        @php 
                        $installer = DB::table("users")->select('id','name')->where('role_id',"11")->orderBy('name','DESC')->get();
                        @endphp
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Installer</label>
                                <!--input type="text" class="form-control" placeholder="Installer" name="installer" id="installer" value="{{$quotations->installer}}"required-->
                                <select class="form-select" aria-label="Default select example" name="installer" id="installer">
                                        <option value="">Select</option>
										@foreach($installer as $install)
                                        <option value="{{$install->name}}" @if($quotations->installer==$install->name) selected @endif>{{$install->name}}</option>
										@endforeach
                                  </select>
                            </div>
                        </div>
                    </div>
					@for($i=0;$i<count($arr['products']);$i++)
                    <div class="row row-cols-xl-4 row-cols-md-3 row-cols-1">
                        <div class="col">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Product*</label>
                                <select class="form-select pro-select in_product{{$i}}" aria-label="Default select example" name="product[]"required>
                                    <option selected value="">Select</option>
									@foreach($products as $product)
                                    <option value="{{$product->id}}" @if($product->id== $arr['products'][$i]) selected @endif>{{$product->product_name}}</option>
									@endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Quantity*</label>
                                <input type="number" id="quantity" class="form-control in_quanity{{$i}} in_quanity" placeholder="1" name="quantity[]" value="{{$arr['quantity'][$i]}}" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Unit*</label>
                                <select class="form-select in_unit{{$i}}" aria-label="Default select example" name="unit[]" required>
                                    <option value="No Unit" @if($arr['unit'][$i]=="NoUnit") selected @endif>No Unit</option>
                                    <option value="Square Feet" @if($arr['unit'][$i]=="Square Feet") selected @endif>Square Feet</option>
                                    <option value="Square Meter" @if($arr['unit'][$i]=="Square Meter") selected @endif>Square Meter</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Unit Price*</label>
                                <input type="text" id="price" class="form-control in_price{{$i}}" placeholder="$500" name="unitprice[]" value="${{$arr['price'][$i]}}" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Amount*</label>
                                <input type="text" id="totalprice" class="form-control totalprice in_amount{{$i}}" placeholder="$500" name="price[]" value="${{$arr['amount'][$i]}}" required>
                            </div>
                        </div>
						<div class="col">
                            <div class="form-group">
                                <label class="form-label">Services</label>
                                <input type="text" id="services" class="form-control services" placeholder="" name="services[]" value="{{$arr['sevices'][$i]}}" >
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Service Price</label>
                                <input type="text" id="serviceprice" class="form-control serviceprice" placeholder="" name="serviceprice[]" value="{{$arr['serviceprice'][$i]}}" >
                            </div>
                        </div>
                    </div>
					@endfor
					
					<div id="append">
						
					</div>
                    <div class="form-group" style="width: fit-content;float: right;">
                        <a id="addmore"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Product</a>
                    </div>

                    <div class="row row-cols-md-2 row-cols-1" style="margin-top: 26px;">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Site Address</label>
                                <input type="text" class="form-control" placeholder="Site Address" value="{{$quotations->site_address}}"name="site_address" >
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Invoice Description</label>
                                <input type="text" class="form-control" placeholder="Invoice Description" name="description" value="{{$quotations->invoice}}">
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="bill" style="display:block;">

                        <h3>Billing</h3>

                        <div class="all-tabel table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Product / Job</th>
                                        <th>Est. Qty (5%) Sqf</th>
                                        <th>Unit Price ($)</th>
                                        <th>Amount ($)</th>
                                    </tr>
                                </thead>
                                <tbody id="append-products">
								@for($i=0;$i < count($arr['products']);$i++)
									<tr>
									@php  
									$products = DB::table('products')->where('id',$arr['products'][$i])->get();
                                    $price_service = (int)$arr['price'][$i]+(int)$arr['serviceprice'][$i];
									@endphp
                                       <td>{{$products[0]->product_name}}</td>
                                       <td>{{$arr['quantity'][$i]}}</td>
                                       <td>${{$arr['price'][$i]}}</td>
                                       <td class="qty-total ptotal">${{$quotations->subtotal}}</td>
									</tr>
								@endfor
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="prices total-detail pt-5">
                        <div class="s-total d-flex justify-content-between">
                            <p><span>Sub Total</span></p>
                            <input type="text" class="form-control" name="subtotal" id="total_price_new" value="${{$quotations->subtotal}}">
                        </div>
                        <div class="s-total d-flex justify-content-between">
                            <div class="form-group">
                                <label class="form-label">GST:</label>
                                <input type="number" class="form-control" value="{{$quotations->gst}}"id="gst" name="gst" placeholder="7%">
                            </div>
                            <input type="text" class="form-control" id="gstval">
                        </div>
                        <div class="s-total d-flex justify-content-between">
                            <div class="form-group">
                                <label class="form-label">Rebates:</label>
                                <input type="number" class="form-control" id="rebates" name="rebates" value="{{$quotations->rebates}}" placeholder="5%">
                            </div>
                            <input type="text" class="form-control" id="rebatesval">
                        </div>
                        <div class="s-total d-flex justify-content-between">
                            <p><span>Total:</span></p>
                            <input type="text" class="form-control" name="totalamt"id="total">
                        </div>
                    </div>

                   

                    <div class="d-flex btn-grid">
                        <button type="submit" class="btn">Update</button>
						<a href="" class="btn btn-white">Clear</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<style>
    .prices.total-detail input{
        
        width:120px;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
<script src="{{ asset('admin/js/validation.js') }}"></script>
<script type="text/javascript">
$(document).ready(function () {
/*Validation*/
var num = $('.in_quanity').length;
var quanity_in = num-2;
$(".in_quanity"+quanity_in).focus();
    $(".in_quanity"+quanity_in).blur(function () {
        var in_quanity = $(".in_quanity"+quanity_in).val();
        if (in_quanity.length == 0) {
            $(".in_quanity"+quanity_in).next('div.red').remove();
			$(".in_quanity"+quanity_in).addClass('red-border');
            $(".in_quanity"+quanity_in).after('<div class="red">Quantity is required</div>');
        } else {
            $(this).next('div.red').remove();
			$(".in_quanity"+quanity_in).removeClass('red-border');
            return true;
        }
    });
   
    $(".in_product"+quanity_in).blur(function () {
        var in_product = $(".in_product"+quanity_in).val();
        if (in_product.length == 0) {
            $(".in_product"+quanity_in).next('div.red').remove();
			$(".in_product"+quanity_in).addClass('red-border');
            $(".in_product"+quanity_in).after('<div class="red">Product is required</div>');
        } else {
            $(this).next('div.red').remove();
			$(".in_product"+quanity_in).removeClass('red-border');
            return true;
        }
    });
    $(".in_unit"+quanity_in).blur(function () {
        var in_unit = $(".in_unit"+quanity_in).val();
        if (in_unit.length == 0) {
            $(".in_unit"+quanity_in).next('div.red').remove();
			$(".in_unit"+quanity_in).addClass('red-border');
            $(".in_unit"+quanity_in).after('<div class="red">Unit is required</div>');
        } else {
            $(this).next('div.red').remove();
			$(".in_unit"+quanity_in).removeClass('red-border');
            return true;
        }
    });
    $(".in_price"+quanity_in).blur(function () {
        var in_price = $(".in_price"+quanity_in).val();
        if (in_price.length == 0) {
            $(".in_price"+quanity_in).next('div.red').remove();
			$(".in_price"+quanity_in).addClass('red-border');
            $(".in_price"+quanity_in).after('<div class="red">Unit Price is required</div>');
        } else {
            $(this).next('div.red').remove();
			$(".in_price"+quanity_in).removeClass('red-border');
            return true;
        }
    });
    $(".in_amount"+quanity_in).blur(function () {
        var in_amount = $(".in_amount"+quanity_in).val();
        if (in_amount.length == 0) {
            $(".in_amount"+quanity_in).next('div.red').remove();
			$(".in_amount"+quanity_in).addClass('red-border');
            $(".in_amount"+quanity_in).after('<div class="red">Amount is required</div>');
        } else {
            $(this).next('div.red').remove();
			$(".in_amount"+quanity_in).removeClass('red-border');
            return true;
        }
    });
	
	
	
 var subtotal = $('#total_price_new').val();
 var gst = $('#gst').val();
 var avoid = "$";
 var new_subtotal = subtotal.replace(avoid, '');
 var quotient = Math.floor(new_subtotal*gst)/100; 
 var val = parseInt(new_subtotal,10)+quotient;
 $('#gstval').attr("value", '$'+quotient);

 
 var rebateval = $('#rebates').val(); 
 var gstval = $('#gstval').val(); 
 var new_gstval = gstval.replace(avoid, '');
 var rebate = Math.floor(rebateval*new_subtotal)/100; 
 $('#rebatesval').attr("value", '- $'+rebate);
 var val1 = parseFloat(new_subtotal)+parseFloat(new_gstval);
 var total = parseFloat(val1)-rebate;
 $('#total').attr("value", '$'+total);
 
});

$(document).on("keyup change", ".totalprice", function() {
    var serviceprice = $('#serviceprice').val();
    if(serviceprice==""){
        var totalservice = 0;
    }
    else{
        var totalservice = serviceprice;
    }
    var totalprice = $('#totalprice').val();
    if(totalprice!=""){
    var total_p = $('#total_price_new').val();
    var avoid = "$";
    var new_totalprice = totalprice.replace(avoid, '');
    var totalprice_new = parseInt(totalservice,10)+parseInt(new_totalprice,10);
    $('td.qty-total').html('$'+totalprice_new);
    var new_totalp = total_p.replace(avoid, '');
}else{
        $('td.qty-total').html('');
    }
    var sum = 0;
    // $("input[class *= 'totalprice']").each(function(){
	// 	var avoid = "$";
	// 	var value = $(this).val();
    $('td.ptotal').each(function(){
        var avoid = "$";
        var currentRow=$(this).closest("tr"); 
        var value=currentRow.find("td:eq(3)").text();

		var newval = value.replace(avoid, '');
        // var totalnew_val =  parseInt(totalservice,10)+parseInt(newval,10);
        if(newval.trim().length == 0){
         var newval = '0';
         }
        sum += +newval;
        $('#total_price_new').attr("value", '$'+sum);	
		$('#total_price_new').val('$'+sum);
        $('#total').attr("value", '$'+sum);	
		$('#total').val('$'+sum);
    });
	 
});

$(document).on("keyup", "#gst", function() {
 var subtotal = $('#total_price_new').val();
 var gst = $('#gst').val();
 var avoid = "$";
 var new_subtotal = subtotal.replace(avoid, '');
 var quotient = Math.floor(new_subtotal*gst)/100; 
 var val = parseInt(new_subtotal,10)+quotient;
 $('#gstval').attr("value", '$'+quotient);
//  $('#total').attr("value", '$'+val);
var gstval = $('#gstval').val();
 if(gstval != "$0"){
 $('#total').val('$'+val);
 }
 

});
$(document).on("keyup", "#rebates", function() {

var rebateval = $('#rebates').val(); 
var gstval = $('#gstval').val(); 
var subtotal = $('#total_price_new').val();
var avoid = "$";
var new_subtotal = subtotal.replace(avoid, '');
var new_gstval = gstval.replace(avoid, '');
var rebate = Math.floor(rebateval*new_subtotal)/100; 
$('#rebatesval').attr("value", '-$'+rebate);
var val = parseFloat(new_subtotal)+parseFloat(new_gstval);
var total = parseFloat(val)-rebate;
//  $('#total').attr("value", '$'+total);
var rebates = $('#rebatesval').val(); 

if(rebates != "-$0"){
   $('#total').val('$'+total);
}


});


$(document).on('change', '.pro-select', function() {
var pid = $(this).val();
var productname = $(this).find(":selected").text();
  $.ajax({
            url: "/get-price",
            type: 'GET',
            data: { pid : pid },
			success:function(data){
			 $('#price').attr("value", '$'+data);
			 $(".bill").show();
			 $("#append-products").html('<tr class="detail-table">'+
                                        '<td class="pname">'+productname+'</td>'+
                                        '<td class="qty-bill" ></td>'+
                                        '<td class="qty-price"></td>'+
                                        '<td class="qty-total"></td>'+
                                    '</tr>');
			
	
			}
          });
 

$("#services").on("keyup", function(e) {
    var services =   this.value;
	$("td.pname").html(productname+"/"+services)
	})		  
});
	
$('#quantity').on("keyup", function(e) {	
    var price = $('#price').val();
    var quantity =   this.value; 
	$("td.qty-bill").html(quantity);
	$('td.qty-price').html(price);
    var numItems = $('.price').length;
	 $.ajax({
            url: "/total-price",
            type: 'GET',
            data: { price : price,quantity:quantity },
			success:function(data){
			 $('#totalprice').attr("value", '$'+data);
			 $('#totalprice').val('$'+data);
			  var t = $('#totalprice').val().replace('$','');

              var service = $('#serviceprice').val();
              if(service != ''){
                var servicetotal = parseInt(t)+parseInt(service);
              }else{
                var servicetotal = t;
              }
         
                $('td.qty-total').html('$'+servicetotal);
				var sum = 0;
				// $("input[class *= 'totalprice']").each(function(){
				// 	var avoid = "$";
				// 	var value = $(this).val();
                    $('td.ptotal').each(function(){
                    var avoid = "$";
                    var currentRow=$(this).closest("tr"); 
                    var value=currentRow.find("td:eq(3)").text();
                
                    var newval = value.replace(avoid, '');
                    if(newval.trim().length == 0){
                        var newval = '0';
                    }
					sum += +newval;   
					$('#total_price_new').attr("value", '$'+sum);
					$('#total_price_new').val('$'+sum);
					$('#total').attr("value", '$'+sum);
					$('#total').val('$'+sum);
					
				});
			}
       }); 
	
});

$('#price').on("keyup", function(e) {
    var price =   this.value.replace('$','');
    var quantity =   $('#quantity').val();
    var serviceprice = $('#serviceprice').val();
    if(serviceprice!=""){
        var service = serviceprice;
    }
    else{
        var service = 0;
    }
    var unit_price = parseInt(price*quantity);
    var new_unit_price = (price*quantity)+parseInt(service);
    $('#totalprice').attr("value", '$'+unit_price);
    $('#totalprice').val('$'+unit_price);
    $('td.qty-total').html('$'+new_unit_price);     
			  var t = $('#totalprice').val();  
				var sum = 0;
				// $("input[class *= 'totalprice']").each(function(){
				// 	var avoid = "$";
				// 	var value = $(this).val();
                $('td.ptotal').each(function(){
                    var avoid = "$";
                    var currentRow=$(this).closest("tr"); 
                    var value=currentRow.find("td:eq(3)").text();
                    var newval = value.replace(avoid, '');
                    if(newval.trim().length == 0){
                        var newval = '';
                    }
					sum += +newval;   
					$('#total_price_new').attr("value", '$'+sum);
					$('#total_price_new').val('$'+sum);
					$('#total').attr("value", '$'+sum);
					$('#total').val('$'+sum);
                    $('td.qty-price').html('$'+price);
				});
	
});


$("#serviceprice").on("keyup", function(e) {
    var service = $('#serviceprice').val();
    if(service != ''){
        var serviceprice = service;
    }else{
        var serviceprice = 0;
    }
    var totalprice = $('#totalprice').val();
    var avoid = "$";
    var new_totalprice = totalprice.replace(avoid, '');
    var totalprice_new = parseInt(serviceprice,10)+parseInt(new_totalprice,10);
    $('td.qty-total').html('$'+totalprice_new);
    var sum = 0;
        $('td.ptotal').each(function(){
            var avoid = "$";
            var currentRow=$(this).closest("tr"); 
            var value=currentRow.find("td:eq(3)").text();
            var newval = value.replace(avoid, '');
            if(newval.trim().length == 0){
                var newval = '0';
            }
            sum += +newval;   
            $('#total_price_new').attr("value", '$'+sum);
            $('#total_price_new').val('$'+sum);
            $('#total').attr("value", '$'+sum);
            $('#total').val('$'+sum);
        });

});
    var path = "{{ route('attention-to') }}";
	
    $( "#search" ).autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            data: {
               search: request.term
            },
            success: function( data ) {
               response( data );
            }
          });
        },
        select: function (event, ui) {
           $('#search').val(ui.item.label);
		   $("#supplierid").val(ui.item.id);
			var qid = ui.item.id;
		    $.ajax({
            url: '/get-details-quotation',
            type: 'GET',
            dataType: "json",
            data: {
              qid:qid
            },
			   success: function(data) {
               $.each(data.results, function( index, value ) {
			   $('#mobile').attr("value", +value.phone);
			   $('#email').val(value.email);
            });
            }
			});
           return false;
        }
      });
  
    var path_cust = "{{ route('get-owners') }}";
    $( "#owner" ).autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: path_cust,
            type: 'GET',
            dataType: "json",
            data: {
               search: request.term
            },
            success: function( data ) {
                if(data==""){
                    $('#red').show();
                }
                else{
                $('#red').hide();
               response( data );
                }
            }
          });
        },
        select: function (event, ui) {
           $('#owner').val(ui.item.label);
		   $("#ownerid").val(ui.item.id);
		   $("#address").val(ui.item.address);
           return false;
        }
      });

      $("#total_price").on("keyup", function(e) {
 var totalprice = $('#total_price').val();
 var gst = $('#gst').val();
 var rebates = $('#rebates').val();
 if(gst != ""){
    var newval = totalprice*gst/100;
 }
else{
    var newval = 0;
}

if(rebates != ""){
    var newreb = totalprice*rebates/100;
}
else{
    var newreb = 0;
}

 var avoid = "$";
 var new_totalprice = totalprice.replace(avoid, '');
  var newprice = new_totalprice+newval-newreb;
 $('#total').attr("value", '$'+new_totalprice);
 $('#gstval').attr("value", '$'+newval);
 $('#rebatesval').attr("value", '-$'+newreb);
})  

$("#gstval").on("keyup", function(e) {
 var totalprice = $('#total_price_new').val();
 var gst = $('#gstval').val();
 var avoid = "$";
 var new_gst = gst.replace(avoid, '');
 var new_totalprice = totalprice.replace(avoid, '');
 var val = parseInt(new_totalprice,10)+parseInt(new_gst,10);

//  $('#total').attr("value", '$'+val);
if(gst==""){
    $('#total').val(totalprice);
}
else{
    $('#total').val('$'+val);
}

})


$("#rebatesval").on("keyup", function(e) {
 var rebateval = $('#rebatesval').val(); 
 var gstval = $('#gstval').val(); 
 var subtotal = $('#total_price_new').val();
 var avoid = "$";
 var avoid1 = "-";
 var new_rebateval = rebateval.replace(avoid, '');
 var new_subtotal = subtotal.replace(avoid, '');
 var new_gstval = gstval.replace(avoid, '');
 var new_rebateval1 = new_rebateval.replace(avoid1, '');
 if(gstval==""){
    var val = parseFloat(new_subtotal);
 }
 else{
 var val = parseFloat(new_subtotal)+parseFloat(new_gstval);
 }
 var total = parseFloat(val) - parseFloat(new_rebateval1);
 if(gstval=="" && rebateval==""){
    $('#total').val(subtotal);
}
else if(gstval!="" && rebateval==""){
    $('#total').val('$'+val);
}
else{
    $('#total').val('$'+total);
}

})


</script>
@include("layouts.admin.footer")