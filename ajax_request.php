<?php
include_once('connection.php');
session_start(); 

extract($_POST);

if( $_POST["flagreq"] == 'addLocation')
{
$location_name=$_POST['newLoc'];
$stmt1 = $conn->prepare("INSERT INTO tbl_location (location_name)
  VALUES (:location_name)");
  $stmt1->bindParam(':location_name', $location_name);
  $stmt1->execute();

   if ($stmt1->rowCount() > 0) {
     echo 1;
    }else{
      echo 0;
    }
  }

if($_POST["flagreq"] == 'getAllLocation')
{
  $location_array= array();
  $resposne='';
  $stmt = ("SELECT id, location_name FROM tbl_location");
  $result = $conn->query($stmt);

   if ($result->rowCount() > 0) {
    while ($resposne=$result->fetch(PDO::FETCH_ASSOC)){
      $location_array[$resposne["id"]]= $resposne["location_name"];
    }
  }
  echo json_encode($location_array);
 }
if($_POST["flagreq"] == 'getUsers')
{
  $users_array= array();
  $resposne='';
  $stmt = ("SELECT id,email FROM tbl_users where admin_flag=0");
  $result = $conn->query($stmt);

   if ($result->rowCount() > 0) {
    while ($resposne=$result->fetch(PDO::FETCH_ASSOC)){
      $users_array[$resposne["id"]]= $resposne["email"];
    }
  }
  echo json_encode($users_array);
 }

if($_POST["flagreq"] == 'makeAdmin')
{
 $flagValue=1;
 $userid=$_POST['userid'];
 $stmt1 = $conn->prepare("UPDATE tbl_users SET admin_flag=:flagValue WHERE id=:userid");
 $stmt1->bindParam(':flagValue', $flagValue);
 $stmt1->bindParam(':userid', $userid);
 $stmt1->execute();

   if ($stmt1->rowCount() > 0) {
     echo 1;
    }else{
      echo 0;
    }
}

if ($_POST["flagreq"] == 'add_product') {
    
    $pName = test_input($_POST["productName"]);
    $uPrice = test_input($_POST["unitPrice"]);
    $pLocation=$_POST["productLocation"];
  try {
  $stmt = $conn->prepare("INSERT INTO tbl_products (name, unit_price, location)
  VALUES (:pName, :uPrice, :pLocation)");
  $stmt->bindParam(':pName', $pName);
  $stmt->bindParam(':uPrice', $uPrice);
  $stmt->bindParam(':pLocation', $pLocation);
  $stmt->execute();
 if ($stmt->rowCount() > 0) {
     echo 1;
    }else{
      echo 0;
    }
 }catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
}

if ($_POST["flagreq"] == 'buy_request') {
    $product_unit=1;
    $user=$_SESSION["user_id"];
    $id = test_input($_POST["id"]);
    date_default_timezone_set('Asia/Dhaka');
    $date=date("Y-m-d H:i:s");
    $pPrice=0;
    $locFlag=0;
    $product_name='';
    $user_loc_name='';
    $product_loc='';
try {
  $stmt = ("SELECT * FROM tbl_products where id=$id");
  $result = $conn->query($stmt);

   if ($result->rowCount() > 0) {
    while ($resposne=$result->fetch(PDO::FETCH_ASSOC)){
      $pName= $resposne["name"];
      $pPrice= $resposne["unit_price"];
      $pLocation= $resposne["location"];
    }
    if ($_SESSION["location"]==$pLocation ) {
    	$pPrice=$pPrice-$pPrice*(0.25);
    	$locFlag=1;
    }
  $stmt = $conn->prepare("INSERT INTO tbl_bought_product (user_id, user_email, user_location, product_id, product_location, product_unit, total_price, bought_at)
  VALUES (:user_id, :user_email, :user_location, :product_id, :product_location, :product_unit, :total_price, :bought_at)");
  $stmt->bindParam(':user_id', $_SESSION["user_id"]);
  $stmt->bindParam(':user_email',  $_SESSION["username"]);
  $stmt->bindParam(':user_location', $_SESSION["location"]);
  $stmt->bindParam(':product_id', $id);
  $stmt->bindParam(':product_location', $pLocation);
  $stmt->bindParam(':product_unit', $product_unit);
  $stmt->bindParam(':total_price', $pPrice);
  $stmt->bindParam(':bought_at', $date );
  $stmt->execute();
 if ($stmt->rowCount() > 0) {
  $stmt_show = ("SELECT * FROM tbl_bought_product where user_id=$user");
  $result_show = $conn->query($stmt_show);

   if ($result_show->rowCount() > 0) {
      while ($resposne_show=$result_show->fetch(PDO::FETCH_ASSOC)){
      $pro_id=$resposne_show["product_id"];
      $user_loc=$resposne_show["user_location"];
      $pro_loc=$resposne_show["product_location"];

      
      $stmt_pro_name = ("SELECT name FROM tbl_products where id=$pro_id");
      $result_pro_name = $conn->query($stmt_pro_name);

   if ($result_pro_name->rowCount() > 0) {
      while ($resposne_pro_name=$result_pro_name->fetch(PDO::FETCH_ASSOC)){
           $product_name= $resposne_pro_name["name"];
      }
      }


      $stmt_user_loc = ("SELECT location_name FROM tbl_location where id=$user_loc");
      $result_user_loc = $conn->query($stmt_user_loc);
    
    if ($result_user_loc->rowCount() > 0) {
      while ($resposne_user_loc=$result_user_loc->fetch(PDO::FETCH_ASSOC)){
           $user_loc_name= $resposne_user_loc["location_name"];
      }
      }



   $stmt_pro_loc = ("SELECT location_name FROM tbl_location where id=$pro_loc");
   $result_pro_loc = $conn->query($stmt_pro_loc);

   if ($result_pro_loc->rowCount() > 0) {
      while ($resposne_pro_loc=$result_pro_loc->fetch(PDO::FETCH_ASSOC)){
           $product_loc= $resposne_pro_loc["location_name"];
      }
      }

echo'<table class="table table-striped">
    <thead>
      <tr>
        <th>Purchase Date</th>
        <th>User Name</th>
        <th>Email</th>
         <th>Users Location</th>
        <th>Product Name</th>
         <th>Quantity</th>
        <th>Total price</th>
        <th>Product Location</th>
      </tr>
    </thead>
    <tbody>
      <tr>
      <td>'.$resposne_show["bought_at"].'</td>
      <td>'.$_SESSION["name"].'</td>
      <td>'.$resposne_show["user_email"].'</td>
      <td>'.$user_loc_name.'</td>
      <td>'.$product_name.'</td>
      <td>'.$resposne_show["product_unit"].'</td>
      <td>'.$resposne_show["total_price"].'</td>
      <td>'.$product_loc.'</td>
        
      </tr>
      
    </tbody>
  </table>';


      }
    }else{
      echo 0;
    }
 }
}
}catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}

}



function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
$conn=null;
?>