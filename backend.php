<?php
include_once('connection.php');
session_start(); 
$name='';
$email='';
$location='';
 $password='';
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["name"] && $_POST["email"] && $_POST["password"] && $_POST["location"]) {
    
    $name = test_input($_POST["name"]);
    $email = test_input($_POST["email"]);
    $password=md5($_POST["password"]);
    $location = test_input($_POST["location"]);

try {

   $stmt = $conn->prepare("INSERT INTO tbl_users (name, password, email, location)
  VALUES (:name, :password, :email, :location)");
  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':password', $password);
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':location', $location);
  $stmt->execute();
  
  header("location:login.php?res=1");
 }catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}

}


if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["longinEmail"] && $_POST["loginPassword"])  
      {
        try{  
           if(empty($_POST["longinEmail"]) || empty($_POST["loginPassword"]))  
           {  
              header("location:login.php?res=0");
           }  
           else  
           {  
                $query = "SELECT * FROM tbl_users WHERE email = :longinEmail AND password = :loginPassword";  
                $statement = $conn->prepare($query);  
                $statement->execute(  
                     array(  
                          'longinEmail'     =>        $_POST["longinEmail"],  
                          'loginPassword'     =>     md5($_POST["loginPassword"])  
                     )  
                );  
                $count = $statement->rowCount();  
                if($count > 0)  
                {  

                     $_SESSION["username"] = $_POST["longinEmail"]; 
                     while ($resposne=$statement->fetch(PDO::FETCH_ASSOC)){
                       $_SESSION["user_id"]=$resposne["id"];
                      $_SESSION["admin_flag"]=$resposne["admin_flag"];
                      $_SESSION["name"]=$resposne["name"];
                      $_SESSION["location"]=$resposne["location"];
          $queryLocation = "SELECT id FROM tbl_location WHERE  = :longinEmail AND password = :loginPassword";  
                $statement = $conn->prepare($query);             
                     } 
                 if ($_SESSION["admin_flag"]==1) {
                      header("location:admin_homepage.php");  
                     }else{   
                     header("location:homepage.php?res=1");  
                   }
                }  
                else  
                {  
                  echo($_POST["longinEmail"]);
                     header("location:login.php?res=0");    
                }  
           }  
      }
      catch(PDOException $error){  
      echo $error->getMessage();  
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