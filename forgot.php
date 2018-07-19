<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Forgot Password <?php include 'includes/title.php'; ?></title>
<?php include 'includes/base.php'; ?>
<link href="assets/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom Theme files -->
<link href="assets/css/style.css" rel="stylesheet" type="text/css" media="all" />
<!-- Custom Theme files -->
<?php include 'includes/stylesheets.php'; ?>
</head>
<body style="background:-moz-linear-gradient(#E1F0FC, #C0BFBF) no-repeat fixed;">    
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
            <h4>Please enter your email-id to verify account</h4>
           
              <div class="project" style="border: 2px solid #fff;padding: 15px; display:block">
                  <form method="post">	
                    <input type="text" class="form_control_login" name="userEmail" placeholder="Your Email-ID" >
                    <br>
                    <span style="display: inline-block;width: 100%;">
                      <input type="submit" class="text btn btn-info floatright click_reset"  value="Reset">
                      <h5><a href="../alumini" class="click_forgot fright" style="margin-top: 20px;margin-right: 10px;" >Login </a></h5>
                      <h5><span id="message_forgot"></span></h5>
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
  
<!--total info Ends Here-->
<div class="clearfix"></div>
</div>
</div>
<script src="assets/js/myscript.js"></script>
<script src="assets/my-js/authentication.js"></script></body>
</html>