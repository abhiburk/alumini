<?php include '../config.php';
$gid = ($_REQUEST['gid']);

				//checking for groups members to allow access to chat
				$sql_grp_mem=mysqli_query($dbconfig,"SELECT * FROM group_members AS m LEFT JOIN user_groups AS g ON g.userID=m.memberID
				WHERE m.groupID='".$gid."' AND memberID='".$userid."'") or die (mysqli_error($dbconfig));
				$check_if_member=mysqli_num_rows($sql_grp_mem);
				$check_if_member = isset($check_if_member) ? $check_if_member : '';
				while($row_member=mysqli_fetch_assoc($sql_grp_mem)){
				 
				 // fetching chats
                $sql_discuss=mysqli_query($dbconfig,"SELECT * FROM group_discussion AS d LEFT JOIN users USING (userID)
				WHERE (d.groupID='".$gid."' ) ");
				while($row_chat=mysqli_fetch_assoc($sql_discuss)){
						
				//checking if msg is deleted or not
				$sql_deleted=mysqli_query($dbconfig,"SELECT * FROM group_discussion_status WHERE disID='".$row_chat['disID']."'
				AND (deletedBy= '".$userid."' AND readBy='".$userid."') ");
				$check_deleted=mysqli_num_rows($sql_deleted);
				$check_deleted = isset($check_deleted) ? $check_deleted : '';
				if($check_deleted!=true){
						
				//checking status if msg read or not
				$sql_status=mysqli_query($dbconfig,"SELECT * FROM group_discussion_status 
				WHERE disID='".$row_chat['disID']."' AND readBy='".$userid."' ") or die (mysqli_error($dbconfig));
				$row_read_status=mysqli_fetch_assoc($sql_status);
				$check_status=mysqli_num_rows($sql_status);
				$check_status = isset($check_status) ? $check_status : '';
				if($check_status!=true){
					
					// inserting user who reads msg	
					$sql=mysqli_query($dbconfig,"INSERT INTO group_discussion_status (disID,readBy,readTime) VALUES 
					('".$row_chat['disID']."','".$userid."','".$time."' )");	
				}
                ?>	 
                   <li rel="<?php echo $row_chat['disID'] ?>" class="click_read <?php if($row_chat['userID']==$_SESSION['userid']){echo 'right mychat';}else{echo 'left userchat';} ?> clearfix">
                        <span class="chat-img pull-<?php if($row_chat['userID']==$_SESSION['userid']){echo 'right';}else{echo 'left';} ?>">
                            <img src="<?php if($row_chat['userImg']==''){echo 'images/default.jpg';}else {
                            echo 'uploads/'.$row_chat['userImg']; } ?>" alt="User Avatar" class="img-circle onlineImg">
                        </span>
                      <div class="chat-body clearfix">
                        <div class="header">
                            <div class="dropdown <?php if($row_chat['userID']==$_SESSION['userid']){echo 'floatleft';}else{echo 'floatright';} ?>" style="display:inline;margin-top: -5px;padding: 5px;">
                              <a onclick="myFunction1(this.id)" id="<?php echo $row_chat['disID']?>" href="javascript:void(0);" rel="<?php echo $row_chat['disID']?>" ><span class="glyphicon glyphicon-chevron-down dropbtn"></span></a>
                              <div id="myDropdown<?php echo $row_chat['disID']?>"  class="dropdown-content">
                                <a href="javascript:void(0);" class="click_del_grp_msg" rel="<?php echo $row_read_status['gdstatusID']?>"> Delete</a>
                              </div>
                            </div>
                        
                        	<?php //checking who sends msg and then assigning to right and green if sender
							if($row_chat['userID']==$userid){ ?>
                             	<small class=" text-muted label label-primary">
                                    <i class="icon-time"></i> <?php echo "" . humanTiming( $row_chat['sentTime'] ). ""; ?></small>
                                <strong class="pull-right primary-font" style="margin-right: 15px;"> <?php  echo $row_chat['firstName']?></strong>
                       	   <?php }else{ ?>
                                <strong class="primary-font "> <?php  echo $row_chat['firstName']?> </strong>
                                <small class="pull-right text-muted label label-danger">
                                    <i class="icon-time"></i> <?php echo "" . humanTiming( $row_chat['sentTime'] ). ""; ?>
                                </small>
                           <?php } ?>
                        </div><br>
                        <p><?php  echo $row_chat['message']?></p>
                      </div>
                    </li>	
                    		
							<?php 
							//checking for discussion status
							$sql_status=mysqli_query($dbconfig,"SELECT * FROM group_discussion_status AS s LEFT JOIN users AS u ON s.readBy=u.userID
							WHERE disID='".$row_chat['disID']."' and  readBy!='".$userid."' ") or die (mysqli_error($dbconfig));
							while($row_read=mysqli_fetch_assoc($sql_status)){
							?>
                    		<!--Seen Status-->
                    		<span class="grey1  hide_read<?php echo $row_chat['disID']; ?> 
							<?php if($row_chat['userID']==$userid){echo 'read_time_right';}else{echo 'read_time_left';} ?> hide_default">
								<?php if($row_chat['userID']==$userid){ ?>
                                <?php echo $row_read['firstName']; ?>
                                <?php echo "Seen " . humanTiming( $row_read['readTime'] ). " ago ";} ?>
                            </span>
                            <?php if($row_chat['userID']==$userid){ ?>
                            <br class="grey1 hide_default hide_read<?php echo $row_chat['disID']; ?>">
                  <?php }}}}} ?>
                  
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