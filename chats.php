<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Chats <?php include 'includes/title.php'; ?></title>

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
	<?php include 'includes/left_panel.php'; ?>
    
    <div class="col-md-4 grid_2">
            <!--Personal Chats-->
            <div class="white-area"><h5>Chats</h5></div>
            <div class="profile_container scroll">
                <ul class="listing">
                	<div id="chats"></div>
                    
                    <script>
					$(document).ready(function(){
						//initially loading chats
						$("#chats").html('<center><img src="images/spinner.gif" style="width: 50px;"></center>');
						$.ajax({
							type: "POST",
							url: "manipulates/load_chat.php",
							success: function (response) {
								document.getElementById("chats").innerHTML=response; 
							}
							});
						setInterval(function(){// wait for 5 secs(2)
						$.ajax({
							type: "POST",
							url: "manipulates/load_chat.php",
							success: function (response) {
								document.getElementById("chats").innerHTML=response; 
							}
							});
						}, 10000);	
					});
                </script>
                </ul> 
            </div>
            
    </div>
    
    	
     <div class="col-md-3 grid_2">
     		<!--Group Chats-->
        	<div class="white-area"><h5>Group Chats</h5></div>
            <div class="profile_container ">
                <ul class="listing">
                	<div id="group_chats"></div>
                    <script>
					$(document).ready(function(){
						//initially loading chats
						$("#group_chats").html('<center><img src="images/spinner.gif" style="width: 50px;"></center>');
						$.ajax({
							type: "POST",
							url: "manipulates/load_group_chat.php",
							success: function (response) {
								document.getElementById("group_chats").innerHTML=response; 
							}
							});
						setInterval(function(){// wait for 5 secs(2)
						$.ajax({
							type: "POST",
							url: "manipulates/load_group_chat.php",
							success: function (response) {
								document.getElementById("group_chats").innerHTML=response; 
							}
							});
						}, 10000);	
					});
                </script>
                 </ul> 
            </div>
        
     </div>
    
    <?php include 'includes/right_panel.php'; ?>
<!--Container Ends Here-->
<div class="clearfix"></div>
</div>
<script src="assets/js/myscript.js"></script>
<script src="assets/my-js/message.js"></script>
<script src="assets/my-js/group_chat.js"></script>
</div>
</body>
</html>