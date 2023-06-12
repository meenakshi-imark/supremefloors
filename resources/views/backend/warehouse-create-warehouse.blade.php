@include("layouts.admin.header")
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<main class="content-wrapper">
    <div class="container-fluid">

        <div class="box-shadow role">

            <div class="main-heading">
                <h1>
                    Create Warehouse
                </h1>
                <p>
                    This segment is for Warehouse creation.
                </p>
            </div>

            <div class="form">
                <form method="POST" action="/warehouse-create-store">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Warehouse Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                        <div class="name_err" style="display:none;color:red;">This filed is required.</div>
                    </div>

                    <div class="form-group form-select-group w-100">
                        <label class="form-label">Address of Warehouse</label>
                        <input type="text" class="form-control" name="address" id="address" value="" placeholder="Address">
                        <div class="address_err" style="display:none;color:red;">This filed is required.</div>
                    </div>
                        <div id="map" class="map"></div>

                    <div class="accordion acc-product" id="myAccordion">
                        <div class="acc-head">
                            <h6>Products In Warehouse</h6>
                        </div>
                        @foreach($categories as $categorie)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseOne{{$categorie->id}}"></button>
                                <div class="check-grid">
                                    <label class="form-check-label">
                                        <input class="form-check-input  checkall{{$categorie->id}}" id="flexCheckDefault" type="checkbox" name="pro_cat"  value="{{$categorie->id}}" onClick = "checkall({{$categorie->id}});"  />
                                        <span>{{$categorie->category_name}}</span>
                                    </label>
                                </div>
                            </h2>
                            <div id="collapseOne{{$categorie->id}}" class="accordion-collapse collapse product-items " data-bs-parent="#myAccordion">
                                <div class="row row-cols-md-3 row-cols-2">
                                    @foreach($products as $product)
                                    @if($categorie->id == $product->product_category)
                                    <div class="col">
                                        <div class="card">
                                            <img src="{{asset('admin/productimage/'.$product->p_image)}}" class="card-img-top" alt="images">
                                            <div class="card-body">
                                                <label class="form-check-label">
                                                    <input class="form-check-input checked{{$categorie->id}}" id="flexCheckDefault" type="checkbox" name="pro_id" value="{{$product->id}}" onClick = "checkallpro({{$categorie->id}})"; />
                                                    <span>{{$product->product_name}}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach     
                    <div class="error">
                    
                    </div>
                    </div>

                    <div class="d-flex btn-grid">
                        <button type="submit" class="btn" id="create_warehouse">Create</button>
                        <a href="" class="btn btn-white">Clear</a>
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
.error{
    color:red;
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

function checkallpro(id){
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

$("#create_warehouse").click(function(e) {
    //alert('ok');
e.preventDefault();
var name = $('#name').val();
var address = $("#address").val();
var pro_cat = [];
$.each($("input[name='pro_cat']:checked"), function(){
pro_cat.push($(this).val());
});
var pro_id = [];
$.each($("input[name='pro_id']:checked"), function(){
pro_id.push($(this).val());
});
if(pro_id==""){
    $(".error").html("Please select atleast one product for warehouse.");
}
if(name==""){
    $(".name_err").show();
}
if(address==""){
    $(".address_err").show();
}
$.ajax({
     url: "/warehouse-create-store",
     type:"POST",
     data:{
     "_token": "{{ csrf_token() }}",
      name:name,
      address:address,
      pro_cat:pro_cat,
      pro_id:pro_id
      
      },
       success:function(response){
       if (response.status==true) {
             $(".overlay").addClass("is-active");
             $(".quick-popup").addClass("is-active");
             setTimeout(function(){
                 window.location.href = '/warehouse-all-warehouse';
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