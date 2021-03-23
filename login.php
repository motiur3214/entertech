<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<style type="text/css">
		.container{
			margin-top: 20px;
		}
		.widthResize{
	        width:40%;
	        margin-bottom: 2px;
        }	

	</style>
</head>
<body>
<div class="container" align="center">
	<h3 >Login Page</h3>

	<form method="post" action="./backend.php" autocomplete="off">
		<input class="form-control widthResize" type="email" name="longinEmail" required  autocomplete="false" />
		<input class="form-control widthResize" type="password" id="mypassword" name="loginPassword" required  />
		<input type="checkbox" onclick="myFunction()">Show Password
		<input class="btn btn-success" type="submit" style="margin-left: 10px;" value="login" name="submit" />
	</form>
</div>
<script type="text/javascript">
function myFunction() {
  var x = document.getElementById("mypassword");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>
</body>
</html>