@include("layouts.admin.header")
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
 <main class="content-wrapper">
    <div class="container-fluid">
		@if (\Session::has('success'))
        <div class="alert alert-success">
         {!! \Session::get('success') !!}
        </div>
		@endif
		 @if(session()->has('error'))
         <div class="alert alert-danger">
          {!! \Session::get('error') !!}
         </div>
         @endif
        <div class="box-shadow role">

            <div class="main-heading">
                <h1>
                    Create Jobsheet
                </h1>
                <p>
                    This segment is to create jobsheet.
                </p>
            </div>
			<div class="form mw-100">
                <form method="POST" action="/insert-jobsheet">
                    @csrf
                    <div class="row row-cols-md-3 row-cols-1">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">RO*</label>
                                <input type="text" class="form-control" name="ro" id="ro" placeholder="RO" value="" required>
								<input id="roid" type="hidden" value="" name="roid">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">ID</label>
                                <input type="text" class="form-control" id="owner" placeholder="ID" value="" readonly required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Postal Code/ Address</label>
                                <input type="text" class="form-control" name="postalcode" id="postalcode"placeholder="Postal Code/ Address" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-md-2 row-cols-1">
                        <div class="col">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Delivery Date</label>
                                <input type="date" id="delivery_date"class="form-control" name="delivery_date" placeholder="Delivery Date" value="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Driver</label>
                                <select class="form-select" name="driver">
                                    <option selected="" value="">Select Driver</option>
									@foreach($drivers as $driver)
                                     <option value="{{$driver->id}}">{{$driver->name}}</option>   
									@endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-md-2 row-cols-1">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Installation Date</label>
                                <input type="date" id="installation_date"class="form-control" name="installation_date" placeholder="Installation Date" value="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Installer</label>
                                <select class="form-select" name="installer">
                                    <option selected="" value="">Select Installer</option>
									@foreach($installers as $install)
                                    <option value="{{$install->id}}">{{$install->name}}</option>  
									@endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Description</label>
								<textarea class="form-control" name="description" placeholder="Description"></textarea>
                            </div>
                        </div>
                    </div>
					 <div class="row row-cols-md-2 row-cols-1">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">C</label>
                                <input type="text" class="form-control" name="c" value="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">PL</label>
                                <input type="text" class="form-control" name="pl" value="">
                            </div>
                        </div>
                        </div>
                    <div class="d-flex btn-grid">
                        <button type="submit" class="btn" >Create</button>
                        <button type="reset" class="btn btn-white">Clear</button>
                    </div>
                </form>
            </div>
		</div>
		
    </div>
	
</main>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
	<script>
    var path = "{{ route('search-ro') }}";
	
    $( "#ro" ).autocomplete({
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
           $('#ro').val(ui.item.label);
		   $("#roid").val(ui.item.id);
		   $("#owner").val(ui.item.owner);
		   $("#postalcode").val(ui.item.site_address);
		
           return false;
        }
      });
	  
	  </script>

@include("layouts.admin.footer")