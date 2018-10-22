<?php
// Initialize the session
session_start();
 
//Check if the user is logged in, if not then redirect him to login page
if(isset($_SESSION["receiverLoggedin"]) && $_SESSION["receiverLoggedin"] == true){
    header("location: welcome.php");
    exit;
}else{
    $hospital_id =  $_SESSION["hospitalId"];
}
if(!$_SESSION){
    header("location: welcome.php");
    exit;
}
// Include config file
include "config.php";
 
// Define variables and initialize with empty values
$bloodGroup = $quantity = "";
$bloodGroup_err = $quantity_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
if($_SERVER["REQUEST_METHOD"] == "POST"){    
    // Check if BloodGroup is empty 
      if(empty(trim($_POST["bloodgroup"]))){
        $bloodGroup_err = "Please enter blood group.";
    } else{
        $bloodGroup = trim($_POST["bloodgroup"]);
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST"){    
    // Check if quantity is empty
      if(empty(trim($_POST["quantity"]))){
        $quantity_err = "Please enter quantity.";
    } else{
        $quantity = trim($_POST["quantity"]);
    }
}
if(empty($bloodGroup_err) && empty($quantity_err)){     
    $sql = "SELECT * FROM blood_register WHERE hospital = '$hospital_id' AND blood_group = '$bloodGroup'";
    $result=$mysqli->query($sql);
        $row_cnt=$result->num_rows;
      if($row_cnt){  
    $updateSql = "UPDATE  blood_register SET quantity = quantity + '$quantity' WHERE hospital = '$hospital_id'";
    $mysqli->query($updateSql);
    mysqli_close($link);
       } else{
          $insertSql = "INSERT INTO blood_register (blood_group, quantity, hospital) VALUES ('$bloodGroup' ,'$quantity', '$hospital_id')";             
          $mysqli->query($insertSql);
          mysqli_close($link);     
      }
    } else{
            echo "Oops! Something went wrong. Please try again later.";
        }  
    mysqli_close($link);
    }      
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="index.css" rel="stylesheet" >
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
<?php
include 'navbar.php'; 
?>
   <div class="container"> 
   <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="form-group mb-2">
    <?php echo (!empty($bloodGroup_err)) ?
        $bloodGroup_err : ''; ?>
    <?php echo (!empty($quantity_err)) ?
        $quantity_err : ''; ?>    
        <div class="input-group mb-3 form-group">
          <div class="input-group-prepend">
             <label class="input-group-text" for="inputGroupSelect01">Blood Group</label>
               </div>                
                 <select class="custom-select" name="bloodgroup" id="inputGroupSelect01">
                    <option value="" selected>Choose...</option>
                    <option value="O-positive">O-positive</option>
                    <option value="O-negative">O-negative</option>
                    <option value="A-positive">A-positive</option>
                    <option value="A-negative">A-negative</option>
                    <option value="B-positive">B-positive</option>
                    <option value="B-negative">B-negative</option>
                    <option value="AB-positive">AB-positive</option>
                    <option value="AB-negative">AB-negative</option>
                 </select>
         </div>
   </div>
      <div class="form-group mx-sm-3 mb-2">
          <div class="input-group mb-3">
             <div class="input-group-prepend <?php echo (!empty($quantity_err)) ?
        'has-error' : '';?>">
             <span class="input-group-text" id="basic-addon3">number of units</span>
           </div>
         <input type="text" name="quantity" class="form-control" id="basic-url" aria-describedby="basic-addon3">
       </div>
  </div>
    <div class="form-group mx-sm-3 mb-2">
     <button type="submit" class="btn btn-primary mb-2">Submit</button>
   </div> 
</form>
<?php

?>
</div class="container">
<div class="container">
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">BloodGroup</th>
      <th scope="col">Quantity</th>
    </tr>
  </thead>
  <tbody>  
<?php
$Tsql = "SELECT quantity, blood_group from blood_register 
WHERE hospital = '$hospital_id'";
$result=$mysqli->query($Tsql);
 foreach($result as $row)
{
  echo '<tr>
         <th scope="row">'.$row['blood_group'].'</th>
         <td>'.$row['quantity'].'</td>
         </tr>';
}
?>    
  </tbody>
</table>
</div>
</body>
</html>
