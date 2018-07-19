<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Notification <?php include 'includes/title.php'; ?></title>
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
    				<?php 
                    $sql_noti_to=mysqli_query($dbconfig,"SELECT * FROM notifications AS n LEFT JOIN users AS u ON n.notiTo=u.userID
                    WHERE u.userID='".$_SESSION['userid']."' ORDER BY notificationID DESC") or die(mysqli_error($dbconfig));
                    //checking if notification is 0 or not
                    $count_notification=mysqli_num_rows($sql_noti_to); 
					$count_notification = isset($count_notification) ? $count_notification : '';?> 
                    <!--Notifications Count-->
                    <div class="white-area"><h5>Notifications</h5></div>
                    <div class="profile_container">
                        <ul class="listing <?php if($count_notification>10){echo 'scroll'; }?>">
					<?php 
                    if($count_notification==''){echo '<ul class="cute"><li class="grey">0 Notification</li></ul>';}else {
                    while($row_noti_to=mysqli_fetch_assoc($sql_noti_to)){

					$sql_noti_by=mysqli_query($dbconfig,"SELECT * FROM notifications AS n LEFT JOIN users AS u ON n.notiBy=u.userID
					WHERE u.userID='".$row_noti_to['notiBy']."' AND notificationID='".$row_noti_to['notificationID']."' ") or die(mysqli_error($dbconfig));
					$row_noti_by=mysqli_fetch_assoc($sql_noti_by);
					?>
					<a href="viewnoti.php?notiid=<?php echo $row_noti_to['notificationID'];?>&type=<?php echo $row_noti_to['type'];?>&uid=<?php echo $row_noti_by['userID']; ?>&refid=<?php echo $row_noti_by['referenceID']; ?>">
					  <li class="subitem_grey <?php if($row_noti_to['read']=='0'){echo 'unread';}?>">
                            	<img src="<?php if($row_noti_by['userImg']==''){echo 'images/default.jpg';}else {
                      			echo 'uploads/'.$row_noti_by['userImg']; } ?>" alt="User Avatar" class="recent_chat" style="margin-top: -15px;"> &nbsp;
							<small class="inline_b" style="width: 75%;">
								<?php
								if($row_noti_to['type']=='grequest.approve'){ echo $row_group['groupName'];}else{ ?>
								<b><?php echo $row_noti_by['firstName']; ?> <?php echo $row_noti_by['lastName']; } ?> </b>
								<?php echo $row_noti_by['notiText']; ?> 
							</small>
							<small id="right_btn" style="color:#000;"><?php echo "" . humanTiming( $row_noti_to['notiTime'] ). " ago"; ?></small>
					  </li>
                     </a>
            		 <?php }} ?>
             </ul> 
        </div>
        
    </div><!--end col-md-5 grid_2-->
    
    <div class="col-md-2 grid_2">
        <div class="white-area"><h5>Notifications</h5></div>
        <div class="hire-me">
            <ul class="cute">
              <li class=""> 
                <small class="grey"></small>
              </li>
             </ul> 
        </div>
    </div>
    
    <?php include 'includes/right_panel.php'; ?>

<!--Container Ends Here-->
<div class="clearfix"></div>
</div>
<script src="assets/js/myscript.js"></script>
</div>
</body>
</html>