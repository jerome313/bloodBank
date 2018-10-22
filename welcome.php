<?php
// Initialize the session
session_start();
 // Include config file
include "config.php";

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

<?php
$pSql = "SELECT hospital_name, hospital_id FROM hospitals";
$pResult=$mysqli->query($pSql);
 foreach($pResult as $pRow)
{ 
  $hospital_id = $pRow['hospital_id'];
  echo  $pRow['hospital_name'],

       '<table class="table table-striped">
         <thead>
         <tr>
         <th scope="col">BloodGroup</th>
         <th scope="col">Quantity</th>
         </tr>
         </thead>
         <tbody>';
 $cSql = "SELECT quantity, blood_group from blood_register 
         WHERE hospital = '$hospital_id'";
         $cResult=$mysqli->query($cSql);
         $row_cnt=$cResult->num_rows;
          foreach($cResult as $cRow)
         {
           echo '<tr>
                  <th scope="row">'.$cRow['blood_group'].'</th>
                  <td>'.$cRow['quantity'].'</td>
                  </tr>';
            $row_cnt--;      
         }
         if($row_cnt==0){
           echo '</tbody>
            </table>';  
         }      
}

?> 

</body>
</html>