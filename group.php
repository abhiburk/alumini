<?php include 'config.php'; 

$gid = isset($_REQUEST['groupID']) ? htmlentities($_REQUEST['groupID']) : '';
$edit_group = isset($_REQUEST['edit_group']) ? htmlentities($_REQUEST['edit_group']) : '';
$members = isset($_REQUEST['view']) ? htmlentities($_REQUEST['view']) : '';

$sql_group=mysqli_query($dbconfig,"SELECT * FROM user_groups 
WHERE groupID='".$gid."' ") or die(mysqli_error($dbconfig));
$row_group=mysqli_fetch_assoc($sql_group);
$reqgroupID = isset($row_group['groupID']) ? htmlentities($row_group['groupID']) : '';
if($reqgroupID==''){
	include 'includes/error.php';	
}

//checking for groups members to allow access
$sql_grp_mem=mysqli_query($dbconfig,"SELECT * FROM group_members AS m LEFT JOIN user_groups AS g ON g.userID=m.memberID
WHERE m.groupID='".$reqgroupID."' AND memberID='".$userid."'") or die (mysqli_error($dbconfig));
$check_if_member=mysqli_num_rows($sql_grp_mem);
$check_if_member = isset($check_if_member) ? htmlentities($check_if_member) : '';

//counting group memebers 	  
$sql_count=mysqli_query($dbconfig,"SELECT memberID FROM group_members WHERE groupID='".$reqgroupID."'");
$count_members=mysqli_num_rows($sql_count);
$count_members = isset($count_members) ? htmlentities($count_members) : '';
?>
<!DOCTYPE html>
<html>
<head>
<title>Group <?php include 'includes/title.php'; ?></title>
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

    <div class="col-md-3 grid_2">
                  <!--Group Image and Menu-->
                  <div class="profile_container">
                        <div class="cover_img_container text-center about">
                         
                         <!--Edit Group Image -->
                         <form action="manipulates/update_profile_photo.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="xAction" value="update_group_photo" />
                            <input type="hidden" name="gid" value="<?php echo $reqgroupID; ?>" />
                            <input type="hidden" name="postType" value="group.photo">
                            <input type="hidden" name="newsText" value="has updated <a href='group/<?php echo $row_group['groupID'] ?>'><?php echo $row_group['groupName'] ?></a> group profile photo" />
                            <input type="hidden" name="reference" value="group_id" />
                            <input type="hidden" name="referenceID" value="<?php echo $row_group['groupID']; ?>" />
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <img class="profile-img fileupload-new" src="<?php if($row_group['groupImg']==''){echo 'images/group.jpg';}else {
                                echo 'uploads/'.$row_group['groupImg']; } ?>" alt="" />
                                
                                <?php if($check_if_member==true){  ?>
                                <div class="fileupload-preview fileupload-exists thumbnail profile-img" ></div>
                                <span class="btn btn-file btn btn-default btn-sm ">
                                    <span class="fileupload-new "><i class="icon-pencil"></i> Edit Photo</span>
                                    <span class="fileupload-exists">Change</span>
                                    <input type="file" name="groupImg"/>
                                </span>
                                <a href="#" class=" fileupload-exists btn btn-default btn-sm" data-dismiss="fileupload" style="float: none">cancel</a>
                                <input type="submit" class="btn btn-default btn-sm fileupload-exists" value="Save">
                                <?php } ?>
                                
                            </div>
                        </form>
                        
                         <h3 style="font-size:21px"><a href="group/<?php echo $reqgroupID; ?>"><?php echo $row_group['groupName']; ?></a> </h3>
                         <div class="profile_menu">
                              <!--Join Group (Show to New Members)-->	
                              <?php if($check_if_member!=true){  
                              $sql_check_if_req=mysqli_query($dbconfig,"SELECT * FROM group_request WHERE userID='".$userid."' AND groupID='".$reqgroupID."'");
                              $check=mysqli_num_rows($sql_check_if_req);
                              $check = isset($check) ? htmlentities($check) : '';
                              //checking if request to join is sent 
                              if($check!=true){
                              ?>
                              <a href="javascript:void(0);" class="click_join_group" rel="<?php echo $reqgroupID;?>">
                              <h3 class="invite"><div id="greq_sent"></div> <div id="join_group">Join Group</div></h3></a> <?php }else{ ?>
                             
                             <a href="javascript:void(0);" class="click_cancel_group" rel="<?php echo $reqgroupID;?>">
                              <h3 class="invite"><div id="greq_sent"></div> <div id="cancel_group">Cancel Join Request</div></h3></a>
                             <?php }} ?>
                             
                             <!--Discussion (Show to Group Members)-->	
                              <?php if($check_if_member==true){  ?>
                              <a href="discussion/<?php {echo ''.$row_group["groupID"].'';} ?>">
                              <h3 class="invite">Discussion</h3></a><?php } ?>
                              
                              <!--Members (Show to Group Members)-->	
                              <?php if($check_if_member==true){  ?>
                              <a href="group<?php {echo '/'.$row_group["groupID"].'';} ?>?view=group_members">
                              <h3 class="invite">Members </h3></a><?php } ?>
                              
                              <div class="dropdown">
                              <!--Add Members (Show to Group Members)-->	
                               <?php if($check_if_member==true){  ?>
                                  <a onclick="myFunction()"  href="javascript:void(0);" ><h3 class="invite dropbtn"> <span class="glyphicon glyphicon-chevron-down dropbtn"></span> More</h3></a>
                                  <div id="myDropdown" class="dropdown-content">
                                    <a href="addmembers.php?<?php echo 'gid='.$reqgroupID.'' ?>">
                                    <i class="icon-plus"></i> Add Member</a>
                                    <a href="invite.php?view=group&<?php {echo 'gid='.$reqgroupID.'';} ?>"><i class="icon-gift"></i> Invite</a>
                                    <a href="group/<?php echo $reqgroupID; ?>?edit_group=1"><i class="icon-cog"></i> Settings</a>
                                    <a href="javascript:void(0);" rel="<?php echo $reqgroupID; ?>" class="click_leave_group"><i class="icon-remove-sign "></i> Leave Group </a>
                                  </div>
                                  <?php }else {echo'<h3 class="invite1">';echo $count_members; echo ' Members</h3>';} ?>
                              </div>
                         </div>
                             
                       </div>
                     </div> 
                 
    </div><!--end col-md-3 grid_2-->
       
	<div class="col-md-4 grid_2">
                  <!--Confirm Notification Delete Group-->
                  <div class="hide_confirm " id="hide_for_cancel">
                  <div class="profile_container auto-height">
                        <ul class="listing">
                          <li style="padding:10px;">
                                    <h5>You are about to delete <b><?php  echo $row_group['groupName']; ?></b> group.
                                    Are you sure want to leave and delete this group ?</h5>
                          </li><hr>
                          <li class=""> 
                             <small class="" style="float:right; padding:15px; ">
                                <a href="javascript:void(0);" rel="<?php echo $gid ?>" class="click_confirm_leave grey invite">
                                    <span id="leave_group"></span> <span id="leave_hide" onClick="click_confirm_leave grey invite"><i class="icon-remove"></i> Confirm</span>  
                                </a> 
                                <a href="javascript:void(0);" class="click_cancel_leave grey invite">
                                     <i class="icon-remove"></i> Cancel  
                                </a>  
                             </small>
                           </li>
                        </ul>
                    </div><div class="div-title"></div>
                	</div>
           
    			<?php  if($edit_group=='1' and $check_if_member==true) { ?>
                <div class="white-area"><h5>Edit Group Info</h5></div>
                <div class="hire-me">
                    <ul class="cute">
                    
                        <!--Group Name Fields-->
                        <form action="manipulates/manipulate.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="xAction" value="update_group_info">
                        <input type="hidden" name="gid" value="<?php echo $row_group['groupID']; ?>">
                          <li class=""> 
                           <span class="hideEdit editgroupName">
                              <label class="grey">Group Name</label> <small class="grey"><?php echo $row_group['groupName']; ?> </small>
                              <small class="edit">
                                  <img class="loadergroupName loader" src="images/loading2.gif">
                                  <a class="clickShow" rel="groupName" href="javascript:void(0);" >Edit</a>
                              </small>
                           </span>
                          
                           <span class="hideName namegroupName">
                                <label class="grey ">Group Name</label>
                                <input type="text" class="form-control" name="gname" value="<?php echo $row_group['groupName']; ?>">
                                <img class="loadergroupName loader" src="images/loading2.gif">
                                <a class="btn btn-primary btn-sm cancelEdit" rel="groupName" href="javascript:void(0);" >Cancel</a>
                                <input type="submit" value="Save" class="btn btn-primary btn-sm">
                           </span>
                          </li>
                        </form>
                        
                        <?php // allow only group admin to edit info
                        if($row_group['userID']==$userid){ ?>
                            <!--Privacy Fields--><hr>
                            <form action="manipulates/manipulate.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="xAction" value="update_group_info">
                            <input type="hidden" name="gid" value="<?php echo $row_group['groupID']; ?>">
                              <li class=""> 
                               <span class="hideEdit edit<?php echo $row_group['privacy']; ?>">
                                  <label class="grey">Privacy</label> <small class="grey"><?php echo $row_group['privacy']; ?> </small>
                                  <small class="edit">
                                      <img class="loader<?php echo $row_group['privacy']; ?> loader" src="images/loading2.gif">
                                      <a class="clickShow" rel="<?php echo $row_group['privacy']; ?>" href="javascript:void(0);" >Edit</a>
                                  </small>
                               </span>
                              
                               <span class="hideName name<?php echo $row_group['privacy']; ?>">
                                    <input type="radio" name="privacy" value="Private" <?php if($row_group['privacy']=='Private') {echo 'checked';}?>> 
                                    <label class="grey">Private</label>
                                    
                                    <input type="radio" name="privacy" value="Public" <?php if($row_group['privacy']=='Public') {echo 'checked';}?>> 
                                    <label class="grey ">Public</label><br><br>
                
                                    <img class="loader<?php echo $row_group['privacy']; ?> loader" src="images/loading2.gif">
                                    <a class="btn btn-primary btn-sm cancelEdit" rel="<?php echo $row_group['privacy']; ?>" href="javascript:void(0);" >Cancel</a>
                                    <input type="submit" value="Save" class="btn btn-primary btn-sm">
                               </span>
                              </li>
                            </form><hr>
                            
                            <!--Membership Approval -->
                            <form action="manipulates/manipulate.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="xAction" value="update_group_info">
                            <input type="hidden" name="gid" value="<?php echo $row_group['groupID']; ?>">
                              <li class=""> 
                               <span class="hideEdit edit<?php echo $row_group['approval']; ?>">
                                  <label class="grey">Members Approval</label> <small class="grey"><?php if($row_group['approval']=='admin') {echo 'Only Admin';} else{echo 'All Members';}  ?> </small>
                                  <small class="edit">
                                      <img class="loader<?php echo $row_group['approval']; ?> loader" src="images/loading2.gif">
                                      <a class="clickShow" rel="<?php echo $row_group['approval']; ?>" href="javascript:void(0);" >Edit</a>
                                  </small>
                               </span>
                              
                               <span class="hideName name<?php echo $row_group['approval']; ?>">
                                    <input type="radio" name="approval" value="admin" <?php if($row_group['approval']=='admin') {echo 'checked';}?> > 
                                    <small class="grey ">Only Admin Can Accept Group Requests</small><hr>
                                    
                                    <input type="radio" name="approval" value="all" <?php if($row_group['approval']=='all') {echo 'checked';}?>> 
                                    <small class="grey">Any Group Member Can Accept Group Requests</small><br><br>
                
                                    <img class="loader<?php echo $row_group['approval']; ?> loader" src="images/loading2.gif">
                                    <a class="btn btn-primary btn-sm cancelEdit" rel="<?php echo $row_group['approval']; ?>" href="javascript:void(0);" >Cancel</a>
                                    <input type="submit" value="Save" class="btn btn-primary btn-sm">
                               </span>
                              </li>
                            </form>
                        
                        <?php } ?>
                    
                   </ul> 
                </div><div class="div-title"></div>
        		  
				<?php }else { ?>
				
				<?php  
				// view group members
					
			    //counting group request 	  
			    $sql_count=mysqli_query($dbconfig,"SELECT * FROM group_request AS r 
                LEFT JOIN users AS u ON r.userID=u.userID WHERE groupID='".$reqgroupID."'");
			    $count_request=mysqli_num_rows($sql_count);
				$count_request = isset($count_request) ? $count_request : '';
				
				//cheching admin of the group
				$sql_admin=mysqli_query($dbconfig,"SELECT * FROM user_groups WHERE groupID='".$row_group['groupID']."'");
				$row_admin=mysqli_fetch_assoc($sql_admin);
				
				//checking if is member of group	
				if($members=='group_members' and $check_if_member==true){ 
				//checking if rights given to "all" along with admin and request not empty
				if(($row_admin['userID']==$userid or $row_admin['approval']=='all') and $count_request!=0){ ?>
                <div class="white-area"><h5>Group Request (<?php echo $count_request; ?>)</h5></div>
                <div class="profile_container <?php if($count_request>3) {echo 'scroll1';}else{echo 'auto-height';} ?>">
            		<ul class="listing">
					  <?php 
                      $sql_group=mysqli_query($dbconfig,"(SELECT * FROM group_request AS r 
                      LEFT JOIN users AS u ON r.userID=u.userID WHERE groupID='".$reqgroupID."' ORDER BY greqID DESC) ")or die (mysqli_error($dbconfig));
                      while($row_group=mysqli_fetch_assoc($sql_group)){
                      ?>
                      <li class="" style="padding:5px; border-bottom:1px solid #f0f0f0; "> 
                      	<a href="user/<?php echo $row_group['userID']; ?>">
                            <img src="<?php if($row_group['userImg']==''){echo 'images/default.jpg';}else {
                            echo 'uploads/'.$row_group['userImg']; } ?>" alt="User Avatar" class="recent_chat">
                          	<small class="" style="margin-left: 5px;"> 
								<?php echo $row_group['firstName']; ?>
                                <?php echo $row_group['lastName']; ?>
                          	</small>
                         </a>   
                         
                        <small class="about" style="float:right; margin-top:8px;">
							<?php echo " " . humanTiming($row_group['requestTime'] ). ""; ?> |
                            <!-- Approve-->
                            <a href="javascript:void(0);" rel="<?php echo $row_group['greqID'] ?>" class="approve_request grey invite">
                            <span id="approve<?php echo $row_group['greqID'] ?>"></span> <span id="approve_mem<?php echo $row_group['greqID'] ?>"><i class="icon-ok"></i> Approve</span></a> 
                            <!-- Decline-->
                            <a href="javascript:void(0);" rel="<?php echo $row_group['greqID'] ?>" data-gid="<?php echo $reqgroupID; ?>" class="decline_request grey invite">
                            <span id="decline<?php echo $row_group['greqID'] ?>"></span> <span id="decline_mem<?php echo $row_group['greqID'] ?>"><i class="icon-remove"></i> Decline </span></a>  
                        </small>
                      </li>
                      <?php } ?> 
                    </ul>
                </div><div class="div-title"></div>
				<?php } ?>
				
                <!--Group Members-->	  
                <div class="white-area"><h5>Group Members (<?php echo $count_members; ?>)</h5></div>
                <div class="profile_container <?php if($count_members>3) {echo 'scroll1';}else{echo 'auto-height';} ?>">
            		<ul class="listing">
					  <?php 
                      $sql_group=mysqli_query($dbconfig,"(SELECT * FROM group_members AS m 
                      LEFT JOIN users AS u ON m.memberID=u.userID WHERE groupID='".$reqgroupID."') ")or die (mysqli_error($dbconfig));
                      while($row_group=mysqli_fetch_assoc($sql_group)){
					  
					  //cheching admin of the group
					  $sql_admin=mysqli_query($dbconfig,"SELECT userID FROM user_groups WHERE groupID='".$row_group['groupID']."'");
					  $row_admin=mysqli_fetch_assoc($sql_admin);
                      ?>
                      <li class="" style="padding:5px; border-bottom:1px solid #f0f0f0; "> 
                      	<a href="user/<?php echo $row_group['userID']; ?>">
                            <img src="<?php if($row_group['userImg']==''){echo 'images/default.jpg';}else {
                            echo 'uploads/'.$row_group['userImg']; } ?>" alt="User Avatar" class="recent_chat">
                          	<small class="" style="margin-left: 5px;"> 
								<?php echo $row_group['firstName']; ?>
                                <?php echo $row_group['lastName']; ?>
                          	</small>
                         </a>   
                            <small class="" style="float:right; margin-top:8px;">
                            
                            <?php echo " " . humanTiming($row_group['addTime'] ). ""; ?> |
                            <!--Hidding Remove Button for Group Owner-->
                            <?php if($row_admin['userID']==$row_group['memberID']) {echo '(Admin)';}else{ ?>
                            
                            <?php if($row_admin['userID']==$userid){ ?>
                            <a href="javascript:void(0);" rel="<?php echo $row_group['memberID'] ?>" data-gid="<?php echo $row_group['groupID'] ?>" class="remove_guser grey invite">
                            <span id="remove_success<?php echo $row_group['memberID'] ?>"></span> 
                            <span id="remove_mem<?php echo $row_group['memberID'] ?>"><i class="icon-remove"></i> Remove</span>  </a>   <?php }} ?>
                            </small>
                       </li>
                      <?php } ?> 
                    </ul>
                </div>
                <div class="div-title"></div>
         	  	
				<?php }else{ ?>
              	
              	<?php if($check_if_member==true) { // showing group post form ?>
             	  
                <div class="white-area"><h5>Group Timeline</h5></div>
                  <div class="hire-me">
                    <ul class="listing">
                      <form action="manipulates/manipulate.php" method="post" enctype="multipart/form-data">
                          <input type="hidden" name="xAction" value="post">
                          <input type="hidden" name="postType" value="group.post">
                          <input type="hidden" name="reference" value="group_id">
                          <input type="hidden" name="referenceID" value="<?php echo $gid; ?>">
                          <input type="hidden" name="newsText" value="added new post to <a href='group/<?php echo $gid; ?>'><?php echo $row_group['groupName']; ?></a> group">
                         <li class="create_group"> 
                            <textarea name="postText" class="form-control" placeholder="Post to Group" style="height: 50px;"></textarea>
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
              
           		<?php }}} ?> 
                  
			   <?php  // group post 
			 	 $sql_group_post=mysqli_query($dbconfig,"SELECT * FROM posts LEFT JOIN users USING (userID)
               WHERE referenceID='".$reqgroupID."' AND postType='group.post' ORDER BY postID DESC");
               $count_grppost=mysqli_num_rows($sql_group_post);
			   $count_grppost = isset($count_grppost) ? $count_grppost : '';
               if($count_grppost==''){echo '
               <div class="profile_container"><ul class="listing"><li class="invite1"><small class="grey1">No Group Post Availabe</small></li></ul></div>';}else{
               while($row_group_post=mysqli_fetch_assoc($sql_group_post)){
               ?>   
               <div class="white-area"><h5>
               <a href="user/<?php echo $row_group_post['userID']; ?>"> <?php echo $row_group_post['firstName']; ?> <?php echo $row_group_post['lastName']; ?></a>
               </h5></div>
               <div class="profile_container">
                 <div class="cover_img_container cute about">
                    <?php if($row_group_post['postImg']!=''){ ?>
                    <a href="post/<?php echo $row_group_post['postID']; ?>"><img src="<?php echo 'uploads/'.$row_group_post['postImg']; ?>"></a><?php } ?>
                        <small class="post_photo_menu profile_menu"><?php echo $row_group_post['postText']; ?></small>
                        <ul class="post_photo_menu profile_menu">
                            <li>
                                <?php //checking if like or not
                                $sql_if_liked=mysqli_query($dbconfig,"SELECT * FROM user_likes WHERE likeTo='".$row_group_post['postID']."' 
                                AND likeType='".$row_group_post['postType']."' AND userID='".$userid."' "); 
                                $check_if_liked=mysqli_num_rows($sql_if_liked);
								$check_if_liked = isset($check_if_liked) ? $check_if_liked : '';?>
                                
                                <a><small class="grey1">
                                            <span id="default_count<?php echo $row_group_post['postID']; ?>"><?php  echo $row_group_post['like_counts']; ?></span>
                                            <span id="like_count<?php echo $row_group_post['postID']; ?>"></span>
                                        </small></a> 
									<?php if($check_if_liked==true){ ?>	
                                    	<!--if already liked-->
										<a href="javascript:void(0);" id="<?php echo $row_group_post['postID']; ?>" class="click_unlike"  data-likeType="<?php echo $row_group_post['postType']; ?>" style="color: #2093F5;font-weight: 600;"> 
										<i class="icon-thumbs-up-alt"></i> Liked </a>
										<?php }else { ?>
										<!--if not liked-->
										<a href="javascript:void(0);" id="<?php echo $row_group_post['postID']; ?>" class="black_bold click_like"  data-likeType="<?php echo $row_group_post['postType']; ?>"> 
										<i class="icon-thumbs-up-alt"></i> Like </a>
									<?php } ?>
                            </li> &nbsp;|
                            <li><a href="post/<?php echo $row_group_post['postID']; ?>">Comment </a></li> &nbsp;|&nbsp;
                            <li><small class="grey1"> <?php  echo "" . humanTiming( $row_group_post['postTime'] ). "";  ?></small></li>
                        </ul>
                   </div>
                 </div>
                 <div class="div-title"></div> 
               
                <?php }} ?>
                  
        		
        
    </div><!--end col-md-4 grid_2-->
    
  
   
    <?php include 'includes/right_panel.php'; ?>

<!--Container Ends Here-->
<div class="clearfix"></div>
</div>
<script src="assets/js/myscript.js"></script>
<script src="assets/my-js/group_action.js"></script>
<script src="assets/my-js/post.js"></script>
</div>
</body>
</html>