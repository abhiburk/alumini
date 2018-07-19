<?php 
include '../config.php'; 
?>

<?php 
// counting personal msgs
$sql_unread_msg=mysqli_query($dbconfig,"SELECT * FROM user_message AS m 
LEFT JOIN user_message_status AS s USING (msgID) WHERE (sentTo='".$userid."') AND `read`='00' GROUP BY sentBy");
$count_unread_msg=mysqli_num_rows($sql_unread_msg);

$sql_grp=mysqli_query($dbconfig,"SELECT * FROM group_members AS m RIGHT JOIN group_discussion AS d USING (groupID)
WHERE NOT EXISTS (SELECT * FROM group_discussion_status WHERE readBy='".$userid."' AND disID=d.disID ) 
AND memberID='".$userid."' GROUP BY groupID");
$count_grp_unread=mysqli_num_rows($sql_grp);
//echo $count_grp_unread;
$total=$count_grp_unread + $count_unread_msg;
echo $total;
?>