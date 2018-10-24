<?php
session_start();
 include 'config.php';
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

if(isset($_POST['bloodGroup']) && isset($_POST['recId'])){
  $bGroup = $_POST['bloodGroup']; 
  $rId = $_POST['recId'];  
  $bSql = "UPDATE blood_register SET quantity = quantity - 1 
          WHERE hospital = '$hospital_id' AND blood_group = '$bGroup'";
  $mysqli->query($bSql);
  $brSql = "UPDATE blood_requests SET granted = 1 WHERE receiver = '$rId'";
  $mysqli->query($brSql);
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
        body{ font: 14px sans-serif; text-align: center; background-color:#f2f2f2 }
    </style>
</head>
<body>
<?php
include 'navbar.php';
?>
<div class="container mt-5">
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Requester Name</th>
      <th scope="col">Blood Group</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
 <?php
 $sql = "SELECT hospital, receiver, blood_group FROM blood_requests 
         WHERE hospital = '$hospital_id' AND granted = 0";
 $result = $mysqli->query($sql);
 $count = 1;
 foreach($result as $row){
  $bloodGroup = $row['blood_group'];
   $bloodGroup;
  $receiverId = $row['receiver']; 
  $rSql = "SELECT receiver_name from receivers WHERE receiver_id = '$receiverId'";
  $rResult = $mysqli->query($rSql);
  foreach($rResult as $row){
    $receiverName = $row['receiver_name'];
   }  
  
   echo  '<tr>   
          <th scope="row">'.$count.'</th>
          <td>'.$receiverName.'</td>
          <td>'.$bloodGroup.'</td>
          <td> <button onclick="myAjax(';echo "'",$bloodGroup,"'",","; echo "'",$receiverId,"'"; echo ')" class="btn btn-primary mb-2">Grant Sample</button></td>
          </tr>';
    $count++;      
 }         
?>   
  </tbody>
</table>
</div>
<script>
function myAjax(bloodGroup,recId) {
      $.ajax({
           type: "POST",
           data:{
                  bloodGroup:bloodGroup,
                  recId:recId               
                },
           url: 'http://127.0.0.1/bloodBank/requestersList.php',
          
           success:function() {
             alert('Blood Sample Granted');
             window.location.href = "requestersList.php";
           }

      });
 }
</script>
</body>
</html>