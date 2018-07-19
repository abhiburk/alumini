<?php
require('../config.php');

//if( $vuser->is_logged_in() ){ header('Location: profile.php'); }
//echo '<pre>'; print_r($_REQUEST); print_r($_FILES); die;
$time =time();

$firstName = ($_POST["firstName"]);
$lastName =  ($_POST["lastName"]);
$userPass = md5($_POST["upass"]);
$userEmail = ($_POST["umail"]);
$day = $_POST["day"];
$month = $_POST["month"];
$year = $_POST["year"];
$gender = $_POST["gender"];
$bday= date('Y-m-d',strtotime($year.'-'.$month.'-'.$day));

if($firstName=='' or $lastName=='' or $userPass=='' or $userEmail=='' or $day=='' or $month=='' or $year=='' or $gender==''){
	 echo '<h5 style="color:red;"><b>* Empty fields cannot submitted</b></h5>'; exit;
}

//creating sessions to hold form data if registration fails
$_SESSION['firstName']=$firstName;
$_SESSION['lastName']=$lastName;
$_SESSION['userEmail']=$userEmail;
$_SESSION['day']=$day;
$_SESSION['month']=$month;
$_SESSION['year']=$year;
$_SESSION['gender']=$gender;

// Validate e-mail
$userEmail = filter_var($userEmail, FILTER_SANITIZE_EMAIL);
if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL) === true) {
	 echo '<h5 style="color:red;"><b>* Entered Email-ID is not a valid email address</b></h5>'; exit;
}else {
 
	$sql1 = $conn->prepare("SELECT * FROM users WHERE userEmail =:userEmail") ;
	$res = $sql1->execute(array("userEmail" =>$userEmail));
	$row=$sql1->fetch(PDO::FETCH_ASSOC);
	$count=$sql1->rowCount();
	
	//checking if user already exist 
	if($count != 0){
	 echo '<h5 style="color:red;"><b>* Entered Email-ID is already registerd with us</b></h5>'; exit;
	}
	else {
		//checking if password is not less then 8 char
		if(strlen($_POST['userPass']) >= 8){
			 echo '<h5 style="color:red;"><b>* Entered password must be 8 or more then 8 characters</b></h5>'; exit;
		} 
		else { 
	
			//generating random password with length 6
			$randcode = substr((uniqid(rand(),1)),3,6);  
					
			//else register user successfully
			$sql=$conn->prepare("INSERT INTO users (firstName,lastName,userEmail,userPass,birthday,gender,verificationCode,createTime) VALUES 
			(?,?,?,?,?,?,?,?)");
			$sql->execute(array($firstName,$lastName,$userEmail,$userPass,$bday,$gender,$randcode,$time));
	
			//email format
			//	
			//		$from = "oyemate";
			//		$url = "http://www.oyemate.com/";
			//		
			//		$subject = "oyemate password recovery";
			//		$headers1 = "From: $from\n";
			//		$headers1 .= "Content-type: text/html;charset=iso-8859-1\r\n";
			//		$headers1 .= "X-Priority: 1\r\n";
			//		$headers1 .= "X-MSMail-Priority: High\r\n";
			//		$headers1 .= "X-Mailer: Just My Server\r\n";
			//		
			//		$sentmail = mail( $to, $subject, $body, $headers1 );
			//	
			//	//If the message is sent successfully, display sucess message otherwise display an error message.
			//	if($sentmail==1)
			//		{
			//		echo 'sent';
			//		echo  '<p>Hello, <b>'.$userName.'</b> A temporary password for your account has been sent to your entered email-id, 
			//		please check your email-id and login using that password. Thank you </p>';
			//		}
			//	else{
			//	if($userEmail!="")
			//		echo '<h5 style="color:red;"><b>* Something went wrong, please try after sometime</b></h5>'; exit;
			//	}
		
			//loging user
			if($sql==true)
			{
				//unset session which were hold earlier	
				unset($_SESSION['firstName']);unset($_SESSION['lastName']);unset($_SESSION['userEmail']);
				unset($_SESSION['day']);unset($_SESSION['month']);unset($_SESSION['year']);unset($_SESSION['gender']);
			
				//checking if email and password is matching in db
				$sql = $conn->prepare("SELECT * FROM users WHERE userEmail =:userEmail AND userPass =:userPass") ;
				$res = $sql->execute(array("userEmail" =>$userEmail,"userPass"=>md5($_REQUEST['upass'])));
				$row=$sql->fetch(PDO::FETCH_ASSOC);
				$count=$sql->rowCount();
							$_SESSION['login']=true;
							$_SESSION['userid']= $row['userID'];
							//echo $_SESSION['userid'];exit;
							echo 'true'; exit; 
					 
			}else{
		  		echo '<h5 style="color:red;"><b>Failed to create account, please try after sometime</b></h5>'; exit;
			}
   
   		}
		
	 }
	 
}// end email condition


?>