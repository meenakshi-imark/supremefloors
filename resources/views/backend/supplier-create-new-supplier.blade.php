@include("layouts.admin.header")
 <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
 <main class="content-wrapper">
    <div class="container-fluid">

        <div class="box-shadow role">

            <div class="main-heading">
                <h1>
                    Create New Supplier
                </h1>
                <p>
                    This segment is to create a New Supplier.
                </p>
            </div>
			<div class="form mw-100">
                <form method="POST" action="/create_supplier">
                    @csrf
                    <div class="row row-cols-lg-2 row-cols-1">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Company Name*</label>
                                <input type="text" class="form-control" id="company_name"placeholder="Company Name">
                                <span class="text-danger" id="name-error"></span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Email*</label>
                                <input type="email" class="form-control" id="email" placeholder="Email">
                                 <span class="text-danger" id="email-error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-1">
                        <div class="col">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Address</label>
                                <input type="text" id="address"class="form-control" placeholder="Address">
                            </div>
                        </div>
                    </div>
                             <div id="map" class="map"></div>
                    <div class="row row row-cols-lg-2 row-cols-1">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Contact Person Name</label>
                                <input type="text" id="person_name"class="form-control" placeholder="Contact Person Name">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Phone</label>
                                <input type="number"id="phone" class="form-control" placeholder="Phone">
                            </div>
                        </div>
                    </div>
                    <div class="row row row-cols-lg-2 row-cols-1">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Website</label>
                                <input type="text" id="website" class="form-control" placeholder="Website">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Country of Origin</label>
                                <input type="text" class="form-control" id="country" placeholder="Country of Origin">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Remarks</label>
								<textarea class="form-control" id="remarks" placeholder="Remarks"></textarea>
                            </div>
                        </div>
                    </div>
					
	
  

                    <div class="d-flex btn-grid">
                        <button type="submit" class="btn" id="create-supplier">Create</button>
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

$("#create-supplier").click(function(e) {
 e.preventDefault();
 var company_name = $('#company_name').val();
 var email = $('#email').val();   
 var address = $('#address').val();   
 var person_name = $('#person_name').val();   
 var phone = $('#phone').val();   
 var website = $('#website').val();   
 var country = $('#country').val();   
 var remarks = $('#remarks').val();   
 if(company_name==""){
 $('#name-error').text("This field is required."); 	
 $(window).scrollTop(0);
 }
 if(email==""){
 $('#email-error').text("This field is required."); 
 $(window).scrollTop(0);	
 }
 else{
    if(isValidEmailAddress(email)==false)
            {
                $('#email-error').text("Please enter a valid email address."); 
                $(window).scrollTop(0);
            }
            else{
               var email1 = email; 
            }
            
 }
 $.ajax({
	 url: "/create-supplier",
     type:"POST",
     data:{
     "_token": "{{ csrf_token() }}",
	  company_name:company_name,
	  email:email1,
	  address:address,
	  person_name:person_name,
	  phone:phone,
	  website:website,
	  country:country,
	  remarks:remarks,
      },
	  success:function(response){
      if (response.status==true) {
         $(".overlay").addClass("is-active");
         $(".quick-popup").addClass("is-active");
		 setTimeout(function(){
		 window.location.href = '/suppliers';
		 }, 1000);
        }
		else{
			$('#name-error').text(response.msg); 
		}
        },
})
});

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
}
</script>
@include("layouts.admin.footer")