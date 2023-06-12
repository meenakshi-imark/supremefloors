@include("layouts.admin.header")

<main class="content-wrapper">
    <div class="container-fluid">

        <div class="box-shadow role">

            <div class="main-heading">
                <h1>
                    Create New Category
                </h1>
                <p>
                    This segment is to create a New Category.
                </p>
            </div>

            <div class="form mw-100">
                <form method="POST" action="/create-new-category">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Category Name</label>
                                <input type="text" class="form-control" id="category_name"placeholder="Category Name">
                                <span class="text-danger" id="name-error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex btn-grid">
                        <button type="submit" class="btn" id="create-category">Create</button>
                        <a href="" class="btn btn-white">Clear</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$("#create-category").click(function(e) {
 e.preventDefault();
 var category_name = $('#category_name').val(); 
 if(category_name==""){
 $('#name-error').text("This field is required."); 	
 }
 $.ajax({
	 url: "/create-new-category",
     type:"POST",
     data:{
     "_token": "{{ csrf_token() }}",
	  category_name:category_name,
      },
	  success:function(response){
      if (response.status==true) {
	    $("#replacetxt").text(function(index, text) { 
        return text.replace('An account is successfully created.', response.msg); 
        }),
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