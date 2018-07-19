<?php 
include 'config.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Login & Register</title>
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
  
      <div class="col-md-9 grid_2">
        <div class="white-area"><h5>About</h5></div>
         <div class="hire-me">
           <div class="project">
              <ul class="join">
                <li ><img class="login-list" src="assets/icons/ok-144.png">Connect with your old friends </li>
                <li ><img class="login-list" src="assets/icons/ok-144.png">Share your experience with friends </li>
                <li ><img class="login-list" src="assets/icons/ok-144.png">View profiles and new friends </li>
                <li ><img class="login-list" src="assets/icons/ok-144.png">Share photos and videos </li>
                <li ><img class="login-list" src="assets/icons/ok-144.png">Create your groups or join other's </li>
              </ul>
              <h4>Get Connected !</h4>
              <a href="#" class="click_register_login">
              <div class="joinnow floatright">Join Now</div>
              </a> 
            </div>
          </div>
      <div class="clearfix"></div>
    </div>
    
   
    
 <?php include 'authentication/login_register.php'; ?>
</div><div class="div-title"></div>

  
  <div class="col-md-3 grid_2">
    <div class="white-area"><h5>Recent News</h5></div>
     <div class="hire-me hire-me-2 ">
       <div class="project">
         <!----start-tweets-scroller---->
		 <script type="text/javascript" src="assets/js/jquery.easy-ticker.js"></script>
			<script type="text/javascript">
			$(document).ready(function(){
			$('#demo').hide();
			$('.vticker').easyTicker();
			});
		</script>
		<!----start-tweets-scroller---->
            <div class="latest-tweets-box">
             <div class="vticker">
              <ul class="recent-news">
                <li >Connect with your old friends </li>
                <li >Share your experience with friends </li>
                <li >View profiles and new friends </li>
                <li >Share photos and videos </li>
                <li >Create your groups or join other's </li>
               </ul>
              </div>
            </div>
        
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
    
   <div class="col-md-3 grid_2">
    <div class="white-area"><h5>Events</h5></div>
     <div class="hire-me hire-me-2">
       <div class="project">
        <!----start-tweets-scroller---->
	    <div class="latest-tweets-box">
		 <div class="vticker">
		  <ul class="recent-news ">
            <li >Connect with your old friends </li>
            <li >Share your experience with friends </li>
            <li >View profiles and new friends </li>
            <li >Share photos and videos </li>
            <li >Create your groups or join other's </li>
           </ul>
		  </div>
		</div>
        <!----end-tweets-scroller---->
        </div>
      </div>
      <div class="clearfix"></div>
    </div>

  

</div>

<?php include 'includes/footer.php'; ?>
<script src="assets/js/myscript.js"></script>
</div>
</body>
</html>