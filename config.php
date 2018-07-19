<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'alumini';
$session=session_id();
$time=time();
$dbconfig = mysqli_connect($host,$username,$password,$database);
try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //  echo "Connected successfully";
    }
catch(PDOException $e)
    {
   // echo "Connection failed: " . $e->getMessage();
    }
error_reporting(0);
	
$name="CONCAT(firstName,' ',lastName) AS name";	
if(!isset($_SESSION)) 
{  session_start();  } 
$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : '';
date_default_timezone_set('Asia/Kolkata');	

$sql_user=mysqli_query($dbconfig,"SELECT *,$name
FROM users AS u LEFT JOIN users_edu USING (userID) LEFT JOIN user_workplace USING (userID) LEFT JOIN user_social_con USING (userID)
WHERE u.userID='".$userid."'") or die(mysqli_error());
$user=mysqli_fetch_assoc($sql_user);


?>