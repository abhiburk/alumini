<?php include 'config.php'; 
$gid = isset($_REQUEST['groupID']) ? htmlentities($_REQUEST['groupID']) : '';

$sql_group=mysqli_query($dbconfig,"SELECT * FROM user_groups 
WHERE groupID='".$gid."' ") or die(mysqli_error($dbconfig));
$row_group=mysqli_fetch_assoc($sql_group);
$reqgroupID = isset($row_group['groupID']) ? htmlentities($row_group['groupID']) : '';


//checking for groups members to allow access
$sql_grp_mem=mysqli_query($dbconfig,"SELECT * FROM group_members AS m LEFT JOIN user_groups AS g ON g.userID=m.memberID
WHERE m.groupID='".$reqgroupID."' AND memberID='".$userid."'") or die (mysqli_error($dbconfig));
$check_if_member=mysqli_num_rows($sql_grp_mem);
$check_if_member = isset($check_if_member) ? htmlentities($check_if_member) : '';
$row_member=mysqli_fetch_assoc($sql_grp_mem);

if($reqgroupID=='' or $check_if_member==''){
	include 'includes/error.php';	
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Discussion <?php include 'includes/title.php'; ?></title>
<?php include 'includes/base.php'; ?>
<script src="assets/js/myscript.js"></script>
<link href="assets/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom Theme files -->
<link href="assets/css/style.css" rel="stylesheet" type="text/css" media="all" />
<!-- Custom Theme files -->
<?php include 'includes/stylesheets.php'; ?>
</head>
<body>    
<?php include 'includes/header.php'; ?>
<div class="container">
	<div class="total-info">
	<?php include 'includes/left_panel.php'; ?>

    <div class="col-md-5 grid_2">

        <div class="white-area"><h5><?php echo $row_group['groupName']; ?></h5></div>
        <div class="chat-panel panel panel-success">
        	<!--Messages-->	
            <div class="panel-body scroll_msgs">
                <ul class="chat">
                
                <div id="group_msg"></div>
                

      
			   <script>
					$(document).ready(function(){
						//initially loading chats
						$("#group_msg").html('<center><img src="images/spinner.gif" style="width: 50px;"></center>');
						$.ajax({
							type: "POST",
							url: "manipulates/load_group_msg.php?gid=<?php echo $reqgroupID; ?>",
							success: function (response) {
								document.getElementById("group_msg").innerHTML=response; 
								$('.scroll_msgs').scrollTop($('.scroll_msgs')[0].scrollHeight);
							}
							});
							
						setInterval(function(){// wait for 5 secs(2)
						$.ajax({
							type: "POST",
							url: "manipulates/load_group_msg.php?gid=<?php echo $reqgroupID; ?>",
							success: function (response) {
								document.getElementById("group_msg").innerHTML=response; 
								$('.scroll_msgs').scrollTop($('.scroll_msgs')[0].scrollHeight);
							}
							});
						}, 10000);	
					});
                </script> 
                  
                </ul>
            </div>
			
            <!--Message Send Box-->				
            <div class="panel-footer">
                <form action="POST" enctype="multipart/form-data">
                <input type="hidden" name="xAction" value="send_discussion_msg">
                <input type="hidden" name="gid" value="<?php echo $reqgroupID; ?>">
                    <div class="input-group" >
                    <textarea name="message" id="textBox" class="form-control input-sm" placeholder="Your Message" style="height: 30px;"></textarea>
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default btn-sm click_discussion" value="Send" style="margin-top:5px;" required>
                        <i class="glyphicon glyphicon-send"></i> &nbsp; </button> 
                   </span>
                </div>
                </form>   
            </div>
            
        </div>
        
    </div><!--end col-md-5 grid_2-->
    
    
    
    <div class="col-md-2 grid_2">
        <div class="white-area"><h5>Active people of this group</h5></div>
            <div class="profile_container ">
                <ul class="listing">
                <?php 
                $sql_recent_chat=mysqli_query($dbconfig,"SELECT *,$name FROM group_members AS m LEFT JOIN users AS u ON m.memberID=u.userID 
                RIGHT JOIN user_session AS s ON s.userID=m.memberID WHERE m.groupID='".$reqgroupID."' AND memberID!='".$userid."' ") or die (mysqli_error($dbconfig));
                $count_active=mysqli_num_rows($sql_recent_chat);
				$count_active = isset($count_active) ? $count_active : '';
                if($count_active==''){echo '<li class="invite1"><small class="grey1">No Active People Availabe</small></li>';}else{
                while($row_recent_chat=mysqli_fetch_assoc($sql_recent_chat)){
                ?>
                <a href="<?php if($row_recent_chat['webName']==''){echo 'user/'.$row_recent_chat["userID"].'';}else{ echo 'user/'.$row_recent_chat["webName"].'';}  ?>">
                  <li class="subitem_grey" style="padding:5px; "> 
                        <img src="<?php if($row_recent_chat['userImg']==''){echo 'images/default.jpg';}else {
                        echo 'uploads/'.$row_recent_chat['userImg']; } ?>" alt="User Avatar" class="recent_chat">
                      <small class="" style="margin-left: 5px;"> 
                        <?php echo $row_recent_chat['name']; ?>
                      </small>
                      <small class="" style="float:right; margin-top:8px;">
                       <?php 
                       //for online and last active
                        $sql_session=mysqli_query($dbconfig,"SELECT * FROM user_session WHERE userID='".$row_recent_chat['userID']."'");
                        $check_active=mysqli_num_rows($sql_session);
						$check_active = isset($check_active) ? $check_active : '';
                        $sql_active=mysqli_query($dbconfig,"SELECT * FROM user_active WHERE userID='".$row_recent_chat['userID']."' ");
                        $row_active=mysqli_fetch_assoc($sql_active);
                       if($check_active==true){echo '<small class="btn btn-success btn-xs btn-circle"></small>';}
					   else {
					     echo "" . humanTiming( $row_active['activeTime'] ). ""; 
					   }?>
                      </small>
                  </li>
                  </a>  
                  <?php }} ?>
                 </ul> 
            </div>
        
    </div><!--end col-md-2 grid_2 -->
<!-- Will try to play bing.mp3 or bing.ogg (depends on browser compatibility) -->
<!-- <button onclick="playSound('assets/audio/all-eyes-on-me');">Play</button>  
<div id="sound"></div>-->    
<?php include 'includes/right_panel.php'; ?>
<script>
$('.scroll_msgs').scrollTop($('.scroll_msgs')[0].scrollHeight);
</script> 
<script>
$(".hide_default").hide();
$(document).on("hover", ".click_read", function (e) {
var disID= $(this).attr('rel');	
$(".hide_read"+disID).slideToggle(200);
});
</script>
<!--Container Ends Here-->
<div class="clearfix"></div>
</div>
<script src="assets/js/myscript.js"></script>
<script src="assets/my-js/group_chat.js"></script>
</div>
</body>
</html>