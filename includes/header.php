<?php 
if(isset($userid)==true){
if($userid==''){
header('location:index.php');	
	}
else if($user['verificationCode']!='verified') {
	header('location:verify.php?unvarified=1');
}}
?>	
<div id="contact_ask_success"></div>
<div id="email_ask_success"></div>
<div id="success"></div>
    
<!--Throw Message-->
<?php if(isset($_GET['emptypost'])== '1') {  
$gname=htmlentities($_REQUEST['gname']); ?>
<div id="slideDown" class="floating_message_red">
    <h5>Post cannot be empty</h5>
</div><?php } ?>
<?php if(isset($_GET['groupname'])== 'na') {  
$gname=htmlentities($_REQUEST['gname']); ?>
<div id="slideDown" class="floating_message_red">
    <h5><b><?php echo $gname; ?></b> is not available.Please choose diffrent name</h5>
</div><?php } ?>
<?php if(isset($_GET['member'])== 'empty') {  ?>
<div id="slideDown" class="floating_message_red">
    <h5>Please select at least 1 member to add in the group</h5>
</div><?php } ?>
<?php if(isset($_GET['empty'])== 'groupname') {  ?>
<div id="slideDown" class="floating_message_red">
    <h5>Group name cannot be empty</h5>
</div><?php } ?>
<?php if(isset($_GET['emailnotValid'])== 1) {  ?>
<div id="slideDown" class="floating_message_red">
    <h5>Please enter a valid email address</h5>
</div><?php } ?>
<?php if(isset($_GET['alrdyReg'])== 1) {  ?>
<div id="slideDown" class="floating_message_red">
    <h5>Email address already register to our system</h5>
</div><?php } ?>
<?php if(isset($_GET['shortPass'])== 1) {  ?>
<div id="slideDown" class="floating_message_red">
    <h5>Entered password is less then 7 character, please enter 8 or more than 8 characters</h5>
</div><?php } ?>
<?php if(isset($_GET['createSuccess'])== 1) {  ?>
<div id="slideDown" class="floating_message_red">
    <h5>Account created succesfully.</h5>
</div><?php } ?>
<?php if(isset($_GET['notReg'])== 1) {  ?>
<div id="slideDown" class="floating_message_red">
    <h5>Incorrect Email or Password.</h5>
</div><?php } ?>
<audio id="chat_sound">
    <source src="assets/audio/all-eyes-on-me.mp3" type="audio/mp3" preload="auto">
    <source src="assets/audio/all-eyes-on-me.ogg" type="audio/ogg" preload="auto">
    Your browser isn't invited for super fun audio time.
</audio>
<script>
var sound_notification = $("#chat_sound")[0];

</script>       
<div class="top-menu" style="position: fixed;z-index: 1;width: 100%;top: 0;"> <!--<span class="menu"> 
<img src="assets/images/menu.png" alt=""> </span>-->
	
		<ul class="menu_head">
		<?php if(isset($userid)!=true){ ?>
           <li><h3>alumnai</h3></li>
         <?php }else if(isset($userid)==true){  ?>
     	<!--menu for login users-->
         <li class="search_input">
            <form action="search.php" method="get">
                <span class="inline-display">
                <input type="text" name="searchVal" autocomplete="off" value="<?php echo $search; ?>" class="form-control-search" placeholder="Search Here" />
                <input type="submit" class="btn btn-primary btn-sm search_btn" value="Search" />
                </span>
            </form>
         </li> 

       <span class="text-menu">
        <li>
            <a <?php if(basename($_SERVER['SCRIPT_NAME'])=='home.php'){ ?> class="active" <?php } ?> href="home.php">
                <i class="icon-home"></i> Home
            </a>
        </li>
        <span class="user_profile_menu">
        <li>
            <a href="javascript:void(0);" class="click_profile_menu">
                <i class="icon-user"></i> Profile
            </a>
        </li></span>
         <li>
            <a <?php if(basename($_SERVER['SCRIPT_NAME'])=='notification.php'){ ?> class="active" <?php } ?> href="notification.php">
            <?php 
            $sql_unread=mysqli_query($dbconfig,"SELECT * FROM notifications WHERE `read`='0' AND notiTo='".$userid."'") or die(mysqli_error($dbconfig));
            $count_noti=mysqli_num_rows($sql_unread);
            ?>
            <i class="icon-bell"></i> Notication <?php if($count_noti!='0') 
            { echo'<span class="label label-danger">'.$count_noti.'</span>'; }  ?>
            </a>
          </li>
          <li>
            <a href="authentication/logout.php"><i class="icon-signout"></i> Logout</a>
          </li>
       </span>
      <?php } ?>
      </ul>
    </div>
    <div id="result"></div>
<!--script for menu--> 
<script>
    $("span.menu").click(function(){
    $(".top-menu ul").slideToggle(500, function(){
    });
  });
</script>
<script>
    $(document).ready(function(){
    $("#slideDown ,#success").hide();
    $("#slideDown ,#success").slideDown(500);
    $("#slideDown ,#success").delay(5000);
    $("#slideDown ,#success").slideUp(1000);
    return false;	
});
</script> 
<!--script for menu-->

 <?php 
	function humanTiming ($time)
	{
		$time = time() - $time; // to get the time since that moment
		$time = ($time<1)? 1 : $time;
		$tokens = array (
			31536000 => 'year',
			2592000 => 'month',
			604800 => 'week',
			86400 => 'day',
			3600 => 'hr',
			60 => 'min',
			1 => 'sec'
	);
	foreach ($tokens as $unit => $text) {
		if ($time < $unit) continue;
		$numberOfUnits = floor($time / $unit);
		return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
	}
}		
	?>
<!--<img class="loader loading" src="images/spinner.gif">
<script>
    $(document).ajaxStart(function() {
        $(".loading").css("display","block");
        $("html").css("opacity" ,"0.4")
        $("html").css("background", "#6b6b6b")

    });
    $(document).ajaxComplete(function(event, XMLHttpRequest, ajaxOptions) {
         $(".loading").css("display","none");
         $("html").css("opacity" ,"unset")
         $("html").css("background", "")
    });
</script>-->       