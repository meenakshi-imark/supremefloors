@include("layouts.admin.header")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

	<script>
	$(document).ready(function(){  
	
	 // document.querySelectorAll('.testimonial').forEach(function (element, index) {
		// const box = document.querySelector('.testimonial');
		 // box[index].setAttribute('id', 'test1' + index);
		// element.innerHTML = 'Testimonial ' + (index + 1);
		// element.attr("id", +index + 1);
		// });
	

	 $('#addmore').click(function(e) {  
	 var numItems = $('.price').length;
     $("#append").append('<div class="row row-cols-md-5" >'+
                        '<div class="col">'+
                            '<div class="form-group form-select-group w-100">'+
                                '<label class="form-label">Product / Job Quoted</label>'+
								'<select class="form-select pro-select1"  aria-label="Default select example" name="product[]" >'+
									'<option value="">Select</option>'+
									@foreach($products as $p)
                                    '<option value="{{$p->id}}">{{$p->product_name}}</option>'+
									@endforeach
									'</select>'+
                            '</div>'+
                        '</div>'+
						'<div class="col">'+
                            '<div class="form-group form-select-group w-100">'+
                                '<label class="form-label">Unit</label>'+
                                '<select class="form-select" aria-label="Default select example" name="unit[]" required>'+
                                    '<option value="SQFT">SQFT</option>'+
                                    '<option value="SQM">SQM</option>'+
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
                                '<label class="form-label">Quantity</label>'+
                                '<input type="number" id="quantity'+numItems+'" name="quantity[]" class="form-control quantity" placeholder="2" required>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col">'+
                            '<div class="form-group">'+
                                '<label class="form-label">Price</label>'+
                                '<input type="text" id="totalprice'+numItems+'" name="price[]" class="form-control totalprice" placeholder="$1000.00"  required >'+
                            '</div>'+
                        '</div>'+
						'<div>');  
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
				});
			}
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
		@if (\Session::has('error'))
			<div class="alert alert-danger">
				<ul>
					<li>{!! \Session::get('error') !!}</li>
				</ul>
			</div>
		@endif
        <div class="box-shadow role">

            <div class="main-heading">
                <h1>
                    Create Purchase Order
                </h1>
                <p>
                    This segment is to Create Purchase Order
                </p>
            </div>

            <div class="form mw-100">
                <form method="POST" action="/insert-purchase-order">
				@csrf
                    <div class="row row-cols-xl-2 row-cols-1">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Purchase Order Number</label>
                                <input type="number" class="form-control" placeholder="5954484" name="ordernumber" readonly>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Supplier</label>
                                <div class="search-it">
                                    <i class="la la-search"></i>
                                    <select class="form-select" aria-label="Default select example" name="supplier" required>
										@foreach($suppliers as $supplier)
                                        <option value="{{$supplier->id}}" >{{$supplier->person_name}}</option>
										@endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row row-cols-xl-5 row-cols-md-3 row-cols-2" >
                        <div class="col">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Product</label>
                                <!--div class="search-it">
                                    <i class="la la-search"></i>
									<input placeholder="Product"  class="search"id="search" type="text" value="" name="product" required>
									<input id="productid" type="hidden" value="" class="productid"name="productid" required>
                                </div-->
								 <select class="form-select pro-select" aria-label="Default select example" name="product[]" required>
								 @foreach($products as $p)
                                    <option value="{{$p->id}}">{{$p->product_name}}</option>
								@endforeach
                                </select>
                            </div>
                        </div>
					
                        <div class="col">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Unit</label>
                                <select class="form-select" aria-label="Default select example" name="unit[]" required>
                                    <option value="SQFT">SQFT</option>
                                    <option value="SQM">SQM</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Unit Price</label>
                                <input type="text" id="price"class="form-control" name="unitprice[]" value=""   required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Quantity</label>
                                <input type="number" id="quantity" name="quantity[]" class="form-control" placeholder="2" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Price</label>
                                <input type="text" id="totalprice" name="price[]" class="form-control totalprice" placeholder="$1000.00" required >
                            </div>
							
                        </div>
						
                    </div>
					<div class="row" >
					<div class="input_fields_wrap">
                    <a id="addmore"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Product</a>
					</div>
					</div>
					
					
					<div id="append">
						
					</div>

                    <div class="prices">
                        <table>
                            <tbody>
                                <tr>
                                    <td>
                                        <label class="form-label">Estimated days before Arrival:</label>
                                    </td>
                                    <td>
                                        <div class="fill-days">
                                            <input type="number" class="form-control" name="days" required>
                                         <label class="form-label">days</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                         <label class="form-label">Estimated Arrival:</label>
                                    </td>
                                    <td>
										<div class="fill-days" ><input type="date" class="form-control" name="date" style="max-width:fit-content;" required></div></td>
                                </tr>
                                <tr>
                                    <td>
                                         <label class="form-label">Total Price:</label>
                                    </td>
                                    <td><input type="text" id="total_price" name="totalprice"style="border: none;"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex btn-grid">
					 <?php 
					  $getrole= DB::table('roles')->where('id',auth()->user()->role_id)->get();
					  $per = explode(",",$getrole[0]->permission_id);
					  $acc = explode(",",$getrole[0]->access_id);
					  ?>
					  @if(in_array("56", $acc) || auth()->user()->role_id=="1" || auth()->user()->role_id=="2")
                        <button type="submit" class="btn">Create</button>
					 @else
						 <button type="submit" class="btn">Submit for Approval</button>
					 @endif
                        <button type="reset" class="btn btn-white">Clear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />

<script type="text/javascript">


$(document).on("keyup change", ".totalprice", function() {
    var sum = 0;
    $("input[class *= 'totalprice']").each(function(){
		var avoid = "$";
		var value = $(this).val();
		var newval = value.replace(avoid, '');
        sum += +newval;
		// alert(sum);
		$('#total_price').attr("value", sum);
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
	
    var path = "{{ route('autocomplete') }}";
	
  	$(document).on('keyup change', '.search1', function() {
		   $( "#search1" ).autocomplete({
		 source: function( request, response ) {
			 
			 }   
      
			});
	
		});
  
/*     $( ".search" ).autocomplete({
	
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
           $('.search').val(ui.item.label);
		   $(".productid").val(ui.item.id);
		    $.ajax({
            url: "/get-price",
            type: 'GET',
            data: { pid : ui.item.id },
			success:function(data){
			 $('#price').attr("value", '$'+data);
			}
          });
           return false;
        }
      });
	   */
	   

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

			}
       }); 
	
})
</script>

@include("layouts.admin.footer")