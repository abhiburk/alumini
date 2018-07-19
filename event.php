<?php include 'config.php'; 
$eid = isset($_REQUEST['eventID']) ? htmlentities($_REQUEST['eventID']) : '';		
$invitation = isset($_REQUEST['invitation']) ? htmlentities($_REQUEST['invitation']) : '';
		
$sql_event=mysqli_query($dbconfig,"SELECT *,$name FROM user_events LEFT JOIN users USING (userID) 
WHERE eventID='".$eid."'") or die(mysqli_error($dbconfig));
$row_event=mysqli_fetch_assoc($sql_event);
$eventid = isset($row_event['eventID']) ? htmlentities($row_event['eventID']) : '';

if($eventid==''){
	include 'includes/error.php';	
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Event <?php include 'includes/title.php'; ?></title>
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

	<div class="col-md-4 grid_2">
    	<!--Event Image and Menu-->
        <div class="profile_container">
            <div class="cover_img_container text-center about">
             
                 <!--Edit Event Image -->
                 <form action="manipulates/update_profile_photo.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="xAction" value="update_event_photo" />
                    <input type="hidden" name="eid" value="<?php echo $eventid; ?>" />
                    <input type="hidden" name="postType" value="event.photo">
                    <input type="hidden" name="newsText" value="has updated <a href='event/<?php echo $row_event['eventID'] ?>'><?php echo $row_event['eventName'] ?></a> event profile photo" />
                    <input type="hidden" name="reference" value="event_id" />
                    <input type="hidden" name="referenceID" value="<?php echo $row_event['eventID'] ?>" />
                    
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <img class="profile-img fileupload-new" src="<?php if($row_event['eventImg']==''){echo 'images/group.jpg';}else {
                        echo 'uploads/'.$row_event['eventImg']; } ?>" alt="" />
                        
                        <?php if($row_event['userID']==$userid){  ?>
                        <div class="fileupload-preview fileupload-exists thumbnail profile-img" ></div>
                        <span class="btn btn-file btn btn-default btn-sm ">
                            <span class="fileupload-new "><i class="icon-pencil"></i> Edit Photo</span>
                            <span class="fileupload-exists">Change</span>
                            <input type="file" name="eventImg"/>
                        </span>
                        <a href="#" class=" fileupload-exists btn btn-default btn-sm" data-dismiss="fileupload" style="float: none">cancel</a>
                        <input type="submit" class="btn btn-default btn-sm fileupload-exists" value="Save">
                        <?php } ?>
                        
                    </div>
                </form>
            
                 <h3 style="font-size:21px"><a href="event/<?php echo $eventid; ?>"><?php echo $row_event['eventName']; ?></a> </h3>
                 <hr>
                 <div class="profile_menu">
                      <!--Event Status (Show to New Members)-->	
                      <?php  
					  $sql_check_if_req=mysqli_query($dbconfig,"SELECT * FROM event_status WHERE userID='".$userid."' AND eventID='".$eventid."'
					  AND status='Interested' ");
					  $row_status=mysqli_fetch_assoc($sql_check_if_req);
					  $check=mysqli_num_rows($sql_check_if_req);
					  $check = isset($check) ? htmlentities($check) : '';
					  //checking if attending or not 
					  if($check!=true){ ?>
                      <a href="javascript:void(0);" class="click_intrested_event" rel="<?php echo $eventid;?>">
                      <h3 class="invite"><div id="show_intrested"></div> <div id="hide_intrested"><i class="icon-star-empty"></i> Interested</div></h3></a> <?php }else{?>
                     
                      <a href="javascript:void(0);" class="click_cancel_intrested" rel="<?php echo  $row_status['estatusID'];?>">
                      <h3 class="invite"><div id="show_cancel_intrested"></div> <div id="hide_cancel_intrested"><i class="icon-star"></i> Interested</div></h3></a>
                      <?php } ?>
                     
                      <!--Event Status (Show to New Members)-->	
                      <?php 
					  $check_if_member = isset( $check_if_member) ? htmlentities( $check_if_member) : '';		
					  if($check_if_member!=true){  
					  $sql_check_if_req=mysqli_query($dbconfig,"SELECT * FROM event_status WHERE userID='".$userid."' AND eventID='".$eventid."'
					  AND status='Attending' ");
					  $row_status=mysqli_fetch_assoc($sql_check_if_req);
					  $check=mysqli_num_rows($sql_check_if_req);
					  $check = isset($check) ? htmlentities($check) : '';	
					  //checking if attending or not 
					  if($check!=true){ ?>
                      <a href="javascript:void(0);" class="click_attend_event" rel="<?php echo $eventid;?>">
                      <h3 class="invite"><div id="show_attend"></div> <div id="attend_event"> Attend</div></h3></a> <?php }else{ ?>
                     
                      <a href="javascript:void(0);" class="click_cancel_attending" rel="<?php echo $row_status['estatusID'];?>">
                      <h3 class="invite"><div id="show_cancel"></div> <div id="cancel_attend"><i class="icon-ok"></i> Attending</div></h3></a>
                      <?php }} ?>
                     
                      <?php if($invitation=='1'){ ?>
                      <a href="javascript:void(0);" class="click_decline_event" rel="<?php echo $eventid;?>">
                      <h3 class="invite"><div id="show_decline"></div> <div id="hide_decline"><i class="icon-remove"></i> Declined</div></h3></a>
                      <?php } ?>
                      <div class="dropdown">
                      <!--More Option-->	
                      	  <a onclick="myFunction()"  href="javascript:void(0);" ><h3 class="invite dropbtn"> <span class="glyphicon glyphicon-chevron-down dropbtn"></span> More</h3></a>
                          <div id="myDropdown" class="dropdown-content">
                            <a href="invite.php?view=event&eid=<?php echo $eventid; ?>">
                            <i class="icon-envelope"></i> Invite</a>
                            <a href="share.php?eid=<?php echo $eventid; ?>"><i class="icon-share-sign "></i> Share</a>
                            <?php if($row_event['userID']==$userid){ //checking owner of event ?>
                            <a href="event/editevent/<?php echo $eventid; ?>"><i class="icon-pencil"></i> Edit Event</a>
                            <a href="javascript:void(0);" class="delete_event" rel="<?php echo $eventid; ?>"><i class="icon-trash"></i> Delete Event</a>
							<?php } ?>
						  </div>
                      </div>
                 </div>
                 
           </div>
         </div><div class="div-title"></div> 
         
         		<?php if($row_event['userID']==$userid) { // showing event post form ?>
                  <div class="white-area"><h5>Event Timeline</h5></div>
                  <div class="hire-me">
                    <ul class="listing">
                      <form action="manipulates/manipulate.php" method="post" enctype="multipart/form-data">
                          <input type="hidden" name="xAction" value="post">
                          <input type="hidden" name="postType" value="event.post">
                          <input type="hidden" name="referenceID" value="<?php echo $eid; ?>">
                          <input type="hidden" name="reference" value="event_id">
                          <input type="hidden" name="newsText" value="added new post to <a href='event/<?php echo $eventid; ?>'><?php echo $row_event['eventName']; ?></a> group">
                         <li class="create_group"> 
                            <textarea name="postText" class="form-control" placeholder="Post to Event" style="height: 50px;"></textarea>
                         </li>
                         <li class="" style="display:inline-flex;">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                            <!--<div class="fileupload-preview fileupload-exists thumbnail profile-img" ></div>-->
                            <span class="btn btn-file  btn-primary btn-xs">
                                <span class="fileupload-new "><i class="icon-picture"></i> Photo</span>
                                <span class="fileupload-exists">Change</span>
                                <input type="file" name="postImg"/>
                            </span>
                            <span class="btn btn-file fileupload-exists  btn-primary btn-xs" data-dismiss="fileupload" style="float: none"> Cancel</span>
                            <input type="submit" class="btn btn-primary btn-xs btn  " value="Post">
                            <span class="fileupload-preview"></span>
                          </li> 
                        </form>
                      </ul> 
                  </div><div class="div-title"></div> 
              
           		<?php }   
				   // event posts 
				   $sql_post=mysqli_query($dbconfig,"SELECT * FROM posts LEFT JOIN users USING (userID)
				   WHERE referenceID='".$eventid."' AND postType='event.post' ORDER BY postID DESC");
				   $count_post=mysqli_num_rows($sql_post);
				   $count_post = isset($count_post) ? htmlentities($count_post) : '';
				   if($count_post==''){echo '
				   <div class="profile_container"><ul class="listing"><li class="invite1"><small class="grey1">No Post Availabe</small></li></ul></div>';}else{
				   while($row_event_post=mysqli_fetch_assoc($sql_post)){
				   ?>   
				   <div class="white-area"><h5>
				   <a href="event/<?php echo $eventid; ?>"> <?php echo $row_event['eventName']; ?></a>
				   </h5></div>
				   <div class="profile_container">
					 <div class="cover_img_container cute about">
						<?php if($row_event_post['postImg']!=''){ ?>
						<a href="post/<?php echo $row_event_post['postID']; ?>"><img src="<?php echo 'uploads/'.$row_event_post['postImg']; ?>"></a><?php } ?>
							<small class="post_photo_menu profile_menu"><?php echo $row_event_post['postText']; ?></small>
							<ul class="post_photo_menu profile_menu">
								<li>
									<?php //checking if like or not
									$sql_if_liked=mysqli_query($dbconfig,"SELECT * FROM user_likes WHERE likeTo='".$row_event_post['postID']."' 
									AND likeType='".$row_event_post['postType']."' AND userID='".$userid."' "); 
									$check_if_liked=mysqli_num_rows($sql_if_liked);
									$check_if_liked = isset($check_if_liked) ? htmlentities($check_if_liked) : '';?>
									<a><small class="grey1">
                                            <span id="default_count<?php echo $row_event_post['postID']; ?>"><?php  echo $row_event_post['like_counts']; ?></span>
                                            <span id="like_count<?php echo $row_event_post['postID']; ?>"></span>
                                        </small></a> 
									<?php if($check_if_liked==true){ ?>	
                                    	<!--if already liked-->
										<a href="javascript:void(0);" id="<?php echo $row_event_post['postID']; ?>" class="click_unlike"  data-likeType="<?php echo $row_event_post['postType']; ?>" style="color: #2093F5;font-weight: 600;"> 
										<i class="icon-thumbs-up-alt"></i> Liked </a>
										<?php }else { ?>
										<!--if not liked-->
										<a href="javascript:void(0);" id="<?php echo $row_event_post['postID']; ?>" class="black_bold click_like"  data-likeType="<?php echo $row_event_post['postType']; ?>"> 
										<i class="icon-thumbs-up-alt"></i> Like </a>
									<?php } ?>
								</li> &nbsp;|
								<li><a href="post/<?php echo $row_event_post['postID']; ?>">Comment </a></li> &nbsp;|&nbsp;
								<li><small class="grey1"> <?php  echo "" . humanTiming( $row_event_post['postTime'] ). "";  ?></small></li>
							</ul>
					   </div>
					 </div>
					 <div class="div-title"></div> 
               
         		<?php }} ?>
          
                 
	</div><!--end col-md-4 grid_2-->
       
	<div class="col-md-3 grid_2">
				
                <?php 
				//counting event Attending people 	  
			    $sql_group=mysqli_query($dbconfig,"(SELECT *,$name FROM event_status AS s 
                LEFT JOIN users AS u ON s.userID=u.userID WHERE eventID='".$eventid."' AND status='Attending' ORDER BY eventID DESC)");
			    $count_attending=mysqli_num_rows($sql_group);
				$count_attending = isset($count_attending) ? htmlentities($count_attending) : '';
				?>
                <div class="white-area"><h5>Event Details</h5></div>
                <div class="profile_container <?php if($count_attending>3) {echo 'scroll1';}else{echo 'auto-height';} ?>">
            		<ul class="cute">
					  <li><small class="grey">Event Creator: <b><?php echo $row_event['name']; ?></b></small></li>  
                      <li><small class="grey">Scheduled: <b><?php echo date('d-M-Y',strtotime($row_event['eventDate'])); ?>, <?php echo date('H:i a',strtotime($row_event['eventTime'])); ?></b></small></li>
                      <li><small class="grey">Event Location: <b><?php echo $row_event['eventLocation']; ?></b></small> </li>
                      <li><p><small class="grey"><?php echo $row_event['eventDetails']; ?></small></p></li>
                    </ul>
                </div>
                <div class="div-title"></div>
                
				
                <div class="white-area"><h5>Attending (<?php echo $count_attending; ?>)</h5></div>
                <div class="profile_container <?php if($count_attending>3) {echo 'scroll1';}else{echo 'auto-height';} ?>">
            		<ul class="listing">
					  <?php 
					  if($count_attending==''){echo '<li class="invite1"><small class="grey1">No People Attending</small></li>';}else{
					  while($row_event=mysqli_fetch_assoc($sql_group)){
                      ?>
                      <li class="" style="padding:5px; border-bottom:1px solid #f0f0f0; "> 
                      	<a href="<?php if($row_event['webName']==''){echo 'user/'.$row_event["userID"].'';}else{ echo 'user/'.$row_event["webName"].'';}  ?>">
                            <img src="<?php if($row_event['userImg']==''){echo 'images/default.jpg';}else {
                            echo 'uploads/'.$row_event['userImg']; } ?>" alt="User Avatar" class="recent_chat">
                          	<small class="" style="margin-left: 5px;"> 
								<?php echo $row_event['name']; ?>
                          	</small>
                         </a>   
                      </li>
                      <?php }} ?> 
                    </ul>
                </div><div class="div-title"></div>
				
                <?php 
				//counting event interested people   
			    $sql_group=mysqli_query($dbconfig,"(SELECT *,$name FROM event_status AS s 
                LEFT JOIN users AS u ON s.userID=u.userID WHERE eventID='".$eventid."' AND status='Interested' ORDER BY eventID DESC) ");
			    $count_interested=mysqli_num_rows($sql_group);
				$count_interested = isset($count_interested) ? htmlentities($count_interested) : '';
				?>
                <div class="white-area"><h5>Interested (<?php echo $count_interested; ?>)</h5></div>
                <div class="profile_container <?php if($count_interested>3) {echo 'scroll1';}else{echo 'auto-height';} ?>">
            		<ul class="listing">
					  <?php 
					  if($count_attending==''){echo '<li class="invite1"><small class="grey1">No People Interested</small></li>';}else{
					  while($row_event=mysqli_fetch_assoc($sql_group)){
                      ?>
                      <li class="" style="padding:5px; border-bottom:1px solid #f0f0f0; "> 
                      	<a href="<?php if($row_event['webName']==''){echo 'user/'.$row_event["userID"].'';}else{ echo 'user/'.$row_event["webName"].'';}  ?>">
                            <img src="<?php if($row_event['userImg']==''){echo 'images/default.jpg';}else {
                            echo 'uploads/'.$row_event['userImg']; } ?>" alt="User Avatar" class="recent_chat">
                          	<small class="" style="margin-left: 5px;"> 
								<?php echo $row_event['name']; ?>
                          	</small>
                         </a>   
                      </li>
                      <?php }} ?> 
                    </ul>
                </div><div class="div-title"></div>
                
        
	</div><!--end col-md-3 grid_2-->
    

<?php include 'includes/right_panel.php'; ?>
<!--Container Ends Here-->
<div class="clearfix"></div>
</div>
<script src="assets/js/myscript.js"></script>
<script src="assets/my-js/event.js"></script>
<script src="assets/my-js/post.js"></script>
</div>
</body>
</html>