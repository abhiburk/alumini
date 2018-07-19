<?php 
require '../config.php';
require '../includes/ImageManipulator.php';
error_reporting(0);
$time=time();
$action = isset($_REQUEST['xAction']) ? htmlentities($_REQUEST['xAction']) : '';
//echo '<pre>'; print_r($_REQUEST); print_r($_FILES); die;



if($action=='email_verify'){
$vcode=$_REQUEST['vcode'];	
$verificationCode='verified';	
	
	//checking if email and password is matching in db
$sql = $conn->prepare("SELECT * FROM users WHERE verificationCode =:vcode") ;
$res = $sql->execute(array("vcode" =>$vcode));
$row=$sql->fetch(PDO::FETCH_ASSOC);
$count=$sql->rowCount();

	if($count != true){ 
		echo '<h5 style="color:red;"><b>* Incorrect Verification Code</b></h5>';
	}else{
		
	$sql =$conn->prepare("UPDATE users SET verificationCode = :verificationCode
	WHERE userID = '".$userid."' ");
	$sql->execute(array(':verificationCode'=>$verificationCode));
			if($sql==true){
				echo 'true';
			}else{
				echo 'fail';
			}
	}
}

// for update question
if($action=='update_answer'){

	$answerText=($_REQUEST['answerText']);
	$answerID=($_REQUEST['answerID']);
	
	if($answerText==''){
	echo '<h5 style="color:red;">* Empty Fields Cannot be Submited</h5>';exit;
	}
	
	$sql =$conn->prepare("UPDATE forum_answers SET answerText = :answerText,updateTime = :updateTime
	WHERE answerID = '".$answerID."' ");
	$sql->execute(array(':answerText'=>$answerText,':updateTime'=>$time));
	if($sql==true){
	echo 'true';
	}else{
	echo 'false ';	
	}

}

//for ans down vote
if($action=='accept_answer'){

$answerID=$_REQUEST['answerID'];
$fqID=$_REQUEST['fqID'];

$sql_if_accepted=mysqli_query($dbconfig,"SELECT * FROM forum_questions WHERE fqID='".$fqID."' AND userID='".$userid."'
AND answerAccepted='1' "); 
$check_if_accepted=mysqli_num_rows($sql_if_accepted);
if($check_if_accepted!=true){
  
		   $sql=mysqli_query($dbconfig,"UPDATE forum_questions SET answerAccepted='1',answerID='".$answerID."',acceptTime='".$time."' 
		   WHERE fqID='".$fqID."' ");
		
			  
		   
	   }else{
			echo 'already'; 
	   }
		
		
if($sql==true){
		echo 'true';
	}else{
		echo 'Fail';	
	} 

}

//for ans down vote
if($action=='down_ans_vote'){

	$answerID=$_REQUEST['answerID'];
	$type=$_REQUEST['type']; 
	$ownerID=$_REQUEST['ownerID'];
	
	$sql_if_voted=mysqli_query($dbconfig,"SELECT * FROM forum_answer_votes WHERE answerID='".$answerID."' AND userID='".$userid."'
	AND type='down' "); 
	$row_if_voted=mysqli_fetch_assoc($sql_if_voted);
	if($ownerID!=$userid){
		$check_if_voted=mysqli_num_rows($sql_if_voted);
		if($check_if_voted!=true){
		  
			   $sql_if_down=mysqli_query($dbconfig,"SELECT * FROM forum_answer_votes WHERE answerID='".$answerID."' AND userID='".$userid."'
			   AND type='up' "); 
			   $check_if_down=mysqli_num_rows($sql_if_down);
			   if($check_if_down==true){
				   
				   $sql=mysqli_query($dbconfig,"UPDATE forum_answers SET votes=votes-2 WHERE answerID='".$answerID."' ");
				   $sql=mysqli_query($dbconfig,"UPDATE forum_answer_votes SET type='down' WHERE answerID='".$answerID."' AND userID='".$userid."' ");
				   
				   
				   // and update notification if up to down
					$sql=mysqli_query($dbconfig,"SELECT *,a.userID FROM forum_questions LEFT JOIN forum_answers AS a USING (fqID)
					WHERE a.answerID='".$answerID."' ");
					$row=mysqli_fetch_assoc($sql);
					$tittle=($row['tittle']);
					$notiTo=($row['userID']);
					
					$type='answer.vote.down';
					$notiText='has down voted to your answer to the question: <b>"'.$tittle.'"</b> ';
					$reference='forum_answer_id';
					$referenceID=$answerID; //this is id of forum_questions table
					$sql=mysqli_query($dbconfig,"UPDATE notifications SET `read`='0',notiText='".$notiText."',type='".$type."'
					WHERE referenceID='".$answerID."' AND notiTo='".$notiTo."'
					AND reference='".$reference."' AND type='answer.vote.up' AND notiBy='".$userid."' ");
				   
			   }else{
					//insert vote
					$sql=$conn->prepare("INSERT INTO forum_answer_votes (userID,answerID,type,voteTime) VALUES 
					(?,?,?,?)");
					$sql->execute(array($userid,$answerID,$type,$time));
					
					// update vote counts for question
					$sql=mysqli_query($dbconfig,"UPDATE forum_answers SET votes=votes-1 WHERE answerID='".$answerID."' ");
					
					$sql=mysqli_query($dbconfig,"SELECT *,a.userID FROM forum_questions LEFT JOIN forum_answers AS a USING (fqID)
					WHERE a.answerID='".$answerID."' ");
					$tittle=($row['tittle']);
					
					//notifying vote of new user
					$notiTo=($row['userID']);
					$type='answer.vote.down';
					$notiText='has down voted to your answer to the question: <b>"'.$tittle.'"</b> ';
					$reference='forum_answer_id';
					$referenceID=$answerID; //this is id of forum_answers table
					$sql_noti=$conn->prepare("INSERT INTO notifications (notiBy,notiTo,type,notiText,reference,referenceID,notiTime) VALUES 
					(?,?,?,?,?,?,?)");
					$sql_noti->execute(array($userid,$notiTo,$type,$notiText,$reference,$referenceID,$time));
			   }
				
		
				$sql_if_vote=mysqli_query($dbconfig,"SELECT * FROM forum_answers WHERE answerID='".$answerID."'"); 
				$voted=mysqli_fetch_assoc($sql_if_vote);
				if($sql==true){
					echo $voted['votes'];
				}else{
					echo 'Fail';	
				}
			}else{
			   echo 'already'; 
			}
		 }else{echo 'yourself';}//end user condition	
		

}

//for ans up vote
if($action=='up_ans_vote'){

	$answerID=$_REQUEST['answerID'];
	$type=$_REQUEST['type']; 
	$ownerID=$_REQUEST['ownerID'];
	
	$sql_if_voted=mysqli_query($dbconfig,"SELECT * FROM forum_answer_votes WHERE answerID='".$answerID."' AND userID='".$userid."'
	AND type='up' "); 
	$row_if_voted=mysqli_fetch_assoc($sql_if_voted);
	if($ownerID!=$userid){
		$check_if_voted=mysqli_num_rows($sql_if_voted);
		if($check_if_voted!=true){
		  
			   $sql_if_down=mysqli_query($dbconfig,"SELECT * FROM forum_answer_votes WHERE answerID='".$answerID."' AND userID='".$userid."'
			   AND type='down' "); 
			   $check_if_down=mysqli_num_rows($sql_if_down);
			   if($check_if_down==true){
				   
				   $sql=mysqli_query($dbconfig,"UPDATE forum_answers SET votes=votes+2 WHERE answerID='".$answerID."' ");
				   $sql=mysqli_query($dbconfig,"UPDATE forum_answer_votes SET type='up' WHERE answerID='".$answerID."' AND userID='".$userid."' ");
				   
				   // and update notification if up to down
					$sql=mysqli_query($dbconfig,"SELECT *,a.userID FROM forum_questions LEFT JOIN forum_answers AS a USING (fqID)
					WHERE a.answerID='".$answerID."' ");
					$row=mysqli_fetch_assoc($sql);
					$tittle=($row['tittle']);
					$notiTo=($row['userID']);
					
					$type='answer.vote.up';
					$notiText='has up voted to your answer to the question: <b>"'.$tittle.'"</b> ';
					$reference='forum_answer_id';
					$referenceID=$answerID; //this is id of forum_questions table
					$sql=mysqli_query($dbconfig,"UPDATE notifications SET `read`='0',notiText='".$notiText."',type='".$type."'
					WHERE referenceID='".$answerID."' AND notiTo='".$notiTo."'
					AND reference='".$reference."' AND type='answer.vote.down' AND notiBy='".$userid."'");
				   
			   }else{
					//insert vote
					$sql=$conn->prepare("INSERT INTO forum_answer_votes (userID,answerID,type,voteTime) VALUES 
					(?,?,?,?)");
					$sql->execute(array($userid,$answerID,$type,$time));
					
					// update vote counts for question
					$sql=mysqli_query($dbconfig,"UPDATE forum_answers SET votes=votes+1 WHERE answerID='".$answerID."' ");
					
					//notifying vote of new user
					$sql=mysqli_query($dbconfig,"SELECT *,a.userID FROM forum_questions LEFT JOIN forum_answers AS a USING (fqID)
					WHERE a.answerID='".$answerID."' ");
					$row=mysqli_fetch_assoc($sql);
					$tittle=($row['tittle']);
					
					$notiTo=($row['userID']);
					$type='answer.vote.up';
					$notiText='has up voted to your answer to the question: <b>"'.$tittle.'"</b> ';
					$reference='forum_answer_id';
					$referenceID=$answerID; //this is id of forum_answers table
					$sql_noti=$conn->prepare("INSERT INTO notifications (notiBy,notiTo,type,notiText,reference,referenceID,notiTime) VALUES 
					(?,?,?,?,?,?,?)");
					$sql_noti->execute(array($userid,$notiTo,$type,$notiText,$reference,$referenceID,$time));
			   }

				$sql_if_vote=mysqli_query($dbconfig,"SELECT * FROM forum_answers WHERE answerID='".$answerID."'"); 
				$voted=mysqli_fetch_assoc($sql_if_vote);
				if($sql==true){
					echo $voted['votes'];
				}else{
					echo 'Fail';	
				}
			
			}else{
			   echo 'already'; 
			}
		
	  }else{echo 'yourself';}//end user condition
 
  
}

// for ask question
if($action=='answer_question'){

$answerText=($_REQUEST['answerText']);
$fqID=$_REQUEST['fqID'];

				if($answerText==''){
				echo '<h5 style="color:red;">* Empty Fields Cannot be Submited</h5>';exit;
				}
				
				$sql=$conn->prepare("INSERT INTO forum_answers (userID,fqID,answerText,createTime) VALUES 
				(?,?,?,?)");
				$sql->execute(array($userid,$fqID,$answerText,$time));
				
				$sql_last=mysqli_query($dbconfig,"SELECT * FROM forum_answers ORDER BY answerID DESC LIMIT 1");
				$row_last=mysqli_fetch_assoc($sql_last);
				$answerID=$row_last['answerID'];
				
				$sql=mysqli_query($dbconfig,"SELECT * FROM forum_questions WHERE fqID='".$fqID."' ");
				$row=mysqli_fetch_assoc($sql);
				$tittle=($row['tittle']);
				
				//notifying answer to the question owner
				$notiTo=($row['userID']);
				$type='answer.to.question';
				$notiText='has answered to your question: <b>"'.$tittle.'"</b> ';
				$reference='forum_answer_id';
				$referenceID=$answerID; //this is id of forum_answers table
				$sql_noti=$conn->prepare("INSERT INTO notifications (notiBy,notiTo,type,notiText,reference,referenceID,notiTime) VALUES 
				(?,?,?,?,?,?,?)");
				$sql_noti->execute(array($userid,$notiTo,$type,$notiText,$reference,$referenceID,$time));


				if($sql==true){
				echo 'true';
				}else{
				echo 'false ';	
				}

}


//for question down vote
if($action=='down_vote'){

	$fqID=$_REQUEST['fqID'];
	$type=$_REQUEST['type'];
	$ownerID=$_REQUEST['ownerID']; 
	
	// checking if already down or not
	$sql_if_voted=mysqli_query($dbconfig,"SELECT * FROM forum_question_votes WHERE fqID='".$fqID."' AND userID='".$userid."'
	AND type='down' "); 
	$check_if_voted=mysqli_num_rows($sql_if_voted);
	$row_if_voted=mysqli_fetch_assoc($sql_if_voted);
	if($ownerID!=$userid){
		if($check_if_voted!=true){
			//checking if already up
		   $sql_if_down=mysqli_query($dbconfig,"SELECT * FROM forum_question_votes WHERE fqID='".$fqID."' AND userID='".$userid."'
		   AND type='up' "); 
		   $check_if_down=mysqli_num_rows($sql_if_down);
		   if($check_if_down==true){
				// if up update to down vote
			   $sql=mysqli_query($dbconfig,"UPDATE forum_questions SET votes=votes-2 WHERE fqID='".$fqID."' ");
			   $sql=mysqli_query($dbconfig,"UPDATE forum_question_votes SET type='down' WHERE fqID='".$fqID."' AND userID='".$userid."' ");
			   
				// and update notification if up to down
				$sql=mysqli_query($dbconfig,"SELECT * FROM forum_questions WHERE fqID='".$fqID."' ");
				$row=mysqli_fetch_assoc($sql);
				$tittle=($row['tittle']);
				$notiTo=($row['userID']);
				
				$type='question.vote.down';
				$notiText='has down voted to your question: <b>"'.$tittle.'"</b> ';
				$reference='forum_question_id';
				$referenceID=$fqID; //this is id of forum_questions table
				$sql=mysqli_query($dbconfig,"UPDATE notifications SET `read`='0',notiText='".$notiText."',type='".$type."'
				WHERE referenceID='".$fqID."' AND notiTo='".$notiTo."'
				AND reference='".$reference."' AND type='question.vote.up' AND notiBy='".$userid."'");
				
		   }else{
				//insert vote
				$sql=$conn->prepare("INSERT INTO forum_question_votes (userID,fqID,type,voteTime) VALUES 
				(?,?,?,?)");
				$sql->execute(array($userid,$fqID,$type,$time));
				
				// update vote counts for question
				$sql=mysqli_query($dbconfig,"UPDATE forum_questions SET votes=votes-1 WHERE fqID='".$fqID."' ");
				
				$sql=mysqli_query($dbconfig,"SELECT * FROM forum_questions WHERE fqID='".$fqID."' ");
				$row=mysqli_fetch_assoc($sql);
				$tittle=($row['tittle']);
				
				//notifying vote of new user
				$notiTo=($row['userID']);
				$type='question.vote.down';
				$notiText='has down voted to <b>"'.$tittle.'"</b> question';
				$reference='forum_question_id';
				$referenceID=$fqID; //this is id of forum_questions table
				$sql_noti=$conn->prepare("INSERT INTO notifications (notiBy,notiTo,type,notiText,reference,referenceID,notiTime) VALUES 
				(?,?,?,?,?,?,?)");
				$sql_noti->execute(array($userid,$notiTo,$type,$notiText,$reference,$referenceID,$time));
		   }
			
			$sql_if_vote=mysqli_query($dbconfig,"SELECT * FROM forum_questions WHERE fqID='".$fqID."'"); 
			$voted=mysqli_fetch_assoc($sql_if_vote);
			if($sql==true){
				echo $voted['votes'];
			}else{
				echo 'Fail';	
			}
			
			}else{
			echo 'already'; 
			}
			
		}else{echo 'yourself';}//end user condition
	

}

//for question up vote
if($action=='up_vote'){

	$fqID=$_REQUEST['fqID'];
	$type=$_REQUEST['type'];
	$ownerID=$_REQUEST['ownerID'];
	
	// checking if already up or not	
	$sql_if_voted=mysqli_query($dbconfig,"SELECT * FROM forum_question_votes WHERE fqID='".$fqID."' AND userID='".$userid."'
	AND type='up' "); 
	$check_if_voted=mysqli_num_rows($sql_if_voted);
	$row_if_voted=mysqli_fetch_assoc($sql_if_voted);
	if($ownerID!=$userid){
		
		if($check_if_voted!=true){
			
				//checking if already down
			   $sql_if_down=mysqli_query($dbconfig,"SELECT * FROM forum_question_votes WHERE fqID='".$fqID."' AND userID='".$userid."'
			   AND type='down' "); 
			   $check_if_down=mysqli_num_rows($sql_if_down);
			   if($check_if_down==true){
					// if down update to up vote
				   $sql=mysqli_query($dbconfig,"UPDATE forum_questions SET votes=votes+2 WHERE fqID='".$fqID."' ");
				   $sql=mysqli_query($dbconfig,"UPDATE forum_question_votes SET type='up' WHERE fqID='".$fqID."' AND userID='".$userid."' ");
				   
				   
					// and update notification if down to up
					$sql=mysqli_query($dbconfig,"SELECT * FROM forum_questions WHERE fqID='".$fqID."' ");
					$row=mysqli_fetch_assoc($sql);
					$tittle=($row['tittle']);
					$notiTo=($row['userID']);
					
					$type='question.vote.up';
					$notiText='has up voted to your question: <b>"'.$tittle.'"</b> ';
					$reference='forum_question_id';
					$referenceID=$fqID; //this is id of forum_questions table
					$sql=mysqli_query($dbconfig,"UPDATE notifications SET `read`='0',notiText='".$notiText."',type='".$type."'
					WHERE referenceID='".$fqID."' AND notiTo='".$notiTo."'
					AND reference='".$reference."' AND type='question.vote.down' AND notiBy='".$userid."'");
				   
			   }else{
					//insert vote
					$sql=$conn->prepare("INSERT INTO forum_question_votes (userID,fqID,type,voteTime) VALUES 
					(?,?,?,?)");
					$sql->execute(array($userid,$fqID,$type,$time));
					
					// update vote counts for question
					$sql=mysqli_query($dbconfig,"UPDATE forum_questions SET votes=votes+1 WHERE fqID='".$fqID."' ");
					
					$sql=mysqli_query($dbconfig,"SELECT * FROM forum_questions WHERE fqID='".$fqID."' ");
					$row=mysqli_fetch_assoc($sql);
					$tittle=($row['tittle']);
					
					//notifying vote of new user
					$notiTo=($row['userID']);
					$type='question.vote.up';
					$notiText='has up voted to your question: <b>"'.$tittle.'"</b> ';
					$reference='forum_question_id';
					$referenceID=$fqID; //this is id of forum_questions table
					$sql_noti=$conn->prepare("INSERT INTO notifications (notiBy,notiTo,type,notiText,reference,referenceID,notiTime) VALUES 
					(?,?,?,?,?,?,?)");
					$sql_noti->execute(array($userid,$notiTo,$type,$notiText,$reference,$referenceID,$time));
					
			   }
				
				$sql_if_vote=mysqli_query($dbconfig,"SELECT * FROM forum_questions WHERE fqID='".$fqID."'"); 
				$voted=mysqli_fetch_assoc($sql_if_vote);
				if($sql==true){
					echo $voted['votes'];
				}else{
					echo 'Fail';	
				}
		}else{ echo 'already';  }
		
	}else{echo 'yourself';}//end user condition cannot vote to yourself


}


// for update question
if($action=='update_question'){

	$tittle=htmlentities($_REQUEST['tittle']);
	$description=($_REQUEST['description']);
	$ftagID=$_REQUEST['ftagID'];
	$fqID=$_REQUEST['fqID'];
	
	if($tittle=='' or $description=='' or $ftagID==''){
	echo '<h5 style="color:red;">* Empty Fields Cannot be Submited</h5>';exit;
	}
	
	$sql =$conn->prepare("UPDATE forum_questions SET tittle = :tittle,description = :description,editedBy=:editedBy,updateTime = :updateTime
	WHERE fqID = '".$fqID."' ");
	$sql->execute(array(':tittle'=>$tittle,':description'=>$description,':editedBy'=>$userid,':updateTime'=>$time));
	
	// first delere all tags so that new updated tag can be added into tags
	$sql_delete_all_tag=mysqli_query($dbconfig,"DELETE FROM forum_question_tag WHERE fqID = '".$fqID."'");
	
	for($i = 0; $i < count($ftagID); $i++)
	{	
	
	$sql=$conn->prepare("INSERT INTO forum_question_tag (fqID,ftagID) VALUES 
	(?,?)");
	$sql->execute(array($fqID,$ftagID[$i]));
	}
	
	if($sql==true){
	echo 'true';
	}else{
	echo 'false ';	
	}
}

// for ask question
if($action=='ask_question'){

	$tittle=htmlentities($_REQUEST['tittle']);
	$description=($_REQUEST['description']);
	
	$ftagID=$_REQUEST['ftagID'];
	if($tittle=='' or $description=='' or $ftagID==''){
	echo '<h5 style="color:red;">* Empty Fields Cannot be Submited</h5>';exit;
	}
	
	$sql=$conn->prepare("INSERT INTO forum_questions (userID,tittle,description,createTime) VALUES 
	(?,?,?,?)");
	$sql->execute(array($userid,$tittle,$description,$time));
	
	$sql_last_id=mysqli_query($dbconfig,"SELECT * FROM forum_questions ORDER BY fqID DESC LIMIT 1");
	$row=mysqli_fetch_assoc($sql_last_id);
	$fqID=($row['fqID']);
	
	for($i = 0; $i < count($ftagID); $i++)
	{
	$sql=$conn->prepare("INSERT INTO forum_question_tag (fqID,ftagID) VALUES 
	(?,?)");
	$sql->execute(array($fqID,$ftagID[$i]));
	}
	
	if($sql==true){
	echo 'true';
	}else{
	echo 'false ';	
	}
}

//cancel attending event
if($action=='event_cancel_action'){

	$esid=$_REQUEST['esid'];	 //estatus id
	$type=$_REQUEST['status'];
	
	//fetching event_status info to delete notification
	$sql_fetch=mysqli_query($dbconfig,"SELECT e.userID,s.eventID FROM event_status AS s LEFT JOIN user_events AS e USING (eventID)
	WHERE estatusID='".$esid."' ");
	$row=mysqli_fetch_assoc($sql_fetch);
	
	
	$sql1=mysqli_query($dbconfig,"DELETE FROM notifications WHERE referenceID='".$row['eventID']."' AND notiBy='".$userid."' 
	AND notiTo='".$row['userID']."' AND type='".$type."'");
	
	$sql2=mysqli_query($dbconfig,"DELETE FROM event_status  WHERE estatusID='".$esid."' ");
	
	if($sql1==true and $sql2==true){
	echo '<i class="icon-ok"> Cancelled</i>';
	}else{
	echo 'Unable to Cancel';	
	}

}

// for event attend
if($action=='event_action'){

	$eid=$_REQUEST['eid'];	 //estatus id
	$status=$_REQUEST['status'];
	
	
	$sql=$conn->prepare("INSERT INTO event_status (userID,eventID,status,statusTime) VALUES 
	(?,?,?,?)");
	$sql->execute(array($userid,$eid,$status,$time));
	
	if($status!='Declined'){ //not sending notification if declined
	// fetching group info for notifications
	$sql_event=mysqli_query($dbconfig,"SELECT * FROM user_events WHERE eventID='".$eid."' ");
	$row_event=mysqli_fetch_assoc($sql_event);
	$ename=$row_event['eventName'];
	$notiTo=$row_event['userID'];
	
	
	if($status=='Attending'){
	$type='event.attend';	
	$notiText='is attending your <b>'.$ename.'</b> event '; }else{
	$type='event.interest';		
	$notiText='is interested in your <b>'.$ename.'</b> event ';	
	}
	$reference='user_events_id';
	$referenceID=$row_event['eventID']; //this is id of user_groups 
	$sql_noti=$conn->prepare("INSERT INTO notifications (notiBy,notiTo,type,notiText,reference,referenceID,notiTime) VALUES 
	(?,?,?,?,?,?,?)");
	$sql_noti->execute(array($userid,$notiTo,$type,$notiText,$reference,$referenceID,$time));
	}
	
	if($sql==true){
	echo '<i class="icon-ok"></i> '.$status.'';
	}else{
	echo 'Failed ';	
	}

}

// for event invitation
if($action=='event_invitation'){

	$uid=$_REQUEST['uid'];
	$eid=$_REQUEST['eid'];
	$type='event.invite';
	
	$sql=$conn->prepare("INSERT INTO invitation (userID,inviteTo,referenceID,type,inviteTime) VALUES 
	(?,?,?,?,?)");
	$sql->execute(array($userid,$uid,$eid,$type,$time));
	
	$sql=mysqli_query($dbconfig,"SELECT * FROM user_events WHERE eventID='".$eid."' ");
	$row=mysqli_fetch_assoc($sql);
	$eventName=($row['eventName']);
	$eventLocation=($row['eventLocation']);
	$eventDate=($row['eventDate']);
	
	$type='event.invite';
	$notiText='invited you to the event <b>'.$eventName.'</b> at <b>'.$eventLocation.'</b> on <b>'.$eventDate.'</b> ';
	$reference='user_event_id';
	$referenceID=$eid; //this is id of user_groups table
	$sql_noti=$conn->prepare("INSERT INTO notifications (notiBy,notiTo,type,notiText,reference,referenceID,notiTime) VALUES 
	(?,?,?,?,?,?,?)");
	$sql_noti->execute(array($userid,$uid,$type,$notiText,$reference,$referenceID,$time));
	
	if($sql==true){
	echo '<i class="icon-ok"></i> Invitation Sent';
	}else{
	echo 'Failed ';	
	}
}

// update event
if($action=='update_event'){

	$eid=htmlentities($_REQUEST['eid']);
	$ename=htmlentities($_REQUEST['ename']);
	$edetails=htmlentities($_REQUEST['edetails']);
	$elocation=htmlentities($_REQUEST['elocation']);
	$eventDate=htmlentities($_REQUEST['eventYear']).'-'.htmlentities($_REQUEST['eventMonth']).'-'.htmlentities($_REQUEST['eventDay']);
	$eventTime=htmlentities($_REQUEST['hour']).':'.htmlentities($_REQUEST['minute']).' '.htmlentities($_REQUEST['mode']);
	
	$sql =$conn->prepare("UPDATE user_events SET eventName = :eventName,eventDetails = :eventDetails,eventLocation = :eventLocation,
	eventDate = :eventDate,eventTime = :eventTime  WHERE eventID = '".$eid."' ");
	$sql->execute(array(':eventName'=>$ename,':eventDetails'=>$edetails,':eventLocation'=>$elocation,
	':eventDate'=>$eventDate,':eventTime'=>$eventTime));
	
	if($sql==true){
	echo '<div class="floating_message_red"><h5>Event Updated successfully</h5></div>';
	}else{
	echo '<div class="floating_message_red"><h5>Failed to Update event</h5></div>';	
	}

}

// creating event
if($action=='create_event'){

	$ename=htmlentities($_REQUEST['ename']);
	$edetails=htmlentities($_REQUEST['edetails']);
	$elocation=htmlentities($_REQUEST['elocation']);
	$eventDate=date('Y-m-d',strtotime(htmlentities($_REQUEST['eventDay']).'-'.htmlentities($_REQUEST['eventMonth']).'-'.htmlentities($_REQUEST['eventYear'])));
	
	$eventTime=htmlentities($_REQUEST['hour']).':'.htmlentities($_REQUEST['minute']).' '.htmlentities($_REQUEST['mode']);
	$time_input=date('H:i:s',strtotime($eventTime));
	
	$sql=$conn->prepare("INSERT INTO user_events (userID,eventName,eventDetails,eventLocation,eventDate,eventTime,createTime) VALUES 
	(?,?,?,?,?,?,?)");
	$sql->execute(array($userid,$ename,$edetails,$elocation,$eventDate,$time_input,$time));
	
	if($sql==true){
	echo '<div class="floating_message_red"><h5>Event created successfully</h5></div>';
	}else{
	echo '<div class="floating_message_red"><h5>Failed to create event</h5></div>';	
	}

}

//sending message
if($action=='send_discussion_msg'){

	$message=htmlentities($_REQUEST['message']);
	$gid=htmlentities($_REQUEST['gid']);
	
	$sql=$conn->prepare("INSERT INTO group_discussion (userID,groupID,message,sentTime) VALUES 
	(?,?,?,?)");
	$sql->execute(array($userid,$gid,($message),$time));
	
	$sql_fetch_msg=mysqli_query($dbconfig,"SELECT * FROM group_discussion WHERE groupID='".$gid."' AND userID=".$userid."  ORDER BY disID DESC");
	$row_fetch_msg=mysqli_fetch_assoc($sql_fetch_msg);	
	
	if($sql==true){
	include 'load_group_msg.php';
	}else{
	echo 'Retry ';	
	}

}

//for unlikeing group post comment
if($action=='delete_post'){
	$postType=$_REQUEST['postType'];
	
	$postid=$_REQUEST['postid'];
	$type=$postType.'.'.'comment';
	
	// fetching all commentid of related post 
	$sql_post_user=mysqli_query($dbconfig,"SELECT * FROM post_comments  WHERE postID='".$postid."'");
	while($row_post_user=mysqli_fetch_assoc($sql_post_user)){
	
	// deleting all notifications of this posts along with comments
	$sql=mysqli_query($dbconfig,"DELETE FROM notifications WHERE (referenceID='".$row_post_user['commentID']."' OR referenceID='".$postid."')
	AND  (type='".$type."' OR type='".$postType."') ");
	
	//delete likes
	$sql=mysqli_query($dbconfig,"DELETE FROM user_likes WHERE (likeTo='".$postid."' OR  likeTo='".$row_post_user['commentID']."' )
	AND (likeType='".$type."' OR likeType='".$postType."') ");
	}
	//delete from news feed
	$sql=mysqli_query($dbconfig,"DELETE FROM news_feed WHERE referenceID='".$postid."' ");
	//delete post
	$sql=mysqli_query($dbconfig,"DELETE FROM posts WHERE postID='".$postid."' ");
	//delete commnent
	$sql=mysqli_query($dbconfig,"DELETE FROM post_comments WHERE postID='".$postid."' ");
	
	if($sql==true){
	echo '<i class="icon-remove "></i> Deleted';
	}else{
	echo 'Fail';	
	}

}


//for deleteing post comment
if($action=='delete_comment'){

	$postType=$_REQUEST['postType'];
	
	
	// delete home post comment
	$postid=$_REQUEST['postid'];
	$likeType=$postType.'.'.'comment';
	
	$commentid=$_REQUEST['commentid']; // id of group post comment
	
	// fetching owner of post and group the owner belongs to
	$sql_post_user=mysqli_query($dbconfig,"SELECT p.userID,p.postID FROM posts AS p LEFT JOIN users AS g ON p.referenceID=g.userID
	WHERE postID='".$postid."'");
	$row_post_user=mysqli_fetch_assoc($sql_post_user);
	
	//deleting all notifications of this comment
	$sql=mysqli_query($dbconfig,"DELETE FROM notifications WHERE (referenceID='".$commentid."')
	AND  (type='".$postType."' OR type='".$likeType."') ");
	
	//delete commnent
	$sql=mysqli_query($dbconfig,"DELETE FROM post_comments WHERE commentID='".$commentid."' ");
	
	if($sql==true){
	echo '<i class="icon-remove "></i> Deleted';
	}else{
	echo 'Fail';	
	}


}


//for unlikeing  post comment
if($action=='unlike_post_comment'){

	$likeType=$_REQUEST['likeType'].'.'.'comment';
	
	$postid=$_REQUEST['postid'];
	$likeTo=$_REQUEST['commentid']; // id of group post comment
	
	$sql_if_liked=mysqli_query($dbconfig,"SELECT * FROM user_likes WHERE likeTo='".$likeTo."' AND userID='".$userid."' "); 
	$check_if_liked=mysqli_num_rows($sql_if_liked);
	if($check_if_liked==true){
	
	// fetching owner of post and group the owner belongs to
	$sql_post_user=mysqli_query($dbconfig,"SELECT c.userID,c.commentID FROM posts AS p LEFT JOIN post_comments AS c USING (postID)
	LEFT JOIN users AS g ON p.referenceID=g.userID
	WHERE c.commentID='".$_REQUEST['commentid']."' ")or die (mysqli_error($dbconfig));
	$row_post_user=mysqli_fetch_assoc($sql_post_user);
	
	//deleting notification
	$sql=mysqli_query($dbconfig,"DELETE FROM notifications WHERE referenceID='".$likeTo."' AND notiBy='".$userid."' 
	AND notiTo='".$row_post_user['userID']."' AND type='".$likeType."' ");
	
	//delete like
	$sql=mysqli_query($dbconfig,"DELETE FROM user_likes WHERE likeTo='".$likeTo."'
	AND likeType='".$likeType."' AND userID='".$userid."' ");
	
	$sql=mysqli_query($dbconfig,"UPDATE post_comments SET like_counts=like_counts-1 WHERE commentID='".$likeTo."' ");
	
	if($sql==true){
	echo '<i class="icon-thumbs-down-alt "></i> Unlike';
	}else{
	echo 'Fail';	
	}
	
	}else{
	echo '<i class="icon-thumbs-down-alt "></i> Unlike';
	}


}

//for liking  post comment
if($action=='like_post_comment'){

	$likeType=$_REQUEST['likeType'].'.'.'comment';
	
	$postid=$_REQUEST['postid'];
	$likeTo=$_REQUEST['commentid']; // id of comment 
	
	
	$sql_if_liked=mysqli_query($dbconfig,"SELECT * FROM user_likes WHERE likeTo='".$likeTo."' AND userID='".$userid."'
	AND likeType='".$likeType."' "); 
	$check_if_liked=mysqli_num_rows($sql_if_liked);
	if($check_if_liked!=true){
	
	//insert like
	$sql=$conn->prepare("INSERT INTO user_likes (userID,likeType,likeTo,likeTime) VALUES 
	(?,?,?,?)");
	$sql->execute(array($userid,$likeType,$likeTo,$time));
	
	// update like counts for post comment
	$sql=mysqli_query($dbconfig,"UPDATE post_comments SET like_counts=like_counts+1 WHERE commentID='".$likeTo."' ");
	
	
	// fetching owner of comment 
	$sql_post_user=mysqli_query($dbconfig,"SELECT CONCAT(firstName,' ',lastName) AS name,c.userID,c.commentID,eventName,groupName 
	FROM posts AS p LEFT JOIN post_comments AS c USING (postID)
	LEFT JOIN users AS u ON p.referenceID=u.userID LEFT JOIN user_events AS e ON e.eventID=p.referenceID
	LEFT JOIN user_groups AS g ON g.groupID=p.referenceID
	WHERE c.commentID='".$_REQUEST['commentid']."' ")or die (mysqli_error($dbconfig));
	$row_post_comment_user=mysqli_fetch_assoc($sql_post_user);
	
	if($userid!=$row_post_comment_user['userID']){ //checking that noti must not sent to post comment owner itself
	
	$notiTo=$row_post_comment_user['userID'];
	$type=$likeType;
	if($_REQUEST['likeType']=='home.post'){$notiText='like your comment for <b>'.$row_post_comment_user['name'].'</b> post';}
	if($_REQUEST['likeType']=='event.post'){$notiText='like your comment for <b>'.$row_post_comment_user['eventName'].'</b> event post';}
	if($_REQUEST['likeType']=='group.post'){$notiText='like your comment for <b>'.$row_post_comment_user['groupName'].'</b> group post';}
	if($_REQUEST['likeType']=='user.photo'){$notiText='like your comment for <b>'.$row_post_comment_user['name'].'</b> profile photo';}
	if($_REQUEST['likeType']=='event.photo'){$notiText='like your comment for <b>'.$row_post_comment_user['eventName'].'</b> event profile photo';}
	if($_REQUEST['likeType']=='group.photo'){$notiText='like your comment for <b>'.$row_post_comment_user['groupName'].'</b> group profile photo';}
	$reference='comment_id';
	$referenceID=$_REQUEST['commentid']; //this is id of comment table
	$sql_noti=$conn->prepare("INSERT INTO notifications (notiBy,notiTo,type,notiText,reference,referenceID,notiTime) VALUES 
	(?,?,?,?,?,?,?)");
	$sql_noti->execute(array($userid,$notiTo,$type,$notiText,$reference,$referenceID,$time));
	}
	
	if($sql==true){
		echo '<i class="icon-thumbs-up-alt "></i> Liked';
	}else{
		echo 'Fail';	
	}
	
	}else{
	echo '<i class="icon-thumbs-up-alt "></i> Liked'; 
	echo '<div class="floating_message_red"><h5> Already Liked</h5></div>';
	}


}

//for commenting on post
if($action=='post_comment'){

	$postType=$_REQUEST['postType'];
	$postid=htmlentities($_REQUEST['postid']);
	$comment=htmlentities($_REQUEST['comment']);
	
	//insert comment for post
	$sql=$conn->prepare("INSERT INTO post_comments (userID,postID,comment,commentTime) VALUES 
	(?,?,?,?)");
	$sql->execute(array($userid,$postid,$comment,$time));
	// update comment counts for post
	$sql=mysqli_query($dbconfig,"UPDATE posts SET comment_counts=comment_counts+1 WHERE postID='".$postid."' ");
	
	
	//// fetching owner of post
	$sql_post_user=mysqli_query($dbconfig,"SELECT p.userID,p.postID,eventName,groupName FROM posts AS p 
	LEFT JOIN users AS u ON p.referenceID=u.userID
	LEFT JOIN user_groups AS g ON g.groupID=p.referenceID LEFT JOIN user_events AS e ON e.eventID=p.referenceID
	WHERE postID='".$postid."'");
	$row_post_user=mysqli_fetch_assoc($sql_post_user);
	
	$sql_post_comment=mysqli_query($dbconfig,"SELECT * FROM post_comments 
	WHERE postID='".$postid."' ORDER BY commentID DESC LIMIT 1") or die (mysqli_error($dbconfig));
	$row_post_comment=mysqli_fetch_assoc($sql_post_comment);
	
	
	if($userid!=$row_post_user['userID']){ //checking that notification must not sent to post owner itself 
	$notiTo=$row_post_user['userID'];
	$type=$postType.'.'.'comment';
	if($postType=='home.post'){$notiText='commented on your post';}
	if($postType=='user.photo'){$notiText='commented on your profile photo';}
	if($postType=='event.photo'){$notiText='commented on your <b>'.$row_post_user['eventName'].'</b> event profile photo';}
	if($postType=='group.photo'){$notiText='commented on your <b>'.$row_post_user['groupName'].'</b> group profile photo';}
	if($postType=='event.post'){$notiText='commented on your <b>'.$row_post_user['eventName'].'</b> event post';}
	if($postType=='group.post'){$notiText='commented on your <b>'.$row_post_user['groupName'].'</b> group post';}
	$reference='comment_id';
	$referenceID=$row_post_comment['commentID']; //this is id of comment table
	$sql_noti=$conn->prepare("INSERT INTO notifications (notiBy,notiTo,type,notiText,reference,referenceID,notiTime) VALUES 
	(?,?,?,?,?,?,?)");
	$sql_noti->execute(array($userid,$notiTo,$type,$notiText,$reference,$referenceID,$time));
	
	}	
	if($sql==true){
	echo '<span class="btn btn-primary btn-xs" style="font-size:11px">
	<i class="icon-ok"></i> Comment</span>';
	}else{
	echo 'Fail';	
	}


}


//for unlikeing  post
if($action=='unlike_post'){
	$likeType=$_REQUEST['likeType'];
	$likeTo=$_REQUEST['postid']; // id of group post
	
	
	$sql_if_liked=mysqli_query($dbconfig,"SELECT * FROM user_likes WHERE likeTo='".$likeTo."' AND userID='".$userid."' "); 
	$check_if_liked=mysqli_num_rows($sql_if_liked);
	if($check_if_liked==true){
	
		// fetching owner of post and event the owner belongs to
		$sql_post_user=mysqli_query($dbconfig,"SELECT p.userID,p.postID FROM posts AS p LEFT JOIN users AS u ON p.referenceID=u.userID
		WHERE postID='".$_REQUEST['postid']."'");
		$row_post_user=mysqli_fetch_assoc($sql_post_user);
		
		//deleting notification
		$sql=mysqli_query($dbconfig,"DELETE FROM notifications WHERE referenceID='".$likeTo."' AND notiBy='".$userid."' 
		AND notiTo='".$row_post_user['userID']."' AND type='".$likeType."' ");
		
		//delete like
		$sql=mysqli_query($dbconfig,"DELETE FROM user_likes WHERE likeTo='".$likeTo."'
		AND likeType='".$likeType."' AND userID='".$userid."' ");
		
		$sql=mysqli_query($dbconfig,"UPDATE posts SET like_counts=like_counts-1 WHERE postID='".$likeTo."' ");
		
		
		$sql_post=mysqli_query($dbconfig,"SELECT * FROM posts
		WHERE postID='".$_REQUEST['postid']."'");
		$row_likes=mysqli_fetch_assoc($sql_post);
		if($sql==true){
		echo $row_likes['like_counts'];
		}else{
		echo 'false';	
		}
	
	}else{
	echo 'already';
	}

}

//for likeing post
if($action=='like_post'){

	$likeType=$_REQUEST['likeType'];
	$likeTo=$_REQUEST['postid']; // id of post
	
	$sql_if_liked=mysqli_query($dbconfig,"SELECT * FROM user_likes WHERE likeTo='".$likeTo."' AND userID='".$userid."' 
	AND likeType='".$likeType."'"); 
	$check_if_liked=mysqli_num_rows($sql_if_liked);
	if($check_if_liked!=true){
	
	//insert like
	$sql=$conn->prepare("INSERT INTO user_likes (userID,likeType,likeTo,likeTime) VALUES 
	(?,?,?,?)");
	$sql->execute(array($userid,$likeType,$likeTo,$time));
	
	// update like counts for post
	$sql=mysqli_query($dbconfig,"UPDATE posts SET like_counts=like_counts+1 WHERE postID='".$likeTo."' ");
	
	
	// fetching owner of post
	$sql_post_user=mysqli_query($dbconfig,"SELECT p.userID,p.postID,groupName,eventName FROM posts AS p LEFT JOIN users AS u ON p.referenceID=u.userID
	LEFT JOIN user_groups AS g ON g.groupID=p.referenceID LEFT JOIN user_events AS e ON e.eventID=p.referenceID
	WHERE p.postID='".$_REQUEST['postid']."'");
	$row_post_user=mysqli_fetch_assoc($sql_post_user);
	
	if($userid!=$row_post_user['userID']){ //checking that noti must not sent to post owner itself
	$notiTo=$row_post_user['userID'];
	$type=$likeType;
	if($likeType=='home.post'){$notiText='like your post';}
	if($likeType=='event.post') {$notiText='like you post from <b>'.$row_post_user['eventName'].'</b> event'; }
	if($likeType=='group.post'){$notiText='like you post from <b>'.$row_post_user['groupName'].'</b> group';}
	if($likeType=='user.photo'){$notiText='like your profile photo';}
	if($likeType=='group.photo'){$notiText='like your <b>'.$row_post_user['groupName'].'</b> group profile photo';}
	if($likeType=='event.photo'){$notiText='like your <b>'.$row_post_user['eventName'].'</b> event profile photo';}
	
	$reference='post_id';
	$referenceID=$_REQUEST['postid']; //this is id of post table
	$sql_noti=$conn->prepare("INSERT INTO notifications (notiBy,notiTo,type,notiText,reference,referenceID,notiTime) VALUES 
	(?,?,?,?,?,?,?)");
	$sql_noti->execute(array($userid,$notiTo,$type,$notiText,$reference,$referenceID,$time));
	}
	
	$sql_post=mysqli_query($dbconfig,"SELECT * FROM posts
		WHERE postID='".$_REQUEST['postid']."'");
		$row_likes=mysqli_fetch_assoc($sql_post);
		if($sql==true){
		echo $row_likes['like_counts'];
	}else{
		echo 'false';	
	}
	
	
	}else{
	echo 'already'; 
	}


}

// adding posts
if($action=='post'){


	$postText=htmlentities($_REQUEST['postText']);
	$postImg = $_FILES['postImg']['name'];
	$postType=htmlentities($_REQUEST['postType']);
	$reference=htmlentities($_REQUEST['reference']);
	$referenceID = htmlentities($_REQUEST['referenceID']); // this is id of respective post 
	
	if($postImg=='' and $postText==''){
	header('location:../home.php?emptypost=1');
	}else{
	
	if($postImg != ''){ // if post image is not empty
	
	if ($_FILES['postImg']['error'] > 0) {
	echo "Error: " . $_FILES['postImg']['error'] . "<br />";
	} else {
	// array of valid extensions
	$validExtensions = array('.jpg', '.jpeg', '.gif', '.png');
	// get extension of the uploaded file
	$fileExtension = strrchr($_FILES['postImg']['name'], ".");
	// check if file Extension is on the list of allowed ones
	if (in_array($fileExtension, $validExtensions)) {
	$newNamePrefix = time() . '_';
	$manipulator = new ImageManipulator($_FILES['postImg']['tmp_name']);
	// resizing to 200x200
	$newImage = $manipulator->resample(700, 700);
	// saving file to uploads folder
	$manipulator->save('../uploads/'. $_FILES['postImg']['name']);
	}
	}
	$sql=$conn->prepare("INSERT INTO posts (userID,postType,postText,postImg,reference,referenceID,postTime) VALUES (?,?,?,?,?,?,?)");
	$sql->execute(array($userid,$postType,$postText,$postImg,$reference,$referenceID,$time)); 
	} 
	
	else{ // post without image
	$sql=$conn->prepare("INSERT INTO posts (userID,postType,postText,reference,referenceID,postTime) VALUES (?,?,?,?,?,?)");
	$sql->execute(array($userid,$postType,$postText,$reference,$referenceID,$time)); 
	
	
	}
	//fetching post id 
	$sql_post=mysqli_query($dbconfig,"SELECT postID FROM posts ORDER BY postID DESC LIMIT 1");
	$row_post=mysqli_fetch_assoc($sql_post);
	
	//news feed
	$newsBy=$userid;
	$type=$postType;
	$newsText=$_REQUEST['newsText'];
	$reference='post_id';
	$referenceID=$row_post['postID']; 
	$sql=$conn->prepare("INSERT INTO news_feed (newsBy,type,newsText,reference,referenceID,newsTime) VALUES (?,?,?,?,?,?)");
	$sql->execute(array($newsBy,$type,$newsText,$reference,$referenceID,$time)); 
	
	
	if($postType=='group.post'){
	if($sql > 0) {
		header('location:../group/'.$_REQUEST['referenceID'].'?post=1'); exit;
	}else{
		header('location:../group/'.$_REQUEST['referenceID'].'?post=0'); exit;
	}
	}else if($postType=='event.post'){
	if($sql > 0) {
		header('location:../event/'.$_REQUEST['referenceID'].'?post=1'); exit;
	}else{
		header('location:../event/'.$_REQUEST['referenceID'].'?post=0'); exit;
	}
	}else if($postType=='home.post'){
	if($sql > 0) {
		header('location:../home.php?post=1'); exit;
	}else{
		header('location:../home.php?post=0'); exit;
	}
	}
	
	
	}
}

//cancel group invitation
if($action=='delete_group_invitation'){

$inviteid=$_REQUEST['inviteid'];	
$type='group.invite';

//fetching invitation info to delete notification
$sql_fetch=mysqli_query($dbconfig,"SELECT * FROM invitation WHERE inviteID='".$inviteid."' ");
$row=mysqli_fetch_assoc($sql_fetch);

$sql=mysqli_query($dbconfig,"DELETE FROM notifications WHERE referenceID='".$row['referenceID']."' AND notiBy='".$row['userID']."' 
AND notiTo='".$row['inviteTo']."' AND type='".$type."'");
$sql=mysqli_query($dbconfig,"DELETE FROM invitation  WHERE inviteID='".$inviteid."' ");

if($sql==true){
echo '<i class="icon-ok"> Deleted</i>';
}else{
echo 'Unable to Cancel';	
}
}

// for accepting invitation
if($action=='accept_group_invitation'){

			$inviteid=$_REQUEST['inviteid'];
			
			
			//fetching group info for notifications and for adding group members
			$sql_invite=mysqli_query($dbconfig,"SELECT * FROM invitation AS i LEFT JOIN user_groups AS g ON i.referenceID=g.groupID
			WHERE inviteID='".$inviteid."' AND type='group.invite' ");
			$row_invite=mysqli_fetch_assoc($sql_invite);
			$gid=$row_invite['referenceID'];// id of user_group
			$inviteTo=$row_invite['inviteTo'];
			$inviteBy=$row_invite['userID'];
			$gname=$row_invite['groupName'];
			
			$sql=$conn->prepare("INSERT INTO group_members (groupID,memberID,addTime) VALUES 
			(?,?,?)");
			$sql->execute(array($gid,$inviteTo,$time));
			
			
			
			$type='group.invite.accepted';
			$notiTo=$inviteBy;
			$notiText='accepted your invitation and joined to <b>'.$gname.'</b> group ';
			$reference='user_groups_id';
			$referenceID=$gid; //this is id of user_groups 
			$sql_noti=$conn->prepare("INSERT INTO notifications (notiBy,notiTo,type,notiText,reference,referenceID,notiTime) VALUES 
			(?,?,?,?,?,?,?)");
			$sql_noti->execute(array($userid,$notiTo,$type,$notiText,$reference,$referenceID,$time));
			
			$sql=mysqli_query($dbconfig,"DELETE FROM invitation WHERE inviteID='".$inviteid."' ");
			
			if($sql==true){
			echo '<i class="icon-ok"></i> Accepted';
			}else{
			echo 'Failed ';	
}

}

//cancel group invitation
if($action=='cancel_group_invitation'){

$inviteID=$_REQUEST['inviteID'];	
$type='group.invite';

//fetching invitation info to delete notification
$sql_fetch=mysqli_query($dbconfig,"SELECT * FROM invitation WHERE inviteID='".$inviteID."' ");
$row=mysqli_fetch_assoc($sql_fetch);

$sql=mysqli_query($dbconfig,"DELETE FROM notifications WHERE referenceID='".$row['referenceID']."' AND notiBy='".$userid."' 
AND notiTo='".$row['inviteTo']."' AND type='".$type."'");
$sql=mysqli_query($dbconfig,"DELETE FROM invitation  WHERE inviteID='".$inviteID."' ");

if($sql==true){
echo '<i class="icon-ok"> Cancelled</i>';
}else{
echo 'Unable to Cancel';	
}

}

// for invitation
if($action=='group_invitation'){

$uid=$_REQUEST['uid'];
$gid=$_REQUEST['gid'];
$type='group.invite';

$sql=$conn->prepare("INSERT INTO invitation (userID,inviteTo,referenceID,type,inviteTime) VALUES 
(?,?,?,?,?)");
$sql->execute(array($userid,$uid,$gid,$type,$time));

//fetching group info for notifications
$sql_group=mysqli_query($dbconfig,"SELECT * FROM user_groups WHERE groupID='".$gid."' ");
$row_group=mysqli_fetch_assoc($sql_group);
$gname=$row_group['groupName'];
$userID=$row_group['userID'];

$type='group.invite';
$notiText='invited you to join <b>'.$gname.'</b> group ';
$reference='user_groups_id';
$referenceID=$row_group['groupID']; //this is id of user_groups 
$sql_noti=$conn->prepare("INSERT INTO notifications (notiBy,notiTo,type,notiText,reference,referenceID,notiTime) VALUES 
(?,?,?,?,?,?,?)");
$sql_noti->execute(array($userid,$uid,$type,$notiText,$reference,$referenceID,$time));


if($sql==true){
echo '<i class="icon-ok"></i> Invitation Sent';
}else{
echo 'Failed ';	
}
}


//declining group request
if($action=='decline_request'){

$greqID=$_REQUEST['greqID'];
$gid=$_REQUEST['gid'];

$sql_reqid=mysqli_query($dbconfig,"DELETE FROM group_request  WHERE greqID='".$greqID."' ");
$sql_reqid=mysqli_query($dbconfig,"DELETE FROM notifications WHERE referenceID='".$gid."' AND notiTo='".$userid."' AND type='grequest.join'");

if($sql_reqid==true){
echo 'Declined';
}else{
echo 'Unable to Declined Request';	
}

}

//for approving group request
if($action=='approve_request'){

$greqID=$_REQUEST['greqID'];	

$sql_reqid=mysqli_query($dbconfig,"SELECT * FROM group_request WHERE greqID='".$greqID."' ");
$row_reqid=mysqli_fetch_assoc($sql_reqid);
$gid=$row_reqid['groupID'];
$memberID=$row_reqid['userID'];

//if approve insert into group_members
$sql=$conn->prepare("INSERT INTO group_members (groupID,memberID,addTime) VALUES 
(?,?,?)");
$sql->execute(array($gid,$memberID,$time));

//notification for req approve
$sql_acceptid=mysqli_query($dbconfig,"SELECT * FROM group_members WHERE groupID='".$gid."' AND memberID='".$memberID."'");
$row_acceptid=mysqli_fetch_assoc($sql_acceptid);

$notiTo=$row_acceptid['memberID'];
$type='grequest.approve';
$notiText='group approved you group request';
$reference='group_members_id';
$referenceID=$row_acceptid['gmID']; //this is id of group_members table
$sql_noti=$conn->prepare("INSERT INTO notifications (notiBy,notiTo,type,notiText,reference,referenceID,notiTime) VALUES 
(?,?,?,?,?,?,?)");
$sql_noti->execute(array($userid,$notiTo,$type,$notiText,$reference,$referenceID,$time));


//delete request from friend_request if accepted
$sql=mysqli_query($dbconfig,"DELETE FROM group_request WHERE greqID='".$greqID."' ");

if($sql==true){
echo 'Request Approved';
}else{
echo 'Unable to Approved Request';	
}

}

//for group join request
if($action=='join_group_request'){

$gid=$_REQUEST['gid'];

$sql=$conn->prepare("INSERT INTO group_request (userID,groupID,requestTime) VALUES 
(?,?,?)");
$sql->execute(array($userid,$gid,$time));

//fetching group info for notifications
$sql_group=mysqli_query($dbconfig,"SELECT * FROM user_groups WHERE groupID='".$gid."' ");
$row_group=mysqli_fetch_assoc($sql_group);
$gname=$row_group['groupName'];
$userID=$row_group['userID'];

$type='grequest.join';
$notiText='has requested to join your group <b>'.$gname.'</b> ';
$reference='user_groups_id';
$referenceID=$row_group['groupID']; //this is id of user_groups table
$sql_noti=$conn->prepare("INSERT INTO notifications (notiBy,notiTo,type,notiText,reference,referenceID,notiTime) VALUES 
(?,?,?,?,?,?,?)");
$sql_noti->execute(array($userid,$userID,$type,$notiText,$reference,$referenceID,$time));

if($sql==true){
echo '<i class="icon-ok"></i> Sent';
}else{
echo 'Failed ';	
}

}

//for cancel join request
if($action=='cancel_group_request'){

$gid=$_REQUEST['gid'];

$sql=mysqli_query($dbconfig,"DELETE FROM group_request WHERE groupID='".$gid."' AND userID='".$userid."'");
$sql=mysqli_query($dbconfig,"DELETE FROM notifications WHERE referenceID='".$gid."' AND notiBy='".$userid."' AND type='grequest.join'");
if($sql==true){
echo '<i class="icon-remove"></i> Request Cancel';
}else{
echo 'Failed ';	
}

}

//for adding members to group
if($action=='add_members_grp'){

$gname=htmlentities($_REQUEST['gname']);
$memberID=$_REQUEST['memberID'];
$gid=htmlentities($_REQUEST['gid']);

//if no. member is <=1 throw back to page
if($gid=='')
{
if(count($memberID)<=1){
if($gid!=''){
header('location:../addmembers.php?gid='.$gid.'&member=empty');exit;
}else{
header('location:../addmembers.php?gname='.$gname.'&member=empty');exit;
}	
}
}

if($gname==''){ //adding members in already created group
for($i = 0; $i < count($memberID); $i++)
{
$add_members=mysqli_query($dbconfig,"INSERT INTO group_members (memberID,addedBy,groupID,addTime) VALUES 
('".$memberID[$i]."','".$userid."','".$gid."','".($time)."')") or die (mysqli_error($dbconfig));

$sql=mysqli_query($dbconfig,"SELECT * FROM user_groups WHERE groupID='".$gid."' ");
$row=mysqli_fetch_assoc($sql);
$groupName=($row['groupName']);

$type='added.group';
$notiText='added you to '.$groupName.' group ';
$reference='user_groups_id';
$referenceID=$gid; //this is id of user_groups table
$sql_noti=$conn->prepare("INSERT INTO notifications (notiBy,notiTo,type,notiText,reference,referenceID,notiTime) VALUES 
(?,?,?,?,?,?,?)");
$sql_noti->execute(array($userid,$memberID[$i],$type,$notiText,$reference,$referenceID,$time));
}//end for loop

if($add_members==true){
header ('location:../group/'.$gid.'?success');
}else{
header ('location:../group/'.$gid.'?fail');
}
}else{ //inserting group name and then fetching same groupname id 
$sql=$conn->prepare("INSERT INTO user_groups (userID,groupName,createTime) VALUES 
(?,?,?)");
$sql->execute(array($userid,$gname,$time));
$sql=mysqli_query($dbconfig,"SELECT * FROM user_groups WHERE userID='".$userid."' AND groupName='".$gname."' ");
$row=mysqli_fetch_assoc($sql);
$groupID=($row['groupID']);


//if(($key=array_search($userid,$memberID))!==false){ unset($memberID[$key]);}

for($i = 0; $i < count($memberID); $i++)
{
$add_members=mysqli_query($dbconfig,"INSERT INTO group_members (memberID,addedBy,groupID,addTime) VALUES 
('".$memberID[$i]."','".$userid."','".$groupID."','".($time)."')") or die (mysqli_error($dbconfig));

$type='added.group';
$notiText='added you to <b>'.$gname.'</b> group ';
$reference='user_groups_id';
$referenceID=$groupID; //this is id of user_groups table
$sql_noti=$conn->prepare("INSERT INTO notifications (notiBy,notiTo,type,notiText,reference,referenceID,notiTime) VALUES 
(?,?,?,?,?,?,?)");
$sql_noti->execute(array($userid,$memberID[$i],$type,$notiText,$reference,$referenceID,$time));
} //end for loop

//deleting session userid from notification as useid send noti to itself
$sql=mysqli_query($dbconfig,"DELETE FROM notifications WHERE type='added.group' 
AND notiTo='".$userid."' AND notiBy='".$userid."' AND reference='user_groups_id' AND referenceID='".$groupID."' ");

if($add_members==true){
header ('location:../creategroup.php?success');
}else{
header ('location:../creategroup.php?fail');
}	
}	

}

//sending message
if($action=='send_msg'){

$message=$_REQUEST['message'];
$sentTo=$_REQUEST['sentTo'];

$sql=$conn->prepare("INSERT INTO user_message (sentBy,sentTo,message,sentTime) VALUES 
(?,?,?,?)");
$sql->execute(array($userid,$sentTo,htmlentities ($message),$time));

$sql_fetch_msg=mysqli_query($dbconfig,"SELECT * FROM user_message WHERE sentTo='".$sentTo."' AND sentBy=".$userid."  ORDER BY msgID DESC");
$row_fetch_msg=mysqli_fetch_assoc($sql_fetch_msg);

$sql1=$conn->prepare("INSERT INTO user_message_status (msgID,userID) VALUES 
(?,?)");
$sql1->execute(array($row_fetch_msg['msgID'],$userid)); 

if($sql==true and $sql1==true){ 
include 'load_msg.php';
?>

<?php }else{
echo 'Retry ';	
}

}

// declining or hiding contact sharing info
if($action=='decline_info'){

$sharereqID=$_REQUEST['sharereqID'];	

if($sharereqID!=''){

//delete shared info from share_request_info 
$sql=mysqli_query($dbconfig,"DELETE FROM share_request_info WHERE sharereqID='".$sharereqID."'");
$sql=mysqli_query($dbconfig,"DELETE FROM notifications WHERE referenceID='".$sharereqID."' 
AND notiBy='".$userid."' AND reference='share_request_info_id' ");
if($sql==true){
echo 'Deleted';
}else{
echo 'Failed ';	
}
}else{

$reqinfoID=$_REQUEST['reqinfoID'];	

//delete request from request_info if decline
$sql=mysqli_query($dbconfig,"DELETE FROM request_info WHERE reqinfoID='".$reqinfoID."'");
$sql=mysqli_query($dbconfig,"DELETE FROM notifications WHERE referenceID='".$reqinfoID."' AND notiTo='".$userid."' AND reference='request_info_id' ");

if($sql==true){
echo 'Declined';
}else{
echo 'Failed ';	
}
}

}

// sharing contact info
if($action=='share_info'){

$reqinfoID=$_REQUEST['reqinfoID'];

//check that contact info is filled
if($user['userPhone']==''){echo '<div class="floating_message_red">
<h5>You dont have phone details to your profile,Please update you contact details and then
share with your request user.</h5></div>';
echo 'Failed';

}else {
// fetching info from request_info
$sql_fetch_req=mysqli_query($dbconfig,"SELECT * FROM request_info WHERE reqinfoID='".$reqinfoID."' ");
$row_fetch_req=mysqli_fetch_assoc($sql_fetch_req);
if($row_fetch_req['reqAbout']=='request.email')	{$info='email';}else{$info='contact';}
$type='share.'.$info.'';

$sql=$conn->prepare("INSERT INTO share_request_info (shareBy,shareWith,type,shareTime) VALUES 
(?,?,?,?)");
$sql->execute(array($userid,$row_fetch_req['reqBy'],$type,$time));

//notification for ask contact
$sql_acceptid=mysqli_query($dbconfig,"SELECT * FROM share_request_info WHERE shareWith='".$row_fetch_req['reqBy']."' AND shareBy='".$userid."'");
$row_acceptid=mysqli_fetch_assoc($sql_acceptid);

if($row_fetch_req['reqAbout']=='request.email')	{$info='email';}else{$info='contact';}

$type='share.'.$info.'';
$notiText='has shared '.$info.' details with you requested by you earlier';
$reference='share_request_info_id';
$referenceID=$row_acceptid['sharereqID']; //this is id of share_request_info table
$sql_noti=$conn->prepare("INSERT INTO notifications (notiBy,notiTo,type,notiText,reference,referenceID,notiTime) VALUES 
(?,?,?,?,?,?,?)");
$sql_noti->execute(array($userid,$row_acceptid['shareWith'],$type,$notiText,$reference,$referenceID,$time));


//delete request from request_info if shared
$sql=mysqli_query($dbconfig,"DELETE FROM request_info WHERE reqinfoID='".$reqinfoID."'");

if($sql==true){
echo 'Success';
}else{
echo 'Failed ';	
}
}

}

//asking phone info
if($action=='ask_contact'){

$reqTo=$_REQUEST['requserID'];
$reqAbout=$_REQUEST['reqAbout'];
// checking if request is already sent
$sql_check_req=mysqli_query($dbconfig,"SELECT * FROM request_info WHERE reqTo='".$reqTo."' AND reqBy='".$userid."' 
AND reqAbout='request.contact' ");
if(mysqli_num_rows($sql_check_req)==true){
echo '<div class="floating_message_red"><h5>You have already requested earlier.Please wait for the user response</h5></div>';
}else{ 
$sql=$conn->prepare("INSERT INTO request_info (reqBy,reqTo,reqAbout,reqTime) VALUES 
(?,?,?,?)");
$sql->execute(array($userid,$reqTo,$reqAbout,$time));

//notification for ask contact
$sql_acceptid=mysqli_query($dbconfig,"SELECT * FROM request_info WHERE reqTo='".$reqTo."' AND reqBy='".$userid."'");
$row_acceptid=mysqli_fetch_assoc($sql_acceptid);
 
$type='request.contact';
$notiText='has requested for your phone contact';
$reference='request_info_id';
$referenceID=$row_acceptid['reqinfoID']; //this is id of request_info table
$sql_noti=$conn->prepare("INSERT INTO notifications (notiBy,notiTo,type,notiText,reference,referenceID,notiTime) VALUES 
(?,?,?,?,?,?,?)");
$sql_noti->execute(array($userid,$reqTo,$type,$notiText,$reference,$referenceID,$time));

if($sql==true){
echo '<div class="floating_message_red"><h5>Request sent successfully</h5></div>';
}else{
echo '<div class="floating_message_red"><h5>Unable to Send Request</h5></div>';	
}
}

}

//asking email info
if($action=='ask_email'){

$reqTo=$_REQUEST['requserID'];
$reqAbout=$_REQUEST['reqAbout'];
// checking if request is already sent
$sql_check_req=mysqli_query($dbconfig,"SELECT * FROM request_info WHERE reqTo='".$reqTo."' AND reqBy='".$userid."' 
AND reqAbout='".$reqAbout."' ");
$check_if_contact_req=mysqli_num_rows($sql_check_req);
if($check_if_contact_req==true){
echo '<div class="floating_message_red"><h5>You have already requested earlier.Please wait for the user response</h5></div>';
}else{ 
$sql=$conn->prepare("INSERT INTO request_info (reqBy,reqTo,reqAbout,reqTime) VALUES 
(?,?,?,?)");
$sql->execute(array($userid,$reqTo,$reqAbout,$time));

//notification for ask contact
$sql_acceptid=mysqli_query($dbconfig,"SELECT * FROM request_info WHERE reqTo='".$reqTo."' AND reqBy='".$userid."'");
$row_acceptid=mysqli_fetch_assoc($sql_acceptid);

$type='request.email';
$notiText='has requested for you Email-ID';
$reference='request_info_id';
$referenceID=$row_acceptid['reqinfoID']; //this is id of request_info table
$sql_noti=$conn->prepare("INSERT INTO notifications (notiBy,notiTo,type,notiText,reference,referenceID,notiTime) VALUES 
(?,?,?,?,?,?,?)");
$sql_noti->execute(array($userid,$reqTo,$type,$notiText,$reference,$referenceID,$time));

if($sql==true){
echo '<div class="floating_message_red"><h5>Request sent successfully</h5></div>';
}else{
echo '<div class="floating_message_red"><h5>Unable to Send Request</h5></div>';	
}
}

}

//accpting friend request
if($action=='friend_request_accept'){

$friendreqID=$_REQUEST['friendreqID'];	

$sql_reqid=mysqli_query($dbconfig,"SELECT * FROM friend_request WHERE friendreqID='".$friendreqID."' ");
$row_reqid=mysqli_fetch_assoc($sql_reqid);
$friendWith=$row_reqid['userID'];

//if accepted insert into my_friends
$sql=$conn->prepare("INSERT INTO my_friends (userID,friendWith,friendshipTime) VALUES 
(?,?,?)");
$sql->execute(array($userid,$friendWith,$time));

//notification for req accepeted
$sql_acceptid=mysqli_query($dbconfig,"SELECT * FROM my_friends WHERE friendWith='".$friendWith."' AND userID='".$userid."'");
$row_acceptid=mysqli_fetch_assoc($sql_acceptid);

$notiTo=$row_acceptid['friendWith'];
$type='request.accepted';
$notiText='accepted your friend request';
$reference='my_friend_id';
$referenceID=$row_acceptid['myfriendID']; //this is id of my_friends table
$sql_noti=$conn->prepare("INSERT INTO notifications (notiBy,notiTo,type,notiText,reference,referenceID,notiTime) VALUES 
(?,?,?,?,?,?,?)");
$sql_noti->execute(array($userid,$notiTo,$type,$notiText,$reference,$referenceID,$time));


//delete request from friend_request if accepted
$sql=mysqli_query($dbconfig,"DELETE FROM friend_request WHERE friendreqID='".$friendreqID."'");

if($sql==true){
echo '<i class="icon-ok"></i> Request Accepted';
}else{
echo 'Unable to Accepet Request';	
}

}

// delete friend request
if($action=='friend_request_delete'){

$friendreqID=$_REQUEST['friendreqID'];	

$sql=mysqli_query($dbconfig,"SELECT * FROM friend_request WHERE friendreqID='".$friendreqID."' ");
$row=mysqli_fetch_assoc($sql);

$sql=mysqli_query($dbconfig,"DELETE FROM notifications WHERE notiBy='".$row['userID']."' AND notiTo='".$row['friendWith']."'
AND `type`='request.sent' AND referenceID='".$friendreqID."' ");

$sql=mysqli_query($dbconfig,"DELETE FROM friend_request WHERE friendreqID='".$friendreqID."'")or die(mysqli_error($dbconfig)) ;

if($sql==true){
echo 'Deleted';
}else{
echo 'Delete Fail';	
}

}

//unfriend 
if($action=='unfrnd'){

$myfriendID=$_REQUEST['myfriendID'];

$sql=mysqli_query($dbconfig,"SELECT * FROM my_friends WHERE myfriendID='".$myfriendID."' ");
$row=mysqli_fetch_assoc($sql);

$sql=mysqli_query($dbconfig,"DELETE FROM notifications WHERE (notiBy='".$row['userID']."' AND notiTo='".$row['friendWith']."')
OR (notiTo='".$row['userID']."' AND notiBy='".$row['friendWith']."') AND `type`='request.sent' ");

$sql=mysqli_query($dbconfig,"DELETE FROM my_friends WHERE myfriendID='".$myfriendID."'") or die(mysqli_error($dbconfig));

if($sql==true){
echo 'Success';
}else{
echo 'Delete Fail';	
}

}


// sending friend request
if($action=='friend_request'){

$friendWith=$_REQUEST['friendWith'];	

$sql=$conn->prepare("INSERT INTO friend_request (userID,friendWith,requestTime) VALUES 
(?,?,?)");
$sql->execute(array($userid,$friendWith,$time));

//notification for friend request
$sql_reqid=mysqli_query($dbconfig,"SELECT * FROM friend_request WHERE userID='".$userid."' AND friendWIth='".$friendWith."'");
$row_reqid=mysqli_fetch_assoc($sql_reqid);

$notiTo=$_REQUEST['friendWith'];
$type='request.sent';
$notiText='sent you a friend request';
$reference='friend_request_id';
$referenceID=$row_reqid['friendreqID']; //this is id of friend_request table
$sql=$conn->prepare("INSERT INTO notifications (notiBy,notiTo,type,notiText,reference,referenceID,notiTime) VALUES 
(?,?,?,?,?,?,?)");
$sql->execute(array($userid,$notiTo,$type,$notiText,$reference,$referenceID,$time));

if($sql==true){
echo '<i class="icon-ok"></i> Request Sent';
}else{
echo 'Unable to Sent Request';	
}

}

// cancel friend request
if($action=='friend_request_cancel'){

$friendreqID=$_REQUEST['friendreqID'];	

//deleting notification of sent req
$sql_reqid=mysqli_query($dbconfig,"SELECT * FROM friend_request WHERE friendreqID='".$friendreqID."'");
$row_reqid=mysqli_fetch_assoc($sql_reqid);

$sql1=mysqli_query($dbconfig,"DELETE FROM notifications WHERE notiBy='".$row_reqid['userID']."' AND notiTo='".$row_reqid['friendWith']."'
AND `type`='request.sent' ");

$sql=mysqli_query($dbconfig,"DELETE FROM friend_request WHERE friendreqID='".$friendreqID."'");
if($sql==true){
echo 'Request Cancel';
}else{
echo 'Unable to Cancel Request';	
}

}

//for updating group info
if($action=='update_group_info'){

$gid=htmlentities($_REQUEST['gid']);	
$groupName=htmlentities($_REQUEST['gname']);
$privacy = htmlentities($_REQUEST['privacy']);
$approval = htmlentities($_REQUEST['approval']);


if($groupName!=''){
$sql =$conn->prepare("UPDATE user_groups SET groupName = :groupName WHERE groupID = '".$gid."' ");
$sql->execute(array(':groupName'=>$groupName));}

if($privacy!=''){
$sql =$conn->prepare("UPDATE user_groups SET privacy = :privacy WHERE groupID = '".$gid."' ");
$sql->execute(array(':privacy'=>$privacy));}

if($approval!=''){
$sql =$conn->prepare("UPDATE user_groups SET approval = :approval WHERE groupID = '".$gid."' ");
$sql->execute(array(':approval'=>$approval));}

if ($sql==true) {
header('location:../group/'.$gid.'?&edit_group=1 '); exit;
}else{
header('location:../group/'.$gid.'?&edit_group=1 '); exit;
}

}

//updating user_profile_info
if($action=='personal_info'){

$firstName=htmlentities($_REQUEST['firstName']);
$lastName = htmlentities($_REQUEST['lastName']);
$birthday =htmlentities($_REQUEST['year']).'-'.htmlentities($_REQUEST['month']).'-'.htmlentities($_REQUEST['day']);
$gender = htmlentities($_REQUEST['gender']);
$webName = htmlentities($_REQUEST['webName']);

$sql =$conn->prepare("UPDATE users SET firstName = :firstName,lastName=:lastName,
birthday = :birthday,gender=:gender,webName = :webName
WHERE userID = '".$userid."' ");
$sql->execute(array(':firstName'=>$firstName,':lastName'=>$lastName,':birthday'=>$birthday,':gender'=>$gender,':webName'=>$webName));

if ($sql==true) {
header('location:../editprofile.php?profile_update_success=1'); exit;
}else{
header('location:../editprofile.php?profile_update_fail=1'); exit;
}

}

//updating user_profile_info
if($action=='user_contact'){

$userPhone = htmlentities($_REQUEST['userPhone']);
$userEmail = htmlentities($_REQUEST['userEmail']);
$emailPrivacy = htmlentities($_REQUEST['emailPrivacy']);
$phonePrivacy = htmlentities($_REQUEST['phonePrivacy']);

$sql =$conn->prepare("UPDATE users SET userPhone = :userPhone,userEmail=:userEmail,
emailPrivacy = :emailPrivacy,phonePrivacy=:phonePrivacy
WHERE userID = '".$userid."' ");
$sql->execute(array(':userPhone'=>$userPhone,':userEmail'=>$userEmail,':emailPrivacy'=>$emailPrivacy,':phonePrivacy'=>$phonePrivacy));


if ($sql==true) {
header('location:../editprofile.php?profile_update_success=1'); exit;
}else{
header('location:../editprofile.php?profile_update_fail=1'); exit;
}

}


//updating user education info
if($action=='user_edu'){

	$instituteName = htmlentities($_REQUEST['instituteName']);
	$courseName = ($_REQUEST['courseName']);
	$branchName = $_REQUEST['branchName'];
	if($_REQUEST['joinDay']!='' or $_REQUEST['joinMonth']!='' or $_REQUEST['joinYear']!=''){
	$joinDate = $_REQUEST['joinYear'].'-'.$_REQUEST['joinMonth'].'-'.$_REQUEST['joinDay'];}
	
	if($_REQUEST['passoutDay']!='' or $_REQUEST['passoutMonth']!='' or $_REQUEST['passoutYear']!=''){
	$passoutDate = $_REQUEST['passoutYear'].'-'.$_REQUEST['passoutMonth'].'-'.$_REQUEST['passoutDay'];}
	$currentlystudying = $_REQUEST['currentlystudying'];
	
	
	//checking if edu info is empty	
	$sql_count=mysqli_query($dbconfig,"SELECT * FROM users_edu WHERE userID='".$userid."'");
	$count=mysqli_num_rows($sql_count);
	
	if($count==''){ //if empty Insert edu info
	$sql=$conn->prepare("INSERT INTO users_edu (userID,instituteName,courseName,branchName,joinDate,passoutDate,currentlystudying,updateTime) VALUES 
	(?,?,?,?,?,?,?,?)");
	$sql->execute(array($userid,$instituteName,$courseName,$branchName,$joinDate,$passoutDate,$currentlystudying,$time));	
	
	}else{	//else update edu info
	
	$sql =$conn->prepare("UPDATE users_edu SET instituteName = :instituteName,courseName=:courseName,
	branchName = :branchName,joinDate=:joinDate,passoutDate = :passoutDate,currentlystudying = :currentlystudying,updateTime = :updateTime
	WHERE userID = '".$userid."' ");
	$sql->execute(array(':instituteName'=>$instituteName,':courseName'=>$courseName,':branchName'=>$branchName,':joinDate'=>$joinDate,':passoutDate'=>$passoutDate
	,':currentlystudying'=>$currentlystudying,':updateTime'=>$time));
	}
	
	$redirect=$_REQUEST['redirect'];
	if($redirect=='step'){
		if ($sql==true){
		header('location:../step/2'); exit;
		} else{
		header('location:../step/1'); exit;	
		}
	}else{	
	
	if ($sql==true) {
	header('location:../editprofile.php?profile_update_success=1'); exit;
	}else{
	header('location:../editprofile.php?profile_update_fail=1'); exit;
	}
	}
}


//update user workplace info
if($action=='update_work_place'){

$workID = htmlentities($_REQUEST['workID']);
$companyName = htmlentities($_REQUEST['companyName']);
$description = ($_REQUEST['description']);
$position = $_REQUEST['position'];
$startDate = $_REQUEST['startyear'].'-'.$_REQUEST['startmonth'].'-'.$_REQUEST['startday'];

$endDate = $_REQUEST['endyear'].'-'.$_REQUEST['endmonth'].'-'.$_REQUEST['endday'];

$currentlyworking = $_REQUEST['currentlyworking'];

	
$sql =$conn->prepare("UPDATE user_workplace SET companyName = :companyName,description = :description,position = :position
,startDate = :startDate,endDate = :endDate,currentlyworking = :currentlyworking WHERE workID = '".$workID."' ");

$sql->execute(array(':companyName'=>$companyName,':description'=>$description,':position'=>$position,':startDate'=>$startDate
,':endDate'=>$endDate,':currentlyworking'=>$currentlyworking));

if ($sql==true) {
	header('location:../editprofile.php?profile_update_success=1'); exit;
}else{
	header('location:../editprofile.php?profile_update_fail=1'); exit;
}

}

//add user workplace info
if($action=='work_place'){

$companyName = htmlentities($_REQUEST['companyName']);
$description = ($_REQUEST['description']);
$position = $_REQUEST['position'];
$startDate = $_REQUEST['startyear'].'-'.$_REQUEST['startmonth'].'-'.$_REQUEST['startday'];

$endDate = $_REQUEST['endyear'].'-'.$_REQUEST['endmonth'].'-'.$_REQUEST['endday'];
$currentlyworking = $_REQUEST['currentlyworking'];

$sql=$conn->prepare("INSERT INTO user_workplace (userID,companyName,description,position,startDate,endDate,currentlyworking,createTime) VALUES 
(?,?,?,?,?,?,?,?)");
$sql->execute(array($userid,$companyName,$description,$position,$startDate,$endDate,$currentlyworking,$time));	

if ($sql==true) {
header('location:../editprofile.php?profile_update_success=1'); exit;
}else{
header('location:../editprofile.php?profile_update_fail=1'); exit;
}

}

//updating user_profile_info
if($action=='change_password'){

	$oldpass=htmlentities(md5($_REQUEST['oldpass']));
	$newpass = htmlentities($_REQUEST['newpass']);
	$confirmpass = htmlentities($_REQUEST['confirmpass']);
	
	$newpassenc = htmlentities(md5($_REQUEST['newpass']));
	
	
	$sql = $conn->prepare("SELECT * FROM users WHERE userPass =:oldpass") ;
	$res = $sql->execute(array("oldpass" =>$oldpass));
	$row=$sql->fetch(PDO::FETCH_ASSOC);
	$count=$sql->rowCount();
		if($oldpass=='' or $newpass=='' or $confirmpass==''){
		echo 'field';exit;
		}else
		if($newpass!=$confirmpass){
			echo 'notmatch';exit;
			}else
			if(strlen($newpass) >= 8){
			 echo 'length'; exit;
		} 
		else if($count != true){ 
			echo 'oldpass';exit; //old pass dont match
		} 
	
	$sql =$conn->prepare("UPDATE users SET userPass = :userPass,updateTime=:updateTime
	WHERE userID = '".$userid."' ");
	$sql->execute(array(':userPass'=>$newpassenc,':updateTime'=>$time));
	
	if ($sql==true) {
	echo 'true';exit;
	}else{
	echo 'false';
	}
}

//updating user_profile_info
if($action=='social_con'){

	$fb_name=htmlentities(($_REQUEST['fb_name']));
	$in_name = htmlentities($_REQUEST['in_name']);
	$fb_privacy=htmlentities(($_REQUEST['fb_privacy']));
	$in_privacy = htmlentities($_REQUEST['in_privacy']);
	 
	
	$sql = $conn->prepare("SELECT * FROM user_social_con WHERE userID =:userID") ;
	$res = $sql->execute(array("userID" =>$userid));
	$row=$sql->fetch(PDO::FETCH_ASSOC);
	$count=$sql->rowCount();
		
		if($count==''){
			$sql=$conn->prepare("INSERT INTO user_social_con (userID,fb_name,fb_privacy,in_name,in_privacy,createTime) VALUES 
			(?,?,?,?,?,?)");
			$sql->execute(array($userid,$fb_name,$fb_privacy,$in_name,$in_privacy,$time));
			} else{
	
		$sql =$conn->prepare("UPDATE user_social_con SET fb_name = :fb_name,fb_privacy = :fb_privacy,in_name = :in_name,in_privacy = :in_privacy,updateTime=:updateTime
		WHERE userID = '".$userid."' ");
		$sql->execute(array(':fb_name'=>$fb_name,':fb_privacy'=>$fb_privacy,':in_name'=>$in_name,':in_privacy'=>$in_privacy,':updateTime'=>$time));
		}
	if ($sql==true) {
	echo 'true';exit;
	}else{
	echo 'false';
	}

}

// for fetching courses 
if(isset($_POST['get_option']))

{
$courseName = $_POST['get_option'];
$sql=mysqli_query($dbconfig,"SELECT * FROM courses LEFT JOIN branches ON courses.courseID=branches.courseID WHERE courses.courseName='".$courseName."'");
$sql>0;
$countSearch=mysqli_num_rows($sql);
while($row=mysqli_fetch_assoc($sql)) 
{  ?>
<option><?php echo $row['branchName']; ?></option>
<?php } ?>
<option>Other</option>
<?php  exit;

}

?>