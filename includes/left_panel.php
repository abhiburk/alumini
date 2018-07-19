<?php //include 'config.php'; 
if($userid==''){
header('location:index.php');	
	}
else if($user['verificationCode']!='verified') {
	header('location:verify.php?unvarified=1');
}
?>

<div class="col-md-2 grid_1" >
	<!--User Profile-->
   <div class="about text-center hide_profile_menu"> 
   
        <!--Uploading Profile Photo-->
        <form action="manipulates/update_profile_photo.php" method="post" enctype="multipart/form-data">
        	<input type="hidden" name="xAction" value="update_user_photo" />
            <input type="hidden" name="postType" value="user.photo">
            <input type="hidden" name="newsText" value="<?php if($user['gender']=='Male'){
			echo 'changed his profile photo'; }else{
			echo 'changed her profile photo';} ?>" />
            <input type="hidden" name="reference" value="user_id" />
            <input type="hidden" name="referenceID" value="<?php echo $user['userID'] ?>" />
            
            <div class="fileupload fileupload-new" data-provides="fileupload">
            	<img class="profile-img fileupload-new" src="<?php if($user['userImg']==''){echo 'images/default.jpg';}else {
            	echo 'uploads/'.$user['userImg']; } ?>" alt="" />
            	<div class="fileupload-preview fileupload-exists thumbnail profile-img" ></div>
                <span class="btn btn-file btn btn-default btn-xs ">
                    <span class="fileupload-new "><i class="icon-pencil"></i> Edit Photo</span>
                    <span class="fileupload-exists">Change</span>
                    <input type="file" name="userImg"/>
                </span>
                <!--<span class="fileupload-preview"></span>-->
                <a href="#" class=" fileupload-exists btn btn-default btn-xs" data-dismiss="fileupload" style="float: none">cancel</a>
                <input type="submit" class="btn btn-default btn-xs fileupload-exists" value="Save">
            </div>
        </form>
        
        
        <h4><?php echo $user['name']; ?></h4>
        <h4><small><?php if($user['webName']!=''){echo '@'; echo $user['webName'];} ?></small></h4><hr>
        <ul class="listing">
        
          <?php
		  	//total columns 
		  	$sql_total=mysqli_query($dbconfig,"SELECT firstName,lastName,webName,userImg,birthday,gender,userPhone,
			instituteName,courseName,branchName,joinDate,(passoutDate or currentlystudying)
			,companyName,position,startDate,(endDate or currentlyworking)
			FROM users LEFT JOIN users_edu USING (userID) LEFT JOIN user_workplace USING (userID) ");
			$row_total=mysqli_num_fields($sql_total);
			//echo $row_total;
			// filled columns
			$sql_fill=mysqli_query($dbconfig,"SELECT count(firstName)+count(lastName)+ count(webName)+count(userImg)+
			count(birthday)+count(gender)+count(userPhone)
			
			+count(instituteName)+count(courseName)+count(branchName)+count(joinDate)+(count(passoutDate) OR count(currentlystudying))
			
			+count(companyName)+count(position)+count(startDate)+(count(endDate) OR count(currentlyworking))
			FROM users AS u LEFT JOIN users_edu USING (userID) LEFT JOIN user_workplace AS wp USING (userID)
			WHERE u.userID='".$userid."' GROUP BY wp.workID");
			$row_fill=mysqli_fetch_assoc($sql_fill);
			$fill= implode($row_fill);

			$percentage=($fill*100)/$row_total;
			$percentage= round($percentage);
		  ?>
          <li>
          	<div class="progress progress-striped active">
				<div class="<?php if($percentage<'50'){ echo 'progress-bar progress-bar-danger';}
				if($percentage>='50' & $percentage<='75') {echo 'progress-bar';}if($percentage>'75'){ echo 'progress-bar progress-bar-success';} ?>" 
                role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percentage; ?>%;">
                
                <span class="sr-only"> <?php echo $percentage; ?>% Complete</span>
				</div>
	        </div>
          </li>
          <a class="profile-list" href="editprofile.php">
              <li class="subitem <?php if(basename($_SERVER['SCRIPT_NAME'])=='editprofile.php'){ ?>profile_active <?php } ?>">
              <i class="icon-pencil"></i></i> Edit Profile 
              </li>
          </a> 
          
          <a class="profile-list" href="<?php echo "user/".$user['userID']."";?>">
              <li class="subitem <?php if(basename($_SERVER['SCRIPT_NAME'])=='user.php'){ ?>profile_active <?php } ?>">
              <i class="icon-user"></i></i> View My Profile 
              </li>
          </a>
          
          <a class="profile-list" href="chats.php">
              <li class="subitem <?php if(basename($_SERVER['SCRIPT_NAME'])=='chats.php'){ ?>profile_active <?php } ?>">
              <i class="icon-envelope-alt "></i> Messages <span id="msg_count"></span>
              </li>
          </a>

          <a class="profile-list" href="friends.php">
              <li class="subitem <?php if(basename($_SERVER['SCRIPT_NAME'])=='friends.php'){ ?>profile_active <?php } ?>">
              <i class="icon-user"></i> Friends
              </li>
          </a> 
          
          <a class="profile-list" href="event/myevents">
              <li class="subitem <?php if(basename($_SERVER['SCRIPT_NAME'])=='createevent.php'){ ?>profile_active <?php } ?>">
              <i class="icon-calendar-empty "></i> Events </li>
          </a>
          
          <a class="profile-list" href="setting.php">
              <li class="subitem <?php if(basename($_SERVER['SCRIPT_NAME'])=='setting.php'){ ?>profile_active <?php } ?>">
              <i class="icon-cogs"></i> Settings </li>
          </a>
          <hr />
          <li class="subitem_no_deco"><i class="icon-plus"></i> Create</li>
             <li class="subitem_no_deco" > <a class="profile-list" href="create/event/form"><small>Event</small> </a> |
             <a class="profile-list" href="create/group"><small>Group</small></a> |
             <a class="profile-list" href="forum.php"><small>Forum</small></a>  
          </li><hr />
          <li>
          </li>
          <!--<li>
            <a href="https://www.accuweather.com/en/us/new-york-ny/10007/weather-forecast/349727" class="aw-widget-legal">
            </a><div id="awcc1498974187232" class="aw-widget-current"  data-locationkey="" data-unit="c" data-language="en-us" data-useip="true" data-uid="awcc1498974187232"></div><script type="text/javascript" src="https://oap.accuweather.com/launch.js"></script>
          </li>-->
          
        </ul>
   </div><div class="div-title"></div>	
   	
  	<div class="clearfix"></div>
   </div>
</div>
<div class="center-div"><!--Starts Here-->
<?php
//$city="London";
//$country="UK"; //Two digit country code
//$url="http://api.openweathermap.org/data/2.5/weather?q=".$city.",".$country."&units=metric&cnt=7&lang=en";
//$json=file_get_contents($url);
//$data=json_decode($json,true);
////Get current Temperature in Celsius
//echo $data['main']['temp']."<br>";
////Get weather condition
//echo $data['weather'][0]['main']."<br>";
////Get cloud percentage
//echo $data['clouds']['all']."<br>";
////Get wind speed
//echo $data['wind']['speed']."<br>";
//?>
