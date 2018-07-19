<?php
require("../config.php");
session_start();
ob_start();
$userid=$_SESSION['userid'];
$time=time();
$time_check=$time-450; // 5 minutes
 
$sql1=mysqli_query($dbconfig,"UPDATE user_active SET activeTime='".$time."' WHERE userID='".$userid."' "); 
//$sql2=mysqli_query($dbconfig,"DELETE FROM user_session WHERE userID='".$userid."' or session_time<'".$time_check."'"); 
$sql2=mysqli_query($dbconfig,"DELETE FROM user_session WHERE userID='".$userid."' "); 

//This function will destroy your session

unset($_SESSION['login']);
unset($_SESSION['session_name']);
unset($_SESSION['userid']);
unset($userid); 
	

// "You are now logged out! <a href=checkregister.php>Register</a> or <a href=index.php>Login</a>";
if($_SESSION['login'] != 'success'){
	header('location:../index.php'); exit;	
}
?> 