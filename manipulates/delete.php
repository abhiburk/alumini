<?php
require('../config.php');
//echo '<pre>'; print_r($_REQUEST); print_r($_FILES); die;

$action = isset($_REQUEST['xAction']) ? htmlentities($_REQUEST['xAction']) : '';

if($action == 'delete_answer'){
	$answerID = intval($_REQUEST['answerID']);
		
		//deleting answers associated with this fqid
		$sql = mysqli_query($dbconfig,"DELETE FROM notifications WHERE 
		(referenceID='".$answerID."' AND reference='forum_answer_id') ");
		
		// deleting answer
		$sql=mysqli_query($dbconfig,"DELETE FROM forum_answers WHERE answerID='".$answerID."' AND userID='".$userid."' ");
		////deleting tag associated with this fqid
		$sql = mysqli_query($dbconfig,"DELETE FROM forum_answer_votes WHERE answerID='".$answerID."' ");	
		
		
	if($sql==true){
	echo '<div class="floating_message_red"><h5>Answer Deleted Successfully </h5></div>';
	}
}

if($action == 'delete_question'){
	$fqID = intval($_REQUEST['fqID']);
		
		$sql1=mysqli_query($dbconfig,"SELECT * FROM forum_questions AS q LEFT JOIN forum_answers USING (fqID)
		WHERE q.fqID='".$fqID."' ") or die (mysqli_error($dbconfig));
		while($row=mysqli_fetch_assoc($sql1)){
			//deleting answer votes associated with this fqid
		$sql = mysqli_query($dbconfig,"DELETE FROM forum_answer_votes WHERE answerID='".$row['answerID']."' ");	
		
		//deleting answers associated with this fqid
		$sql = mysqli_query($dbconfig,"DELETE FROM notifications WHERE (referenceID='".$fqID."' AND reference='forum_question_id') OR
		(referenceID='".$row['answerID']."' AND reference='forum_answer_id') ");	
		}
		
		// deleting question
		$sql=mysqli_query($dbconfig,"DELETE FROM forum_questions WHERE fqID='".$fqID."' AND userID='".$userid."' ");
		////deleting tag associated with this fqid
		$sql = mysqli_query($dbconfig,"DELETE FROM forum_question_tag WHERE fqID='".$fqID."' ");
		//deleting votes associated with this fqid
		$sql = mysqli_query($dbconfig,"DELETE FROM forum_question_votes WHERE fqID='".$fqID."' ");	
			
		//deleting answers associated with this fqid
		$sql = mysqli_query($dbconfig,"DELETE FROM forum_answers WHERE fqID='".$fqID."' ");	
		
	if($sql==true){
	echo '<div class="floating_message_red"><h5>Question Deleted Successfully </h5></div>';
	}
}

if($action == 'delete_event'){
	$eid = intval($_REQUEST['eid']);
		
		$sql=mysqli_query($dbconfig,"SELECT * FROM posts AS p LEFT JOIN user_events AS e ON p.referenceID=e.eventID
		LEFT JOIN post_comments AS c USING (postID)
		WHERE eventID='".$eid."' AND postType='event.post' ") or die (mysqli_error($dbconfig));
		while($row=mysqli_fetch_assoc($sql)){
			
		//deleting notification assocaiated with this events	
		$sql = mysqli_query($dbconfig,"DELETE FROM notifications WHERE (referenceID='".$eid."' OR  referenceID='".$row['commentID']."' OR  referenceID='".$row['postID']."')
		AND (reference='user_event_id' or  reference='comment_id' or  reference='post_comment_id' or reference='event_post_id') ");
		
		//deleting post comments
		$sql=mysqli_query($dbconfig,"DELETE FROM post_comments WHERE (commentID='".$row['commentID']."')");
		}
		// deleting post
		$sql=mysqli_query($dbconfig,"DELETE FROM posts WHERE (referenceID='".$eid."') AND (postType='event.post' ) ");
		//deleting event
		$sql = mysqli_query($dbconfig,"DELETE FROM user_events WHERE eventID='".$eid."' AND userID='".$userid."'  ");	
		
	if($sql==true){
	echo '<div class="floating_message_red"><h5>Event Deleted Successfully </h5></div>';
	}
}

//deleting group chat
if($action == 'del_group_chat'){
	$gid = htmlentities($_REQUEST['gid']);
		
		$sql=mysqli_query($dbconfig,"SELECT * FROM group_discussion_status LEFT JOIN group_discussion USING (disID) 
		WHERE groupID='".$gid."' AND readBy='".$userid."' ") or die (mysqli_error($dbconfig));
		while($row=mysqli_fetch_assoc($sql)){
		//echo $row['gdstatusID'];
		
		
		$sql_delete = mysqli_query($dbconfig,"UPDATE group_discussion_status SET deletedBy='".$userid."' WHERE gdstatusID='".$row['gdstatusID']."' ");
	}
	if($sql_delete==true){
	echo '<div class="floating_message_red"><h5>Chat Deleted</h5></div>';
	}else {
		echo 'Fail';	
		}
	
}
//deleting group message
if($action=='del_group_msg'){
$gdstatusID=$_REQUEST['gdstatusID'];
	$sql=mysqli_query($dbconfig,"UPDATE group_discussion_status SET deletedBy='".$userid."' WHERE gdstatusID='".$gdstatusID."' ");
}

if($action == 'remove_guser'){
	$mID = intval($_REQUEST['mID']);
	$gid = intval($_REQUEST['gid']);
		
		$sql = mysqli_query($dbconfig,"DELETE FROM group_members WHERE memberID='".$mID."' AND groupID='".$gid."'  ");	
		$sql = mysqli_query($dbconfig,"DELETE FROM notifications WHERE notiBy='".$gID."' AND notiTo='".$mID."' AND type='grequest.approve'  ");
	if($sql==true){
	echo 'Removed Successfully';
	}
}
if($action == 'confirm_leave'){
$gid = intval($_REQUEST['gid']);
		
		$sql = mysqli_query($dbconfig,"DELETE FROM group_members WHERE memberID='".$userid."' AND groupID='".$gid."'  ");
		$sql = mysqli_query($dbconfig,"DELETE FROM user_groups WHERE groupID='".$gid."'  ");	
		$sql = mysqli_query($dbconfig,"DELETE FROM notifications WHERE notiBy='".$gid."' AND notiTo='".$userid."' AND type='grequest.approve'  ");
	if($sql==true){
	echo '<i class="icon-ok"> Done </i>';	
	echo '<div class="floating_message_red"><h5>Group Deleted and Left Successfully</h5></div>';
	}else {
		echo 'Fail';	
		}
}
if($action == 'leave_group'){
	$gid = intval($_REQUEST['gid']);
		
		//checking if admin leaves the group and assigning below person as admin
		$sql=mysqli_query($dbconfig,"SELECT * FROM user_groups WHERE userID=".$userid." AND groupID=".$gid." ") ;
		$row=mysqli_fetch_assoc($sql);
		if($row['userID']==$userid){
			$sql_new_admin=mysqli_query($dbconfig,"SELECT * FROM group_members WHERE groupID=".$gid." AND memberID!=".$userid." ")or die (mysqli_error($dbconfig));
			$row_new_admin=mysqli_fetch_assoc($sql_new_admin);
			$count=mysqli_num_rows($sql_new_admin);
			if($count!=0){
				$sql_update=mysqli_query($dbconfig,"UPDATE user_groups SET userID=".$row_new_admin['memberID']." WHERE groupID=".$gid." ")or die (mysqli_error($dbconfig));
				}
			else { // delete whole group
					echo '';exit; 
			}
		}
		
		$sql = mysqli_query($dbconfig,"DELETE FROM group_members WHERE memberID='".$userid."' AND groupID='".$gid."'  ");	
		$sql = mysqli_query($dbconfig,"DELETE FROM notifications WHERE notiBy='".$gid."' AND notiTo='".$userid."' AND type='grequest.approve'  ");
	if($sql==true){
	echo '<div class="floating_message_red"><h5>Group Left Successfully </h5></div>';
	}
}


if($action == 'del_msg'){
	$msgID = intval($_REQUEST['msgID']);
	$sql_delete=mysqli_query($dbconfig,"SELECT * FROM user_message WHERE sentBy='".$userid."' AND msgID='".$msgID."' ");
	$check=mysqli_num_rows($sql_delete);
	if($check==true){
		$sql = mysqli_query($dbconfig,"UPDATE user_message_status SET deleted='10' WHERE msgID = '".$msgID."' ");	
		}else{
		$sql = mysqli_query($dbconfig,"UPDATE user_message_status SET deleted='01' WHERE msgID = '".$msgID."' ");		
			}
	if($sql_delete==true){
	echo '<div class="floating_message_red"><h5>Deleted successfully</h5></div>';
	}
}

if($action == 'delete_chat'){
	$uID = intval($_REQUEST['uID']);
	
	
			//checking if already deleted by end user
			$sql_fetch1=mysqli_query($dbconfig,"SELECT * FROM user_message
	 		WHERE (sentBy='".$userid."' AND sentTo='".$uID."') ");
			while($row_fetch1=mysqli_fetch_assoc($sql_fetch1)){

				$sql_fetch_deleted1=mysqli_query($dbconfig,"SELECT * FROM user_message LEFT JOIN user_message_status USING (msgID)
				WHERE (sentBy='".$userid."' AND sentTo='".$uID."') AND deleted=01 AND msgID='".$row_fetch1['msgID']."' ");
				$check_if_deleted1=mysqli_num_rows($sql_fetch_deleted1);
				
				if($check_if_deleted1==true){ // if true then mark delete as 11
				$sql1 = mysqli_query($dbconfig,"UPDATE user_message_status SET deleted='11' WHERE msgID = '".$row_fetch1['msgID']."'  ");	
				//deleting oringnal msgs if deleted=11
				$sql1=mysqli_query($dbconfig,"DELETE FROM user_message WHERE msgID='".$row_fetch1['msgID']."' ");
				
			}
			else { //mark read=10 ,deleted=10
			      $sql1 = mysqli_query($dbconfig,"UPDATE user_message_status SET deleted='10' WHERE msgID = '".$row_fetch1['msgID']."' ");
				  $sql1 = mysqli_query($dbconfig,"UPDATE user_message_status SET `read`='10',readTime='".$time."' WHERE msgID = '".$row_fetch1['msgID']."' ");
				  }
			}
			if($sql1==true){
			echo '<div class="floating_message_red"><h5>Chat Deleted</h5></div>';
			}
			
			//checking if already deleted by owner of msg
			$sql_delete2=mysqli_query($dbconfig,"SELECT * FROM user_message
	 		WHERE (sentTo='".$userid."' AND sentBy='".$uID."') ");
			while($row_fetch2=mysqli_fetch_assoc($sql_delete2)){
				
				
				$sql_fetch_deleted2=mysqli_query($dbconfig,"SELECT * FROM user_message LEFT JOIN user_message_status USING (msgID)
				 WHERE (sentTo='".$userid."' AND sentBy='".$uID."') AND deleted=10 AND msgID = '".$row_fetch2['msgID']."' ");
				$check_if_deleted2=mysqli_num_rows($sql_fetch_deleted2);
				
				if($check_if_deleted2==true){
				$sql22 = mysqli_query($dbconfig,"UPDATE user_message_status SET deleted='11' WHERE msgID = '".$row_fetch2['msgID']."'    ");
				$sql22=mysqli_query($dbconfig,"DELETE FROM user_message WHERE msgID='".$row_fetch2['msgID']."' ");	
			}
			else {
			      $sql22 = mysqli_query($dbconfig,"UPDATE user_message_status SET deleted='01' WHERE msgID = '".$row_fetch2['msgID']."' ");
				  $sql22 = mysqli_query($dbconfig,"UPDATE user_message_status SET `read`='01',readTime='".$time."' WHERE msgID = '".$row_fetch2['msgID']."' ");
				  }
			}
			if($sql22==true){
			echo '<div class="floating_message_red"><h5>Chat Deleted</h5></div>';
			}
			
			$sql_delete_all=mysqli_query($dbconfig,"DELETE FROM user_message_status WHERE deleted='11' ");
			
}	


?>
