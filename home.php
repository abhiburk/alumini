<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Home <?php include 'includes/title.php'; ?></title>
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
    			<!--Form-->
                <div class="white-area"><h5>Activity Feed</h5></div>
                          <div class="hire-me">
                            <ul class="listing">
                              <form action="manipulates/manipulate.php" method="post" enctype="multipart/form-data">
                                  <input type="hidden" name="xAction" value="post">
                                  <input type="hidden" name="postType" value="home.post">
                                  <input type="hidden" name="reference" value="user_id">
                                  <input type="hidden" name="referenceID" value="<?php echo $userid; ?>">
                                  <input type="hidden" name="newsText" value="added new post">
                                 <li class="create_group"> 
                                    <textarea name="postText" class="form-control" placeholder="Post Activity" style="height: 50px;"></textarea>
                                 </li>
                                 <li class="" style="display:inline-flex;">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <!--<div class="fileupload-preview fileupload-exists thumbnail profile-img" ></div>-->
                                    <span class="btn btn-file  btn-primary btn-sm">
                                        <span class="fileupload-new "><i class="icon-picture"></i> Photo</span>
                                        <span class="fileupload-exists">Change</span>
                                        <input type="file" name="postImg"/>
                                    </span>
                                    <span class="btn btn-file fileupload-exists  btn-primary btn-sm" data-dismiss="fileupload" style="float: none"> Cancel</span>
                                    <input type="submit" class="btn btn-primary btn-sm btn  " value="Post">
                                    <span class="fileupload-preview"></span>
                                  </li> 
                                </form>
                              </ul> 
                          </div><div class="div-title"></div>
                   
                <!--<div class="radius-white-div">    
                  <ul class="post_photo_menu profile_menu" style="padding:1px;">
                        <li><a href=""><i class="icon-list-alt "></i> Activity Feed</a></li>
                  </ul> 
                </div><div class="div-title"></div>--> 

				<!--News Feed-->
                <div id="more_result"></div>
                <?php 
					// news feed
				   $sql_post=mysqli_query($dbconfig,"SELECT *,
				   $name FROM news_feed AS f LEFT JOIN users AS u 
				   ON f.newsBy=u.userID LEFT JOIN posts AS p ON p.postID=f.referenceID 
				   ORDER BY feedID DESC");
				   $count_post=mysqli_num_rows($sql_post);
				   $count_post = isset($count_post) ? $count_post : '';
				   if($count_post==''){echo '
				   <div class="profile_container"><ul class="listing"><li class="invite1"><small class="grey1">No Post Availabe</small></li></ul></div>';}else{
					   
				   while($row_news_feed=mysqli_fetch_assoc($sql_post)){
				   //checking if are friends
				   $sql_check_frnds=mysqli_query($dbconfig,"SELECT * FROM my_friends AS mf 
				   LEFT JOIN news_feed AS f ON mf.userID=f.newsBy OR mf.friendWith=f.newsBy
				   WHERE (userID='".$userid."' AND friendWith='".$row_news_feed['newsBy']."' ) 
				   OR (userID='".$row_news_feed['newsBy']."' AND friendWith='".$userid."') ");
				   $check_friends=mysqli_num_rows($sql_check_frnds);
				   $check_friends = isset($check_friends) ? $check_friends : '';
					   
				   //checking if are members of group to see group posts
				   $sql_grp_mem=mysqli_query($dbconfig,"SELECT * FROM group_members AS m LEFT JOIN user_groups AS g ON g.userID=m.memberID
				   WHERE m.groupID='".$row_news_feed['referenceID']."' AND memberID='".$userid."'") or die (mysqli_error($dbconfig));
				   $check_if_member=mysqli_num_rows($sql_grp_mem); 
				   $check_if_member = isset($check_if_member) ? $check_if_member : '';
				   
				   //checking if user interested or attending event then only show respective posts
				    $sql_check_int_or_att=mysqli_query($dbconfig,"SELECT * FROM event_status AS s LEFT JOIN user_events AS e USING (eventID) 
				   WHERE s.eventID='".$row_news_feed['referenceID']."'
				   AND (status='Interested' OR status='Attending') AND (s.userID='".$userid."' OR e.userID='".$userid."') ") or die (mysqli_error($dbconfig));
				   $check_int_or_att=mysqli_num_rows($sql_check_int_or_att);
				   $check_int_or_att = isset($check_int_or_att) ? $check_int_or_att : '';
				   
				   if(($check_friends==true or $userid==$row_news_feed['newsBy']) and ($row_news_feed['type']=='user.photo' or $row_news_feed['type']=='home.post')
				   or($check_if_member==true or $userid==$row_news_feed['newsBy']) and ($row_news_feed['type']=='group.photo' or $row_news_feed['type']=='group.post')
				   or($check_int_or_att==true or $userid==$row_news_feed['newsBy']) and ($row_news_feed['type']=='event.photo' or $row_news_feed['type']=='event.post') )
				   { ?>   
				   <div class="white-area"><h5>
				   <a href="<?php if($row_news_feed['webName']==''){echo 'user/'.$row_news_feed["userID"].'';}else{ echo 'user/'.$row_news_feed["webName"].'';}  ?>"> <?php echo $row_news_feed['name'];  ?></a>
                   <?php echo $row_news_feed['newsText']; ?>
				   </h5></div>
				   <div class="profile_container">
					 <div class="cover_img_container cute about">
                           <small class="post_photo_menu profile_menu">
								<?php $str=($row_news_feed['postText']); if(strlen($str)>=99){ echo substr($str,0,100).'...';}else{echo $str; }?>
                           </small>
						<?php if($row_news_feed['postImg']!=''){ ?><a href="post/<?php echo $row_news_feed['postID']; ?>"><img src="<?php echo 'uploads/'.$row_news_feed['postImg']; ?>"></a><?php } ?>
							
							<ul class="post_photo_menu profile_menu">
								<li>
									<?php //checking if like or not
									$sql_if_liked=mysqli_query($dbconfig,"SELECT * FROM user_likes WHERE likeTo='".$row_news_feed['postID']."' 
									AND likeType='".$row_news_feed['postType']."' AND userID='".$userid."' "); 
									$check_if_liked=mysqli_num_rows($sql_if_liked);
									$check_if_liked = isset($check_if_liked) ? $check_if_liked : '';?>
									<a><small class="grey1">
                                            <span id="default_count<?php echo $row_news_feed['postID']; ?>"><?php  echo $row_news_feed['like_counts']; ?></span>
                                            <span id="like_count<?php echo $row_news_feed['postID']; ?>"></span>
                                        </small></a> 
									<?php if($check_if_liked==true){ ?>	
                                    	<!--if already liked-->
										<a href="javascript:void(0);" id="<?php echo $row_news_feed['postID']; ?>" class="click_unlike"  data-likeType="<?php echo $row_news_feed['postType']; ?>" style="color: #2093F5;font-weight: 600;"> 
										<i class="icon-thumbs-up-alt"></i> Liked </a>
										<?php }else { ?>
										<!--if not liked-->
										<a href="javascript:void(0);" id="<?php echo $row_news_feed['postID']; ?>" class="black_bold click_like"  data-likeType="<?php echo $row_news_feed['postType']; ?>"> 
										<i class="icon-thumbs-up-alt"></i> Like </a>
									<?php } ?>
								</li> |
								<li>
                                    &nbsp;<small class="grey1"> <?php  echo $row_news_feed['comment_counts']; ?></small>
                                    <a href="post/<?php echo $row_news_feed['postID']; ?>" class="black_bold"> <i class="icon-comment-alt"></i> Comment </a>
                                </li> |&nbsp;
								<li>
                                	<small class="grey1"> <?php  echo "" .humanTiming( $row_news_feed['postTime'] ). "";  ?></small>
                                </li>
							</ul>
					   </div>
					 </div><div class="div-title"></div> 
               
         		<?php }}} ?>

 
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
                      <span style="display:inline-grid">     
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
                    </span><hr>
                  </li>
                  <?php } ?>
                </ul>
            </div><div class="div-title"></div> 
			<?php } ?>
            
            <!--Birthday-->		
            <?php 
            $sql_bday=mysqli_query($dbconfig,"SELECT *,CONCAT(firstName,' ',lastName)AS name FROM users AS u
            LEFT JOIN my_friends AS mf ON u.userID=mf.userID OR u.userID=mf.friendWith 
            WHERE DAY(birthday)=DAY(NOW()) 
            AND MONTH(birthday)=MONTH(NOW()) AND (mf.userID='".$userid."' OR mf.friendWith='".$userid."' )") or die (mysqli_error($dbconfig));
            $count_bday=mysqli_num_rows($sql_bday);
			$count_bday = isset($count_bday) ? $count_bday : '';
            if($count_bday!=''){
            ?>
            <div class="white-area"><h5>Birthday</h5></div>
            <div class="profile_container">
                <ul class="listing">
                <?php while($row_bday=mysqli_fetch_assoc($sql_bday)){ ?>
                    <a href="user/wall/<?php echo $row_bday['userID']; ?>"><li class="subitem_grey"><i class="icon-gift"></i> <?php echo $row_bday['name']; ?>
                    <small class="grey1 fright">Today</small>
                    </li></a>
                    <?php } ?>
                </ul>
            </div>
            <div class="div-title"></div>
			<?php } ?>
        
    	<!--<div class="white-area"><h5>Menu</h5></div>
        <div class="profile_container">
            <ul class="cute">
            	<li><a href="?menu=upcoming"><i class="icon-calendar"></i> Upcoming Events</a></li>
                <li><a href="?menu=invites"><i class="icon-envelope-alt "></i> Event Invites</a></li>
                <li><a href="?menu=myevents"><i class="icon-home"></i> My Events</a></li>
                <li><a href="?menu=declined"><i class="icon-remove"></i> Declined Events</a></li>
                <li><a href="?menu=pastevent"><i class="icon-time"></i> Past Events</a></li>
                <li><a href="?menu=birthday"><i class="icon-gift"></i> Birthday</a></li>
            </ul>
        </div>
        <div class="div-title"></div>-->
        
        
    </div><!--end col-md-3-->
    
    
    <?php include 'includes/right_panel.php'; ?>

<!--Container Ends Here-->
<div class="clearfix"></div>
</div>
<script src="assets/js/myscript.js"></script>
<script src="assets/js/ajax_load.js"></script>
<script src="assets/my-js/post.js"></script>
<script src="assets/my-js/friend_request.js"></script>
<script src="assets/my-js/invitation.js"></script>
</div>
</body>
</html>