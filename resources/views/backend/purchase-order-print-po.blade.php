<!DOCTYPE html>
<html>
  
<head>
    <title>
        Print Purchase Order
    </title>
</head>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
 <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<body>	
<b>Purchase Order Number: #{{$orders->order_no}}</b></br>
@php 
$sup = DB::table('suppliers')->where('id',$orders->product_id)->first();
@endphp
<b>Supplier: {{$sup->person_name}}</b></br>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Product</th>
      <th scope="col">Unit</th>
      <th scope="col">Unit Price</th>
      <th scope="col">Quantity</th>
      <th scope="col">Price</th>
    </tr>
  </thead>
  <tbody>
  @php $count =1; @endphp 
  @for($i=0;$i<count($arr['products']);$i++)
	  @php 
	  $product = DB::table('products')->where('id',$arr['products'][$i])->first();
	  @endphp
    <tr>
      <td>{{$product->product_name}}</td>
      <td>{{$arr['unit'][$i]}}</td>
      <td>${{$arr['unitprice'][$i]}}</td>
      <td>{{$arr['quantity'][$i]}}</td>
      <td>${{$arr['price'][$i]}}</td>
    </tr>
  @endfor

  </tbody>
</table>
<b>Estimated Days Before Arrival: {{$orders->days_before_arrival}} days</b></br>
<b>Estimated Arrival: {{$orders->estimated_arrival}}</b></br>
<b>Total Price: ${{$orders->total_price}}</b></br>
	
<script type="text/javascript">
$( document ).ready(function() {
    window.print();
	window.onafterprint = function(event) {
    window.location.href = '/purchase-order-list'
};

});

</script>


</body>
  
</html>