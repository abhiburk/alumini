<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Create Group <?php include 'includes/title.php'; ?></title>
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
    	<!--Create Group-->
        <div class="white-area"><h5>Create New Group</h5></div>
        <div class="hire-me">
            <ul class="cute">
              <li>
                <form action="addmembers.php" method="get">
                    <span class="inline-display">
                    <input type="text" name="gname" class="form-control-search" placeholder="Group Name" />
                    <input type="submit" class="btn btn-primary btn-sm search_btn" value="Create" />
                    </span>
                </form>
        	  </li> 
            </ul> 
        </div><div class="div-title"></div>
        
        <!--Suggested Groups-->
        <div class="white-area"><h5>Suggested Groups </h5></div>
        <div class="profile_container">
            <ul class="listing">
            <?php 
			$sql=mysqli_query($dbconfig,"SELECT * FROM  user_groups WHERE NOT EXISTS (SELECT * FROM group_members 
			WHERE group_members.groupID=user_groups.groupID AND memberID='".$userid."')  ");
			$count=mysqli_num_rows($sql);
			$count = isset($count) ? htmlentities($count) : '';
			if($count==''){echo '<h5 class="invite1 grey1">No Groups Available</h5>';}else{
			while($row=mysqli_fetch_assoc($sql)){
				
					$sql_count=mysqli_query($dbconfig,"SELECT memberID FROM group_members WHERE groupID='".$row['groupID']."'");
					$count_members=mysqli_num_rows($sql_count);
					$count_members = isset($count_members) ? htmlentities($count_members) : '';
			?>
              <a href="group/<?php echo $row['groupID']; ?>">
                  <li class="subitem_grey" style="padding:5px; "> 
                        <img src="<?php if($row['groupImg']==''){echo 'images/group.jpg';}else {
                        echo 'uploads/'.$row['groupImg']; } ?>" alt="User Avatar" class="recent_chat">
                      <small class=""> 
                        <?php echo $row['groupName']; ?>
                      </small>
                      <small id="right_btn">
                        <?php echo $count_members; ?> Members
                      </small>
                  </li>
              </a> 
             <?php } }?>
             </ul> 
        </div>
        
    </div><!--end col-md-4 grid_2-->
    
    <div class="col-md-3 grid_2">
    	<!--My Groups-->
        <div class="white-area"><h5>My Groups</h5></div>
        <div class="profile_container">
            <ul class="listing">
            <?php 
			$sql_group=mysqli_query($dbconfig,"SELECT * FROM user_groups LEFT JOIN group_members USING (groupID)
			WHERE memberID='".$userid."' ");
			$check_groups=mysqli_num_rows($sql_group);
			$check_groups = isset($check_groups) ? $check_groups : '';
			if($check_groups==0){echo '<h5 class="invite1 grey1">Not a member in any group</h5>';}else{
			while($row_group=mysqli_fetch_assoc($sql_group)){
				
				$sql_count=mysqli_query($dbconfig,"SELECT memberID FROM group_members WHERE groupID='".$row_group['groupID']."'");
				$count_members=mysqli_num_rows($sql_count);
				$count_members = isset($count_members) ? $count_members : '';
			?>
              <a href="group/<?php echo $row_group['groupID']; ?>">
                  <li class="subitem_grey" style="padding:5px; "> 
                        <img src="<?php if($row_group['groupImg']==''){echo 'images/group.jpg';}else {
                        echo 'uploads/	'.$row_group['groupImg']; } ?>" alt="User Avatar" class="recent_chat">
                      <small id="break_inline"> 
                        <?php echo $row_group['groupName']; ?>
                      </small>
                      <small id="right_btn">
                        <?php echo $count_members; ?> Members
                      </small>
                  </li>
              </a> 
             <?php }} ?>
             </ul> 
        </div>
        
    </div><!--end col-md-3 grid_2-->
   

    <?php include 'includes/right_panel.php'; ?>
<!--Container Ends Here-->
<div class="clearfix"></div>
</div>
<script src="assets/js/myscript.js"></script>
<script src="assets/js/ajax_load.js"></script>
</div>
</body>
</html>