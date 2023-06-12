@include("layouts.admin.header")

<main class="content-wrapper">
    <div class="container-fluid">

        <div class="box-shadow role">

            <div class="main-heading">
                <h1>
                    Edit Warehouse
                </h1>
                <p>
                    This segment is for Warehouse creation.
                </p>
            </div>

            <div class="form">
                <form method="POST" action="/warehouse-update">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label class="form-label">Warehouse Name</label>
                        <input type="hidden" name="id" id="id" value="{{$edit_warehouse->id}}">
                        <input type="text" class="form-control" name="name" id="name" value="{{$edit_warehouse->name}}" placeholder="Warehouse Name">
                    </div>

                    <div class="form-group form-select-group w-100">
                        <label class="form-label">Address of Warehouse</label>
                        <input type="text" name="address" id="address" value="{{$edit_warehouse->address}}" class="form-control" placeholder="Address of Warehouse">
                        @if($edit_warehouse->address==NULL)
							@php $address = "Canberra Community Club"; @endphp
							@else
							@php $address = $edit_warehouse->address; @endphp
							@endif
							<div id="map"></div>
							 <iframe id="addressmap"src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBIipfS2ZXDWqKMdgRqu5H-U_-p6oV0Ako&q={{$address}}" width="100%" height="472" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>

                    

                    <div class="accordion acc-product" id="myAccordion">
                        <div class="acc-head">
                            <h6>Products In Warehouse</h6>
                        </div>
                        <div class="accordion-item">
                            @php
                            $var =explode(",",$edit_warehouse->pro_cat);
                            @endphp
                            @foreach($product_categories as $pro_cat)
                            <h2 class="accordion-header" id="headingOne">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseOne{{$pro_cat->id}}"></button>
                                <div class="check-grid">
                                    <label class="form-check-label">
                                        <!-- <input class="form-check-input" id="flexCheckDefault" type="checkbox" value="" /> -->
                                        <input class="form-check-input checkall{{$pro_cat->id}}" id="flexCheckDefault" type="checkbox" name="pro_cat" value="{{$pro_cat->id}}" onClick = "checkall({{$pro_cat->id}});"  
                                             @if(in_array($pro_cat->id, $var)) checked @endif />
                                        <span>{{$pro_cat->category_name}}</span>
                                    </label>
                                </div>
                            </h2>

                            <div id="collapseOne{{$pro_cat->id}}" class="accordion-collapse collapse product-items" data-bs-parent="#myAccordion">
                                <div class="row row-cols-md-3 row-cols-2">
                                    @foreach($products as $product)
                                    @if($pro_cat->id == $product->product_category)

                                    @php
                                    $var_id = explode(",",$edit_warehouse->pro_id);

                                    @endphp




                                    <div class="col">
                                        <div class="card">
                                            <img src="{{asset('admin/productimage/'.$product->p_image)}}" class="card-img-top" alt="image">
                                            <div class="card-body">
                                                <label class="form-check-label">
                                                    <input class="form-check-input checked{{$pro_cat->id}}" id="flexCheckDefault" type="checkbox" name="pro_id" value="{{$product->id}}"
                                                     onClick = "checkallid({{$pro_cat->id}});"    @if(in_array($product->id, $var_id)) checked @endif />
                                                    
                                                    <span>{{$product->product_name}}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                    
                                    
                                    
                                    
                                    
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                    </div>

                    <div class="d-flex btn-grid">
                        <button type="submit" class="btn" id="update_create">Update</button>
                        <a href=""class="btn btn-white">Clear</a>
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
</style>

<script>
    
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
    $(document).ready(function() {
        $("#map").hide();
        $('#address').on("input", function() {
            $("#addressmap").hide();
            $("#map").show();
            // var dInput = this.value;
            // if(dInput==""){
                // var dInput = "Canberra Community Club";
            // }
            // $('#map')
            // .attr('src','https://www.google.com/maps/embed/v1/place?key=AIzaSyBIipfS2ZXDWqKMdgRqu5H-U_-p6oV0Ako&q='+dInput);
        });
    });
var checkval = false; // desecelted
function checkall(id){
var isChecked = $('.checkall'+id).is(':checked');
if(isChecked == true){

    $('.checked'+id).each(function() {
        if(!checkval) {
            this.checked = true;
        } 
    }); 
}
else{
    $('.checked'+id).each(function() {
        if(!checkval) {
            this.checked = false;
        } 
    }); 
}

}

function checkallid(id){
var isChecked = $('.checked'+id).is(':checked');
if(isChecked == true){
    $('.checkall'+id).each(function() {
        if(!checkval) {
            this.checked = true;
        } 
    }); 
    
}
else{
    $('.checkall'+id).each(function() {
        if(!checkval) {
            this.checked = false;
        } 
    }); 
}
}

$("#update_create").click(function(e) {
 
e.preventDefault();
var name = $('#name').val();
var id = $('#id').val();
var address = $("#address").val();
var pro_cat = [];
$.each($("input[name='pro_cat']:checked"), function(){
pro_cat.push($(this).val());

//alert(pro_cat);
});

var pro_id = [];
$.each($("input[name='pro_id']:checked"), function(){
pro_id.push($(this).val());
//alert(pro_id);
});

$.ajax({
     url: "/warehouse-update",
     type:"POST",
     data:{
     "_token": "{{ csrf_token() }}",
      name:name,
      address:address,
      pro_cat:pro_cat,
      id:id,
      pro_id:pro_id,
      },
      
       success:function(response){
       if (response.status==true) {
             $(".overlay").addClass("is-active");
             $(".quick-popup").addClass("is-active");
             setTimeout(function(){
               window.location.reload(1);
            }, 1000);
            }
        else{
            $('#name-error').text(response.msg); 
        }
        },
})  
});

</script>

@include("layouts.admin.footer")