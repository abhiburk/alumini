<?php include '../config.php'; 

            $sql = "SELECT DISTINCT (chatWith),T.* FROM 
            (SELECT 
                s.msgID
                , m.message
                , (
                    SELECT userImg 
                    FROM users 
                    WHERE userID = CASE WHEN m.sentTo = '".$userid."' 
                    THEN m.sentBy 
                    ELSE m.sentTo END
                ) AS uImg
                , (
                    SELECT userID 
                    FROM users 
                    WHERE userID = CASE WHEN m.sentTo = '".$userid."' 
                    THEN m.sentBy 
                    ELSE m.sentTo END
                ) AS uID
                , (
                    SELECT CONCAT(firstName, ' ', lastName) 
                    FROM users 
                    WHERE userID = CASE WHEN m.sentTo = '".$userid."' 
                    THEN m.sentBy 
                    ELSE m.sentTo END 
                ) AS chatWith
                , m.sentTime
                , s.read
                , s.msgstatusID
                , m.sentBy
                , s.deleted
            FROM user_message_status s
            LEFT JOIN user_message m USING (msgID)
            WHERE (m.sentTo='".$userid."' AND deleted!=01 OR m.sentBy='".$userid."' AND deleted!=10 )
                    
            ORDER BY m.msgID DESC)AS T GROUP BY uID ORDER BY sentTime DESC";
            $sql_mymsgs=mysqli_query($dbconfig,$sql) or die(mysqli_error($dbconfig));
            $tmp_user = '';
            $count_mymsgs=mysqli_num_rows($sql_mymsgs);
			$count_mymsgs = isset($count_mymsgs) ? $count_mymsgs : '';
            if($count_mymsgs==''){echo '<li class="invite1"><small class="grey1">No Chats Availabe</small></li>';}else{
				
            while($row_mymsgs=mysqli_fetch_assoc($sql_mymsgs)){
            $chat_with = $row_mymsgs['chatWith'];
            if ($tmp_user != $chat_with){
			$chat_with = isset($chat_with) ? $chat_with : ''; 
				
				$sql_unread_msg=mysqli_query($dbconfig,"SELECT * FROM user_message AS m 
				LEFT JOIN user_message_status AS s USING (msgID) WHERE (sentTo='".$userid."' AND sentBy='".$row_mymsgs['sentBy']."') AND `read`='00'");
				$count_unread_msg=mysqli_num_rows($sql_unread_msg);	 
			?>
                 <a href="message/<?php echo $row_mymsgs['uID']; ?>">
                  <li class="subitem_grey <?php if($row_mymsgs['read']=='00' and $row_mymsgs['sentBy']!=$userid){echo 'unread';} ?>" style="padding:10px;">
                            <img src="<?php if($row_mymsgs['uImg']==''){echo 'images/default.jpg';}else {
                        	echo 'uploads/'.$row_mymsgs['uImg']; } ?>" alt="User Avatar" class="recent_chat">
                            
                            <small class="grey <?php if($row_mymsgs['read']=='00' and $row_mymsgs['sentBy']!=$userid){echo 'black_bold';} ?>" style="color:#000;margin-left: 5px;display: inline-block;position: absolute;padding:2px">
								<?php echo "<b>$chat_with </b>"; 
                                 $tmp_user= $chat_with; ?>
                                 <?php if($count_unread_msg!='0'){ echo "<b>(".$count_unread_msg.")</b>";} ?>
                                &nbsp;<span id="loading<?php echo $row_mymsgs['uID']; ?>"></span>
                            <br> 
                            	<?php $str=($row_mymsgs['message']); if(strlen($str)>=30){ echo substr($str,0,30).'...';}else{echo $str; }?>
                        	</small>
                   </li>
                  </a>
                  <small class="floatright" style="position: relative;margin-top: -2em;margin-right: 1em;">
                  	<a href="javascript:void(0);" class="delete_chat" rel="<?php echo $row_mymsgs['uID']; ?>"> Delete </a>
                  </small>
                  <small class="floatright" style="position: relative;margin-top: -2em;margin-right: 4em;">
                   	<?php echo "" . humanTiming( $row_mymsgs['sentTime'] ). "" ; ?> | &nbsp;
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

