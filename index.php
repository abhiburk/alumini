<?php  
if(!isset($_SESSION)) 
    {
		session_start();
		$fname = isset($_SESSION['firstName']) ? $_SESSION['firstName'] : '';
		$lname = isset($_SESSION['lastName']) ? $_SESSION['lastName'] : '';
		$umail = isset($_SESSION['userEmail']) ? $_SESSION['userEmail'] : '';
		$day = isset($_SESSION['day']) ? $_SESSION['day'] : '';
		$month = isset($_SESSION['month']) ? $_SESSION['month'] : '';
		$year = isset($_SESSION['year']) ? $_SESSION['year'] : '';
		$gender = isset($_SESSION['gender']) ? $_SESSION['gender'] : '';

	}
?>
<!DOCTYPE html>
<html>
<head>
<title>LogIn & SignUp <?php include 'includes/title.php'; ?></title>
<link href="assets/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom Theme files -->
<link href="assets/css/style.css" rel="stylesheet" type="text/css" media="all" />
<!-- Custom Theme files -->
<?php include 'includes/stylesheets.php'; ?>
</head>
<body style="background:-moz-linear-gradient(#E1F0FC, #C0BFBF) no-repeat fixed;">    
<?php include 'includes/header.php'; ?>
<div class="container">
	<div class="total-info">
	
    <div class="col-md-1 grid_2"></div>
	<div class="col-md-5 grid_1"></div><!--end col-md-5-->
     <div class="col-md-1 grid_3"></div>
     
    
    <div class="col-md-4 grid_2">
    	
        <div class="hire-me-2">
          <div class="project">
          <span id="message_login"></span>
              <form method="post">	
                <input type="text" class="form-control1" name="userEmail" placeholder="Email-ID"  style=" width:49%;">
                <input type="password" class="form-control1" name="userPass" placeholder="Password"  style=" width:50%;">
                <span style="display:inline-block; width:100%">
                  <input type="submit" class="text btn btn-info btn-sm fright click_login"  value="Login">
                  <h5><a href="forgot.php" class="click_forgot" >Forgot Password ?</a></h5>
                </span>  
              </form> 
          </div>
        </div>
        <hr> 
      
    </div><!--end col-md-5-->
    
   
   <div class="col-md-1 grid_3"></div>
   <div class="col-md-6 grid_3">
   			
             <div class="login_image" style="">
             	<h3 style="position: absolute;margin-left: 29%;margin-top: -3em;">Get connected to your old days.</h3>
                <h4 style="position: absolute;margin-left: 29%;margin-top: -2em;">a small,simple community.</h4>
            	<img src="images/social3.png" style="max-width: 40em;margin-left: 5em;"></div>   
             </div>
      
   </div><!--end col-md-5-->
      
      
    <div class="col-md-1 grid_3"></div>
    
   <div class="col-md-4 grid_3">
   
   		<div class="hire-me-2">
        <h3>Create your account</h3><br>
          <div class="project">
              <form method="post">	
              	<input type="text" class="form_control_login" name="firstName" placeholder="First Name" value="<?php echo $fname;?>" style=" width:49%">
         		<input type="text" class="form_control_login" name="lastName" placeholder="Last Name" value="<?php echo $lname; ?>"  style=" width:50%">
                <input type="text" class="form_control_login" name="umail" placeholder="Your Email-ID" value="<?php echo $umail;?>" >
                <br>
                <input type="password" class="form_control_login" name="upass" placeholder="Your Password" >
                
                 <h5><b>Birthday</b></h5>
                 <select name="day" class='form-control1' style="width:20%;">
                      <option value="">Date</option>
                      <?php $k=0; 
                      for($i=1;$i<=31;$i++) {?>
                      <option value="<?php if($i<=9) {echo $k;} echo $i; ?>"<?php if($day== $k.''.$i){ echo 'selected';} ?>>
                      <?php if($i<=9) echo $k; echo $i ; } ?>
                      </option>
                  </select>
                  <select name="month" class='form-control1' style="width:20%;">
                      <option value="">Of</option>
                      <option value="01"<?php if($month == '01'){ echo 'selected';};?>> January		</option>
                      <option value="02"<?php if($month == '02'){ echo 'selected';};?>> February	</option>
                      <option value="03"<?php if($month == '03'){ echo 'selected';};?>> March		</option>
                      <option value="04"<?php if($month == '04'){ echo 'selected';};?>> April		</option>
                      <option value="05"<?php if($month == '05'){ echo 'selected';};?>> May			</option>
                      <option value="06"<?php if($month == '06'){ echo 'selected';};?>> June		</option>
                      <option value="07"<?php if($month == '07'){ echo 'selected';};?>> July		</option>
                      <option value="08"<?php if($month == '08'){ echo 'selected';};?>> August		</option>
                      <option value="09"<?php if($month == '09'){ echo 'selected';};?>> September	</option>
                      <option value="10"<?php if($month == '10'){ echo 'selected';};?>> October		</option>
                      <option value="11"<?php if($month == '11'){ echo 'selected';};?>> November	</option>
                      <option value="12"<?php if($month == '12'){ echo 'selected';};?>> December	</option>
                  </select>
                  <select name="year" class='form-control1' style="width:20%;"> 
                      <option  value="">Birth</option>
                        <?php for($i=1950;$i<=2016;$i++) { ?>
                      <option value="<?php echo $i; ?>"<?php if($year == $i){ echo 'selected';};?> >
                       <?php echo  $i;}  ?>
                      </option>
                  </select><br/>
                  
                 <span class="radio_gender"> 
                  <input type="radio" name="gender" value="Female"<?php if($gender == 'Female'){ echo 'checked';}?> class="form_control_login"> 
                  <span class="radio_sub_gender">Female</span>
                  <input type="radio" name="gender" value="Male"<?php if($gender == 'Male'){ echo 'checked';}?> class="form_control_login radio_sub_gender"> 			  		  
                  <span class="radio_sub_gender">Male</span>
                 </span>
                <br>
                <span style="display: inline-block;width: 100%;">
                  <input type="submit" class="text btn btn-success floatright click_signup"  value="Create Account">
                  <h5><span id="message_signup"></span></h5>
                </span>
              </form> 
              <hr>
          </div>
        </div>
        
   </div><!--end col-md-5-->
   
   <div class="col-md-2 grid_3"></div>
   
   <div class="col-md-9 grid_3">
   <!--Copyright-->
        <div class="white_box" >
            <ul class="cute">
            	<p><li style="text-align:center"> <small class="grey1"> Copyright &copy; <?php echo date("Y"); ?>  All rights  Reserved <br /> 
                Developed by <a href="http://facebook.com/abhishburk" target="target_blank">Abhishek Burkule</a></small> 
                <small class="grey1">|<a href="faq.php" target="target_blank"> Faq </a>|
                <a href="contactus.php" target="target_blank"> Contact us</a></li></p>
            </ul>
        </div><div class="div-title"></div>	
        </div>
  
<!--total info Ends Here-->
<div class="clearfix"></div>
</div>
</div>
<script src="assets/js/myscript.js"></script>
<script src="assets/my-js/authentication.js"></script></body>
</html>