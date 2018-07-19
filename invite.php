<?php include 'config.php'; 
$search_mem = isset($_REQUEST['search_mem']) ? htmlentities($_REQUEST['search_mem']) : '';
$view = isset($_REQUEST['view']) ? htmlentities($_REQUEST['view']) : '';
$eid = isset($_REQUEST['eid']) ? htmlentities($_REQUEST['eid']) : '';

if($view=='event'){ // for event invitation
	if($eid==''){ 
	$sql_last_event=mysqli_query($dbconfig,"SELECT * FROM user_events WHERE userID='".$userid."' ORDER BY eventID DESC LIMIT 1");
	$row_last_event=mysqli_fetch_assoc($sql_last_event);
	$eid=$row_last_event['eventID'];
	}else{
	$sql_last_event=mysqli_query($dbconfig,"SELECT * FROM user_events WHERE eventID='".$eid."'");
	$row_last_event=mysqli_fetch_assoc($sql_last_event);
	$eid=$row_last_event['eventID'];	
	}
	//if eventid is empty
	if($eid==''){ 
	include 'includes/error.php'; 
	}
	
}else if($view==''){ include 'includes/error.php'; }

if($view=='group'){ // for group invitation
	$gid = isset($_REQUEST['gid']) ? htmlentities($_REQUEST['gid']) : '';
	//fetching group info
	$sql_group=mysqli_query($dbconfig,"SELECT * FROM user_groups WHERE groupID='".$gid."' ")or die (mysqli_error($dbconfig));
	$row_group=mysqli_fetch_assoc($sql_group);
	
	//checking access of the user to the group	
	if($gid!=''){
	$sql_access=mysqli_query($dbconfig,"SELECT * FROM user_groups AS g LEFT JOIN group_members USING (groupID)
	WHERE g.groupID=".$gid." AND memberID='".$userid."' ") or die (mysqli_error($dbconfig));
	$check_access_of_group=mysqli_num_rows($sql_access);
	$check_access_of_group = isset($check_access_of_group) ? htmlentities($check_access_of_group) : '';
	if($check_access_of_group==''){
		 include 'includes/error.php'; 
		}
	}
}else if($view==''){  include 'includes/error.php';  }
?>
<!DOCTYPE html>
<html>
<head>
<title>Invite <?php include 'includes/title.php'; ?></title>
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
    
    <?php if($view=='group'){ // for group invitation  ?>
    
        <div class="col-md-4 grid_2">
        
            <div class="white-area"><h5>Invite Friends to <?php echo $row_group['groupName']; ?></h5></div>
            <div class="hire-me">
                <ul class="cute">
                
                  <!--Search Form-->
                  <li>
                    <form action="invite.php" method="get">
                    <input type="hidden" name="gid" value="<?php echo $gid; ?>">
                        <span class="inline-display">
                        <input type="text" name="search_mem" class="form-control-search" placeholder="Search Member" />
                        <input type="submit" class="btn btn-primary btn-sm search_btn" value="Search" />
                        </span>
                    </form>
                  </li>
                  
                  <!--Search Members-->
                  <?php if($search_mem!=''){ ?>
                  <li><hr><h5 class="grey">Search Members</h5></li>
                       <?php
                        $sql=$conn->prepare("SELECT *,$name FROM users WHERE (firstName LIKE :search_mem OR lastName LIKE :search_mem) AND userID!=".$userid." ");
                        $sql->bindValue(':search_mem','%'.$search_mem.'%'); 
                        $sql->execute();
                        $sql>0;
                        while($row_search_members=$sql->fetch(PDO::FETCH_ASSOC)) { 
                        //counting no of groups person member of   
                        $sql_no_of_groups=mysqli_query($dbconfig,"SELECT * FROM group_members WHERE memberID=".$row_search_members['userID']." ");
                        $check_no_of_groups=mysqli_num_rows($sql_no_of_groups);
						$check_no_of_groups = isset($check_no_of_groups) ? htmlentities($check_no_of_groups) : '';
                        
                        //checking if already a member of the group
                        $sql_mem_already=mysqli_query($dbconfig,"SELECT * FROM group_members WHERE groupID='".$gid."' AND memberID=".$row_search_members['userID']." ");
                        $check_member=mysqli_num_rows($sql_mem_already);
						$check_member = isset($check_member) ? htmlentities($check_member) : '';
                        if($check_member!=true){
                       ?>
                  <li class="" style="padding:5px; border-bottom:1px solid #f0f0f0; "> 
                            <a href="<?php if($row_search_members['webName']==''){echo 'user/'.$row_search_members["userID"].'';}else{ echo 'user/'.$row_search_members["webName"].'';}  ?>">
                                <img src="<?php if($row_search_members['userImg']==''){echo 'images/default.jpg';}else {
                                echo 'uploads/'.$row_search_members['userImg']; } ?>" alt="User Avatar" class="recent_chat">
                                <small class="" style="margin-left: 5px;"> 
                                    <?php echo $row_search_members['name']; ?>
                                </small>
                             </a>   
                             
                            <small class="about" id="right_btn">
                                <small class="grey">Member of <?php echo $check_no_of_groups; ?> Groups </small> |
                                <!-- Invite-->
                                <a href="javascript:void(0);" rel="<?php echo $row_search_members['userID'] ?>" data-gid="<?php echo $gid; ?>"  class="group_invite grey invite">
                                <span id="approve<?php echo $row_search_members['userID'] ?>"></span> <span id="approve_mem<?php echo $row_search_members['userID'] ?>">
                                <i class="icon-gift"></i> Invite</span></a> 
                            </small>
                  </li>
                       <?php }}} ?>
                  <li><hr><h5 class="grey1">Suggested Friends</h5></li>
    
                        <?php 
                        $sql_members=mysqli_query($dbconfig,"SELECT *,$name FROM users WHERE userID!=".$userid." ORDER BY RAND()");
                        while($row_members=mysqli_fetch_assoc($sql_members)){
                        //counting no of groups person member of   
                        $sql_no_of_groups=mysqli_query($dbconfig,"SELECT * FROM group_members WHERE memberID=".$row_members['userID']." ");
                        $check_no_of_groups=mysqli_num_rows($sql_no_of_groups);
                        $check_no_of_groups = isset($check_no_of_groups) ? htmlentities($check_no_of_groups) : '';
						  
                        //checking if already a member of the group
                        $sql_mem_already=mysqli_query($dbconfig,"SELECT * FROM group_members AS m LEFT JOIN invitation AS i ON m.groupID=i.referenceID
                        WHERE m.groupID='".$gid."' AND (memberID=".$row_members['userID']."  OR (inviteTo=".$row_members['userID']."  AND type='group.invite'))
                       ") or die (mysqli_error($dbconfig)) ;
                        $check_member=mysqli_num_rows($sql_mem_already);
						$check_member = isset($check_member) ? htmlentities($check_member) : '';
                        if($check_member!=true){	   
                        ?>
                   <li class="" style="padding:5px; border-bottom:1px solid #f0f0f0; "> 
                            <a href="<?php if($row_members['webName']==''){echo 'user/'.$row_members["userID"].'';}else{ echo 'user/'.$row_members["webName"].'';}  ?>">
                                <img src="<?php if($row_members['userImg']==''){echo 'images/default.jpg';}else {
                                echo 'uploads/'.$row_members['userImg']; } ?>" alt="User Avatar" class="recent_chat">
                                <small class="" style="margin-left: 5px;"> 
                                    <?php echo $row_members['name']; ?>
                                </small>
                             </a>   
                             
                            <small class="about" id="right_btn">
                                <small class="grey1">Member of <?php echo $check_no_of_groups; ?> Groups </small> |
                                <!-- Invite-->
                                <a href="javascript:void(0);" rel="<?php echo $row_members['userID'] ?>" data-gid="<?php echo $gid; ?>" class="click_group_invite grey invite">
                                <span id="invited<?php echo $row_members['userID'] ?>"></span> <span id="hide_invite<?php echo $row_members['userID'] ?>">
                                <i class="icon-gift"></i> Invite</span></a> 
                            </small>
                    </li>
                          <?php }} ?>
                 </ul> 
            </div>
            
        </div><!--end col-md-4 grid_2-->
        
        
        
        <div class="col-md-3 grid_2">
        	<!--Invited People to group-->
            <div class="white-area"><h5><small>Invited Friend to <b><?php echo $row_group['groupName']; ?></b></small></h5></div>
            <div class=" profile_container">
                <ul class="cute">
                    <?php 
                    $sql_invited_people=mysqli_query($dbconfig,"SELECT * FROM invitation AS i LEFT JOIN users AS u ON i.inviteTo=u.userID
                    WHERE referenceID='".$gid."'AND type='group.invite' ");
                    $check_if_people=mysqli_num_rows($sql_invited_people);
					$check_if_people = isset($check_if_people) ? htmlentities($check_if_people) : '';
                    if($check_if_people==''){echo '<h5 class="invite1 grey1">No Invitation sent</h5>';}else{
                    while($row_invited_people=mysqli_fetch_assoc($sql_invited_people)){
                    ?>
                         <li class="about"> 
                            <a href="user/<?php echo $row_invited_people['userID']; ?>">
                                <img src="<?php if($row_invited_people['userImg']==''){echo 'images/default.jpg';}else {
                                echo 'uploads/'.$row_invited_people['userImg']; } ?>" alt="User Avatar" class="recent_chat">
                                <small class="" style="margin-left: 5px;"> 
                                    <?php echo $row_invited_people['firstName']; ?>
                                    <?php echo $row_invited_people['lastName']; ?>
                                </small>
                             </a>   
                             
                            <small class="about" id="right_btn">
                                <a href="javascript:void(0);" rel="<?php echo $row_invited_people['inviteID'] ?>" class="click_cancel_ginvite">
                                <span id="cancelled<?php echo $row_invited_people['inviteID'] ?>"></span> <span id="hide_cancel<?php echo $row_invited_people['inviteID'] ?>">
                                <i class="icon-remove"></i> Cancel</span></a> 
                            </small>
                         </li>
                    <?php }} ?> 
                 </ul> 
            </div>
            
        </div><!--end col-md-3 grid_2-->
    
   <?php }  ?>
   
   <?php if($view=='event'){ // for event invitation  ?>
    
        <div class="col-md-4 grid_2">
            <!--Invited People to event+Form-->
            <div class="white-area"><h5>Invite People to <?php echo $row_last_event['eventName']; ?></h5></div>
            <div class="hire-me">
                <ul class="cute">
                
                  <!--Search Form-->
                  <li>
                    <form action="invite.php" method="get">
                    <input type="hidden" name="view" value="<?php echo $view; ?>">
                        <span class="inline-display">
                        <input type="text" name="search_mem" class="form-control-search" placeholder="Search Member" />
                        <input type="submit" class="btn btn-primary btn-sm search_btn" value="Search" />
                        </span>
                    </form>
                  </li>
                  
                  <?php if($search_mem!=''){ ?>
                  <li><hr><h5 class="grey">Search Members</h5></li>
                       <?php
                        $sql=$conn->prepare("SELECT *,$name FROM users WHERE (firstName LIKE :search_mem OR lastName LIKE :search_mem) AND userID!=".$userid." ");
                        $sql->bindValue(':search_mem','%'.$search_mem.'%'); 
                        $sql->execute();
                        $sql>0;
                        while($row_search_members=$sql->fetch(PDO::FETCH_ASSOC)) { 
                        //checking if already a member of the group
                        $sql_mem_already=mysqli_query($dbconfig,"SELECT * FROM invitation WHERE inviteTo=".$row_search_members['userID']."
                        AND type='event.invite' AND referenceID='".$eid."' ") or die (mysqli_error($dbconfig)) ;
                        $check_member=mysqli_num_rows($sql_mem_already);
						$check_member = isset($check_member) ? htmlentities($check_member) : '';
                        if($check_member!=true){	
                       ?>
                   <li class="" style="padding:5px; border-bottom:1px solid #f0f0f0; "> 
                            <a href="<?php if($row_search_members['webName']==''){echo 'user/'.$row_search_members["userID"].'';}else{ echo 'user/'.$row_search_members["webName"].'';}  ?>">
                                <img src="<?php if($row_search_members['userImg']==''){echo 'images/default.jpg';}else {
                                echo 'uploads/'.$row_search_members['userImg']; } ?>" alt="User Avatar" class="recent_chat">
                                <small class="" style="margin-left: 5px;"> 
                                    <?php echo $row_search_members['name']; ?>
                                </small>
                             </a>   
                             
                            <small id="right_btn">
                                <!-- Invite-->
                                <a href="javascript:void(0);" rel="<?php echo $row_search_members['userID'] ?>" data-eid="<?php echo $eid; ?>" class="click_event_invite grey invite">
                                <span id="invited<?php echo $row_search_members['userID'] ?>"></span> <span id="hide_invite<?php echo $row_search_members['userID'] ?>">
                                <i class="icon-gift"></i> Invite</span></a> 
                            </small>
                    </li>
                       <?php }}} ?>
                  <li><hr><h5 class="grey1">Suggested Friends</h5></li>
    
                        <?php 
                        $sql_members=mysqli_query($dbconfig,"SELECT *,$name FROM users WHERE userID!=".$userid." ORDER BY RAND()");
                        while($row_members=mysqli_fetch_assoc($sql_members)){
                          
                        //checking if already a sent invitation 
                        $sql_mem_already=mysqli_query($dbconfig,"SELECT * FROM invitation WHERE inviteTo=".$row_members['userID']."
                        AND type='event.invite' AND referenceID='".$eid."' ") or die (mysqli_error($dbconfig)) ;
                        $check_member=mysqli_num_rows($sql_mem_already);
						$check_member = isset($check_member) ? htmlentities($check_member) : '';
                        if($check_member!=true){	   
                        ?>
                   <li class="" style="padding:5px; border-bottom:1px solid #f0f0f0; "> 
                            <a href="<?php if($row_members['webName']==''){echo 'user/'.$row_members["userID"].'';}else{ echo 'user/'.$row_members["webName"].'';}  ?>">
                                <img src="<?php if($row_members['userImg']==''){echo 'images/default.jpg';}else {
                                echo 'uploads/'.$row_members['userImg']; } ?>" alt="User Avatar" class="recent_chat">
                                <small class="" style="margin-left: 5px;"> 
                                    <?php echo $row_members['name']; ?>
                                </small>
                             </a>   
                             
                            <small id="right_btn">
                                <!-- Invite-->
                                <a href="javascript:void(0);" rel="<?php echo $row_members['userID'] ?>" data-eid="<?php echo $eid; ?>" class="click_event_invite grey invite">
                                <span id="invited<?php echo $row_members['userID'] ?>"></span> <span id="hide_invite<?php echo $row_members['userID'] ?>">
                                <i class="icon-gift"></i> Invite</span></a> 
                            </small>
                    </li>
                          <?php }} ?>
                    <li><small><a href="event/<?php echo $row_last_event['eventID']; ?>" class="">Skip</a></small></li>      
                 </ul> 
            </div>
            
        </div><!--end col-md-4 grid_2-->
        
        
        
        <div class="col-md-3 grid_2">
        	<!--Invited People to event-->
            <div class="white-area"><h5><small>Invited People to <b><?php echo $row_last_event['eventName']; ?></b></small></h5></div>
            <div class=" profile_container">
                <ul class="cute">
                    <?php 
                    $sql_invited_people=mysqli_query($dbconfig,"SELECT *,$name FROM invitation AS i LEFT JOIN users AS u ON i.inviteTo=u.userID
                    WHERE referenceID='".$eid."' AND type='event.invite' AND i.userID='".$userid."' ");
                    $check_if_people=mysqli_num_rows($sql_invited_people);
					$check_if_people = isset($check_if_people) ? htmlentities($check_if_people) : '';
                    if($check_if_people==''){echo '<h5 class="invite1 grey1">No Invitation sent</h5>';}else{
                    while($row_invited_people=mysqli_fetch_assoc($sql_invited_people)){
                    ?>
                         <li class="about"> 
                            <a href="<?php if($row_invited_people['webName']==''){echo 'user/'.$row_invited_people["userID"].'';}else{ echo 'user/'.$row_invited_people["webName"].'';}  ?>">
                                <img src="<?php if($row_invited_people['userImg']==''){echo 'images/default.jpg';}else {
                                echo 'uploads/'.$row_invited_people['userImg']; } ?>" alt="User Avatar" class="recent_chat">
                                <small class="" style="margin-left: 5px;"> 
                                    <?php echo $row_invited_people['name']; ?>
                                </small>
                             </a>   
                             
                            <small id="right_btn">
                                <a href="javascript:void(0);" rel="<?php echo $row_invited_people['inviteID'] ?>" class="click_cancel_ginvite">
                                <span id="cancelled<?php echo $row_invited_people['inviteID'] ?>"></span> <span id="hide_cancel<?php echo $row_invited_people['inviteID'] ?>">
                                <i class="icon-remove"></i> Cancel</span></a> 
                            </small>
                         </li>
                    <?php }} ?> 
                    	 
                 </ul> 
            </div>
            
        </div><!--end col-md-3 grid_2-->
    
   <?php }  ?>
   
    <?php include 'includes/right_panel.php'; ?>

<!--Container Ends Here-->
<div class="clearfix"></div>
</div>
<script src="assets/js/myscript.js"></script>
<script src="assets/my-js/invitation.js"></script>
</div>
</body>
</html>