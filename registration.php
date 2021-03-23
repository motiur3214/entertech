<!DOCTYPE html>
<html>
<head>
	<title>Registration</title>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style type="text/css">
.widthResize{
	width:40%;
	margin-bottom: 2px;
}	
</style>
</head>
<body>
<div class="container">
<h3>Please Registration</h3>	
<div>
<form method="post" action="./backend.php" autocomplete="off">
<input type="text" name="name" placeholder="Name" class="form-control widthResize" pattern="[a-zA-Z0-9_ ]+" required>
<input type="password" name="password" placeholder="password"  class="form-control widthResize" required>
<input type="email" name="email" placeholder="Email"  class="form-control widthResize" required>

<select class="form-control widthResize" name="location" id="getLocation" required >
	
	<option disabled="true" selected="true">Select Your Location</option>

</select>	
<input type="submit" name="submit" class="btn btn-success" value="registration" />
</form>
</div>
</div>
<script type="text/javascript">
	$( document ).ready(function() {
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
console.log(res);
let x = document.getElementById("getLocation");	
Object.keys(res).map(function (item) {
    option = document.createElement( 'option' );
    option.value = item;
    option.text =res[item];
    x.add( option );
});		
}
	});
});
</script>
</body>
</html>