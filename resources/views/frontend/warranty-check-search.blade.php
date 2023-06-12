@include('layouts.header')

<main id="main">


    <section class="sec-p height-screen login-sec search-sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                @if (\Session::has('success'))
                <div class="alert alert-success">
                {!! \Session::get('success') !!}
                </div>
                @endif
                    <div class="login-grid search-grid">
                        <div class="search-inner-grid">

                            <div class="p-box">
                                <p>
                                    Check your warranty status with a single click by entering your postal code.
                                </p>
                            </div>

                            <form method="POST" action="/insert-warranty" id="insert-warranty">
                                @csrf
                                <div class="form-group">
                                    <i class="fa fa-search"></i>
                                    <label class="form-label">Search</label>
                                    <input type="text" class="form-control" placeholder="Enter Address" id="address" required>
                                    <input type="hidden" name="userid"id="id">
                                    <input type="hidden" id="address_val">
                                </div>

                                <div class="red" id="red"style="display:none;color:red;">Invalid Address</div>

                                <div class="result">
                                </div>

                                <div class="d-flex status">
                                    
                                </div>

                                <div class="btn-grid d-flex search-btn" style="display:none !important;">
                                    <a  href="#" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal">Create Case</a>
                                    <a class="btn btnn" href="/warranty-check-search">Make Another Search</a>
                                </div>


                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Enter Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Enter Name"  name="name" required>
                                    </div>
                                    <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Enter Email"  name="email" required>
                                    </div>

                                    <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Enter Phone Number"  name="phone" required>
                                    </div>

                                    <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Enter Housing unit"  name="housing_unit" required>
                                    </div>
                             
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </form>

                            <div class="p-box">
                                <b>Note:</b>
                                <p>
                                    Enter your postal code in the search bar. If your address is in our database, you will see the status of your warranty.
                                </p>
                                <br>
                                <p>
                                    If you require help, contact us at +65 4444-4444.
                                </p>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-7 p-0">
                    <div class="map">
                        <!--iframe id="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.557255445572!2d103.80405571533079!3d1.4405927616770473!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31da13de7742f72d%3A0x98be6e35e4230fde!2sKimly%20Seafood%20(691%20Woodlands%20Drive%2073)!5e0!3m2!1sen!2sin!4v1656568949260!5m2!1sen!2sin" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe-->
                        <iframe id="addressmap"src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBIipfS2ZXDWqKMdgRqu5H-U_-p6oV0Ako&q=Test Address, Melbourne Street, Southampton, UK" width="100%" height="472" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

            </div>
        </div>
    </section>



</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
<script>
var path_cust = "{{ route('get-address') }}";
$( "#address" ).autocomplete({
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
		   $("#address").val(ui.item.label);
		   $("#id").val(ui.item.id);
		   var check = $("#address_val").val(ui.item.value);
           var checked = check.val();
        //    alert(checked);
           $(".result").html('<h5>'+ui.item.value+'</h5>');
           $(".status").html('<h6>Warranty Status</h6> <span>Valid</span>');
           $('.search-btn').show();

           $('#addressmap').attr('src',"https://www.google.com/maps/embed/v1/place?key=AIzaSyBIipfS2ZXDWqKMdgRqu5H-U_-p6oV0Ako&q="+checked+"");
           
           return false;
        }
      });

    //   $("#insert-warranty").submit(function(e){
    //     e.preventDefault();

    //     var formData = new FormData(this);

    //         $.ajax({
    //             url: "/insert-warranty",
    //             type: "POST",
    //             dataType: "json",
    //             data: formData,
    //             cache: false,
    //             contentType: false,
    //             processData: false,
    //             success: function(data){
    //                 if(data){
    //                    alert('success');
    //                 }else{
    //                     alert('failed');
    //                 }
    //                 },
    //         });
    //     });
</script>
@include('layouts.footer')