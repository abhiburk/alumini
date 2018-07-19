<?php include 'config.php'; 
$mid = isset($_REQUEST['mid']) ? htmlentities($_REQUEST['mid']) : '';
$uid = isset($_REQUEST['uid']) ? htmlentities($_REQUEST['uid']) : '';
$msid = isset($_REQUEST['msid']) ? htmlentities($_REQUEST['msid']) : '';
$webname = isset($_REQUEST['webName']) ? htmlentities($_REQUEST['webName']) : '';

$sql_req_user=mysqli_query($dbconfig,"SELECT * FROM users_edu RIGHT JOIN users ON users_edu.userID=users.userID
WHERE users.userID='".$uid."' or webName='".$webname."'") or die(mysqli_error($dbconfig));
$req_user=mysqli_fetch_assoc($sql_req_user);
$reqid=$req_user['userID'];
if($reqid==''){
	include 'includes/error.php';	
	}
//for online and last active
$sql_session=mysqli_query($dbconfig,"SELECT * FROM user_session WHERE userID='".$reqid."'");
$check_active=mysqli_num_rows($sql_session);
$check_active = isset($check_active) ? htmlentities($check_active) : '';
$sql_active=mysqli_query($dbconfig,"SELECT * FROM user_active WHERE userID='".$reqid."' ");
$row_active=mysqli_fetch_assoc($sql_active);
?>
<!DOCTYPE html>
<html>
<head>
<title>Message <?php include 'includes/title.php'; ?></title>
<?php include 'includes/base.php'; ?>

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
			<!--Message Tab-->
            <div class="white-area"><h5><?php echo $req_user['firstName']; ?> <?php echo $req_user['lastName']; ?>
            <?php if($check_active==true){echo '<small class="btn btn-success btn-xs btn-circle"></small>';}
                  else {
                  echo "" . humanTiming( $row_active['activeTime'] ). ""; }?>  </h5>
            </div>
        
        <div class="chat-panel panel panel-success">
            <div class="panel-body scroll_msgs" >
                <ul class="chat">
                
                <div id="msg_chat"></div>
                
			   <script>
					$(document).ready(function(){
						//initially loading chats
						$("#msg_chat").html('<center><img src="images/spinner.gif" style="width: 50px;"></center>');
						$.ajax({
							type: "POST",
							url: "manipulates/load_msg.php?sentTo=<?php echo $reqid; ?>",
							success: function (response) {
								document.getElementById("msg_chat").innerHTML=response; 
								$('.scroll_msgs').scrollTop($('.scroll_msgs')[0].scrollHeight);
							}
							});
							
						setInterval(function(){// wait for 5 secs(2)
						$.ajax({
							type: "POST",
							url: "manipulates/load_msg.php?sentTo=<?php echo $reqid; ?>",
							success: function (response) {
								document.getElementById("msg_chat").innerHTML=response; 
								$('.scroll_msgs').scrollTop($('.scroll_msgs')[0].scrollHeight);
							}
							});
						}, 10000);	
					});
                </script>
                
                </ul>
            </div>
				
             
            <!--Message Box-->   			
            <div class="panel-footer">
            <form action="POST" enctype="multipart/form-data">
            <input type="hidden" name="xAction" value="send_msg">
            <input type="hidden" name="sentTo" value="<?php echo $reqid ?>">
                <div class="input-group" >
                    <textarea name="message" id="textBox" class="form-control input-sm" placeholder="Your Message" style="height: 30px;"></textarea>
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default btn-sm click_send_msg" value="Send" style="margin-top:5px;" required>
                        <i class="glyphicon glyphicon-send"></i> &nbsp; </button> 
                   </span>
                </div>
            </form>   
            </div>
            
        </div>
        
    </div><!--end col-md-5 grid_2-->
    
    
    
    <div class="col-md-2 grid_2">
        <!--Recent Chats-->
        <div class="white-area"><h5>Recent Chats</h5></div>
     	<div class="profile_container ">
        <ul class="listing">
            <?php 
			$sql_recent_chat=mysqli_query($dbconfig,"SELECT DISTINCT $name,userID,userImg FROM (SELECT * FROM user_message AS m 
			LEFT JOIN users AS u ON m.sentTo=u.userID WHERE sentBy='".$userid."' ORDER BY msgID DESC LIMIT 5) AS F ");
			while($row_recent_chat=mysqli_fetch_assoc($sql_recent_chat)){
			?>
            <a href="message/<?php echo $row_recent_chat['userID']; ?>">
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
					$check_active = isset($check_active) ? htmlentities($check_active) : '';
					$sql_active=mysqli_query($dbconfig,"SELECT * FROM user_active WHERE userID='".$row_recent_chat['userID']."' ");
					$row_active=mysqli_fetch_assoc($sql_active);
				    if($check_active==true){echo '<small class="btn btn-success btn-xs btn-circle"></small>';}
			  	    else {
		 	  	    echo "" . humanTiming( $row_active['activeTime'] ). ""; }?>
                  </small>
               </li>
          	 </a>  
              <?php } ?>
           </ul> 
        </div>
        
    </div><!--end col-md-5 grid_2-->
    
    
    
<script>
	<!--Scroll to bottom-->
  $('.scroll_msgs').scrollTop($('.scroll_msgs')[0].scrollHeight);
	
	<!--Msg Read Hover-->
	$(".hide_default").hide();
	$(document).on("hover", ".click_read", function (e) {
	var msgID= $(this).attr('rel');	
	$(".hide_read"+msgID).slideToggle(200);
	});
</script>
    <?php include 'includes/right_panel.php'; ?>
<!--Container Ends Here-->
<div class="clearfix"></div>
</div>
<script src="assets/js/myscript.js"></script>
<script src="assets/my-js/message.js"></script>

</div>
</body>
</html>