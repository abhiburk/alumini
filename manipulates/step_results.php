<?php 
require '../config.php';
require '../includes/ImageManipulator.php';

$time=time();
$action = isset($_REQUEST['xAction']) ? htmlentities($_REQUEST['xAction']) : '';
//echo '<pre>'; print_r($_REQUEST); print_r($_FILES); die;


if($action=='search_friends'){
 $searchVal = ($_POST['searchVal']);
 
	$q=$conn->prepare("SELECT *,$name FROM users LEFT JOIN users_edu USING (userID)
	WHERE firstName LIKE :searchVal OR lastName LIKE :searchVal OR instituteName LIKE :searchVal");
    $q->bindValue(':searchVal','%'.$searchVal.'%'); 
    $q->execute();
  ?>
        <ul class="cute scroll2" style="width: 100%;">
        Search Result: 
        <?php echo '"'.$searchVal.'"'; while ($row_search = $q->fetch(PDO::FETCH_ASSOC)) {  ?>
           <li style="padding:0px;">
           <img src="<?php if($row_search['userImg']==''){echo 'images/default.jpg';}else {
                    echo 'uploads/'.$row_search['userImg']; } ?>" alt="User Avatar" class="recent_chat" style="margin-top: 15px;">
             <div class="user_info">
                <small><b><?php echo $row_search['name']; ?></b></small>
                <small class="grey1"><?php echo $row_search['instituteName']; ?></small>
             </div>  
             <a href="javascript:void(0);" rel="<?php echo $row_search['userID']; ?>" class="btn btn-default btn-sm" id="right_btn"><i class="icon-plus"></i> Add as Friend</a> 
             <hr>
           </li>
           <?php } ?>
         </ul>
         
<?php 
exit; }
 

// for fetching courses 
if(isset($_POST['get_option']))

{
$courseName = $_POST['get_option'];
$sql=mysqli_query($dbconfig,"SELECT * FROM courses LEFT JOIN branches ON courses.courseID=branches.courseID WHERE courses.courseName='".$courseName."'");
$sql>0;
$countSearch=mysqli_num_rows($sql);
while($row=mysqli_fetch_assoc($sql)) 
{  ?>
<option><?php echo $row['branchName']; ?></option>
<?php } ?>
<option>Other</option>
<?php  exit;

}

?>