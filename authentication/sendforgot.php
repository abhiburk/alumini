<?php
 session_start();
 ob_start();
include ('../config.php'); 
$userEmail = htmlentities($_POST["userEmail"]);
	if($userEmail==''){
	 echo '<h5 style="color:red;"><b>* Empty fields cannot submitted</b></h5>'; exit;
	}
if (isset($userEmail)){
	//echo '<pre>'; print_r($_REQUEST); print_r($_FILES); die;
	
	// Validate email address
 	$userEmail = filter_var($userEmail, FILTER_SANITIZE_EMAIL);

	if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL) === true) {
	 
    echo '<h5 style="color:red;"><b>* Entered Email-ID is not a valid email address</b></h5>'; exit;
	}else {
		
	//checking if email and password is matching in db
	$sql = $conn->prepare("SELECT * FROM users WHERE userEmail =:userEmail") ;
	$res = $sql->execute(array("userEmail" =>$userEmail));
	$row=$sql->fetch(PDO::FETCH_ASSOC);
	$count=$sql->rowCount();
	// If the count is equal to one, we will send message other wise display an error message.
	if($count==1)
	
	{
		//$rows=mysqli_fetch_array($query);
		$userPass  =  $row['userPass']; 
		$userName  =  $row['firstName'];
		$to = $row['userEmail'];
		//echo $sql; 
		//generating random password with length 10
		$randpass = substr(md5(uniqid(rand(),1)),3,10);  
		
		$encypass = md5($randpass); //encrypted version for database entry
		
		
		  
		
		$tempPassword='0';
		//Updating Password with ency before sending randompass
		$sql_update=$conn->prepare("UPDATE users SET userPass=:userPass,tempPassword=:tempPassword WHERE userEmail='".$to."'");
		$sql_update->execute(array(':userPass'=>$encypass,':tempPassword'=>$tempPassword));
		
		//echo '';
		$body= '<p style="width: 72%;">Hello <b>'.$userName.'</b> Here is your temparory password <b>'.$randpass.'</b>. <br/>
		You can login using this password and changed password to something more rememberable		</p>';
//		echo $body;exit;
	
		$from = "oyemate";
		$url = "http://www.oyemate.com/";
		
		$subject = "oyemate password recovery";
		$headers1 = "From: $from\n";
		$headers1 .= "Content-type: text/html;charset=iso-8859-1\r\n";
		$headers1 .= "X-Priority: 1\r\n";
		$headers1 .= "X-MSMail-Priority: High\r\n";
		$headers1 .= "X-Mailer: Just My Server\r\n";
		
		$sentmail = mail( $to, $subject, $body, $headers1 );
	} else {
		if ($userEmail != "") {
		echo '<h5 style="color:red;"><b>* Entered Email-ID not available in our system.</b></h5>'; exit;
		}
	}
	//If the message is sent successfully, display sucess message otherwise display an error message.
	if($sentmail==1)
		{
		echo 'sent';
		echo  '<p>Hello, <b>'.$userName.'</b> A temporary password for your account has been sent to your entered email-id, 
		please check your email-id and login using that password. Thank you </p>';
		}
		else
		{
		if($userEmail!="")
		echo '<h5 style="color:red;"><b>* Something went wrong, please try after sometime</b></h5>'; exit;
		}
}
}
?>