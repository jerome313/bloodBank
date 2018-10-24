
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<a class="navbar-brand" href="#"> <img class="logo" src="http://bootstrap-ecommerce.com/main/images/logo-white.png" height="40"> BloodBank</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar1" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbar1">
    <ul class="navbar-nav ml-auto"> 
<?php
session_start();
if(isset($_SESSION["hospitalLoggedin"]) && $_SESSION["hospitalLoggedin"] == true){
  echo '<li class="nav-item">
  <a class="nav-link" href="welcome.php">
   Home </a></li>';

  echo '<li class="nav-item">
  <a class="nav-link" href="hospitalDashboard.php">
   Dashboard </a></li>';

  echo '<li class="nav-item">
       <a class="nav-link" href="requestersList.php">
        Blood Requests </a></li>';
}

if(!isset($_SESSION["receiverLoggedin"]) && $_SESSION["receiverLoggedin"] !== true
   && 
   !isset($_SESSION["hospitalLoggedin"]) && $_SESSION["hospitalLoggedin"] !== true
){
echo        
'

<li class="nav-item">
<a class="btn btn-sm mr-3 btn-warning" href="receiverLogin.php">Login as Receiver</a></li>

<li class="nav-item">
<a class="btn btn-sm mr-3 btn-warning" href="hospitalLogin.php"> or Hospital</a></li>
';
}else{
echo
'
<li class="nav-item">
<a href="logout.php" class="btn btn-danger">Sign Out</a></li>
';    
}
?>
    </ul>
  </div>
</nav>