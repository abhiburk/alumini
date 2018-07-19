<?php include 'config.php'; 

$search_mem = isset($_REQUEST['search_mem']) ? htmlentities($_REQUEST['search_mem']) : '';
$gname = isset($_REQUEST['gname']) ? htmlentities($_REQUEST['gname']) : '';
$gid = isset($_REQUEST['gid']) ? htmlentities($_REQUEST['gid']) : '';

//if group name and group id is empty 
if($gid=='' and $gname==''){
header('location:creategroup.php?empty=groupname');exit;
}
//checking if group name is available
$sql_check_gname=mysqli_query($dbconfig,"SELECT groupName FROM user_groups WHERE groupName='".$gname."' ")or die (mysqli_error($dbconfig));
$check_available=mysqli_num_rows($sql_check_gname);
$check_available = isset($check_available) ? htmlentities($check_available) : '';
if($check_available==true){
header('location:creategroup.php?groupname=na&gname='.$gname.'');exit;	
	}
	
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
?>
<!DOCTYPE html>
<html>
<head>
<title>Add Members <?php include 'includes/title.php'; ?></title>
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
    <div class="col-md-5 grid_2">
        <div class="white-area"><h5>Add Friends to Group</h5></div>
        <div class="hire-me">
            <ul class="cute">
            
              <!--Search Form-->
              <li>
                <form action="addmembers.php" method="get">
                <?php if($gid==''){ ?>
                <input type="hidden" name="gname" value="<?php echo $gname; ?>"> <?php }else { ?>
                <input type="hidden" name="gid" value="<?php echo $gid; ?>"><?php } ?>
                    <span class="inline-display">
                    <input type="text" name="search_mem" class="form-control-search" placeholder="Search Member" />
                    <input type="submit" class="btn btn-primary btn-sm search_btn" value="Search" />
                    </span>
                </form>
        	  </li>
              
               <form action="manipulates/manipulate.php" method="POST">
                <input type="hidden" name="xAction" value="add_members_grp">
                <?php if($gid==''){ ?>
                <input type="hidden" name="memberID[]" value="<?php echo $userid; ?>">
                <input type="hidden" name="gname" value="<?php echo $gname; ?>"> <?php }else { ?>
                <input type="hidden" name="gid" value="<?php echo $gid; ?>">
				<?php } ?>
                
              <?php if($search_mem!=''){ ?>
              <li><hr><h5 class="grey">Search Members</h5></li>
              <li>
                   <?php
				    $sql=$conn->prepare("SELECT *,$name FROM users WHERE (firstName LIKE :search_mem OR lastName LIKE :search_mem) AND userID!=".$userid." ");
					$sql->bindValue(':search_mem','%'.$search_mem.'%'); 
					$sql->execute();
					$sql>0;
					while($row_search_members=$sql->fetch(PDO::FETCH_ASSOC)) { 
					//checking if already a member of the group
					$sql_mem_already=mysqli_query($dbconfig,"SELECT * FROM group_members WHERE groupID='".$gid."' AND memberID=".$row_search_members['userID']." ");
					$check_member=mysqli_num_rows($sql_mem_already);
					$check_member = isset($check_member) ? htmlentities($check_member) : '';
					if($check_member!=true){
				   ?>
                   <span style="display:block">
                   <input type="checkbox" name="memberID[]" value="<?php echo $row_search_members['userID'];?>" class="form-control2" > 
				   <?php echo $row_search_members['name']; ?>
                   </span>
                   <?php }} ?>
        	  </li>
              <?php } ?>
              <li><hr><h5 class="grey">Suggested Members</h5></li>
              <li>
                   <?php 
				   $sql_members=mysqli_query($dbconfig,"SELECT *,$name FROM users WHERE userID!=".$userid." ORDER BY RAND()");
				   while($row_members=mysqli_fetch_assoc($sql_members)){
					//checking if already a member of the group
					$sql_mem_already=mysqli_query($dbconfig,"SELECT * FROM group_members WHERE groupID='".$gid."' AND memberID=".$row_members['userID']." ");
					$check_member=mysqli_num_rows($sql_mem_already);
					$check_member = isset($check_member) ? htmlentities($check_member) : '';
					if($check_member!=true){	   
				   ?>
                   <span style="display:block">
                   <input type="checkbox" name="memberID[]" value="<?php echo $row_members['userID'];?>" class="form-control2" >
                    <?php echo $row_members['name']; ?>
                   </span>
                   <?php }} ?>
                  <input type="submit" class="btn btn-primary btn-sm search_btn" value="Add Selected" style="float:right" />
                </form><br><br>
        	  </li> 
              
             </ul> 
        </div>
    </div>
    
    <div class="col-md-2 grid_2">
        <div class="white-area"><h5>Notifications</h5></div>
        <div class="hire-me">
            <ul class="cute">
              <li class="create_group"> 
                <small class="grey"> </small>
              </li>
             </ul> 
        </div>
    </div>
   
    <?php include 'includes/right_panel.php'; ?>

<!--Container Ends Here-->
<div class="clearfix"></div>
</div>
<script src="assets/js/myscript.js"></script>
<script src="assets/my-js/group_action.js"></script>
</div>
</body>
</html>