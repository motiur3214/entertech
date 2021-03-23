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
<div class="container">
	
	
	 <?php  
session_start();
 if(isset($_SESSION["username"]))  
 {  ?>
 	<div class="container-fluid" align="center">
      <h3> Welcome <?php echo $_SESSION["name"]; ?></h3> 
      <div align="right">
       <a  type="button" class="btn btn-danger" href="logout.php" >Logout</a>  
</div>
   <div>
   <?php
   $loc='';
   $pro_id='';
   if ($result->rowCount() > 0) {
    echo '<div class="row">';
    while ($resposne=$result->fetch(PDO::FETCH_ASSOC)){
    	  $loc=$resposne["location"];
         $stmtLocation = ("SELECT location_name FROM tbl_location where id=$loc");
         $resultLocation = $conn->query($stmtLocation); 
     echo'<div class="column">
     <div class="card">
      <img src="./image/shirt.jpg" alt="'.$resposne["name"].'" style="width:100%">
     <h4>'.$resposne["name"].'</h4>
     <p class="price">$'.$resposne["unit_price"].'</p>';
while ($resposneLocation=$resultLocation->fetch(PDO::FETCH_ASSOC)){
     echo'<p>'.$resposneLocation["location_name"].'</p>';
 }

 $pro_id= $resposne['id'];
 ?>
    <button type="button" class="btn btn-success"  style="outline:none;" value="" onclick="buy_product(' <?php echo $pro_id; ?>')">Buy Now</button>

     </div>
     </div>
<?php
    }
  echo '</div>';
}
   	?>
   </div>
</div>
<?php
 }else{
 	header("location:index.php");
 }

 ?>
</div>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body" id="show_my_purchaes">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

<script type="text/javascript">

     function buy_product(id){
	
 $.ajax({  
		url:"ajax_request.php",  
		method:"post",  
		data:{
			flagreq:'buy_request',
			id: id,
			contentType: false,
			cache: false,
			processData: false,
         },  
        success:function(data){
        	console.log(data);
        	$("#myModal").modal();
		$('#show_my_purchaes').html(data);
			
		
}
	});

}	

</script>
</body>
</html>