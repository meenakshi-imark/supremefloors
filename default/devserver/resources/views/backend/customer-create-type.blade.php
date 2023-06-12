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
                    Create Customer Type
                </h1>
                <p>
                This segment allows for new customer type to be created and customized. You can assign an individual to a role in the 'Create Account' segment.
                </p>
            </div>

            <div class="form mw-100">
                <form method="POST" action="/create_type">
				 @csrf
                    <div class="form-group">
                        <label class="form-label">Customer Type Name <span style="color:red" class="ms-0">*</span></label>
                        <input type="text" class="form-control" name="type"placeholder="Customer Type Name" required>
                    </div>

                    <div class="form-group form-select-group w-100">
                        <label class="form-label">Description <span style="color:red" class="ms-0">*</span></label>
                        <textarea id="searchit" class="searchit form-control" name="description" rows="10" placeholder="Write a here..." required></textarea>
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

@include("layouts.admin.footer")