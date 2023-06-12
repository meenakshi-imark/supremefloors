@include("layouts.admin.header")

<main class="content-wrapper">
    <div class="container-fluid">
		@if (\Session::has('success'))
        <div class="alert alert-success">
		{!! \Session::get('success') !!}
        </div>
		@endif
		@if (\Session::has('error'))
			<div class="alert alert-danger">
			{!! \Session::get('error') !!}
			</div>
		@endif 
        <div class="box-shadow role">

            <div class="main-heading">
                <h1>
                    Edit Customer Type
                </h1>
                <p>
                    This segment allows for new customer type to be created and customized. You can assign an individual to a role in the 'Create Account' segment.
                </p>
            </div>

            <div class="form mw-100">
                <form method="POST" action="/update-type">
				@csrf
                    <div class="form-group">
                        <label class="form-label">Customer Type Name</label>
                        <input type="text" class="form-control" placeholder="Customer Type Name" name="type_name" value="{{$type->type_name}}">
                        <input type="hidden" name="id" value="{{$type->id}}">
                    </div>

                    <div class="form-group form-select-group w-100">
                        <label class="form-label">Description</label>
                        <textarea id="searchit" class="searchit form-control" rows="10" placeholder="Write a here..." name="description">{{$type->description}}</textarea>
                    </div>

                    <div class="d-flex btn-grid">
                        <button type="submit" class="btn">Update</button>
                        <button type="reset" class="btn btn-white">Clear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

@include("layouts.admin.footer")