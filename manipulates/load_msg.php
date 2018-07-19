<?php 
include '../config.php'; 
$sentTo = ($_REQUEST['sentTo']);

		$sql_chat1=mysqli_query($dbconfig,"SELECT * FROM user_message AS m LEFT JOIN users AS u 
		ON m.sentBy=u.userID LEFT JOIN user_message_status USING (msgID)
		WHERE m.sentBy='".$sentTo."' AND m.sentTo='".$userid."' AND deleted!='01' 
		UNION 
		SELECT * FROM user_message AS m LEFT JOIN users AS u ON m.sentBy=u.userID
		LEFT JOIN user_message_status USING (msgID)
		WHERE m.sentBy='".$userid."' AND m.sentTo='".$sentTo."' AND deleted!='10'  
		ORDER BY msgID ASC") or die (mysqli_error($dbconfig));
		while($row_chat1=mysqli_fetch_assoc($sql_chat1)){
			
			//for user info
			$sql_chat=mysqli_query($dbconfig,"SELECT *,$name FROM users AS u 
			WHERE u.userID='".$row_chat1['userID']."' ") or die (mysqli_error($dbconfig));
			($row_chat=mysqli_fetch_assoc($sql_chat));
			
			//for read msg
			$sql_read=mysqli_query($dbconfig,"SELECT * FROM user_message_status
			WHERE msgID='".$row_chat1['msgID']."' AND `read`='01' AND userID='".$userid."' ") or die (mysqli_error($dbconfig));
			($row_read=mysqli_fetch_assoc($sql_read));	
				
				$sql_req_user=mysqli_query($dbconfig,"SELECT * FROM user_message_status WHERE msgstatusID='".$row_chat1['msgstatusID']."'
				AND `read`='00' ") or die(mysqli_error($dbconfig));
				$check=mysqli_num_rows($sql_req_user);
				$check = isset($check) ? htmlentities($check) : '';
				if($check==true){
				//for updateing read status
				$sql_update_read=mysqli_query($dbconfig,"UPDATE user_message_status SET `read`='01',readTime='".$time."' 
				WHERE msgstatusID='".$row_chat1['msgstatusID']."' AND userID='".$sentTo."'")or die(mysqli_error($dbconfig));
				}
		?>	 
			<li rel="<?php echo $row_chat1['msgID'] ?>" class="click_read <?php if($row_chat['userID']==$userid){echo 'right mychat';}else{echo 'left userchat';} ?> clearfix">
				<span class="chat-img pull-<?php if($row_chat['userID']==$userid){echo 'right';}else{echo 'left';} ?>">
					<img src="<?php if($row_chat['userImg']==''){echo 'images/default.jpg';}else {
					echo 'uploads/'.$row_chat['userImg']; } ?>" alt="User Avatar" class="img-circle onlineImg">
				</span>

				<div class="chat-body clearfix">
				
				<div class="header">
				<div class="dropdown <?php if($row_chat['userID']==$userid){echo 'floatleft';}else{echo 'floatright';} ?>" style="display:inline;margin-top: -5px;padding: 5px;">
				  <a onclick="myFunction1(this.id)" id="<?php echo $row_chat1['msgID']?>" href="javascript:void(0);" rel="<?php echo $row_chat1['msgID']?>" ><span class="glyphicon glyphicon-chevron-down dropbtn"></span></a>
				  <div id="myDropdown<?php echo $row_chat1['msgID']?>"  class="dropdown-content">
					<a href="javascript:void(0);" class="click_del_msg" rel="<?php echo $row_chat1['msgID']?>"> Delete</a>
				  </div>
				</div>
				
				<?php //checking who sends msg and then assigning to right and green if sender
					if($row_chat['userID']==$userid){ ?>
					 <small class=" text-muted label label-primary">
							<i class="icon-time"></i> <?php echo "" .humanTiming( $row_chat1['sentTime'] ). ""; ?></small>
						<strong class="pull-right primary-font" style="margin-right: 15px;"> <?php  echo $row_chat['name']?></strong>
				<?php	}else{ ?>
						<strong class="primary-font "> <?php  echo $row_chat['name']?> </strong>
						<small class="pull-right text-muted label label-danger">
							<i class="icon-time"></i> <?php echo "" . humanTiming( $row_chat1['sentTime'] ). ""; ?>
						</small>
						<?php } ?>
						
					</div>
					 <br>
					<p><?php  echo $row_chat1['message']?></p>
				</div>
			</li>
					<!--Seen Status-->
					<small class="grey1 hide_read<?php echo $row_chat1['msgID']?> 
						<?php if($row_chat['userID']==$userid){echo 'read_time_right';}else{echo 'read_time_left';} ?> hide_default">
						<?php if($row_read['readTime']!=0){ 
						echo "Seen " . humanTiming($row_read['readTime'] ). " ago ";} ?>
					</small>
					
		<?php } ?>
                
<?php             
function humanTiming ($time)
{
	$time = time() - $time; // to get the time since that moment
	$time = ($time<1)? 1 : $time;
	$tokens = array (
		31536000 => 'year',
		2592000 => 'month',
		604800 => 'week',
		86400 => 'day',
		3600 => 'hr',
		60 => 'min',
		1 => 'sec'
);
foreach ($tokens as $unit => $text) {
	if ($time < $unit) continue;
	$numberOfUnits = floor($time / $unit);
	return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
}
}

?>
                   