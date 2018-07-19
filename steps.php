<?php include 'config.php';
$step = isset($_REQUEST['step']) ? htmlentities($_REQUEST['step']) : '';
?>
<!DOCTYPE html>
<html>
<head>
<title>Steps to complete profile <?php include 'includes/title.php'; ?></title>
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
       <div class="col-md-3 grid_3"></div>
        
       <div class="col-md-6 grid_3">
        	<h5><span id="message_password"></span></h5>
            <div class="hire-me-2" style="margin-top: 3em;">
            
				<?php if($step=='1'){ ?>
                <!--Add Education Info-->
                <h4>Add Education Step 1 <i class="icon-chevron-right"></i> of 3</h4>
                  <div class="div_steps">
                      <!--Edit Education Info-->
                        <ul class="cute">
                        <form action="manipulates/manipulate.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="xAction" value="user_edu">
                        <input type="hidden" name="redirect" value="step">
                            <li class="sub" > 
                                <label class="grey">Education</label><br>	
                                <select name="instituteName" class='form-control1' required>
                                  <option value="">Institute</option>
                                 <?php $sql_colg=mysqli_query($dbconfig,"SELECT * FROM institutes"); 
                                       while($row_colg=mysqli_fetch_assoc($sql_colg)){ ?> 
                                  <option value="<?php echo $row_colg['instituteName']; ?>"<?php if($user['instituteName'] == $row_colg['instituteName']){ echo 'selected';};?>> <?php echo $row_colg['instituteName']; ?></option>
                                  <?php } ?>
                                </select>
                           
                                <select name="courseName" class='form-control1' onchange="fetch_select(this.value);"  required > 
                                  <option value="">Course</option>
                                 <?php $sql_colg=mysqli_query($dbconfig,"SELECT * FROM courses"); 
                                       while($row_colg=mysqli_fetch_assoc($sql_colg)){?> 
                                  <option value="<?php echo $row_colg['courseName']; ?>"<?php if($user['courseName'] == $row_colg['courseName']){ echo 'selected';};?>> <?php echo $row_colg['courseName']; ?></option>
                                  <?php } ?>
                                </select>
        
                                <select name="branchName" class='form-control1' id="new_select" required>
                                  <option value="">Branch</option>
                                 	 <?php $sql_colg=mysqli_query($dbconfig,"SELECT * FROM branches"); 
                                       while($row_colg=mysqli_fetch_assoc($sql_colg)){ ?> 
                                  <option value="<?php echo $row_colg['branchName']; ?>"<?php if($user['branchName'] == $row_colg['branchName']){ echo 'selected';};?>> <?php echo $row_colg['branchName']; ?></option>
                                  <?php } ?>
                                </select>
                            </li>
                            
                            <li class="sub">
                                <label class="grey">Join Date</label><br>
                                <select name="joinDay" class='form-control1' required>
                                  <option value="">Day</option>
                                      <?php $k=0; 						  
                                      for($i=1;$i<=31;$i++) {?>
                                      <option value="<?php echo $i; ?>"<?php if(substr($user['joinDate'],8,3) == $i){ echo 'selected';} ?>>
                                      <?php if($i<=9) {echo $k;} echo $i;} ?>
                                  </option>
                                </select>
                                
                                <select name="joinMonth" class='form-control1' required>
                                  <option value="">Month</option>
                                  <option value="01"<?php if(substr($user['joinDate'],5,2) == '01'){ echo 'selected';};?>> January		</option>
                                  <option value="02"<?php if(substr($user['joinDate'],5,2) == '02'){ echo 'selected';};?>> February	</option>
                                  <option value="03"<?php if(substr($user['joinDate'],5,2) == '03'){ echo 'selected';};?>> March		</option>
                                  <option value="04"<?php if(substr($user['joinDate'],5,2) == '04'){ echo 'selected';};?>> April		</option>
                                  <option value="05"<?php if(substr($user['joinDate'],5,2) == '05'){ echo 'selected';};?>> May			</option>
                                  <option value="06"<?php if(substr($user['joinDate'],5,2) == '06'){ echo 'selected';};?>> June		</option>
                                  <option value="07"<?php if(substr($user['joinDate'],5,2) == '07'){ echo 'selected';};?>> July		</option>
                                  <option value="08"<?php if(substr($user['joinDate'],5,2) == '08'){ echo 'selected';};?>> August		</option>
                                  <option value="09"<?php if(substr($user['joinDate'],5,2) == '09'){ echo 'selected';};?>> September	</option>
                                  <option value="10"<?php if(substr($user['joinDate'],5,2) == '10'){ echo 'selected';};?>> October		</option>
                                  <option value="11"<?php if(substr($user['joinDate'],5,2) == '11'){ echo 'selected';};?>> November	</option>
                                  <option value="12"<?php if(substr($user['joinDate'],5,2) == '12'){ echo 'selected';};?>> December	</option>
                                </select>
                                <select name="joinYear" class='form-control1' required> 
                                  <option  value="">Year</option>
                                    <?php for($i=1950;$i<=date('Y');$i++) { ?>
                                  <option value="<?php echo $i; ?>"<?php if(substr($user['joinDate'],0,4) == $i){ echo 'selected';};?> >
                                   <?php echo  $i;} ?>
                                  </option>
                                </select>
                            </li>
                            <li class="sub">
                                <small class="grey">
                                    <input type="checkbox" value="1"<?php if($user['currentlystudying'] == '1'){ echo 'checked';};?> name="currentlystudying" > Currently Studying
                                </small>
                            </li>
                            <li class="sub">
                                <label class="grey">Passout Date</label><br>
                                <select name="passoutDay" class='form-control1'>
                                  <option value="">Day</option>
                                      <?php $k=0; 
                                      for($i=1;$i<=31;$i++) {?>
                                      <option value="<?php echo $i; ?>"<?php if(substr($user['passoutDate'],8,3) == $i){ echo 'selected';} ?>>
                                      <?php if($i<=9) echo $k; echo $i;} ?>
                                  </option>
                                </select>
                                <select name="passoutMonth" class='form-control1' >
                                  <option value="">Month</option>
                                  <option value="01"<?php if(substr($user['passoutDate'],5,2) == '01'){ echo 'selected';};?>> January		</option>
                                  <option value="02"<?php if(substr($user['passoutDate'],5,2) == '02'){ echo 'selected';};?>> February	</option>
                                  <option value="03"<?php if(substr($user['passoutDate'],5,2) == '03'){ echo 'selected';};?>> March		</option>
                                  <option value="04"<?php if(substr($user['passoutDate'],5,2) == '04'){ echo 'selected';};?>> April		</option>
                                  <option value="05"<?php if(substr($user['passoutDate'],5,2) == '05'){ echo 'selected';};?>> May			</option>
                                  <option value="06"<?php if(substr($user['passoutDate'],5,2) == '06'){ echo 'selected';};?>> June		</option>
                                  <option value="07"<?php if(substr($user['passoutDate'],5,2) == '07'){ echo 'selected';};?>> July		</option>
                                  <option value="08"<?php if(substr($user['passoutDate'],5,2) == '08'){ echo 'selected';};?>> August		</option>
                                  <option value="09"<?php if(substr($user['passoutDate'],5,2) == '09'){ echo 'selected';};?>> September	</option>
                                  <option value="10"<?php if(substr($user['passoutDate'],5,2) == '10'){ echo 'selected';};?>> October		</option>
                                  <option value="11"<?php if(substr($user['passoutDate'],5,2) == '11'){ echo 'selected';};?>> November	</option>
                                  <option value="12"<?php if(substr($user['passoutDate'],5,2) == '12'){ echo 'selected';};?>> December	</option>
                                </select>
                                <select name="passoutYear" class='form-control1'> 
                                  <option  value="">Year</option>
                                    <?php for($i=1950;$i<=2017;$i++) { ?>
                                  <option value="<?php echo $i; ?>"<?php if(substr($user['passoutDate'],0,4) == $i){ echo 'selected';};?> >
                                   <?php echo  $i;} ?>
                                  </option>
                                </select>
                            </li>
                        </ul>  
                        <span style="display: flow-root;">
                          <h5>
                          <input type="submit" value="Save & Continue " class="click_step_save_continue fright btn btn-info" style="margin-top: 20px;margin-right: 0px;" >
                          </form>
                          </h5>                 
                          <h5><a href="step/2" class="fright btn btn-default" style="margin-top: 20px;margin-right: 5px;" ><i class="icon-forward"></i> Skip this  </a></h5>
                        </span>
                        <hr>
                   </div> 
                   
                <?php } ?>
                
                <?php if($step=='2'){ ?>
                <!--Search or Close Friends-->
                <h4>Search or Close Friends Step 2 <i class="icon-chevron-right"></i> of 3</h4>
                  <div class="div_steps">
                      <form method="post">	
                          <input type="hidden" name="xAction" value="search_new_users">
                          <span class="inline-display">
                            <input type="text" class="form-control-search" name="searchVal" placeholder="Search Friends" >
                            <input type="submit" class="btn btn-info  click_search_friends"  value="Search" style="border-radius:0px">
                          </span>
                       </form> 
                     <div id="loading"></div>
                     <div id="searchResults"> </div> 
                     
                     <?php     
                     $sql_new_users=mysqli_query($dbconfig,"SELECT *,$name FROM users LEFT JOIN users_edu USING (userID)
                     WHERE instituteName='".$user['instituteName']."' AND userID!='".$userid."' ORDER BY RAND()");
                     $count=mysqli_num_rows($sql_new_users);
					 $count = isset($count) ? htmlentities($count) : '';
                     if($count==''){echo '<small class="grey1">No record found, as records were shown based on your institute.If you wish to have list of friends of your
					 institute you can search or go back and save your education details</small>';}{
                     ?>
                     <ul class="cute <?php if($count>4){echo 'scroll2';} ?>" id="default_new_user" style="width: 100%;">
                     <small class="grey1"><b>Friends from your institute</b></small>
                        <?php   while($row_new_users=mysqli_fetch_assoc($sql_new_users)){
                                $sql_req_sent=mysqli_query($dbconfig,"SELECT * FROM friend_request
                                WHERE friendWith='".$row_new_users['userID']."' AND userID='".$userid."'") or die(mysqli_error($dbconfig));
                                $check_req_sent=mysqli_num_rows($sql_req_sent);
								$check_req_sent = isset($check_req_sent) ? htmlentities($check_req_sent) : '';
                                ?>
                           <li style="padding:0px;">
                             <img src="<?php if($row_new_users['userImg']==''){echo 'images/default.jpg';}else {
                             echo 'uploads/'.$row_new_users['userImg']; } ?>" alt="User Avatar" class="recent_chat" style="margin-top: 15px;">
                             <div class="user_info">
                                <small><b><?php echo $row_new_users['name']; ?></b></small>
                                <small class="grey1"><?php echo $row_new_users['instituteName']; ?></small>
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
                         <?php }} ?>
                      </ul>
                      <span style="display: flow-root;">
                          <h5><a href="javascript:void(0);" class="fright btn btn-info" style="margin-top: 20px;margin-right: 0px;" >Continue  </a></h5>
                          <h5><a href="step/3" class="fright btn btn-default" style="margin-top: 20px;margin-right: 5px;" ><i class="icon-forward"></i> Skip this  </a></h5>
                          <h5><a href="step/1" class="fright btn btn-default" style="margin-top: 20px;margin-right: 5px;" ><i class="icon-step-backward"></i> Back  </a></h5>
                      </span>
                      <hr>
                   </div>
                   
                 <?php } ?>
                 
				 <?php if($step=='3'){ ?>
                 <!--Upload profile photo-->
                 <h4>Add Profile Photo Step 3 <i class="icon-chevron-right"></i> of 3</h4>
                  <div class="div_steps">
                      <!--Uploading Profile Photo-->
                        <form action="manipulates/update_profile_photo.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="xAction" value="update_user_photo" />
                            <input type="hidden" name="postType" value="user.photo">
                            <input type="hidden" name="newsText" value="<?php if($user['gender']=='Male'){
                            echo 'changed his profile photo'; }else{
                            echo 'changed her profile photo';} ?>" />
                            <input type="hidden" name="reference" value="user_id" />
                            <input type="hidden" name="referenceID" value="<?php echo $user['userID'] ?>" />
                            
                            <h3 style="position: absolute;margin-left: 12em;margin-top: 2em;">
                            <i class="icon-upload-alt ok_green" style="margin-left: 3em;"></i><hr> Setup your profile photo </h3>
        
                            <div class="fileupload fileupload-new" data-provides="fileupload" style="width:40%; ">
                                <img class="profile-img fileupload-new"  src="<?php if($user['userImg']==''){echo 'images/default.jpg';}else {
                                echo 'uploads/'.$user['userImg']; } ?>" alt="" style="border: 4px solid #c6c6c6;width: 70%;"/>
                                
                                <div class="fileupload-preview fileupload-exists thumbnail profile-img"></div>
                                <span class="btn btn-file btn btn-default btn-sm ">
                                <span class="fileupload-new "><i class="icon-pencil"></i> Select Photo</span>
                                <span class="fileupload-exists"><i class="icon-repeat"></i> Change</span>
                                <input type="file" name="userImg" required/>
                                </span>
                                <a href="#" class=" fileupload-exists btn btn-default btn-sm" data-dismiss="fileupload" style="float: none"><i class="icon-remove"></i> Cancel</a>
                            </div>
                        
                      <span style="display: flow-root;">
                          <h5><input type="submit" class="fright btn btn-info fileupload-exists" value="Save & Continue" style="margin-top: 20px;margin-right: 5px;"></h5>
                          <h5><a href="home.php?view=welcome" class="fright btn btn-default" style="margin-top: 20px;margin-right: 5px;" ><i class="icon-step-forward"></i> Skip this  </a></h5>
                          <h5><a href="step/2" class="fright btn btn-default" style="margin-top: 20px;margin-right: 5px;" ><i class="icon-step-backward"></i> Back  </a></h5>
                      </span>
                      
                     </form>  
                      <hr>
                   </div>  
               
                 <?php } ?>
            
              
            </div>
            
        <!--Copyright-->
        <div class="hire-me">
            <ul class="cute">
            	<p><li style="text-align:center"> <small class="grey1"> Copyright &copy; <?php echo date("Y"); ?>  All rights  Reserved <br /> 
                Developed by <a href="http://facebook.com/abhishburk" target="target_blank">Abhishek Burkule</a></small> 
                <small class="grey1">|<a href="faq.php" target="target_blank"> Faq </a>|
                <a href="contactus.php" target="target_blank"> Contact us</a></li></p>
            </ul>
        </div><div class="div-title"></div>	 
         
       </div><!--end col-md-5-->
  
  	   <div class="col-md-5 grid_3"></div>
       	
<!--total info Ends Here-->
<div class="clearfix"></div>
</div>
</div>
<script src="assets/js/myscript.js"></script>
<script src="assets/js/ajax_load.js"></script>
<script src="assets/my-js/friend_request.js"></script>
</body>
</html>