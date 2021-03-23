
<?php
include_once('connection.php');
$stmt = ("SELECT * FROM tbl_products");
$result = $conn->query($stmt);
?>
<!DOCTYPE html>
<html>
<head>
<title>Homepage</title>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="mystyle.css">
</head>
<body>
	
<div class="container"  style="margin-top:20px; ">
	<div>
		<h3 align="center">Registration/Login to buy poroducts</h3>
	</div>
	<div align="right">
    <a href="./registration.php" type="button" class="btn btn-danger">Registration</a>	
    <a href="./login.php" type="button" class="btn btn-success">Login</a>	
   </div>
   <div class="container-fluid" >

   	<?php
   if ($result->rowCount() > 0) {
    echo '<div class="row">';
    while ($resposne=$result->fetch(PDO::FETCH_ASSOC)){
      
     echo'<div class="column">
     <div class="card">
      <img src="./image/shirt.jpg" alt="'.$resposne["name"].'" style="width:100%">
     <h4>'.$resposne["name"].'</h4>
     <p class="price">$'.$resposne["unit_price"].'</p>
     <p>'.$resposne["location"].'</p>
     </div>
     </div>';
    }
  echo '</div>';
}
   	?>
   </div>
</div>
</body>
</html>


