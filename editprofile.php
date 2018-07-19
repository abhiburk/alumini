<?php include 'config.php'; ?>

<!DOCTYPE html>
<html>
<head>
<title><?php echo $user['name']; ?> <?php include 'includes/title.php'; ?></title>
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
        	<h5>Personal Info <a href="javascript:void(0);" rel="Personal" class="fright click_edit"><i class="icon-user"></i> Edit</a> </h5>
        </div>
        <div class="hire-me">
            <ul class="cute ">
            
              <!--Show Personal Info-->
              <div class="showPersonal">
                <li class="sub"><label class="grey">Name</label> <small class="grey"><?php echo $user['name']; ?></small></li><hr>
                <li class="sub"><label class="grey">Birthday</label><small class="grey"> <?php echo $user['birthday']; ?> </small></li><hr>
                <li class="sub"><label class="grey">Gender</label> 
                    <small class="grey"> <?php if($user['gender']==''){echo 'Gender not set';}else { echo $user['gender'];} ?></small>
                </li><hr>
                <li class="sub">
                  <label class="grey">Webname</label> <small class="grey">
                  <?php if($user['webName']==''){echo 'Your Webname is Unavailable';}else 
                  {echo'<a href="http://www.site.com/'.$user['webName'].'">www.site.com/'; echo $user['webName'];} ?></a></small>
                </li>
              </div>
              	   
              <!--Edit Personal Info-->
              <div class="hidePersonal display_none">
                <form action="manipulates/manipulate.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="xAction" value="personal_info">
                     <li class="sub">
                            <label class="grey ">First Name</label>
                            <input type="text" class="form-control" name="firstName" value="<?php echo $user['firstName']; ?>">
                            <label class="grey">Last Name</label>
                            <input type="text" class="form-control" name="lastName" value="<?php echo $user['lastName']; ?>">
                     </li>  
                     <li class="sub">
                        <label class="grey">Birthday</label><br>
                        <select name="day" class='form-control1' required>
                            <option value="">Date</option>
                          <?php $k=0; 
                          for($i=1;$i<=31;$i++) { ?>
                          <option value="<?php if($i<=9) echo $k; echo $i ?>"
                          <?php if(substr($user['birthday'],8,3) == $k.''.$i)
                          { echo 'selected';} ?>>
                          <?php if($i<=9) echo $k; echo $i ?>
                          <?php } ?>
                          </option>
                        </select>
                        <select name="month" class='form-control1' required>
                            <option value="01"<?php if(substr($user['birthday'],5,2) == '01'){ echo 'selected';};?>>January</option>
                              <option value="02"<?php if(substr($user['birthday'],5,2) == '02'){ echo 'selected';};?>>February</option>
                              <option value="03"<?php if(substr($user['birthday'],5,2) == '03'){ echo 'selected';};?>>March</option>
                              <option value="04"<?php if(substr($user['birthday'],5,2) == '04'){ echo 'selected';};?>>April</option>
                              <option value="05"<?php if(substr($user['birthday'],5,2) == '05'){ echo 'selected';};?>>May</option>
                              <option value="06"<?php if(substr($user['birthday'],5,2) == '06'){ echo 'selected';};?>>June</option>
                              <option value="07"<?php if(substr($user['birthday'],5,2) == '07'){ echo 'selected';};?>>July</option>
                              <option value="08"<?php if(substr($user['birthday'],5,2) == '08'){ echo 'selected';};?>>August</option>
                              <option value="09"<?php if(substr($user['birthday'],5,2) == '09'){ echo 'selected';};?>>September</option>
                              <option value="10"<?php if(substr($user['birthday'],5,2) == '10'){ echo 'selected';};?>>October</option>
                              <option value="11"<?php if(substr($user['birthday'],5,2) == '11'){ echo 'selected';};?>>November</option>
                              <option value="12"<?php if(substr($user['birthday'],5,2) == '12'){ echo 'selected';};?>>December</option>
                        </select>
                        <select name="year" class='form-control1' required> 
                            <option  value="">Year</option>
                            <?php for($i=1970;$i<=2017;$i++)
                            { echo "<option value=".$i." " ?>
                            <?php if(substr($user['birthday'],0,4) == $i)
                            { echo 'selected';} ?>> <?php echo  $i; } ?>
                            </option>
                        </select>
                     </li>
                     <li class="sub">
                       <label class="grey">Gender</label>
                       <select name="gender" class='form-control' required>
                          <option value="Female"<?php if($user['gender'] == 'Female'){ echo 'selected';};?>> Female		</option>
                          <option value="Male"<?php if($user['gender'] == 'Male'){ echo 'selected';};?>> Male	</option>
                       </select>
                     </li> 
                     <li class="sub">
                        <label class="grey ">Webname</label><small>www.site.com/webname</small>
                        <input type="text" class="form-control" name="webName" placeholder="Public Webname" value="<?php echo $user['webName']; ?>">
                     </li>
                     <li>
                     	<input type="submit" value="Save" class="btn btn-primary btn-sm search_btn" >
                        <a href="javascript:void(0);" rel="Personal" class="btn btn-primary btn-sm search_btn click_edit" >Cancel</a>
                     </li>
                 </form>
               </div>
            
            </ul>
        </div><div class="div-title"></div> 
       			  
                   
                   
                   
        <!--Education Start-->  
        <div class="white-area">
            <h5>Education Info 
            <a href="javascript:void(0);" rel="Edu" class="fright click_edit"><i class="glyphicon glyphicon-education"></i> Edit</a> </h5>
        </div>
        <div class="hire-me">
            <ul class="cute ">
            
            	<!--Show Education Info-->
                <div class="showEdu">
                    <li class="sub">
                        <label class="grey">Institute</label> <small class="grey">
                        <?php if($user['instituteName']==''){echo 'Institute Not Set';}else{echo $user['instituteName'];} ?></small>
                    </li>
                    <li class="sub">
                        <label class="grey">Course</label> <small class="grey">
                        <?php if($user['courseName']==''){echo 'Course Not Set';}else{echo $user['courseName'];} ?></small>
                    </li>
                    <li class="sub">
                        <label class="grey">Branch</label> <small class="grey">
                        <?php if($user['branchName']==''){echo 'Branch Not Set';}else{echo $user['branchName'];} ?></small>
                    </li>
                    <li class="sub">
                        <label class="grey">Join Date</label> <small class="grey">
                        <?php if($user['joinDate']==''){echo 'Join Date Not Set';}else{echo $user['joinDate'];} ?></small>
                    </li>
                    <li class="sub">
                        <label class="grey">Passout Date</label> <small class="grey">
                        <?php if(($user['passoutDate']=='') and ($user['currentlystudying']=='')){echo 'Passout Date Not Set';}else if($user['passoutDate']!='')
                        {echo $user['passoutDate'];}else if($user['currentlystudying']=='1')echo 'Currently Studying'; ?></small>
                    </li>
                </div>
       
       			<!--Edit Education Info-->
                <div class="hideEdu display_none">
                    <form action="manipulates/manipulate.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="xAction" value="user_edu">
                        <li class="sub"> 
                            <label class="grey ">Institute</label>
                            <select name="instituteName" class='form-control' required>
                              <option value="">Institute</option>
                             <?php $sql_colg=mysqli_query($dbconfig,"SELECT * FROM institutes"); 
                                   while($row_colg=mysqli_fetch_assoc($sql_colg)){ ?> 
                              <option value="<?php echo $row_colg['instituteName']; ?>"<?php if($user['instituteName'] == $row_colg['instituteName']){ echo 'selected';};?>> <?php echo $row_colg['instituteName']; ?></option>
                              <?php } ?>
                            </select>
                        </li>
                        <li class="sub">
                            <label class="grey">Course</label>
                            <select name="courseName" class='form-control' onchange="fetch_select(this.value);"  required>
                              <option value="">Course</option>
                             <?php $sql_colg=mysqli_query($dbconfig,"SELECT * FROM courses"); 
                                   while($row_colg=mysqli_fetch_assoc($sql_colg)){?> 
                              <option value="<?php echo $row_colg['courseName']; ?>"<?php if($user['courseName'] == $row_colg['courseName']){ echo 'selected';};?>> <?php echo $row_colg['courseName']; ?></option>
                              <?php } ?>
                            </select>
                        </li>
                        <li class="sub">
                            <label class="grey">Branch</label>
                            <select name="branchName" class='form-control' id="new_select" required>
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
                        <li>
                            <input type="submit" value="Save" class="btn btn-primary btn-sm search_btn" >
                        	<a href="javascript:void(0);" rel="Edu" class="btn btn-primary btn-sm search_btn click_edit" >Cancel</a>
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
        </div><div class="div-title hideContact_for_wp"></div>
        			
        			<!--Work Place Start-->  
                    <div class="white-area">
                    	<h5>Work Place <a href="javascript:void(0);" class="fright click_add_wp"><i class="icon-plus"></i> Add Work</a> </h5>
                    </div>
                    <div id="loading"></div>
                    <div id="show_edit_wp"></div>
                    
                    <!--Add Work Place-->
                    <div class="show_add_wp display_none">
                    <div class="hire-me">
                        <ul class="cute">
                        	 
                              <!--Company+Description+Position Fields-->
                              <form action="manipulates/manipulate.php" method="post" enctype="multipart/form-data">
                              <input type="hidden" name="xAction" value="work_place">
                              <li class="sub"> 
                                  <label class="grey1">Company Name</label> 
                                   <span class="hide_wp_edit">
                                        <input type="text" class="form-control" placeholder="Company Name" name="companyName">
                                   </span>
                              </li>
                              
                              <li class="sub"> 
                                  <label class="grey1">Description</label> 
                                   <span class="hide_wp_edit">
                                        <textarea class="form-control" placeholder="Description" name="description"></textarea>
                                   </span>
                              </li>
                              
                              <li class="sub"> 
                                  <label class="grey1">Position</label> 
                                   <span class="hide_wp_edit">
                                        <input type="text" class="form-control" placeholder="Position" name="position">
                                   </span>
                              </li>
                              
                              <!--Join Date+ End Date Fields-->
                              <li class="sub"> 
                               <label class="grey1">Start Date</label><br> 
                                <span class="hide_wp_edit">
                                    <select name="startday" class='form-control1' required>
                                      <option value="">Day</option>
                                      <?php $k=0; for($i=1;$i<=31;$i++) {?>
                                      <option><?php if($i<=9) {echo $k;} echo $i;} ?></option>
                                    </select>
                                    
                                    <select name="startmonth" class='form-control1' required>
                                      <option value="">Month</option>
                                      <option value="01"> January		</option>
                                      <option value="02"> February	</option>
                                      <option value="03"> March		</option>
                                      <option value="04"> April		</option>
                                      <option value="05"> May			</option>
                                      <option value="06"> June		</option>
                                      <option value="07"> July		</option>
                                      <option value="08"> August		</option>
                                      <option value="09"> September	</option>
                                      <option value="10"> October		</option>
                                      <option value="11"> November	</option>
                                      <option value="12"> December	</option>
                                    </select>
                                    <select name="startyear" class='form-control1' required> 
                                      <option  value="">Year</option>
									  <?php for($i=1950;$i<=date('Y');$i++) { ?>
                                      <option><?php echo  $i;} ?></option>
                                    </select>
                                    
                               </span>
                              </li>
                              <li>
                                  <small class="grey">
                                     <input type="checkbox" value="1" name="currentlyworking" > Currently Working
                                  </small>
                              </li>
                              
                              <!--End Date Fields-->
                               <li class="sub"> 
                               <label class="grey1">End Date</label> <br>
                                <span class="hide_wp_edit">
                                    <select name="endday" class='form-control1'>
                                      <option value="">Day</option>
                                      <?php $k=0; for($i=1;$i<=31;$i++) {?>
                                      <option><?php if($i<=9) {echo $k;} echo $i;} ?></option>
                                    </select>
                                    
                                    <select name="endmonth" class='form-control1'>
                                      <option value="">Month</option>
                                      <option value="01"> January		</option>
                                      <option value="02"> February	</option>
                                      <option value="03"> March		</option>
                                      <option value="04"> April		</option>
                                      <option value="05"> May			</option>
                                      <option value="06"> June		</option>
                                      <option value="07"> July		</option>
                                      <option value="08"> August		</option>
                                      <option value="09"> September	</option>
                                      <option value="10"> October		</option>
                                      <option value="11"> November	</option>
                                      <option value="12"> December	</option>
                                    </select>
                                    <select name="endyear" class='form-control1'> 
                                      <option  value="">Year</option>
                                      <?php for($i=1950;$i<=date('Y');$i++) { ?>
                                      <option><?php echo  $i;} ?></option>
                                    </select>
                               </span>
                               <input type="submit" value="Save" class="btn btn-primary btn-sm search_btn" >
                               <a href="javascript:void(0);" class="btn btn-primary btn-sm search_btn click_add_wp" >Cancel</a>
                              </li>
                              </form>
                              
                         </ul>
                     </div>
                     </div>
        			
                    <!--Work Place-->
                    <?php 
					$sql_user=mysqli_query($dbconfig,"SELECT *,$name
					FROM users AS u LEFT JOIN users_edu USING (userID) LEFT JOIN user_workplace AS wp USING (userID) 
					WHERE wp.userID='".$userid."'") or die(mysqli_error());
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
                                    <small><a href="javascript:void(0);" class="edit_wp" rel="<?php echo $user['workID']; ?>"> Edit</a></small>
                                </span>
                            </li><hr>
                            <?php }} ?>
                        </ul>
                    </div>
                    <div class="div-title"></div>	
                    
    </div><!-- end col-md-5-->
    
    
    <?php include 'includes/right_panel.php'; ?>

<!--Container Ends Here-->
<div class="clearfix"></div>
</div>

</div>
<script src="assets/js/myscript.js"></script>
<script src="assets/js/ajax_load.js"></script>
<script src="assets/my-js/profile_edit.js"></script>
</body>
</html>