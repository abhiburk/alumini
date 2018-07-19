<?php 
require '../config.php';
require '../includes/ImageManipulator.php';
$time=time();

$action = isset($_REQUEST['xAction']) ? htmlentities($_REQUEST['xAction']) : '';
?>
	
    	
    <?php
	if($action=='tab_filter') 
	{ 
		$tab_filter = isset($_REQUEST['tab_filter']) ? htmlentities($_REQUEST['tab_filter']) : ''; 
		$uid = isset($_REQUEST['uid']) ? htmlentities($_REQUEST['uid']) : ''; 
		$sql_req_user=mysqli_query($dbconfig,"SELECT *,CONCAT(firstName,' ',lastName) AS name FROM users as u 
		LEFT JOIN users_edu USING (userID) LEFT JOIN user_social_con AS s USING (userID)
		WHERE u.userID='".$uid."' ") or die(mysqli_error($dbconfig));
		$req_user=mysqli_fetch_assoc($sql_req_user);
		$reqid = isset($req_user['uid']) ? $req_user['uid'] : '';	
		?>
		
		<?php if($tab_filter=='about'){ ?>
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
		<?php } ?>
		<?php if($tab_filter=='edu'){ ?>
				<div class="white-area"><h5><i class="glyphicon glyphicon-education"></i> Education</h5></div>
				<div class="hire-me">
					<ul class="cute">
					<?php if($req_user['instituteName']=='' or $req_user['courseName']=='' or $req_user['branchName']=='' or $req_user['joinDate']=='')
					{echo '<li><small class="grey">No Education Info Set</small></li>'; }else{?>
					<?php if($req_user['instituteName']!=''){ ?>
					  <li class="req_profile"> 
						  <label class="grey">Institute</label> <small class="grey "><?php echo $req_user['instituteName']; ?> </small>
					  </li>
					  <hr> <?php } ?>
					  <?php if($req_user['courseName']!=''){ ?>
					  <li class="req_profile"> 
						  <label class="grey">Course</label> <small class="grey "><?php echo $req_user['courseName']; ?> </small>
					  </li>
					  <hr><?php } ?>
					  <?php if($req_user['branchName']!=''){ ?>
					  <li class="req_profile"> 
						  <label class="grey">Stream</label> <small class="grey "><?php echo $req_user['branchName']; ?></small>
					  </li>
					  <hr><?php } ?>
					  <?php if($req_user['joinDate']!=''){ ?>
					  <li class="req_profile"> 
						  <label class="grey">Join-Passout</label> <small class="grey"><?php echo $req_user['joinDate']; ?> -
						  <?php if($req_user['passoutDate']!=''){ echo $req_user['passoutDate'];}else if($req_user['currentlystudying']=='1'){echo 'Currently Studying';} ?></small>
					  </li><?php }} ?>
					</ul>
				 </div><div class="div-title"></div>
		<?php } ?>
		<?php if($tab_filter=='contact'){ ?>
				<div class="white-area"><h5><i class="icon-phone"></i> Contact</h5></div>
				<div class="hire-me">
					<ul class="cute">
					  <li class="req_profile"><label class="grey">Phone</label> <small class="grey">
							<?php if($req_user['phonePrivacy']=='Only Me'){?>Phone Hidden |
							<?php 
							// checking if request is already sent 
							$sql_check_req=mysqli_query($dbconfig,"SELECT * FROM request_info WHERE reqTo='".$reqid."' 
							AND reqBy='".$userid."' AND reqAbout='request.contact'");
							if(mysqli_num_rows($sql_check_req)==true){ //show Request already created
							?> 
							<a>Requested</a> <?php }else{ //show request button?>
							<a href="javascript:void(0);" class="click_ask_contact" rel= "<?php echo $reqid; ?>" data-contact="request.contact">Ask for Contact</a>
							<?php  }}else{ echo $req_user['userPhone'];} ?> </small>
					   </li>
					   <hr>
					  <!--Email-->
					  <li class="req_profile"><label class="grey">Email</label> <small class="grey">
						  <?php if($req_user['emailPrivacy']=='Only Me'){?> Email Hidden |
								<?php 
								// checking if request is already sent
								$sql_check_req=mysqli_query($dbconfig,"SELECT * FROM request_info WHERE reqTo='".$reqid."' 
								AND reqBy='".$userid."' AND reqAbout='request.email'");
								if(mysqli_num_rows($sql_check_req)==true){  //show Request already created
								?> 
								<a>Requested</a> <?php }else {//show request button ?>
								<a href="javascript:void(0);" class="click_ask_email" rel=<?php echo $reqid; ?> data-email="request.email">Ask for Email</a>
						  <?php }}else{ echo $req_user['userEmail'];} ?></small>
					  </li>
					</ul>
				  </div><div class="div-title"></div>
		<?php } ?>
		<?php if($tab_filter=='wp'){ ?>
				<!--Work Place-->
				<div class="white-area"><h5><i class="icon-briefcase"></i> Work Place </h5></div>
				<?php 
				$sql_user=mysqli_query($dbconfig,"SELECT *,$name
				FROM users AS u LEFT JOIN users_edu USING (userID) LEFT JOIN user_workplace AS wp USING (userID) 
				WHERE wp.userID='".$uid."'") or die(mysqli_error());
				$count_wp=mysqli_num_rows($sql_user);
				$count_wp = isset($count_wp) ? $count_wp : '';
				?>
				<div class="profile_container show_workplace_list <?php if($count_wp>=3){echo 'scroll2';} ?>">
					<ul class="cute">
						<?php 
						if($count_wp==''){echo '<li><small>Workplace Not Set</small></li>';}else{
						while($user=mysqli_fetch_assoc($sql_user)){ ?>
						<li style="display:flex; width:100%">
							<img src="images/work.jpg" class="recent_chat">
							<span class="inline_grid">
								<b><?php echo $user['companyName']; ?></b>
								<small class="grey1"><?php echo $user['position']; ?>  </small>
								<small class="grey1">
									<?php echo date('F d,Y',strtotime($user['startDate'])); ?> - <?php if($user['currentlyworking']=='1'){echo 'Present';}else{ echo $user['endDate'];} ?>
								</small>
								<?php if($user['description']!=''){ ?> 
								<small class="grey1">
									<span class="hide_onclick<?php echo $user['workID']; ?>">
										<?php $str=htmlspecialchars($user['description']); if(strlen($str)>=30)
										{echo substr($str,0,30).'..<a href="javascript:void(0);" rel="'.$user["workID"].'" class="click_more">More</a>';}else{echo $str; }?>
									</span>
									<span class="display_none show_onclick<?php echo $user['workID']; ?>"><?php echo htmlspecialchars($user['description']); ?><br>
										<a href="javascript:void(0);" rel="<?php echo $user['workID']; ?>" class="click_more">Hide</a>
									</span>
								</small>
								<?php } ?>
							</span>
						</li><hr>
						<?php }} ?>
					</ul>
				</div>
				<div class="div-title"></div>	
		<?php } ?>
		<?php if($tab_filter=='social'){ ?>
				<!--Social Connection-->
				<div class="white-area"><h5>Social Connections <i class="icon-facebook-sign"></i> <i class="icon-linkedin-sign"></i></h5></div> 
				<div class="hire-me">
				<ul class="cute ">
						<li class="sub">
							<label class="grey"><i class="icon-facebook-sign" style="color:#5F75A7"></i> Facebook</label> 
						<?php if($req_user['fb_privacy']!='0' and $req_user['fb_name']!='') {?>    
							<small class="grey">
								<a href="http://facebook.com/<?php echo $req_user['fb_name']; ?>" target="target_blank">facebook.com/<?php echo $req_user['fb_name']; ?></a>
								<div class="fb-follow" data-href="https://www.facebook.com/abhishburk" data-layout="standard" data-size="small" data-show-faces="true" data-width="250px"></div>
							</small>
						<?php  }else {echo '<small>Not Available</small>';} ?>    
						</li>
						<hr>
						<li class="sub">
							<label class="grey"><i class="icon-linkedin-sign" style="color:#39F"></i> LinkedIn</label> 
						<?php if($req_user['in_privacy']!='0' and $req_user['in_name']!='') {?>
							<small class="grey">
								<a href="http://linkedin.com/in/<?php echo $req_user['in_name']; ?>" target="target_blank">linkedin.com/in/<?php echo $req_user['in_name']; ?></a>
							</small>
						<?php  }else {echo '<small>Not Available</small>';} ?> 
						</li>
					  </ul> 
					</div>
					
		<?php } ?>
	
	<?php } ?>
    
    	
	<?php
    if($action=='home_pagination') { 
    $start=0;
    $limit=2;
    if(isset($_REQUEST['nid'])){
        $nid=$_REQUEST['nid'];
        $start=($nid-1)*$limit;}
    else{ $nid=1; }
    ?>
    
                        <?php 
                        // news feed
                       $sql_post=mysqli_query($dbconfig,"SELECT *,
                       $name FROM news_feed AS f LEFT JOIN users AS u 
                       ON f.newsBy=u.userID LEFT JOIN posts AS p ON p.postID=f.referenceID 
                       ORDER BY feedID DESC LIMIT $start,$limit");
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
                                        <a><small class="grey1"><?php  echo $row_news_feed['like_counts']; ?></small></a> 
                                        <?php if($check_if_liked==true){ ?>	
                                            <!--if already liked-->
                                            <a href="javascript:void(0);" class="click_unlike" rel="<?php echo $row_news_feed['postID']; ?>" data-likeType="<?php echo $row_news_feed['postType']; ?>" style="color: #2093F5;font-weight: 600;"> 
                                            <span id="show_unlike<?php echo $row_news_feed['postID']; ?>"></span> <span id="hide_unlike<?php echo $row_news_feed['postID']; ?>"><i class="icon-thumbs-up-alt"></i> Liked</span> </a>
                                            <?php }else { ?>
                                            <!--if not liked-->
                                            <a href="javascript:void(0);" class="black_bold click_like" rel="<?php echo $row_news_feed['postID']; ?>" data-likeType="<?php echo $row_news_feed['postType']; ?>"> 
                                            <span id="show_like<?php echo $row_news_feed['postID']; ?>"></span> <span id="hide_like<?php echo $row_news_feed['postID']; ?>"><i class="icon-thumbs-up-alt"></i> Like</span> </a>
                                        <?php } ?>
                                    </li> |
                                    <li>
                                        &nbsp;<small class="grey1"> <?php  echo $row_news_feed['comment_counts']; ?></small>
                                        <a href="post/<?php echo $row_news_feed['postID']; ?>" class="black_bold"> <i class="icon-comment-alt"></i> Comment </a>
                                    </li> |&nbsp;
                                    <li>
                                        <small class="grey1"> <?php  echo "" . ( $row_news_feed['postTime'] ). "";  ?></small>
                                    </li>
                                </ul>
                           </div>
                         </div><div class="div-title"></div> 
                   
                    <?php }}} ?>      
          
    <?php
    //fetch all the data from database.
    $count=mysqli_num_rows(mysqli_query($dbconfig,"SELECT *,
    $name FROM news_feed AS f LEFT JOIN users AS u 
    ON f.newsBy=u.userID LEFT JOIN posts AS p ON p.postID=f.referenceID 
    ORDER BY feedID"));
    //calculate total page number for the given table in the database 
    $total=ceil($count-($check_friends+$check_if_member+$sql_check_int_or_att)/$limit); ?>
    <?php
    if($nid>1)
    {
        //Go to previous page to show previous 10 items. If its in page 1 then it is inactive
        echo "<center><a href='javascript:void(0);' rel=".($nid-1)." class='btn btn-info click_more_records' style='width:75%' >Back</a></center>";
    }
    if($nid!=$total)
    {
    {
    if($count >0)
        //Go to previous page to show next 10 items.
        echo "<center><a href='javascript:void(0);' rel=".($nid+1)." class='btn btn-info click_more_records' style='width:75%' >More Feed</a></center>";
    }
    }
    } 
    ?>      
        
        
    <?php
	// for searching all site
	$search = isset($_REQUEST['datasearch']) ? htmlentities($_REQUEST['datasearch']) : '';
	$searchBy = isset($_REQUEST['searchBy']) ? htmlentities($_REQUEST['searchBy']) : '';
	
	if($searchBy=='people') {
		
		$q=$conn->prepare("SELECT *,$name FROM users LEFT JOIN users_edu USING (userID)
		WHERE (firstName LIKE :search OR lastName LIKE :search OR instituteName LIKE :search) AND userID!='".$userid."'");
		$q->bindValue(':search','%'.$search.'%'); 
		$q->execute();
		$count=$q->rowCount();
		if($search==''){echo 'Search Result: Empty search value';}else {
?>    
        <ul class="cute <?php if($count>6){echo 'scroll';} ?>" style="width: 100%;">
                <li>Search Result: <?php echo '<b>"'.$search.'"</b></li><hr>'; 
                 if($count==''){echo '<li>No record found</li>';}{
                while ($row_search = $q->fetch(PDO::FETCH_ASSOC)) {  ?>
                
                <?php //cheching if frnd req is sent   
                $sql_req_sent=mysqli_query($dbconfig,"SELECT * FROM friend_request
                WHERE friendWith='".$row_search['userID']."' AND userID='".$userid."'") or die(mysqli_error($dbconfig));
                $check_req_sent=mysqli_num_rows($sql_req_sent);
                $check_req_sent = isset($check_req_sent) ? htmlentities($check_req_sent) : '';
                //checking if are friends
                $sql_my_frnds=mysqli_query($dbconfig,"SELECT * FROM my_friends
                WHERE userID='".$row_search['userID']."' AND friendWith='".$userid."' or 
                friendWith='".$row_search['userID']."' AND userID='".$userid."'") or die(mysqli_error($dbconfig));
                $row_my_frnds=mysqli_fetch_assoc($sql_my_frnds);
                $check_my_frnd=mysqli_num_rows($sql_my_frnds);
                $check_my_frnd = isset($check_my_frnd) ? htmlentities($check_my_frnd) : '';
                ?>
                
           <li style="padding:0px;">
             <img src="<?php if($row_search['userImg']==''){echo 'images/default.jpg';}else {
             echo 'uploads/'.$row_search['userImg']; } ?>" alt="User Avatar" class="recent_chat" style="margin-top: 10px;">
             <div class="user_info">
                <small><b><a href="<?php if($row_search['webName']==''){echo 'user/'.$row_search["userID"].'';}else{ echo 'user/'.$row_search["webName"].'';}  ?>"><?php echo $row_search['name']; ?></a></b></small>
                <small class="grey1"><?php echo $row_search['instituteName']; ?></small>
             </div>
             <?php //check if frnd req sent
             if($check_req_sent==true){  ?> 
             <span id="right_btn" class="btn btn-default btn-sm"><i class="icon-ok"></i> Sent</span> <?php }
             //check if already driends
             else if($check_my_frnd==true) {
             echo '<span id="right_btn" class="btn btn-default btn-sm"><i class="icon-ok"></i> Friends</span>';		 
             //else show add friend button
             }else { ?>
             <span id="req_sent<?php echo $row_search['userID']; ?>" style="float:right;"></span> 
             <span id="add_frnd<?php echo $row_search['userID']; ?>">
             <a href="javascript:void(0);" rel="<?php echo $row_search['userID']; ?>" class="click_add_friend btn btn-default btn-sm" id="right_btn"><i class="icon-plus"></i> Add as Friend</a> 
             </span>
             <?php } ?>
             <hr>
           </li>
         <?php }}} ?>
        </ul>
          
    <?php } ?> 
    
   <?php if($searchBy=='event') {
	   
		$q=$conn->prepare("SELECT * FROM user_events
		WHERE eventName LIKE :search OR eventDetails LIKE :search OR eventLocation LIKE :search OR eventDate LIKE :search ");
		$q->bindValue(':search','%'.$search.'%'); 
		$q->execute();
		$count=$q->rowCount();
		if($search==''){echo 'Search Result: Empty search value';}else {
	 ?>    
         <ul class="cute <?php if($count>6){echo 'scroll';} ?>" style="width: 100%;">
                    <li>Search Result: <?php echo '<b>"'.$search.'"</b></li><hr>'; 
                     if($count==''){echo '<li>No record found</li>';}{
                    while ($row_search = $q->fetch(PDO::FETCH_ASSOC)) {
						  
                    //checking status
                    $sql_check_if_req=mysqli_query($dbconfig,"SELECT * FROM event_status WHERE userID='".$userid."' AND eventID='".$row_search['eventID']."'");
				    $row_status=mysqli_fetch_assoc($sql_check_if_req);
                    ?>
                    
               <li style="padding:0px;">
                  <img src="<?php if($row_search['eventImg']==''){echo 'images/event.jpg';}else {
                  echo 'uploads/'.$row_search['eventImg']; } ?>" alt="Avatar" class="recent_chat" style="margin-top: 10px;">
                  <div class="user_info">
                    <small><b><a href="event/<?php echo $row_search['eventID']; ?>"><?php echo $row_search['eventName']; ?></a></b></small>
                    <small class="grey1"><?php echo date('d-M-Y',strtotime($row_search['eventDate'])); ?></small>
                  </div>
                  <?php 
				 	 //check if attending
				 	if($row_status['status']=='Attending') { 
                 	echo '<span id="right_btn" class="btn btn-default btn-sm"><i class="icon-ok"></i> Attending</span>';  }
                 	//check if Declined
                 	else if($row_status['status']=='Declined') {
                    echo '<span id="right_btn" class="btn btn-default btn-sm"><i class="icon-ok"></i> Declined</span>';		 
                    //else show add friend button
                    }else if($row_status['status']=='Interested') {
                    echo '<span id="right_btn" class="btn btn-default btn-sm"><i class="icon-ok"></i> Interested</span>';		 
                    } ?>
                 <hr>
               </li>
               
             <?php }}} ?>
          </ul>
          
    <?php } ?>
    
    <?php if($searchBy=='group') {
	   
		$q=$conn->prepare("SELECT * FROM user_groups WHERE groupName LIKE :search ");
		$q->bindValue(':search','%'.$search.'%'); 
		$q->execute();
		$count=$q->rowCount();
		if($search==''){echo 'Search Result: Empty search value';}else {
	 ?>    
         <ul class="cute <?php if($count>6){echo 'scroll';} ?>" style="width: 100%;">
                    <li>Search Result: <?php echo '<b>"'.$search.'"</b></li><hr>'; 
                     if($count==''){echo '<li>No record found</li>';}{
                    while($row_search = $q->fetch(PDO::FETCH_ASSOC)) {
						  
					//check if member	  
                    $sql_access=mysqli_query($dbconfig,"SELECT * FROM user_groups AS g LEFT JOIN group_members USING (groupID)
					WHERE g.groupID=".$row_search['groupID']." AND memberID='".$userid."' ") or die (mysqli_error($dbconfig));
					$check_access_of_group=mysqli_num_rows($sql_access);
					$check_access_of_group = isset($check_access_of_group) ? htmlentities($check_access_of_group) : '';
                    ?>
                    
               <li style="padding:0px;">
                  <img src="<?php if($row_search['groupImg']==''){echo 'images/event.jpg';}else {
                  echo 'uploads/'.$row_search['groupImg']; } ?>" alt="Avatar" class="recent_chat" style="margin-top: 10px;">
                  <div class="user_info">
                    <small><b><a href="group/<?php echo $row_search['groupID']; ?>"><?php echo $row_search['groupName']; ?></a></b></small>
                  </div>
                  <?php 
				 	 //check if member
				 	if($check_access_of_group==true) { 
                 	echo '<span id="right_btn" class="btn btn-default btn-sm"><i class="icon-ok"></i> Member</span>';  }
                 	?>
                 <hr>
               </li>
               
             <?php }}} ?>
          </ul>
          
    <?php } ?>
    
    <?php if($searchBy=='question') {
	   
		$q=$conn->prepare("SELECT *,$name,fq.createTime,fq.updateTime
        FROM forum_questions AS fq 
        LEFT JOIN users AS u USING (userID)
		WHERE tittle LIKE :search OR description LIKE :search ");
		$q->bindValue(':search','%'.$search.'%'); 
		$q->execute();
		$count=$q->rowCount();
		if($search==''){echo 'Search Result: Empty search value';}else {
	 ?>    
         <ul class="cute <?php if($count>6){echo 'scroll';} ?>" style="width: 100%;">
                    <li>Search Result: <?php echo '<b>"'.$search.'"</b></li><hr>'; 
                    if($count==''){echo '<li>No record found</li>';}{
                    while($row_search = $q->fetch(PDO::FETCH_ASSOC)) {
						  
					//check if answered	  
                    $sql_count=mysqli_query($dbconfig,"SELECT answerID FROM forum_answers WHERE fqID='".$row_search['fqID']."'");
                    $count_answers=mysqli_num_rows($sql_count);
                    $count_answers = isset($count_answers) ? htmlentities($count_answers) : '';
                    ?>
                    
              <li style="display:flex; width:100%">
                    <i class="icon-ok <?php if($row_search['answerAccepted']=='1'){echo 'ok_green';}else{echo 'ok_grey';} ?>"></i>
                    <span style="position: absolute;margin-top: 33px;font-size: 11px;"><?php echo $count_answers; ?> Ans</span>
                    <span class="inline_grid">
                        <b><a href="question/<?php echo $row_search['fqID']; ?>/<?php echo urlencode($row_search['tittle']); ?>"><?php echo ($row_search['tittle']); ?></a></b>
                        <small class="grey1">Asked by: 
                        <a href="<?php echo 'user/'.$row_search["userID"].'';  ?>"><?php echo $row_search['name']; ?></a>  |
                            <?php echo "" .date("d-M-'y, h:m a",$row_search['createTime']). ""; ?>
                        </small>
                    </span>
              <hr></li>
               
             <?php }}} ?>
          </ul>
          
    <?php }// end searching all site ?>
       
       

	<?php  // search new users in step    
    if($action=='search_new_users'){
		$searchVal = ($_POST['searchVal']);
		
		$q=$conn->prepare("SELECT *,$name FROM users LEFT JOIN users_edu USING (userID)
		WHERE firstName LIKE :searchVal OR lastName LIKE :searchVal OR instituteName LIKE :searchVal AND userID!='".$userid."'");
		$q->bindValue(':searchVal','%'.$searchVal.'%'); 
		$q->execute();
		$count=$q->rowCount();
		if($searchVal==''){echo 'Search Result: Empty search value';}else {
		?>
			<ul class="cute <?php if($count>4){echo 'scroll2';} ?>" style="width: 100%;">
			   Search Result: <?php echo '"'.$searchVal.'"'; 
			   if($count==''){echo ', No record found';}{
			   while ($row_search = $q->fetch(PDO::FETCH_ASSOC)) {  ?>
               <?php  
				$sql_req_sent=mysqli_query($dbconfig,"SELECT * FROM friend_request
				WHERE friendWith='".$row_search['userID']."' AND userID='".$userid."'") or die(mysqli_error($dbconfig));
				$check_req_sent=mysqli_num_rows($sql_req_sent); ?>
			   <li style="padding:0px;">
			   <img src="<?php if($row_search['userImg']==''){echo 'images/default.jpg';}else {
						echo 'uploads/'.$row_search['userImg']; } ?>" alt="User Avatar" class="recent_chat" style="margin-top: 15px;">
				 <div class="user_info">
					<small><b><?php echo $row_search['name']; ?></b></small>
					<small class="grey1"><?php echo $row_search['instituteName']; ?></small>
				 </div>  
				<?php //check if frnd req sent
                   if($check_req_sent==true){  ?> 
                 <span id="right_btn" class="click_add_friend btn btn-default btn-sm"><i class="icon-ok"></i> Sent</span> <?php }else { ?>
                 <span id="req_sent" style="float:right;"></span> 
                 <span id="add_frnd">
                 <a href="javascript:void(0);" rel="<?php echo $row_new_users['userID']; ?>" class="click_add_friend btn btn-default btn-sm" id="right_btn"><i class="icon-plus"></i> Add as Friend</a> 
                 </span>
                 <?php } ?>
				 <hr>
			   </li>
			   <?php }}} ?>
			 </ul>
         
    <?php  } ?>   
     	
            
    <?php  // editi wp
	if($action=='edit_wp'){ ?>   
        <div class="show_edit_wp display_none">
        <div class="hire-me">
            <ul class="cute">
                 
                  <?php $workID=(isset($_POST['workID']))? $_POST['workID']:null;
                  $sql_wp=mysqli_query($dbconfig,"SELECT * FROM user_workplace AS wp
                  WHERE wp.workID='".$workID."'") or die(mysqli_error());
                  $row_wp=mysqli_fetch_assoc($sql_wp);
                  ?>	
                  <!--Company+Description+Position Fields-->
                  <form action="manipulates/manipulate.php" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="xAction" value="update_work_place">
                  <input type="hidden" name="workID" value="<?php echo $row_wp['workID']; ?>">
                  <li class="sub"> 
                      <label class="grey1">Company Name</label> 
                       <span class="hide_wp_edit">
                            <input type="text" class="form-control" value="<?php echo $row_wp['companyName']; ?>" placeholder="Company Name" name="companyName">
                       </span>
                  </li>
                  
                  <li class="sub"> 
                      <label class="grey1">Description</label> 
                       <span class="hide_wp_edit">
                            <textarea class="form-control" value="<?php echo $row_wp['description']; ?>" placeholder="Description" name="description"></textarea>
                       </span>
                  </li>
                  
                  <li class="sub"> 
                      <label class="grey1">Position</label> 
                       <span class="hide_wp_edit">
                            <input type="text" class="form-control" value="<?php echo $row_wp['position']; ?>" placeholder="Position" name="position">
                       </span>
                  </li>
                  
        
                  <!--Join Date+ End Date Fields-->
                  <li class="sub"> 
                   <label class="grey1">Start Date</label><br> 
                    <span class="hide_wp_edit">
                        <select name="startday" class='form-control1' required>
                          <option value="">Day</option>
                          <?php $k=0; for($i=1;$i<=31;$i++) {?>
                          <option value="<?php echo $i; ?>"<?php if(substr($row_wp['startDate'],8,3) == $i){ echo 'selected';} ?>>
                          <?php if($i<=9) {echo $k;} echo $i;} ?>
                        </select>
                        
                        <select name="startmonth" class='form-control1' required>
                          <option value="">Month</option>
                          <option value="01"<?php if(substr($row_wp['startDate'],5,2) == '01'){ echo 'selected';};?>> January		</option>
                          <option value="02"<?php if(substr($row_wp['startDate'],5,2) == '02'){ echo 'selected';};?>> February	</option>
                          <option value="03"<?php if(substr($row_wp['startDate'],5,2) == '03'){ echo 'selected';};?>> March		</option>
                          <option value="04"<?php if(substr($row_wp['startDate'],5,2) == '04'){ echo 'selected';};?>> April		</option>
                          <option value="05"<?php if(substr($row_wp['startDate'],5,2) == '05'){ echo 'selected';};?>> May			</option>
                          <option value="06"<?php if(substr($row_wp['startDate'],5,2) == '06'){ echo 'selected';};?>> June		</option>
                          <option value="07"<?php if(substr($row_wp['startDate'],5,2) == '07'){ echo 'selected';};?>> July		</option>
                          <option value="08"<?php if(substr($row_wp['startDate'],5,2) == '08'){ echo 'selected';};?>> August		</option>
                          <option value="09"<?php if(substr($row_wp['startDate'],5,2) == '09'){ echo 'selected';};?>> September	</option>
                          <option value="10"<?php if(substr($row_wp['startDate'],5,2) == '10'){ echo 'selected';};?>> October		</option>
                          <option value="11"<?php if(substr($row_wp['startDate'],5,2) == '11'){ echo 'selected';};?>> November	</option>
                          <option value="12"<?php if(substr($row_wp['startDate'],5,2) == '12'){ echo 'selected';};?>> December	</option>
                        </select>
                        <select name="startyear" class='form-control1' required> 
                          <option  value="">Year</option>
                          <?php for($i=1950;$i<=date('Y');$i++) { ?>
                          <option value="<?php echo $i; ?>"<?php if(substr($row_wp['startDate'],0,4) == $i){ echo 'selected';};?> >
                          <?php echo  $i;} ?>
                        </select>
                        
                   </span>
                  </li>
                  <li>
                    <small class="grey">
                            <input type="checkbox" value="1"<?php if($row_wp['currentlyworking']=='1'){echo 'checked';} ?> name="currentlyworking" > Currently Working
                        </small>
                  </li>
                  
                  <!--End Date Fields-->
                  <li class="sub"> 
                   <label class="grey1">End Date</label> <br>
                    <span class="hide_wp_edit">
                        <select name="endday" class='form-control1'>
                          <option value="">Day</option>
                          <?php $k=0; for($i=1;$i<=31;$i++) {?>
                          <option value="<?php echo $i; ?>"<?php if(substr($row_wp['endDate'],8,3) == $i){ echo 'selected';} ?>>
                          <?php if($i<=9) {echo $k;} echo $i;} ?>
                        </select>
                        
                        <select name="endmonth" class='form-control1'>
                          <option value="">Month</option>
                          <option value="01"<?php if(substr($row_wp['endDate'],5,2) == '01'){ echo 'selected';};?>> January		</option>
                          <option value="02"<?php if(substr($row_wp['endDate'],5,2) == '02'){ echo 'selected';};?>> February	</option>
                          <option value="03"<?php if(substr($row_wp['endDate'],5,2) == '03'){ echo 'selected';};?>> March		</option>
                          <option value="04"<?php if(substr($row_wp['endDate'],5,2) == '04'){ echo 'selected';};?>> April		</option>
                          <option value="05"<?php if(substr($row_wp['endDate'],5,2) == '05'){ echo 'selected';};?>> May			</option>
                          <option value="06"<?php if(substr($row_wp['endDate'],5,2) == '06'){ echo 'selected';};?>> June		</option>
                          <option value="07"<?php if(substr($row_wp['endDate'],5,2) == '07'){ echo 'selected';};?>> July		</option>
                          <option value="08"<?php if(substr($row_wp['endDate'],5,2) == '08'){ echo 'selected';};?>> August		</option>
                          <option value="09"<?php if(substr($row_wp['endDate'],5,2) == '09'){ echo 'selected';};?>> September	</option>
                          <option value="10"<?php if(substr($row_wp['endDate'],5,2) == '10'){ echo 'selected';};?>> October		</option>
                          <option value="11"<?php if(substr($row_wp['endDate'],5,2) == '11'){ echo 'selected';};?>> November	</option>
                          <option value="12"<?php if(substr($row_wp['endDate'],5,2) == '12'){ echo 'selected';};?>> December	</option>
                        </select>
                        <select name="endyear" class='form-control1'> 
                          <option  value="">Year</option>
                          <?php for($i=1950;$i<=date('Y');$i++) { ?>
                          <option value="<?php echo $i; ?>"<?php if(substr($row_wp['endDate'],0,4) == $i){ echo 'selected';};?> >
                          <?php echo  $i;} ?>
                        </select>
                   </span>
                   		<input type="submit" value="Save" class="btn btn-primary btn-sm search_btn" >
                        <a href="javascript:void(0);" class="btn btn-primary btn-sm search_btn click_cancel" >Cancel</a>
                  </li>
                  </form>
                </ul>
            </div>
        </div>
   
    <?php } ?>  
         
            		
	<?php  // filter batch
    if($action=='filter_batch'){
        $filter=$_REQUEST['filter'];
        $reqid=$_REQUEST['reqid'];
        if($filter=='college'){$filterby="instituteName='".$user['instituteName']."' " ;}
        else if($filter=='stream'){$filterby="branchName='".$user['branchName']."' " ;}
        else if($filter=='batch'){$filterby="YEAR(joinDate)=YEAR('".$user['joinDate']."') " ;}

        $sql_batch_mates=mysqli_query($dbconfig,"SELECT *,CONCAT(firstName,' ',lastName)AS name FROM users_edu AS e 
        LEFT JOIN users AS u USING (userID) WHERE $filterby AND userID!='".$reqid."' ");
        $count_batch_mates=mysqli_num_rows($sql_batch_mates);
    ?> 
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
                        <?php if($filter=='batch'){ echo date('Y',strtotime($row_batch_mates['joinDate']));} 
                        else if($filter=='stream'){ echo $row_batch_mates['branchName'];}
                        else if($filter=='college'){ echo $row_batch_mates['instituteName'];} ?> Batch
                    </small>
                </li>
                </a>
                <?php }} ?>
             </ul> 
          </div>
    
	<?php } ?>  
 
