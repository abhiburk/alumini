<?php include '../config.php'; 
$search = isset($_REQUEST['searchVal']) ? htmlentities($_REQUEST['searchVal']) : '';
?>
    		
        	 		<?php    
                    $q=$conn->prepare("
					SELECT * FROM (SELECT userImg as one,instituteName as two,u.userID as id,$name,'users_table' AS comes_from FROM users AS u 
					LEFT JOIN users_edu AS e USING (userID)
					WHERE (firstName LIKE :search OR lastName LIKE :search OR instituteName LIKE :search) AND u.userID!='".$userid."'
					UNION
					SELECT eventImg as one,eventDate as two,eventID as id,eventName as name,'user_events_table' AS comes_from FROM user_events
					WHERE eventName LIKE :search OR eventDetails LIKE :search OR eventLocation LIKE :search OR eventDate LIKE :search
					UNION
					SELECT groupImg as one,createTime as two,groupID as id,groupName as name,'user_groups_table' AS comes_from FROM user_groups 
					WHERE groupName LIKE :search 
					UNION 
					SELECT tittle as one,fq.createTime as two,fqID as id,$name,'forum_questions' AS comes_from FROM forum_questions AS fq 
					LEFT JOIN users AS u USING (userID)
					WHERE tittle LIKE :search OR description LIKE :search
					)x ORDER BY name ASC
					");
					$q->bindValue(':search','%'.$search.'%'); 
					$q->execute();
					$count=$q->rowCount();
                    ?>
                    <div class="white-area"><h5>
                        <a href="javascript:void(0);" rel="people" data-search="<?php echo $search; ?>" class="click_searchBy">People</a> | 
                        <a href="javascript:void(0);" rel="event" data-search="<?php echo $search; ?>" class="click_searchBy">Event</a> | 
                        <a href="javascript:void(0);" rel="group" data-search="<?php echo $search; ?>" class="click_searchBy">Group </a> |
                        <a href="javascript:void(0);" rel="question" data-search="<?php echo $search; ?>" class="click_searchBy">Question </a></h5>
                    </div>
           	 		<div class="profile_container"> 
                    	 <div id="show_search"></div>
                         <ul class="cute <?php if($count>6 and $search!=''){echo 'scroll';} ?>" id="default_search" style="width: 100%;">
                                <li><?php if($search==''){echo 'Search Result: Empty search value';}else { ?></li>
                                <li>Search Result: <?php echo '<b>"'.$search.'"</b></li><hr>'; 
                                if($count==''){echo 'No record found';}{
                                    
                                while ($row_search = $q->fetch(PDO::FETCH_ASSOC)) { //echo $row_search['comes_from'];  ?>
                                
                                <!--For People-->  
								<?php if($row_search['comes_from']=='users_table'){
								//cheching if frnd req is sent   
                                $sql_req_sent=mysqli_query($dbconfig,"SELECT * FROM friend_request
                                WHERE friendWith='".$row_search['id']."' AND userID='".$userid."'") or die(mysqli_error($dbconfig));
                                $check_req_sent=mysqli_num_rows($sql_req_sent);
                                $check_req_sent = isset($check_req_sent) ? htmlentities($check_req_sent) : '';
                                //checking if are friends
                                $sql_my_frnds=mysqli_query($dbconfig,"SELECT * FROM my_friends
                                WHERE userID='".$row_search['id']."' AND friendWith='".$userid."' or 
                                friendWith='".$row_search['id']."' AND userID='".$userid."'") or die(mysqli_error($dbconfig));
                                $row_my_frnds=mysqli_fetch_assoc($sql_my_frnds);
                                $check_my_frnd=mysqli_num_rows($sql_my_frnds);
                                $check_my_frnd = isset($check_my_frnd) ? htmlentities($check_my_frnd) : '';
                                ?>
                                    
                                <li style="padding:0px;">
                                         <img src="<?php if($row_search['one']==''){echo 'images/default.jpg';}else {
                                         echo 'uploads/'.$row_search['one']; } ?>" alt="User Avatar" class="recent_chat" style="margin-top: 10px;">
                                         <div class="user_info">
                                            <small><b><a href="user/<?php echo ''.$row_search["id"].'';?>"><?php echo $row_search['name']; ?></a></b></small>
                                            <small class="grey1"><?php echo $row_search['two']; ?></small>
                                         </div>
                                         <?php //check if frnd req sent
                                         if($check_req_sent==true){  ?> 
                                         <span id="right_btn" class="btn btn-default btn-sm"><i class="icon-ok"></i> Sent</span> <?php }
                                         //check if already driends
                                         else if($check_my_frnd==true) {
                                         echo '<span id="right_btn" class="btn btn-default btn-sm"><i class="icon-ok"></i> Friends</span>';		 
                                         //else show add friend button
                                         }else { ?>
                                          <div id="right_btn"><span id="req_sent<?php echo $row_search['id']; ?>"></span> </div>
                                          <span id="add_frnd<?php echo $row_search['id']; ?>">
                                         <a href="javascript:void(0);" rel="<?php echo $row_search['id']; ?>" class="click_add_friend btn btn-default btn-sm" id="right_btn"><i class="icon-plus"></i> Add as Friend</a> 
                                         </span>
                                         <?php } ?>
                                         <hr>
                                   </li>
                               
                                <?php } ?>
                                
                                <?php if($row_search['comes_from']=='user_events_table') { 

								//checking status
								$sql_check_if_req=mysqli_query($dbconfig,"SELECT * FROM event_status 
								WHERE userID='".$userid."' AND eventID='".$row_search['id']."'");
								$row_status=mysqli_fetch_assoc($sql_check_if_req);
								?>
                                <!--For Event-->
							   <li style="padding:0px;">
								  <img src="<?php if($row_search['one']==''){echo 'images/event.jpg';}else {
								  echo 'uploads/'.$row_search['one']; } ?>" alt="Avatar" class="recent_chat" style="margin-top: 10px;">
								  <div class="user_info">
									<small><b><a href="event/<?php echo $row_search['id']; ?>"><?php echo $row_search['name']; ?></a></b></small>
									<small class="grey1"><?php echo date('d-M-Y',strtotime($row_search['two'])); ?></small>
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

                                <?php } ?>
                                
                                <?php if($row_search['comes_from']=='user_groups_table') {

								//check if member	  
								$sql_access=mysqli_query($dbconfig,"SELECT * FROM user_groups AS g LEFT JOIN group_members USING (groupID)
								WHERE g.groupID='".$row_search['id']."' AND memberID='".$userid."' ") or die (mysqli_error($dbconfig));
								$check_access_of_group=mysqli_num_rows($sql_access);
								$check_access_of_group = isset($check_access_of_group) ? htmlentities($check_access_of_group) : '';
								?>
                                <!--For Group-->
							   <li style="padding:0px;">
								  <img src="<?php if($row_search['one']==''){echo 'images/group.jpg';}else {
								  echo 'uploads/'.$row_search['one']; } ?>" alt="Avatar" class="recent_chat" style="margin-top: 10px;">
								  <div class="user_info">
									<small><b><a href="group/<?php echo $row_search['id']; ?>"><?php echo $row_search['name']; ?></a></b></small>
								  </div>
								  <?php 
									 //check if member
									if($check_access_of_group==true) { 
									echo '<span id="right_btn" class="btn btn-default btn-sm"><i class="icon-ok"></i> Member</span>';  }
									?>
								 <hr>
							   </li>
                               
                              <?php } ?>  
                              <?php if($row_search['comes_from']=='forum_questions') {    

								$sql_question=mysqli_query($dbconfig,"SELECT * FROM forum_questions WHERE fqID='".$row_search['id']."'");
								$row_question=mysqli_fetch_assoc($sql_question);
								?>
                    
                                  <li style="display:flex; width:100%">
                                        <i class="icon-ok <?php if($row_question['answerAccepted']=='1'){echo 'ok_green';}else{echo 'ok_grey';} ?>"></i>
                                        <span class="inline_grid">
                                            <b><a href="question/<?php echo $row_search['id']; ?>/<?php echo urlencode($row_search['one']); ?>"><?php echo ($row_search['one']); ?></a></b>
                                            <small class="grey1">Asked by: 
                                            <a href="<?php echo 'user/'.$row_question["userID"].'';?>"><?php echo $row_search['name']; ?></a>  |
                                                <?php echo "" . humanTiming($row_search['two']). " ago"; ?>
                                            </small>
                                        </span>
                                  <hr></li>
								
							  <?php } ?> 
                               
                             <?php }}} ?>
                          </ul> 
				    </div>
              
        
