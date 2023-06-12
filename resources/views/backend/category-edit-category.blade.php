@include("layouts.admin.header")

<main class="content-wrapper">
    <div class="container-fluid">

        <div class="box-shadow role">

            <div class="main-heading">
                <h1>
                    Edit Supplier
                </h1>
                <p>
                    This segment is to Edit Supplier.
                </p>
            </div>

            <div class="form mw-100">
                <form method="POST" action="/update-supplier">
                    @csrf
                    <div class="row row-cols-2">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Category Name</label>
                                <input type="hidden" id="id" value="{{$category->id}}">
                                <input type="text" class="form-control" id="category_name"placeholder="Category Name" value="{{$category->category_name}}">
                                <span class="text-danger" id="name-error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex btn-grid">
                        <button type="submit" class="btn" id="update-category">Update</button>
                        <a href="" class="btn btn-white">Clear</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
$("#update-category").click(function(e) {
 e.preventDefault();
 var id = $('#id').val();
 var category_name = $('#category_name').val(); 
 if(category_name==""){
 $('#name-error').text("This field is required."); 	
 }
 $.ajax({
	 url: "/update-category",
     type:"POST",
     data:{
     "_token": "{{ csrf_token() }}",
	  category_name:category_name,
	  id:id,
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