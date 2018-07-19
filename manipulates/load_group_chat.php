<?php include '../config.php';

                $sql_recent_chat=mysqli_query($dbconfig,"
                SELECT 
                groupImg,message,groupName,sentTime,fname,disID ,userID,groupID
                FROM (SELECT groupImg,d.message,g.groupName,d.sentTime,d.userID,d.disID,d.groupID,
                (
                SELECT firstname 
                FROM users 
                WHERE userID=d.userID 
                ) AS fname
                FROM group_discussion AS d LEFT JOIN user_groups AS g USING (groupID)
                LEFT JOIN group_members AS m USING (groupID) LEFT JOIN group_discussion_status USING (disID) 
                WHERE m.memberID='".$userid."'  ORDER BY disID DESC ) AS x GROUP BY groupID ORDER BY sentTime DESC  ") or die (mysqli_error($dbconfig));
                $count_grpchats=mysqli_num_rows($sql_recent_chat);
				$count_grpchats = isset($count_grpchats) ? $count_grpchats : '';
                if($count_grpchats==''){echo '<li class="invite1"><small class="grey1">No Group Chats Availabe</small></li>';}else{
                while($row_recent_chat=mysqli_fetch_assoc($sql_recent_chat)){
                        //checking if msg is read or not
                       $sql_unread_grp=mysqli_query($dbconfig,"SELECT readBy,disID,groupID,userID FROM group_discussion_status LEFT JOIN group_discussion USING (disID)
                       WHERE disID='".$row_recent_chat['disID']."'  AND readBy='".$userid."' 
                       AND groupID='".$row_recent_chat['groupID']."'   ")or die (mysqli_error($dbconfig));
                       $count_unread_grp=mysqli_num_rows($sql_unread_grp); 
					   $count_unread_grp = isset($count_unread_grp) ? $count_unread_grp : '';
                             //checking if group chat deleted 		   
                             $sql_deleted=mysqli_query($dbconfig,"SELECT deletedBy,disID FROM group_discussion LEFT JOIN group_discussion_status USING (disID)   
                             WHERE deletedBy='".$userid."' AND disID='".$row_recent_chat['disID']."' ")or die (mysqli_error($dbconfig));
                             $check_if_deleted=mysqli_num_rows($sql_deleted);
							 $check_if_deleted = isset($check_if_deleted) ? $check_if_deleted : '';
                             if($check_if_deleted==true){echo '<li class="invite1"><small class="grey1">No Group Chats Availabe</small></li>';}else{
								 //counting no of messages
								 $sql_grp=mysqli_query($dbconfig,"SELECT * FROM group_members AS m RIGHT JOIN group_discussion AS d USING (groupID)
								WHERE NOT EXISTS (SELECT * FROM group_discussion_status WHERE readBy='".$userid."' AND disID=d.disID ) 
								AND memberID='".$userid."' AND d.groupID='".$row_recent_chat['groupID']."'");
								$count_grp_unread=mysqli_num_rows($sql_grp);
                ?>
                       
                <a href="discussion/<?php echo $row_recent_chat['groupID']; ?>">
                  <li class="subitem_grey <?php if($count_unread_grp!=true and $row_recent_chat['userID']!=$userid){echo 'unread';} ?>" style="padding:8px; "> 
                        <img src="<?php if($row_recent_chat['groupImg']==''){echo 'images/default.jpg';}else {
                        echo 'uploads/'.$row_recent_chat['groupImg']; } ?>" alt="User Avatar" class="recent_chat">
                       
                        <small class="<?php if($count_unread_grp!=true and $row_recent_chat['userID']!=$userid){echo 'black_bold';} ?>" style=" color:#000;margin-left: 5px;display: inline-block;position: absolute;padding:2px"> 
                          <?php echo $row_recent_chat['groupName']; ?> </b>
                          <?php if($count_grp_unread!='0'){ echo "<b>(".$count_grp_unread.")</b>";} ?>
                          <span id="loading<?php echo $row_recent_chat['groupID']; ?>"></span>   
                          <br> 
                          <?php if($row_recent_chat['userID']==$userid){echo 'You';}else{ echo $row_recent_chat['fname'];} ?> :
                          <?php $str=($row_recent_chat['message']); if(strlen($str)>=10){ echo substr($str,0,13).'...';}else{echo $str; }?></b>
                        </small>
                     </li>
                </a> 
                      <small class="floatright" style="position: relative;margin-top: -2em;margin-right: 0.5em;">
                          <a href="javascript:void(0);" class="delete_group_chat" rel="<?php echo $row_recent_chat['groupID']; ?>"> Delete </a>
                      </small>
                      <small class="floatright" style="position: relative;margin-top: -2em;margin-right: 4em;">
                          <?php  echo "" . humanTiming( $row_recent_chat['sentTime'] ). "" ; ?> |
                      </small>
                 <?php }}} ?>
                 
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