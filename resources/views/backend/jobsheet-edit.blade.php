@include("layouts.admin.header")
 <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
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
                    Edit Jobsheet
                </h1>
                <p>
                    This segment is to edit jobsheet.
                </p>
            </div>
			<div class="form mw-100">
                <form method="POST" action="/update-jobsheet">
                    @csrf
                    <div class="row row-cols-md-3 row-cols-1">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">RO*</label>
                                <input type="text" class="form-control" name="ro" placeholder="RO" value="{{$ro->order_id}}" readonly>
                                <input type="hidden" name="roid" value="{{$jobsheets->ro_id}}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">ID</label>
                                <input type="text" class="form-control" placeholder="ID" value="{{$ro->owner}}" readonly>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Postal Code/Address</label>
                                <input type="text" class="form-control" name="postalcode" placeholder="Postal Code/Address" value="{{$ro->site_address}}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-md-2 row-cols-1">
                        <div class="col">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Delivery Date</label>
                                <input type="date" id="delivery_date"class="form-control" name="delivery_date" placeholder="Delivery Date" value="{{$jobsheets->delivery_date}}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Driver</label>
                                <select class="form-select" name="driver">
                                    <option selected="" value="">Select Driver</option>
									@foreach($drivers as $driver)
                                     <option value="{{$driver->id}}" @if($driver->id == $jobsheets->driver) selected @endif>{{$driver->name}}</option>    
									 @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-md-2 row-cols-1">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Installation Date</label>
                                <input type="date" id="installation_date"class="form-control" name="installation_date" placeholder="Installation Date" value="{{$jobsheets->installation_date}}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">Installer</label>
                                <select class="form-select" name="installer">
                                    <option selected="" value="">Select Installer</option>
									@foreach($installers as $installer)
                                    <option value="{{$installer->id}}" @if($installer->id == $jobsheets->installer) selected @endif>{{$installer->name}}</option>    
									@endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Description</label>
								<textarea class="form-control" name="description" placeholder="Description">{{$jobsheets->description}}</textarea>
                            </div>
                        </div>
                    </div>
					 <div class="row row-cols-md-2 row-cols-1">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">C</label>
                                <input type="text" class="form-control" name="c" value="{{$jobsheets->c}}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group form-select-group w-100">
                                <label class="form-label">PL</label>
                                <input type="text" class="form-control" name="pl" value="{{$jobsheets->pl}}">
                            </div>
                        </div>
                        </div>
                    <div class="d-flex btn-grid">
                        <button type="submit" class="btn" >Update</button>
                        <button type="reset" class="btn btn-white">Clear</button>
                    </div>
                </form>
            </div>
		</div>
		
    </div>
	
</main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

@include("layouts.admin.footer")