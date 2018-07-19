<?php include 'config.php'; 

$notiid = isset($_REQUEST['notiid']) ? htmlentities($_REQUEST['notiid']) : '';
$type = isset($_REQUEST['type']) ? htmlentities($_REQUEST['type']) : '';
$gid = isset($_REQUEST['gid']) ? htmlentities($_REQUEST['gid']) : '';
$uid = isset($_REQUEST['uid']) ? htmlentities($_REQUEST['uid']) : '';
$refid = isset($_REQUEST['refid']) ? htmlentities($_REQUEST['refid']) : '';

//update read status
$sql_read=mysqli_query($dbconfig,"UPDATE notifications SET `read`='1' WHERE notificationID='".$notiid."' ") or die(mysqli_error($dbconfig));

$sql_req=mysqli_query($dbconfig,"SELECT * FROM users WHERE userID='".$uid."'") or die(mysqli_error($dbconfig));
$req_user=mysqli_fetch_assoc($sql_req);

$sql_noti=mysqli_query($dbconfig,"SELECT * FROM notifications WHERE notificationID='".$notiid."' ");
$row_noti=mysqli_fetch_assoc($sql_noti);

//forum 
if($type=='answer.vote.up' or $type=='answer.vote.down'  or $type=='answer.to.question'){
$sql_forum=mysqli_query($dbconfig,"SELECT * FROM forum_questions AS q RIGHT JOIN forum_answers a USING (fqID) WHERE a.answerID='".$row_noti['referenceID']."'  ");
$row_forum=mysqli_fetch_assoc($sql_forum);
header('location:question/'.$row_forum['fqID'].'/'.urlencode($row_forum['tittle']).'');	
}
if($type=='question.vote.up' or $type=='question.vote.down'){
$sql_forum=mysqli_query($dbconfig,"SELECT * FROM forum_questions AS q WHERE fqID='".$row_noti['referenceID']."'  ");
$row_forum=mysqli_fetch_assoc($sql_forum);	
header('location:question/'.$row_noti['referenceID'].'/'.urlencode($row_forum['tittle']).'');	
}

//event 
if($type=='event.attend' or $type=='event.invite'){
header('location:event/'.$row_noti['referenceID'].'');	
}
// fetching id on which comment 
$sql_post_comment=mysqli_query($dbconfig,"SELECT * FROM post_comments WHERE commentID='".$refid."'  ");
$row_post_comment=mysqli_fetch_assoc($sql_post_comment);
//posts
if($type=='group.post' or $type=='event.post' or $type=='home.post' or $type=='group.photo' or $type=='event.photo' or $type=='user.photo'){
header('location:post/'.$row_noti['referenceID'].'');	
}
if($type=='group.post.comment' or $type=='home.post.comment' or $type=='event.post.comment' or
$type=='group.photo.comment' or $type=='user.photo.comment' or $type=='event.photo.comment'){
header('location:post/'.$row_post_comment['postID'].'?view=post&cmntid='.$row_post_comment['commentID'].'');	
}
	
//group members 	
if($type=='grequest.join' or $type=='group.invite.accepted' or $type=='added.group' ){
header('location:group/'.$row_noti['referenceID'].'?view=group_members');	
	}
//friend request	
if($type=='request.accepted'){
header('location:user/'.$uid.'');	
	}
//group request	
if($type=='grequest.approve'){
header('location:group/'.$row_noti['referenceID'].'');	
	}	
?>
<!DOCTYPE html>
<html>
<head>
<title>View Notification <?php include 'includes/title.php'; ?></title>
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
    	
         <?php // checking if request type is available correct and not empty or diffrent then this
		  if(($type!='group.invite') and ($type!='request.sent') and ($type!='request.email') and ($type!='request.contact') 
			 and ($type!='share.email') and ($type!='share.contact'))
			 {
		     include 'includes/error1.php'; 
			 } else { //if not diffrent 
		  ?>
          
          <?php // script for accepting or declining invitation
		  if($type=='group.invite') {  ?>
          <div class="col-md-4 grid_2">
          
    	   <div class="white-area"><h5>Invitation</h5></div>
           	 <div class="profile_container">
            	<ul class="cute">
                  <?php
				  //fetching info whom invitation recieved
				  $sql_invite_to=mysqli_query($dbconfig,"SELECT * FROM invitation AS i LEFT JOIN user_groups AS g ON i.referenceID=g.groupID
				  WHERE i.inviteTo='".$userid."' AND type='group.invite'") or die(mysqli_error($dbconfig));
				
				  //check if invitation available
				  $check_invite=mysqli_num_rows($sql_invite_to);
				  $check_invite = isset($check_invite) ? htmlentities($check_invite) : '';
				  if($check_invite==''){echo '<div class="bx_top"><h3>No Invitation Available</h3></div>';}else {
				  while($row_invite_to=mysqli_fetch_assoc($sql_invite_to)){
					
					  //fetching info whose invitation recieved
					  $sql_invite_by=mysqli_query($dbconfig,"SELECT * FROM invitation AS i LEFT JOIN users AS u ON i.userID=u.userID
					  WHERE inviteID='".$row_invite_to['inviteID']."'") or die(mysqli_error($dbconfig));
					  ($row_invite_by=mysqli_fetch_assoc($sql_invite_by));
				  ?>
                  <li> 
                    <small> 
                       <a href="user/<?php echo $row_invite_by['userID']; ?>">
                            <b><?php echo $row_invite_by['firstName']; ?> <?php echo $row_invite_by['lastName']; ?></b> 
                        </a> invited you to join 
                        <a href="group/<?php echo $row_invite_to['groupID']; ?>"><b><?php echo $row_invite_to['groupName']; ?></b></a>
                    <br><br>
                        <!--Accept Frnd Request-->	
                      	<a href="javascript:void(0);" class="click_accept_invite invite inline_b" rel="<?php echo $row_invite_by['inviteID'];?>">
                      	<span id="accept_grp_invitation<?php echo $row_invite_by['inviteID'];?>"></span> <span id="hide_accept_join<?php echo $row_invite_by['inviteID'];?>">Accept Join Request</span></a> 
                      	<!--Delete Request-->   
                      	<a href="javascript:void(0);" class="click_delete_invite invite inline_b" rel="<?php echo $row_invite_by['inviteID'];?>">
                      	<span id="delete_grp_invitation<?php echo $row_invite_by['inviteID'];?>"></span><span id="hide_delete_join<?php echo $row_invite_by['inviteID'];?>">Delete</span></a>  
                    </small>
                  <hr></li>
                  <?php }} ?>
                </ul>
            </div>
            
       	  </div><!--end col-md-3 grid_2-->
       	  
          <!--Empty Div-->
          <div class="col-md-3 grid_2">
          	
          </div>
	      <?php } ?>
          
          
     	  <?php // script for notifying friend request
		  if($type=='request.sent') { 
	      ?>
          <div class="col-md-4 grid_2">
    	   <div class="white-area"><h5>Friend Request</h5></div>
           	 <div class="profile_container">
            	<ul class="cute">
                  <?php
				  //fetching info whome req recieved
				  $sql_req=mysqli_query($dbconfig,"SELECT * FROM friend_request LEFT JOIN users ON friend_request.friendWith=users.userID
				  WHERE friend_request.friendWith='".$_SESSION['userid']."'") or die(mysqli_error($dbconfig));
				
				  //check of request available
				  $check_req=mysqli_num_rows($sql_req);
				  $check_req = isset($check_req) ? $check_req : '';
				  if($check_req==''){echo '<div class="bx_top"><h3>No friend request available</h3></div>';}else {
				  while($row_frnd=mysqli_fetch_assoc($sql_req)){
					
					  //fetching info whose req recieved
					  $sql_req_accept=mysqli_query($dbconfig,"SELECT * FROM friend_request LEFT JOIN users ON friend_request.userID=users.userID
					  WHERE friendreqID='".$row_frnd['friendreqID']."'") or die(mysqli_error($dbconfig));
					  ($row_frnd_accept=mysqli_fetch_assoc($sql_req_accept));
				  ?>
                  <li> 
                    <a href="user/<?php echo $row_frnd_accept['userID']; ?>">
                        <img src="<?php if($row_frnd_accept['userImg']==''){echo 'images/default.jpg';}else {
                        echo 'uploads/'.$row_frnd_accept['userImg']; } ?>" alt="User Avatar" class="recent_chat">
                        <small class="" style="margin-left: 5px;"> 
                            <?php echo $row_frnd_accept['firstName']; ?>
                            <?php echo $row_frnd_accept['lastName']; ?>
                        </small>
                     </a>   
                    <small id="right_btn">
                        <!--Accept Frnd Request-->	
                      	<a href="javascript:void(0);" class="click_accept_friend invite" rel="<?php echo $row_frnd_accept['friendreqID'];?>">
                      	<span id="req_accept<?php echo $row_frnd_accept['friendreqID'];?>"></span> <span id="accept_frnd<?php echo $row_frnd_accept['friendreqID'];?>">Accept Request</span></a> 
                      	<!--Delete Request-->   
                      	<a href="javascript:void(0);" class="click_delete_friend invite" rel="<?php echo $row_frnd_accept['friendreqID'];?>">
                      	<span id="req_delete<?php echo $row_frnd_accept['friendreqID'];?>"></span><span id="delete_frnd<?php echo $row_frnd_accept['friendreqID'];?>">Cancel</span></a>  
                    </small>
                  <hr></li>
                  <?php }} ?>
                </ul>
            </div>
            
       	  </div><!--end col-md-3 grid_2-->
       	  
          <!--Empty Div-->
          <div class="col-md-3 grid_2">
          	
          </div>
	      <?php } ?>
          
       	  <?php // condition for wheather type is of contact info sharing
			  if($type=='request.email' or $type=='request.contact' 
			  or $type=='share.email' or $type=='share.contact') 
			  { 
		  ?>	
          
				  <?php // script for notifying contact & email sharing
                      if($type=='request.email' or   $type=='request.contact') { 
                      if($type=='request.email')	{$contact_type='email';}else{$contact_type='phone';}
                   ?>
                  <div class="col-md-4 grid_2">
                      <div class="white-area"><h5>Contact Request</h5></div>
                        <div class="profile_container">
                          <ul class="cute">
                               <?php
                               $sql_req_info=mysqli_query($dbconfig,"SELECT * FROM request_info WHERE reqBy='".$req_user['userID']."' AND reqTo='".$userid."'
                               AND reqAbout='".$type."'") or die (mysqli_error($dbconfig));
                               if(mysqli_num_rows($sql_req_info)==0){echo '<div class="profile_container"><div class="bx_top"><h3>No request to share</h3></div></div>';} else{
                               ($row_req_info=mysqli_fetch_assoc($sql_req_info));
                               ?>
                             <li> 
                                <small> 
                                    Do you want to share your <?php echo $contact_type;?> with
                                    <a href="user/<?php echo $req_user['userID']; ?>">
                                        <b><?php echo $req_user['firstName']; ?> <?php echo $req_user['lastName']; ?></b> 
                                    </a>?
                                    <br><br>
                                    <!--Share Request-->	
                                    <a href="javascript:void(0);" class="click_share_info invite inline_b" rel="<?php echo $row_req_info['reqinfoID'];?>">
                                    <span id="req_share"></span> <span id="accept_share">Share</span></a> 
                                    <!--Decline Request-->   
                                    <a href="javascript:void(0);" class="click_decline_info invite inline_b" rel="<?php echo $row_req_info['reqinfoID'];?>">
                                    <span id="req_decline"></span><span id="decline_share">Decline</span></a>
                                </small>
                               <hr></li>
                              <?php } ?>
                            </ul>
                        </div>
                        
                   </div><!--end col-md-3 grid_2-->
                    
                  <?php } ?>		
               
                  <?php // script for sharing contact & emails
                      if($type=='share.email' or $type=='share.contact') { 
                      if($type=='share.email')	{$type='Email';}else{$type='Phone';}
                  ?>
                  <div class="col-md-4 grid_2">
                   <div class="white-area"><h5>Contact Request</h5></div>
                     <div class="profile_container">
                        <ul class="cute">
                           <?php
                           $sql_see_share_info=mysqli_query($dbconfig,"SELECT * FROM share_request_info 
                           WHERE type='".$_REQUEST['type']."' AND (shareBy='".$uid."' AND shareWith='".$userid."' ) ") or die (mysqli_error($dbconfig));
                           $check=mysqli_num_rows($sql_see_share_info);
						   $check = isset($check) ? $check : '';
						   if($check==0){echo '<div class="profile_container"><div class="bx_top"><h3>Not shared with you</h3></div></div>';} else{
                           $row_see_share_info=mysqli_fetch_assoc($sql_see_share_info);
                           ?>
                           <li class="listing"> 
                               <h5>
                                    <?php echo $type;?> Details of 
                                    <b><a href="<?php if($req_user['webName']==''){echo 'user/'.$req_user["userID"].'';}else{echo 'user/'.$req_user["webName"].'';} ?>">
                                    <?php echo $req_user['firstName']; ?> <?php echo $req_user['lastName']; ?> </a></b>
                                    
                                    <?php if($row_see_share_info['type']=='share.contact'){ ?>
                                    <?php echo $req_user['userPhone']; ?><?php }else{ ?>
                                    <?php echo $req_user['userEmail']; ?><?php } ?>
                                </h5>
                           </li>
                          <?php } ?>
                        </ul>
                    </div>
                    
                 </div><!--end col-md-3 grid_2-->
               
                  <?php } ?>
          
              <!--List of user with whom contact is shared-->
              <div class="col-md-3 grid_2">
                    <div class="white-area"><h5><small class="grey1">Contact Details Share with</small></h5></div>
             <div class="profile_container">
                <ul class="cute">
               <?php 
               $sql_share_user=mysqli_query($dbconfig,"SELECT * FROM share_request_info LEFT JOIN users ON share_request_info.shareWith=users.userID
               WHERE shareBy='".$_SESSION['userid']."'") or die(mysqli_error($dbconfig));
               $share_with=mysqli_num_rows($sql_share_user);
               $share_with = isset($share_with) ? $share_with : '';
               if($share_with==0){echo '<div class="bx_top"><h3>Nothing available</h3></div>';}else{
               while($row_share_user=mysqli_fetch_assoc($sql_share_user)){
               ?>
                 <li class="listing"> 
                         <a href="<?php if($row_share_user['webName']==''){echo 'user/'.$row_share_user["userID"].'';}else{echo 'user/'.$row_share_user["webName"].'';} ?>">
                            <img src="<?php if($row_share_user['userImg']==''){echo 'images/default.jpg';}else {
                            echo 'uploads/'.$row_share_user['userImg']; } ?>" alt="User Avatar" class="recent_chat">
                            <small class="" style="margin-left: 5px;"> 
                                <?php echo $row_share_user['firstName']; ?>
                                <?php echo $row_share_user['lastName']; ?>
                            </small>
                         </a> 
                            
                         <small class="about" id="right_btn">
                              <?php if($row_share_user['type']=='share.email'){echo 'Email';}else{echo 'Phone';} ?> |
                              <!--Decline Request-->   
                              <a href="javascript:void(0);" class="click_cancel_share" rel="<?php echo $row_share_user['sharereqID'];?>">
                              <span id="cancel_share<?php echo $row_share_user['sharereqID'];?>"></span>
                              <span id="hide_cancel<?php echo $row_share_user['sharereqID'];?>"><i class="icon-remove"></i> Hide contact</span></a>	
                         </small>
                   </li>
                  <?php }} ?>
                </ul>
            </div>
            
              </div><!--end col-md-3 grid_2-->
   
          <?php } ?>
       
       	  
    	  <?php } //ending for error condition ?>
  
  

    <?php include 'includes/right_panel.php'; ?>
<!--Container Ends Here-->
<div class="clearfix"></div>
</div>
<script src="assets/js/myscript.js"></script>
<script src="assets/my-js/share_contact.js"></script>
<script src="assets/my-js/friend_request.js"></script>
<script src="assets/my-js/invitation.js"></script>
</div>
</body>
</html>