<?php 
include 'config.php';
if($userid==''){
header('location:index.php');	
	}
if($user['verificationCode']=='verified') {
	header('location:home.php');
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Verify <?php include 'includes/title.php'; ?></title>
<?php include 'includes/base.php'; ?>
<link href="assets/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom Theme files -->
<link href="assets/css/style.css" rel="stylesheet" type="text/css" media="all" />
<!-- Custom Theme files -->
<?php include 'includes/stylesheets.php'; ?>
</head>
<body>    
<div class="top-menu" style="position: fixed;z-index: 1;width: 100%;top: 0;"> 
    <ul class="menu_head">
       <li><h3>alumnai</h3></li>
    </ul>
</div>
<div class="container">
	<div class="total-info">
       <div class="col-md-4 grid_3"></div>
        
       <div class="col-md-4 grid_3">
       
          	<h5><span id="message_password"></span></h5>
          <div class="hire-me-2" style="margin-top: 8em;">
              <h4><small>Hello <b><?php echo $user['name']; ?></b>, Verification code has been sent to your email-id,Please enter verification code to confirm your Email-ID</small></h4>
              <div class="project" style="border: 2px solid #fff;padding: 15px; display:block">
                  <form method="post">
                  	<input type="hidden" name="xAction" value="email_verify">	
                    <input type="text" class="form_control_login" name="vcode" data-mask="a*-999-a999" placeholder="Verification Code" >
                    <br>
                    <span style="display: inline-block;width: 100%;">
                      <input type="submit" class="text btn btn-info floatright click_confirm_verification"  value="Verify Account">
                      <h5><a href="javascript:void(0);" class="fright click_verify_cancel" style="margin-top: 20px;margin-right: 10px;" >Cancel </a></h5>
                      <h5><span id="message_verified"></span></h5>
                    </span>
                  </form> 
                  <hr>
              </div>
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
 <script>
/* for verify cancel*/
$(document).ready(function(){
	$(document).on("click", ".click_verify_cancel", function(e) {
	window.location=("authentication/logout.php");
				
	});		
});				
 </script> 
<!--total info Ends Here-->
<div class="clearfix"></div>
</div>
</div>
<script src="assets/js/myscript.js"></script>
<script src="assets/my-js/authentication.js"></script>
</body>
</html>