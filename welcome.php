<?php
// Initialize the session
session_start();
 // Include config file
include "config.php";


if(isset($_SESSION["receiverLoggedin"]) && $_SESSION["receiverLoggedin"] == true){
     $rId = $_SESSION["receiverId"]; 
}

if($_POST['bloodGroup'] && $_POST['hospId']){
   $bg =$_POST['bloodGroup'];
   $hid =  $_POST['hospId'];
    echo  $hid, $rId;
   $reqSql = "SELECT * FROM blood_requests WHERE hospital = '$hid' AND receiver ='$rId' AND granted = 1";

   $reqResult = $mysqli->query($reqSql);
    $reqCount = $reqResult->num_rows;         
     
    if(!$reqCount){
     $iSql = "INSERT INTO blood_requests 
            (hospital, receiver, blood_group) 
            values ('$hid','$rId','$bg') ";
     $bool = $mysqli->query($iSql);
    }else{
    $brSql = "UPDATE blood_requests SET granted = 0 WHERE receiver = '$rId' AND hospital = '$hid'";
    $mysqli->query($brSql);
    }   
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
include "navbar.php";
?>
    <!-- <div class="page-header">
        <h1>Hi, <b><?php //echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
    </div>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p> -->
<div class="container"> 
<?php
$pSql = "SELECT hospital_name, hospital_id FROM hospitals";
$pResult=$mysqli->query($pSql);




if($rId){
$rSql = "SELECT receiver_blood from receivers where receiver_id = '$rId'";
$rResult = $mysqli->query($rSql);
foreach($rResult as $r){
    $receiverBlood = $r['receiver_blood'];
  }
}
 foreach($pResult as $pRow)
{ 

  $hospital_id = $pRow['hospital_id'];
  echo  '<div class="container">', 
        $pRow['hospital_name'],
       '<table class="table table-striped">
         <thead>
         <tr>
         <th scope="col">BloodGroup</th>
         <th scope="col">Quantity</th>
         </tr>
         </thead>
         <tbody>';
 $cSql = "SELECT quantity, blood_group , hospital from blood_register 
         WHERE hospital = '$hospital_id'";
         $cResult=$mysqli->query($cSql);
         $row_cnt=$cResult->num_rows;
          foreach($cResult as $cRow)
         {
           echo '<tr>
                  <th scope="row">'.$cRow['blood_group'].'</th>
                  <td>'.$cRow['quantity'].'</td>';
     
        $hosp_id = $cRow['hospital'];        
        $requestedSql = "SELECT * from blood_requests 
                         WHERE receiver = '$rId' AND hospital ='$hosp_id' AND granted = 1";

         $requested_result=$mysqli->query($requestedSql);
         $requested_count = $requested_result->num_rows;
        
         if($rId){ 
            $bloodGroup =  $cRow['blood_group'];

         if($receiverBlood == $cRow['blood_group'] && $requested_count!=NULL){  
           echo  '<td>
                   <button onclick="myAjax(';echo "'",$bloodGroup,"'",","; echo "'",$hosp_id,"'"; echo ')" class="btn btn-primary mb-2">Request Sample</button>
                  </td>
                  </tr>';
            }else{
                echo '<td>
                     <button disabled="true" class="btn btn-primary mb-2">Request Sample</button>
                     </td>
                     </tr>';
            } 
        }else{
            echo '</tr>';
        }

            $row_cnt--;      
         }
         if($row_cnt==0){
           echo '</tbody>
            </table>
            </div>';  
         }      
}
?> 
</div>
<script>
function myAjax(bloodGroup,hospId) {
      $.ajax({
           type: "POST",
           data:{
                  bloodGroup:bloodGroup,
                  hospId:hospId               
                },
           url: 'http://127.0.0.1/bloodBank/welcome.php',
          
           success:function() {
             alert('Request Submitted');
             window.location.href = "welcome.php";
           }

      });
 }
</script>

</body>
</html>