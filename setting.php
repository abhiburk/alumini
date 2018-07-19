<?php include 'config.php'; ?>

<!DOCTYPE html>
<html>
<head>
<title>Settings <?php include 'includes/title.php'; ?></title>
<link href="assets/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom Theme files -->
<link href="assets/css/style.css" rel="stylesheet" type="text/css" media="all" />
<!-- Custom Theme files -->
<?php include 'includes/stylesheets.php'; ?>
</head>

<body>
<?php  include 'includes/header.php'; ?>
<div class="container">
	<div class="total-info">
	<?php include 'includes/left_panel.php';  ?>

    <div class="col-md-4 grid_2">
        <div class="white-area">
        	<h5>Change Password <a href="javascript:void(0);" rel="Password" class="fright click_edit"><i class="icon-key"></i> Edit</a> </h5>
        </div>
        <div class="hire-me">
            <ul class="cute ">
            
              <!--Show Personal Info-->
              <div class="showPassword">
                <li class="sub"><label class="grey">Password</label> <span style="font-size: 17px;">* * * * * * * * </span> </li><hr>
              </div>
              	   
              <!--Edit Personal Info-->
              <div class="hidePassword display_none">
                <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="xAction" value="change_password">
                     <li class="sub">
                            <label class="grey ">Old Password</label><span id="change_message"></span>
                            <input type="text" class="form-control" name="oldpass" placeholder="Enter your old password">
                            <label class="grey">New Password</label>
                            <input type="text" class="form-control" name="newpass" placeholder="Enter your new password">
                            <label class="grey">Confirm New Password</label>
                            <input type="text" class="form-control" name="confirmpass" placeholder="Confirm new password">
                     </li>  
                     <li>
                     	<input type="submit" value="Change" class="btn btn-primary btn-sm click_change_password">
                        <a href="javascript:void(0);" rel="Password" class="btn btn-primary btn-sm search_btn click_edit" >Cancel</a>
                     </li>
                 </form>
               </div>
            
            </ul>
        </div><div class="div-title"></div> 


        
        
        <!--Social Connection Start-->  
        <div class="white-area">
            <h5>Social Connection 
            <a href="javascript:void(0);" rel="SocialCon" class="fright click_edit"><i class="icon-plus-sign-alt "></i> Edit</a> </h5>
        </div>
        <div class="hire-me">
            <ul class="cute ">
<!--    <div class="fb-follow" data-href="https://www.facebook.com/abhishburk" data-layout="standard" data-size="small" data-show-faces="true" data-width="225px"></div>
-->            	

				<!--Show Social Connection Info-->
                <div class="showSocialCon" id="show">
                    <li class="sub">
                        <label class="grey"><i class="icon-facebook-sign" style="color:#5F75A7"></i> Facebook</label> 
                        <small class="grey">
                        <?php if($user['fb_name']==''){echo 'Facebook Username Not Set';}else{ ?>
                        <a href="http://facebook.com/<?php echo $user['in_name']; ?>" target="target_blank">facebook.com/<?php echo $user['fb_name']; ?></a>
                        | <?php if($user['fb_privacy']=='0') {echo '<a title="Only Me"><i class="icon-lock"></i></a>';}
                          else{echo '<a title="Public"><i class="icon-globe"></i></a>';}   } ?>
                        </small>
                    </li><hr>
                    <li class="sub">
                        <label class="grey"><i class="icon-linkedin-sign" style="color:#39F"></i> LinkedIn</label> <small class="grey">
                        <?php if($user['in_name']==''){echo 'LinkedIn Username Not Set';}else{?>
                        <a href="http://linkedin.com/in/<?php echo $user['in_name']; ?>" target="target_blank">linkedin.com/in/<?php echo $user['in_name']; ?></a>
                        | <?php if($user['in_privacy']=='0') {echo '<a title="Only Me"><i class="icon-lock"></i></a>';}
                          else{echo '<a title="Public"><i class="icon-globe"></i></a>';}   } ?>
                        </small>
                    </li>
                </div>
       
       			<!--Edit Education Info-->
                <div class="hideSocialCon display_none">
                    <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="xAction" value="social_con">
                        <li class="sub"> 
                            <label class="grey"><i class="icon-facebook-sign" style="color:#5F75A7"></i> Facebook</label>
                            <br>
                            www.facebook.com/<small id="targetfb"></small>
                            <input type="text" class="form-control" value="<?php echo $user['fb_name']; ?>" name="fb_name" id="textfb" placeholder="facebook.com/username (Only Username)">
                            <label><i class="icon-globe"></i> Privacy</label>
                            <select name="fb_privacy" class="form-control">
                                <option value="0">Only Me</option>
                                <option value="1">Public</option>
                            </select>           
                            <hr>
                            <label class="grey"><i class="icon-linkedin-sign" style="color:#39F"></i> LinkedIn</label><br>
                            www.linkedin.com/in/<small id="targetin"></small>
                            <input type="text" class="form-control" value="<?php echo $user['in_name']; ?>" name="in_name" id="textin" placeholder="linkedin.com/in/username (Only Username)">
                       		<label><i class="icon-globe"></i> Privacy</label>
                            <select name="in_privacy" class="form-control">
                                <option value="0">Only Me</option>
                                <option value="1">Public</option>
                            </select>  
                        </li>   
                        <li>
                            <input type="submit" value="Save" class="btn btn-primary btn-sm click_social_con" >
                        	<a href="javascript:void(0);" rel="SocialCon" class="btn btn-primary btn-sm click_edit" >Cancel</a>
                            <span id="social_message"></span>
                            </form>
                            
                        </li>
                </div>
                
            </ul>
        </div><div class="div-title"></div> 
                
    </div><!--end col-md-5 grid_2-->
    
    <div class="col-md-3 grid_2">
    
    	<!--Contacts-->
        <div class="white-area hideContact_for_wp">
            <h5>Contact Info 
            <a href="javascript:void(0);" rel="Contact" class="fright click_edit"><i class="icon-phone"></i> Edit</a> </h5>
        </div>
        <div class="hire-me hideContact_for_wp">
            <ul class="cute">
              	
               <div class="showContact">
               		<!--Showing Contact-->
               		<li>
                    	<label class="grey">Phone</label> <small class="grey">
						<?php if($user['userPhone']==''){echo 'Phone No.Not Available';}else 
                        {echo $user['userPhone'];} ?></small>
                        
                          <a class="clickShow" rel="Privacy" title="<?php echo $user['phonePrivacy']; ?>" href="javascript:void(0);">
                          <?php if($user['phonePrivacy']=='Only Me') {echo '<i class="icon-lock"></i>';}
                          else{echo '<i class="icon-globe"></i>';} ?>
                          </a>
                    </li>
                    
                    <li>
                    	 <label class="grey">Email</label> <small class="grey"><?php  echo $user['userEmail']; ?></small>
                          <a class="clickShow" rel="EmailPrivacy" title="<?php echo $user['emailPrivacy']; ?>" href="javascript:void(1);">
                          <?php if($user['emailPrivacy']=='Only Me') {echo '<i class="icon-lock"></i>';}
                          else{echo '<i class="icon-globe"></i>';} ?>
                          </a>
                    </li>
                    
               </div>
               
               <div class="hideContact display_none">
               		<!--Edit Contact-->
                    <form action="manipulates/manipulate.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="xAction" value="user_contact">
                        <li>
                            <label class="grey1">Phone</label>
                            <input type="text" class="form-control" name="userPhone" placeholder="Phone Number" value="<?php echo $user['userPhone']; ?>">
                       
                            <label class="grey1">Phone Privacy</label>
                            <select name="phonePrivacy" class='form-control' required>
                              <option value="Only Me"<?php if($user['phonePrivacy'] == 'Only Me'){ echo 'selected';};?>> Only Me</option>
                              <option value="Public"<?php if($user['phonePrivacy'] == 'Public'){ echo 'selected';};?>>Public</option>
                            </select>  
                        </li>
                        <hr>
                        <li>
                            <label class="grey1 ">Email</label>
                            <input type="text" class="form-control" name="userEmail" value="<?php echo $user['userEmail']; ?>">
                        
                            <label class="grey1">Email Privacy</label>
                           <select name="emailPrivacy" class='form-control' required>
                              <option value="Only Me"<?php if($user['emailPrivacy'] == 'Only Me'){ echo 'selected';};?>> Only Me</option>
                              <option value="Public"<?php if($user['emailPrivacy'] == 'Public'){ echo 'selected';};?>>Public</option>
                            </select>  
                        </li>
                        <li>
                            <input type="submit" value="Save" class="btn btn-primary btn-sm search_btn" >
                       		<a href="javascript:void(0);" rel="Contact" class="btn btn-primary btn-sm search_btn click_edit" >Cancel</a>
                            </form>
                        </li>
               </div>
              
            </ul>
        </div>
        			
        			
        			
                    	
                    
    </div><!-- end col-md-5-->
    
    
    <?php include 'includes/right_panel.php'; ?>

<!--Container Ends Here-->
<div class="clearfix"></div>
</div>

</div>
<script src="assets/js/myscript.js"></script>
<script src="assets/js/ajax_load.js"></script>
<script src="assets/my-js/setting.js"></script>
</body>
</html>