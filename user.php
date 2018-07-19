<?php include 'config.php'; 

$uid = isset($_REQUEST['userID']) ? htmlentities($_REQUEST['userID']) : '';
$webname = isset($_REQUEST['webName']) ? htmlentities($_REQUEST['webName']) : '';
$view = isset($_REQUEST['view']) ? htmlentities($_REQUEST['view']) : '';

$sql_req_user=mysqli_query($dbconfig,"SELECT *,CONCAT(firstName,' ',lastName) AS name FROM users as u 
LEFT JOIN users_edu USING (userID) LEFT JOIN user_social_con AS s USING (userID)
WHERE u.userID='".$uid."' or webName='".$webname."'") or die(mysqli_error($dbconfig));
$req_user=mysqli_fetch_assoc($sql_req_user);
$reqid = isset($req_user['userID']) ? $req_user['userID'] : '';

if($reqid==''){
	 include 'includes/error.php'; 
	}
?>
<!DOCTYPE html>
<html>
<head>
<?php include 'includes/base.php'; ?>
<title><?php echo $req_user['name']; ?> <?php include 'includes/title.php'; ?></title>
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
        
    <div class="col-md-3 grid_2 hide_search">
    	
        <!--Displaying Photo and Menu--> 
        <div class="profile_container">
            <div class="cover_img_container">
                 <img src="<?php if($req_user['userImg']==''){echo 'images/default.jpg';} else{echo 'uploads/'.$req_user['userImg']; } ?>" />
                 <h4 class="text-center"><?php echo $req_user['firstName'];?> <?php echo $req_user['lastName']; ?></h4><hr>
                 <div class="profile_menu">
                 	
                  <?php 	$sql_my_frnds=mysqli_query($dbconfig,"SELECT * FROM my_friends
					 		WHERE userID='".$reqid."' AND friendWith='".$userid."' or 
							friendWith='".$reqid."' AND userID='".$userid."'") or die(mysqli_error($dbconfig));
							$row_my_frnds=mysqli_fetch_assoc($sql_my_frnds);
							$check_my_frnd=mysqli_num_rows($sql_my_frnds);
							$check_my_frnd = isset($check_my_frnd) ? htmlentities($check_my_frnd) : '';
					  	    //check if frnd req sent
						    if($check_my_frnd==true){ ?>
                           
                            <small><a href="javascript:void(0);" class="invite" >
                      		<span><i class="icon-ok"></i> Friends </span></a></small>
                            
                            <!--Delete Request-->   
                            <small><a href="javascript:void(0);" class="click_delete_myfriend invite" rel="<?php echo $row_my_frnds['myfriendID'];?>">
                            <span id="req_delete"></span><span id="delete_frnd">Unfriend</span></a></small>
				  			<?php }else{ 
						
							$sql_req_sent=mysqli_query($dbconfig,"SELECT * FROM friend_request
					 		WHERE friendWith='".$reqid."' AND userID='".$userid."'") or die(mysqli_error($dbconfig));
							$row_frnd_req=mysqli_fetch_assoc($sql_req_sent);
							$check_req_sent=mysqli_num_rows($sql_req_sent);
							$check_req_sent = isset($check_req_sent) ? htmlentities($check_req_sent) : '';
					  	    //check if frnd req sent
						    if($check_req_sent==true){ ?>
                      
                              <!--Cancel Request-->    
                              <small><a href="javascript:void(0);" class="click_cancel_friend invite" rel="<?php echo $row_frnd_req['friendreqID'];?>">
                              <span id="req_sent_cancel"></span><span id="cancel_frnd">Cancel Request</span></a></small>	 <?php }else {?>
                                
                               <?php if($userid!=$user['userID'] || $userid!= $reqid){ ?> 
                              <!--Send Frnd Request-->	
                              <small><a href="javascript:void(0);" class="click_add_friend invite" rel="<?php echo $reqid;?>">
                              <span id="req_sent"></span> <span id="add_frnd">Add as Friend</span></a></small> <?php }}?>
                              <?php } ?>
                              <small> <a href="message<?php if($req_user['webName']==''){echo '/'.$req_user["userID"].'';}else{echo '/'.$req_user["webName"].'';} ?>" class="invite">
                               Message </a></small>
                              
                             <small>
                               <div class="dropdown">
                              	<a onclick="myFunction()"  href="javascript:void(0);" class="invite dropbtn" > <span class="glyphicon glyphicon-chevron-down dropbtn"></span> More</a>
                                  <div id="myDropdown" class="dropdown-content">
                                    <a href="user/about/<?php echo $reqid; ?>"><i class="icon-info-sign"></i> About</a>
                                    <a href="user/friends/<?php echo $reqid; ?>"><i class="icon-user"></i> Friends</a>
                                    <a href="user/batch/<?php echo $reqid; ?>"><i class="glyphicon glyphicon-education"></i> Batchmates</a>
                                  </div>
                                </div>
                              </small>
                 </div>
             </div>
         </div>
         
        
	</div><!-- end col-md-3 grid_2-->
    
    
    
    <!--Displaying User Information--> 
    <div class="col-md-4 grid_2 hide_search">
    	<?php 
			// news feed
		    if($view==''){ 
			$sql_post=mysqli_query($dbconfig,"SELECT *,
			   CONCAT(firstName,' ',lastName) AS name FROM news_feed AS f LEFT JOIN users AS u 
			   ON f.newsBy=u.userID LEFT JOIN posts AS p ON p.postID=f.referenceID WHERE newsBy='".$reqid."'
			   ORDER BY feedID DESC");
			   $count_post=mysqli_num_rows($sql_post);
			   $count_post = isset($count_post) ? $count_post : '';
			   if($count_post==''){echo '
			   <div class="profile_container"><ul class="listing"><li class="invite1"><small class="grey1">No Post Availabe</small></li></ul></div>';}else{
				   
			   while($row_news_feed=mysqli_fetch_assoc($sql_post)){
			   ?>   
			   <div class="white-area"><h5>
			   <a href="user/<?php echo $row_news_feed['userID']; ?>"> <?php echo $row_news_feed['name'];  ?></a>
			   <?php echo $row_news_feed['newsText']; ?>
			   </h5></div>
			   <div class="profile_container">
				 <div class="cover_img_container cute about">
					   <small class="post_photo_menu profile_menu">
						<?php $str=htmlspecialchars($row_news_feed['postText']); if(strlen($str)>=99){ echo substr($str,0,100).'...';}else{echo $str; }?>
						</small>
					<?php if($row_news_feed['postImg']!=''){ ?>
					<a href="post/<?php echo $row_news_feed['postID']; ?>"><img src="<?php echo 'uploads/'.$row_news_feed['postImg']; ?>"></a><?php } ?>
						
						<ul class="post_photo_menu profile_menu">
							<li>
								<?php //checking if like or not
								$sql_if_liked=mysqli_query($dbconfig,"SELECT * FROM user_likes WHERE likeTo='".$row_news_feed['postID']."' 
								AND likeType='".$row_news_feed['postType']."' AND userID='".$userid."' "); 
								$check_if_liked=mysqli_num_rows($sql_if_liked);
								$check_if_liked = isset($check_if_liked) ? $check_if_liked : ''; ?>
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
							<a href="post/<?php echo $row_news_feed['postID']; ?>" class="black_bold"> <i class="icon-comment-alt"></i> Comment </a></li> |&nbsp;
							<li><small class="grey1"> <?php  echo "" . humanTiming( $row_news_feed['postTime'] ). "";  ?></small></li>
						</ul>
				   </div>
				 </div>
				 <div class="div-title"></div> 
		   
			<?php }}} ?>   
            
    	<?php 
			// About
			if($view=='about'){ ?>
			<div class="panel panel-default">
                        
                        <div class="panel-body">
                            <ul class="nav nav-tabs">
                                <li class="tab_about remove"><a href="javascript:void(0);" class="click_user_tab" rel="about" data-uid="<?php echo $reqid; ?>" data-toggle="tab">About</a>
                                </li>
                                <li class="tab_edu remove"><a href="javascript:void(0);" class="click_user_tab" rel="edu" data-uid="<?php echo $reqid; ?>" data-toggle="tab">Education</a>
                                </li>
                                <li class="tab_contact remove"><a href="javascript:void(0);" class="click_user_tab" rel="contact" data-uid="<?php echo $reqid; ?>" data-toggle="tab">Contact</a>
                                </li>
                                <li class="tab_wp remove"><a href="javascript:void(0);" class="click_user_tab" rel="wp" data-uid="<?php echo $reqid; ?>" data-toggle="tab">Workplace</a>
                                </li>
                                <li class="tab_social remove"><a href="javascript:void(0);" class="click_user_tab" rel="social" data-uid="<?php echo $reqid; ?>" data-toggle="tab">Social Connection</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="tab_result"> </div>
                                <div id="hide_default_tab">
                                			<!--About-->
                                            <div class="white-area"><h5>About <?php echo $req_user['firstName']; ?></h5></div>
                                            <div class="hire-me">
                                            <ul class="cute ">
                                              <li class="req_profile"> 
                                                  <label class="grey">Name</label> <small class="grey "><?php echo $req_user['firstName']; ?> <?php echo $req_user['lastName']; ?></small>
                                              </li>
                                              <hr> 
                                              <li class="req_profile"> 
                                                  <label class="grey">Birthday</label> <small class="grey "><?php echo $req_user['birthday']; ?></small>
                                              </li>
                                              <hr>
                                              <li class="req_profile"> 
                                                  <label class="grey">Gender</label> <small class="grey "><?php echo $req_user['gender']; ?></small>
                                              </li>
                                              
                                              <?php if($req_user['webName']!=''){ ?><hr>
                                              <li class="req_profile"> 
                                                  <label class="grey">Webname</label> <small class="grey "><a href="http://www.site.com/user/<?php echo $req_user['webName']; ?>">@<?php echo $req_user['webName']; ?></a></small>
                                              </li><?php } ?>
                                             </ul>
                                           </div><div class="div-title"></div>
                                </div>
                            </div>
                        </div>
                    </div>
        <?php } ?>  
           
           
           
        <?php //friends
			if($view=='friends'){ ?>     
			
			<?php 
				$sql_newest_mem1=mysqli_query($dbconfig,"SELECT *,CONCAT(firstName,' ',lastName) AS name FROM my_friends LEFT JOIN users ON my_friends.userID=users.userID
				WHERE my_friends.friendWith='".$reqid."' UNION SELECT *,CONCAT(firstName,' ',lastName) AS name FROM my_friends LEFT JOIN users ON my_friends.friendWith=users.userID
				WHERE my_friends.userID='".$reqid."'");
				$count_frnds=mysqli_num_rows($sql_newest_mem1);
				$count_frnds = isset($count_frnds) ? $count_frnds : '';
			?>  
				<div class="white-area"><h5>Friends (<?php echo $count_frnds; ?>)</h5></div>
				<div class="profile_container <?php if($count_frnds>6) {echo 'scroll2';} ?> ">
					<ul class="listing">
						<?php 
						if($count_frnds=='')
						{echo '<small class="grey" style="padding:5px;">No Friends Yet</small>';}else{
						while($row_friends=mysqli_fetch_assoc($sql_newest_mem1)){
						?>
						<a href="message/<?php echo $row_friends['userID']; ?>">
						<li class="subitem_grey" style="padding:5px; "> 
							<img src="<?php if($row_friends['userImg']==''){echo 'images/default.jpg';}else {
							echo 'uploads/'.$row_friends['userImg']; } ?>" alt="User Avatar" class="recent_chat">
							<small class="" style="margin-left: 5px;"> 
								<?php echo $row_friends['name']; ?>
							</small>
							<small class="" style="float:right; margin-top:8px;">
								
							</small>
						</li>
						</a>
						<?php }} ?>
					 </ul> 
				  </div>
              
        <?php } ?>
        
        <?php //batches
			if($view=='batch'){ ?>     
               
			<?php 
                $sql_batch_mates=mysqli_query($dbconfig,"SELECT *,CONCAT(firstName,' ',lastName)AS name FROM users_edu AS e 
                LEFT JOIN users AS u USING (userID) WHERE (YEAR(joinDate)=YEAR('".$user['joinDate']."')  AND userID!='".$reqid."')");
                $count_batch_mates=mysqli_num_rows($sql_batch_mates);
				$count_batch_mates = isset($count_batch_mates) ? $count_batch_mates : '';
            ?>  
            <div class="white-area" style="display:inline-flex; width:100%"><h5>Batchmates (<?php echo $count_batch_mates; ?>)</h5> 
                 <small class="grey1" style="float: right;margin-left: 10px;">Filter by: 
                 <a href="javascript:void(0);" rel="college" data-uid="<?php echo $reqid; ?>" class="click_filter_batch">College</a> |
                 <a href="javascript:void(0);" rel="batch" data-uid="<?php echo $reqid; ?>" class="click_filter_batch">Batch</a> |  
                 <a href="javascript:void(0);" rel="stream" data-uid="<?php echo $reqid; ?>" class="click_filter_batch">Stream</a>
                 </small>
            </div>
            <div id="show_filter_batch"><!--Ajax Response Here--></div>
            <div id="hide_default_filter">
            <div class="profile_container <?php if($count_batch_mates>6) {echo 'scroll2';} ?> ">
                <ul class="listing">
                    <?php 
                    if($count_batch_mates=='')
                    {echo '<small class="grey" style="padding:5px;">No Batchmates Yet</small>';}else{
                    while($row_batch_mates=mysqli_fetch_assoc($sql_batch_mates)){
                    ?>
                    <a href="user/<?php echo $row_batch_mates['userID']; ?>">
                    <li class="subitem_grey" style="padding:5px; "> 
                        <img src="<?php if($row_batch_mates['userImg']==''){echo 'images/default.jpg';}else {
                        echo 'uploads/'.$row_batch_mates['userImg']; } ?>" alt="User Avatar" class="recent_chat">
                        <small class="" style="margin-left: 5px;"> 
                            <?php echo $row_batch_mates['name']; ?>
                        </small>
                        <small class="grey1" style="float:right; margin-top:8px;">
                            <?php echo date('Y',strtotime($row_batch_mates['joinDate'])); ?> Batch
                        </small>
                    </li>
                    </a>
                    <?php }} ?>
                 </ul> 
              </div>
          </div>
              
        <?php } ?>   
         
         
        
    </div><!-- end col-md-4 grid_2-->


    <?php include 'includes/right_panel.php'; ?>
<!--Container Ends Here-->
<div class="clearfix"></div>
</div>
<script src="assets/js/myscript.js"></script>
<script src="assets/js/ajax_load.js"></script>
<script src="assets/my-js/friend_request.js"></script>
<script src="assets/my-js/post.js"></script>
<script src="assets/my-js/share_contact.js"></script>

</div>
</body>
</html>