<?php
include("Admin/includes/function.php");

if(isset($_SESSION['LoggedIn'])){
    logoutSession();
    echo "<script>window.open('index.php','_self')</script>";
    $_SESSION['success'] = "You've Logged Out.";
}

?>