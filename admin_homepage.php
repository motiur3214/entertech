<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>	
</head>
<style type="text/css">
.form-control{
	width: 40%;
}	
#product_add{
	outline: none;
}
</style>
<body>
<?php	
session_start();
if(isset($_SESSION["username"]) && $_SESSION["admin_flag"]==1)  
 {  

 	?>
    <div class="container">
	<h3>Admin Homepage</h3>
	<div style="float:right"><a href="index.php" type="button" class="btn btn-info" >General homepage</a>  
		<a href="homepage.php" type="button" class="btn btn-default" >Homepage</a> 
    <a  type="button" class="btn btn-danger" href="logout.php" >Logout</a>
    <br><br>
    <button type="button" class="btn btn-warning btn-lg" data-toggle="modal" data-target="#myModal" id="product_add" >Add Product</button>
   </div>
    <div>
    	<label for="add_location">Add Location</label>
    <input type="text" class="form-control" name="add_location" id="add_location" autocomplete="off"/>
    <label for="add_admin">Add Admin</label>
    <select type="text" class="form-control" name="add_admin" id="add_admin">
    	<option selected="selected" disabled>Select an user</option>

    </select>
    </div>
    </div> 
 <?php
 } else{
 	header("location:homepage.php");
 }

?>
<div class="modal fade" id="myModal" role="dialog" align="center" >
    <div class="modal-dialog" >
    <div class="modal-content">
        <div class="modal-header" >
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Product Details</h4>
        </div>
        <div class="modal-body" id="modal_body">
     <form method="post" action="#" autocomplete="off" id="product_add_form">
	<input type="text" id="productName" placeholder="Product Name" class="form-control widthResize" pattern="[a-zA-Z ]+" required>
	<input type="text" id="unitPrice" placeholder="Unit Price" class="form-control widthResize" pattern="[0-9]+" title="please enter number only" required>
	<select class="form-control widthResize"  id="productLocation" required >
	
	<option disabled="true" selected="true">Select Your Location</option>
	</select>
	<input type="submit" name="submit" class="btn btn-success" value="Add product" style=" outline: none;"/>
       </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>


<script type="text/javascript">
	$( document ).ready(function() {

    get_users();
    get_location();
	$(document).on('change', '#add_location', function() {
	var reg = /^[a-zA-Z\s]*$/;	
    let newLoc=document.getElementById("add_location").value;
    newLoc=newLoc.trim();
    if(!reg.test(newLoc)){ 
    alert("Only letters and spaces.");
   
}else{
	
	$.ajax({  
		url:"ajax_request.php",  
		method:"post",  
		data:{
			flagreq:'addLocation',
			newLoc: newLoc,
			contentType: false,
			cache: false,
			processData: false,
         },  

		success:function(data){
		if(data==1){
			 alert("New location added successfull.");
			document.getElementById("add_location").value='';
		}
}
	});
}
});

$(document).on('change', '#add_admin', function() {
	let userid=document.getElementById("add_admin").value;
	
	$.ajax({  
		url:"ajax_request.php",  
		method:"post",  
		data:{
			userid:userid,
			flagreq:'makeAdmin',
			contentType: false,
			cache: false,
			processData: false,  
		},  
 success:function(data){
 	alert("Selected user is now an admin");
     setTimeout(function(){location.reload(); },0);

 }
});
});

$('#product_add_form').on("submit", function(event){
 event.preventDefault();
  let element = document.getElementById("modal_body");
let form_data = new FormData();
  form_data.append('flagreq',"add_product");
  form_data.append("productName", document.getElementById('productName').value);
  form_data.append("unitPrice", document.getElementById('unitPrice').value);
  form_data.append("productLocation",document.getElementById('productLocation').value);
  
  $.ajax({
    url:"ajax_request.php",
    method:"POST",
    data: form_data,
    contentType: false,
    cache: false,
    processData: false,
       
    success:function(data)
    {   console.log(data);
    	var para = document.createElement("p");
        var node = document.createTextNode("Product added successfully.");
         para.appendChild(node);
         element.appendChild(para);
         document.getElementById("product_add_form").reset();
         setTimeout(function(){ para.parentNode.removeChild(para); }, 3000);
         
    }
   });


});
});
 function get_users(){
 document.getElementById("add_admin").text='';
$.ajax({  
		url:"ajax_request.php",  
		method:"post",  
		data:{
			flagreq:'getUsers',
			contentType: false,
			cache: false,
			processData: false,  
		},  
 success:function(data){
 	
let res=JSON.parse(data);
let x = document.getElementById("add_admin");
Object.keys(res).map(function (item) {
    option = document.createElement( 'option' );
    option.value = item;
    option.text =res[item];
    x.add( option );
});
}
});
}
	
function get_location(){
	$.ajax({  
		url:"ajax_request.php",  
		method:"post",  
		data:{
			flagreq:'getAllLocation',
			contentType: false,
			cache: false,
			processData: false,  
		},  
         success:function(data){

       let res=JSON.parse(data);
       let x = document.getElementById("productLocation");	
    Object.keys(res).map(function (item) {
    option = document.createElement( 'option' );
    option.value = item;
    option.text =res[item];
    x.add( option );
});
  }
	});
}
</script>
</body>
</html>