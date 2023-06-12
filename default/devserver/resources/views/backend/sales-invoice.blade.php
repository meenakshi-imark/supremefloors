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
     $("#append").append('<div class="row row-cols-xl-4 row-cols-md-3 row-cols-md-2 row-cols-1 align-items-end appenddiv" >'+
                        '<div class="col">'+
                            '<div class="form-group form-select-group w-100">'+
                                '<label class="form-label">Product / Job Quoted</label>'+
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
                                '<label class="form-label">Quantity</label>'+
                                '<input type="number" id="quantity'+numItems+'" name="quantity[]" class="form-control quantity" placeholder="1" required>'+
                            '</div>'+
                        '</div>'+
						'<div class="col">'+
                            '<div class="form-group form-select-group w-100">'+
                                '<label class="form-label">Unit</label>'+
                                '<select class="form-select" aria-label="Default select example" name="unit[]" id="unit'+numItems+'" required>'+
                                    '<option value="No Unit">No Unit</option>'+
                                    '<option value="Square Feet">Square Feet</option>'+
                                    '<option value="Square Meter">Square Meter</option>'+
                                '</select>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col">'+
                            '<div class="form-group">'+
                                '<label class="form-label">Unit Price</label>'+
                                '<input type="text" class="form-control price" value="" id="price'+numItems+'"name="unitprice[]"  required>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col">'+
                            '<div class="form-group">'+
                                '<label class="form-label">Amount</label>'+
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
  var classname = numItems-1;
  var newclass = "#price"+classname;
  var quantity = "#quantity"+classname;
  var totalprice = "#totalprice"+classname;	 
  var serviceprice = "#serviceprice"+classname;	 
  var services = "#services"+classname;	 
  var productname = $(this).find(":selected").text();
  

  $.ajax({
         url: "/get-price",
         type: 'GET',
         data: { pid : pid },
	     success:function(data){
			$(newclass).attr("value", '$'+data); 
			$(".bill").show();
			$("#append-products").append('<tr>'+
                                        '<td class="pname1">'+productname+'</td>'+
                                        '<td class="qty1"></td>'+
                                        '<td class="qty1-price"></td>'+
                                        '<td class="qty1-total"></td>'+
                                    '</tr>');
									
		// $("td.pname").append(","+productname);
		}
        });	
		
$(services).on("keyup", function(e) {
var services_val =   this.value;
$("td.pname1").html(","+productname+"/"+services_val)

})
	
  $(quantity).on("keyup", function(e) {
    // $(".total1").val(sum);
	
    var price = $(newclass).val();
    var quantity =   this.value;
	$('td.qty1').html(quantity);
	$('td.qty1-price').html(price);
	// var quotient = Math.floor(price*quantity); 
	 $.ajax({
            url: "/total-price",
            type: 'GET',
            data: { price : price,quantity:quantity },
			success:function(data){
			 $(totalprice).attr("value", '$'+data);
			  var t = $(totalprice).val();
			  $('td.qty1-total').html(t);
				var sum = 0;
				$("input[class *= 'totalprice']").each(function(){
					var avoid = "$";
					var value = $(this).val();
					// var price1 = $(totalprice).val();
					var newval = value.replace(avoid, '');
					// var totalval=price1.replace(avoid, '');
					// var newtotal = parseInt(totalval, 10)+parseInt(newval,10);
					sum += +newval;
					// var total = sum+parseInt(totalval,10);
					// alert(total);
					$('#total_price').attr("value", sum);
					
				});
			}
       }); 
	
});



});
});  

</script>
<main class="content-wrapper">
    <div class="container-fluid">

        <div class="box-shadow role">

            <div class="main-heading">
                <h1>
                    Invoice
                </h1>
                <p>
                    This segment is to create an Invoice in Supreme Floor ERP.
                </p>
            </div>
			     @if(session()->has('success'))
                 <div class="alert alert-warning alert-dismissible fade show" role="alert">
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
				 @php 
				 $company = DB::table('suppliers')->select('id','company_name')->orderBy('company_name','ASC')->get();
				 @endphp
            <div class="form mw-100">
                <form method="POST" action="/insert-invoice">
				@csrf
                    <div class="row  row-cols-md-2 row-cols-1">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Invoice ID</label>
                                <input type="number" class="form-control" placeholder="5954484" name="invoiceid" id="invoiceid"required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Owner / Company</label>
                                <div class="search-it">
                                    <i class="la la-search"></i>
									<select class="form-select" aria-label="Default select example" name="owner" id="owner" required>
                                        <option value="">Select</option>
										@foreach($company as $com)
                                        <option value="{{$com->id}}">{{$com->company_name}}</option>
										@endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control" placeholder="Calle Socrates Nolasco #6-B, Ens. Naco" name="address" id="address"required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Attention To</label>
                                <div class="search-it">
                                    <i class="la la-search"></i>
                                    <input type="text" class="form-control" id="search" name="attentionto" placeholder="Search" required>
									<input id="supplierid" type="hidden" value="" name="supplierid">
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Phone</label>
                                <input type="number" class="form-control" placeholder="(450) 297-1007" name="phone" id="phone" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="davidsmith89@gmail.com" name="email" id="email" required >
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Due Date</label>
                                <input type="date" class="form-control" placeholder="mm/dd/yy" name="duedate" id="duedate" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Installer</label>
                                <input type="text" class="form-control" placeholder="Installer" name="installer" id="installer" required>
                            </div>
                        </div>
                    </div>

                                       <div class="row row-cols-xl-4 row-cols-md-3 row-cols-md-2 row-cols-1 align-items-end">
                        <div class="col">
                            <div class="form-group form-select-group w-100 testing">
                                <label class="form-label">Product / Job Quoted</label>
                                <select class="form-select pro-select" aria-label="Default select example" name="product[]" id="product" required>
                                    <option selected value="">Select</option>
									@foreach($products as $product)
                                    <option value="{{$product->id}}">{{$product->product_name}}</option>
									@endforeach
                                </select>	
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Quantity</label>
                                <input type="number" id="quantity" class="form-control" placeholder="1" name="quantity[]" id="quantity" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Unit</label>
                                <select class="form-select" aria-label="Default select example" name="unit[]" id="unit" required>
                                    <option selected value="No Unit">No Unit</option>
                                    <option value="Square Feet">Square Feet</option>
                                    <option value="Square Meter">Square Meter</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Unit Price</label>
                                <input type="text" id="price" class="form-control" placeholder="$500" name="unitprice[]" id="unitprice" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Amount</label>
                                <input type="text" id="totalprice" class="form-control totalprice" placeholder="$500" name="price[]" id="price" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Services</label>
                                <input type="text" id="services" class="form-control services" placeholder="" name="services[]">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Service Price</label>
                                <input type="text" id="serviceprice" class="form-control serviceprice" placeholder="" name="serviceprice[]">
                            </div>
                        </div>
                    </div>
					<div id="append">
						
					</div>
                    <div class="form-group" style="width: fit-content;float: right;">
                        <a id="addmore"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Product</a>
                    </div>

                    <div class="row row-cols-md-2 row-cols-1" style="margin-top: 26px;">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Site Address</label>
                                <input type="text" class="form-control" placeholder="Site Address" name="site_address" >
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Invoice Description</label>
                                <input type="text" class="form-control" placeholder="Invoice Description" name="description">
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="bill" style="display:none;">

                        <h3>Billing</h3>

                        <div class="all-tabel">
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
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="prices total-detail">
                        <div class="s-total d-flex justify-content-between">
                            <p><span>Sub Total</span></p>
                            <input type="text" class="form-control subtotal"name="subtotal" id="total_price" value="" placeholder="Sub total">
                        </div>
                        <div class="s-total d-flex justify-content-between">
                            <div class="form-group">
                                <label class="form-label">GST:</label>
                                <input type="number" class="form-control" name="gst" id="gst" placeholder="" >
                            </div>
                            <input type="text" class="form-control subtotal" id="gstval" placeholder="GST" value="">
                        </div>
                        <div class="s-total d-flex justify-content-between">
                            <div class="form-group">
                                <label class="form-label">Rebates:</label>
                                <input type="number" class="form-control" name="rebates"id="rebates" placeholder="" >
                            </div>
                            <input type="text" class="form-control subtotal" id="rebatesval" placeholder="Rebates" value="">
                        </div>
                        <div class="s-total d-flex justify-content-between">
                            <p><span>Total:</span></p>
                            <input type="text" class="form-control subtotal" name="totalamt"id="total" value="" placeholder="Total">
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
<style>
.form-control.subtotal {
    width: 120px;
    margin-top: 12px;
}

</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
 <script src="{{ asset('admin/js/validation.js') }}"></script>
<script>

$(document).on("keyup change", ".totalprice", function() {
    var sum = 0;
    $("input[class *= 'totalprice']").each(function(){
		var avoid = "$";
		var value = $(this).val();
		var newval = value.replace(avoid, '');
        sum += +newval;
		// alert(sum);
		$('#total_price').attr("value", '$'+sum);
		$('#total').attr("value", '$'+sum);
    });
    // $(".total1").val(sum);
	 // var price = $('#totalprice').val();
	 
});
$(document).on("keyup", "#gst", function() {
 var subtotal = $('#total_price').val();
 var gst = $('#gst').val();
 var avoid = "$";
 var new_subtotal = subtotal.replace(avoid, '');
 var quotient = Math.floor(new_subtotal*gst)/100; 
 var val = parseInt(new_subtotal,10)+quotient;
 $('#gstval').attr("value", '$'+quotient);
 $('#total').attr("value", '$'+val);
 

});
$(document).on("keyup", "#rebates", function() {

 var rebateval = $('#rebates').val(); 
 var gstval = $('#gstval').val(); 
 var subtotal = $('#total_price').val();
 var avoid = "$";
 var new_subtotal = subtotal.replace(avoid, '');
 var new_gstval = gstval.replace(avoid, '');
 var rebate = Math.floor(rebateval*new_subtotal)/100; 
 $('#rebatesval').attr("value", '-$'+rebate);
 var val = parseFloat(new_subtotal)+parseFloat(new_gstval);
 var total = parseFloat(val)-rebate;
 $('#total').attr("value", '$'+total);
 
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
			
			// $("td.pname").html(productname)
			}
          });


	// $('.testing').closest('.test').remove();
	  // $(this).parent('.test').remove();
	$("#services").on("keyup", function(e) {
    var services =   this.value;
	$("td.pname").html(productname+"/"+services)
	})
		  
});
	
    var path = "{{ route('search-customer') }}";
	
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
		   var supid = ui.item.id;
		   	 $.ajax({
            url: '/get-details',
            type: 'GET',
            dataType: "json",
            data: {
              supid:supid
            },
            success: function(data) {
               $.each(data.results, function( index, value ) {
			   $('#phone').attr("value", +value.phone);
			   $('#email').val(value.email);
            });
            }
          });
           return false;
        }
      });
	  
  $("#quantity").on("keyup", function(e) {
    var price = $('#price').val();
    var quantity =   this.value;
	$("td.qty-price").html(price)
	$("td.qty-bill").html(quantity)
	// $('td.qty-price').empty().append(price);
	// $('td.qty-bill').append(quantity);
	 $.ajax({
            url: "/total-price",
            type: 'GET',
            data: { price : price,quantity:quantity },
			success:function(data){
			 $('#totalprice').attr("value", '$'+data);
			 $('#total_price').attr("value", '$'+data);	
			 $('#total').attr("value", '$'+data);
			 var qtytotal = $('#total_price').val();
			 $('td.qty-total').html(qtytotal);
			}
       }); 
})



  
$("#total_price").on("keyup", function(e) {
 var totalprice = $('#total_price').val();
 var gst = $('#gst').val();
 var rebates = $('#rebates').val();
 var newval = totalprice*gst/100;
 var newreb = totalprice*rebates/100;
 var avoid = "$";
 var new_totalprice = totalprice.replace(avoid, '');
  var newprice = new_totalprice+newval-newreb;
 $('#total').attr("value", '$'+new_totalprice);
 $('#gstval').attr("value", '$'+newval);
 $('#rebatesval').attr("value", '-$'+newreb);
})  

$("#gstval").on("keyup", function(e) {
 var totalprice = $('#total_price').val();
 var gst = $('#gstval').val();
 var avoid = "$";
 var new_gst = gst.replace(avoid, '');
 var new_totalprice = totalprice.replace(avoid, '');
 var val = parseInt(new_totalprice,10)+parseInt(new_gst,10);

 $('#total').attr("value", '$'+val);
})

$("#rebatesval").on("keyup", function(e) {
 var rebateval = $('#rebatesval').val(); 
 var gstval = $('#gstval').val(); 
 var subtotal = $('#total_price').val();
 var avoid = "$";
 var avoid1 = "-";
 var new_rebateval = rebateval.replace(avoid, '');
 var new_subtotal = subtotal.replace(avoid, '');
 var new_gstval = gstval.replace(avoid, '');
 var new_rebateval1 = new_rebateval.replace(avoid1, '');
 var val = parseFloat(new_subtotal)+parseFloat(new_gstval);
 var total = parseFloat(val) - parseFloat(new_rebateval1);
 console.log(total);
// alert(total);
 $('#total').attr("value", '$'+total);
})

</script>
@include("layouts.admin.footer")