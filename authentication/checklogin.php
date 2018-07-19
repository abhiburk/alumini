<?php
session_start();
ob_start();
$time=time();
$session=session_id();
require('../config.php');
//echo '<pre>'; print_r($_REQUEST); print_r($_FILES); die;

$userEmail = $_POST["userEmail"];
$userPass = md5($_POST['userPass']);
if($userEmail=='' or $userPass==''){
	echo '<h5 style="color:red;"><b>*Fields cannot be empty</h5>'; exit;
	}
//unset session created during register
unset($_SESSION['firstName']);unset($_SESSION['lastName']);unset($_SESSION['userEmail']);
unset($_SESSION['day']);unset($_SESSION['month']);unset($_SESSION['year']);unset($_SESSION['gender']);

//checking if email and password is matching in db
$sql = $conn->prepare("SELECT * FROM users WHERE userEmail =:userEmail AND userPass =:userPass") ;
$res = $sql->execute(array("userEmail" =>$userEmail,"userPass"=>$userPass));
$row=$sql->fetch(PDO::FETCH_ASSOC);
$count=$sql->rowCount();

	if($count != 1){ 
		echo '<h5 style="color:red;"><b>* Incorrect Username or Password</b></h5>';
	}else{

			$_SESSION['login']=true;
			$_SESSION['userid']= $row['userID'];
			//$_SESSION['firstName'] = $row['firstName'];
			
			if($row['verificationCode']!='verified') {
	    		echo 'unvarified';
			}else {
			
				//checking for session user
				$sql_session=mysqli_query($dbconfig,"SELECT * FROM user_session 
				WHERE userID='".$_SESSION['userid']."'")or die (mysqli_error()); 
				$count_session=mysqli_num_rows($sql_session); 
				
				//If count is 0 insert session
				if($count_session==0){ 
				$sql_active_insert=mysqli_query($dbconfig,"INSERT INTO user_session(userID,session_name,session_time)
				VALUES('".$_SESSION['userid']."','".$session."','".$time."')") or die (mysqli_error()); 
				}
				// else update the session 
				 else {
				$sql_update=mysqli_query($dbconfig,"UPDATE user_session SET session_time ='".$time."',session_name='".$session."'
				WHERE userID ='".$_SESSION['userid']."' ") or die (mysqli_error());
				}
				
				//checking for active user
				$sql_active=mysqli_query($dbconfig,"SELECT * FROM user_active 
				WHERE userID='".$_SESSION['userid']."'") or die (mysqli_error()); 
				$count_active=mysqli_num_rows($sql_active); 
				
				//If count is 0 insert session
				if($count_active==0){ 
				$sql_active_insert=mysqli_query($dbconfig,"INSERT INTO user_active(userID,activeTime)
				VALUES('".$_SESSION['userid']."','".$time."')")or die (mysqli_error()); 
				}
				// else update the session 
				 else {
				$sql_update=mysqli_query($dbconfig,"UPDATE user_active SET activeTime ='".$time."' 
				WHERE userID='".$_SESSION['userid']."' ") or die (mysqli_error());
				}
				
				if($row['tempPassword'] =='0') {
					  echo '<h5 style="color:red;"><b>system</b></h5>';
				}else {
					 'home';
				}
				 echo 'true';
			}
	}
	

?>