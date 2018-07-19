<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Friends <?php include 'includes/title.php'; ?></title>
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
    
    <div class="col-md-4 grid_2">
    		<!--Friends-->
        	<?php 	//friends
				$sql_newest_mem1=mysqli_query($dbconfig,"SELECT *,CONCAT(firstName,' ',lastName) AS name FROM my_friends LEFT JOIN users ON my_friends.userID=users.userID
				WHERE my_friends.friendWith='".$userid."' UNION SELECT *,CONCAT(firstName,' ',lastName) AS name FROM my_friends LEFT JOIN users ON my_friends.friendWith=users.userID
				WHERE my_friends.userID='".$userid."'");
				$count_frnds=mysqli_num_rows($sql_newest_mem1);
				$count_frnds = isset($count_frnds) ? $count_frnds : '';
			?>  
				<div class="white-area"><h5>Friends (<?php echo $count_frnds; ?>)</h5></div>
				<div class="profile_container <?php if($count_frnds>10) {echo 'scroll';} ?> ">
					<ul class="listing">
						<?php 
						if($count_frnds=='')
						{echo '<small class="grey" style="padding:5px;">No Friends Yet</small>';}else{
						while($row_friends=mysqli_fetch_assoc($sql_newest_mem1)){
						?>
						<a href="<?php if($row_friends['webName']==''){echo 'user/'.$row_friends["userID"].'';}else{ echo 'user/'.$row_friends["webName"].'';}  ?>">
						<li class="subitem_grey" style="padding:5px; "> 
							<img src="<?php if($row_friends['userImg']==''){echo 'images/default.jpg';}else {
							echo 'uploads/'.$row_friends['userImg']; } ?>" alt="User Avatar" class="recent_chat">
							<small class="" style="margin-left: 5px;"> 
								<?php echo $row_friends['name']; ?>
							</small>
						</li>
						</a>
						<?php }} ?>
					 </ul> 
				  </div>
              
        
    </div><!--end col-md-4-->
    
    <div class="col-md-3 grid_2">
    		<!--Friend Request-->
            <?php 
		    	  //fetching info whome req recieved
				  $sql_req=mysqli_query($dbconfig,"SELECT * FROM friend_request LEFT JOIN users ON friend_request.friendWith=users.userID
				  WHERE friend_request.friendWith='".$_SESSION['userid']."'") or die(mysqli_error($dbconfig));
				
				  //check of request available
				  $check_req=mysqli_num_rows($sql_req);
				  $check_req = isset($check_req) ? $check_req : '';
				  if($check_req!=''){
		    ?> 
    	   <div class="white-area"><h5>Friend Request (<?php echo $check_req; ?>)</h5></div>
           	 <div class="profile_container">
            	<ul class="cute">
                  <?php
				  while($row_frnd=mysqli_fetch_assoc($sql_req)){
					  //fetching info whose req recieved
					  $sql_req_accept=mysqli_query($dbconfig,"SELECT *,$name FROM friend_request LEFT JOIN users ON friend_request.userID=users.userID
					  WHERE friendreqID='".$row_frnd['friendreqID']."'") or die(mysqli_error($dbconfig));
					  ($row_frnd_accept=mysqli_fetch_assoc($sql_req_accept));
				  ?>
                  <li><img src="<?php if($row_frnd_accept['userImg']==''){echo 'images/default.jpg';}else {
                        echo 'uploads/'.$row_frnd_accept['userImg']; } ?>" alt="User Avatar" class="recent_chat">
                      <a href="<?php if($row_frnd_accept['webName']==''){echo 'user/'.$row_frnd_accept["userID"].'';}else{ echo 'user/'.$row_frnd_accept["webName"].'';}  ?>">
                        <small class="" style="margin-left: 5px;"> 
                            <?php echo $row_frnd_accept['name']; ?>
                        </small>
                     </a>   
                    <small id="right_btn">
                        <!--Accept Frnd Request-->	
                      	<a href="javascript:void(0);" class="click_accept_friend invite2" rel="<?php echo $row_frnd_accept['friendreqID'];?>">
                      	<span id="req_accept<?php echo $row_frnd_accept['friendreqID'];?>"></span> <span id="accept_frnd<?php echo $row_frnd_accept['friendreqID'];?>">Accept Request</span></a> 
                      	<!--Delete Request-->   
                      	<a href="javascript:void(0);" class="click_delete_friend invite2" rel="<?php echo $row_frnd_accept['friendreqID'];?>">
                      	<span id="req_delete<?php echo $row_frnd_accept['friendreqID'];?>"></span><span id="delete_frnd<?php echo $row_frnd_accept['friendreqID'];?>">Cancel</span></a>  
                    </small>
                    <hr>
                  </li>
                  <?php } ?>
                </ul>
            </div><div class="div-title"></div> 
			<?php } ?>
            
            <!--Friend Request Sent-->
            <?php 
		    	  //fetching info whome req recieved
				  $sql_req=mysqli_query($dbconfig,"SELECT * FROM friend_request LEFT JOIN users ON friend_request.friendWith=users.userID
				  WHERE friend_request.userID='".$userid."'") or die(mysqli_error($dbconfig));
				
				  //check of request available
				  $check_req=mysqli_num_rows($sql_req);
				  $check_req = isset($check_req) ? $check_req : '';
				  if($check_req!=''){
		    ?> 
    	   <div class="white-area"><h5>Sent Friend Request (<?php echo $check_req; ?>)</h5></div>
           	 <div class="profile_container">
            	<ul class="cute">
                  <?php
				  while($row_frnd=mysqli_fetch_assoc($sql_req)){
					  //fetching info whose req recieved
					  $sql_req_accept=mysqli_query($dbconfig,"SELECT *,$name FROM friend_request LEFT JOIN users ON friend_request.friendWith=users.userID
					  WHERE friendreqID='".$row_frnd['friendreqID']."'") or die(mysqli_error($dbconfig));
					  ($row_frnd_accept=mysqli_fetch_assoc($sql_req_accept));
				  ?>
                  <li><img src="<?php if($row_frnd_accept['userImg']==''){echo 'images/default.jpg';}else {
                        echo 'uploads/'.$row_frnd_accept['userImg']; } ?>" alt="User Avatar" class="recent_chat">
                      <a href="<?php if($row_frnd_accept['webName']==''){echo 'user/'.$row_frnd_accept["userID"].'';}else{ echo 'user/'.$row_frnd_accept["webName"].'';}  ?>">
                        <small class="" style="margin-left: 5px;"> 
                            <?php echo $row_frnd_accept['name']; ?>
                        </small>
                     </a>   
                    <small id="right_btn">
                      	<!--Delete Request-->   
                      	<a href="javascript:void(0);" class="click_cancel_friend invite2" rel="<?php echo $row_frnd_accept['friendreqID'];?>">
                      	<span id="req_sent_cancel<?php echo $row_frnd_accept['friendreqID'];?>"></span><span id="cancel_frnd<?php echo $row_frnd_accept['friendreqID'];?>">Cancel</span></a>  
                    </small>
                    <hr>
                  </li>
                  <?php } ?>
                </ul>
            </div><div class="div-title"></div> <?php } ?>
        
    </div><!--end col-md-3-->
    
    

    <?php include 'includes/right_panel.php'; ?>
<!--Container Ends Here-->
<div class="clearfix"></div>
</div>
<script src="assets/js/myscript.js"></script>
<script src="assets/my-js/friend_request.js"></script>
</div>
</body>
</html>