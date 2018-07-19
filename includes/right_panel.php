</div><!--End Center Div-->
<div class="col-md-3 grid_3 mydiv">
		
        <!--Network Stats-->
    	<div class="white-area"><h5>Network Stats</h5></div>
    <div class="profile_container">
    
    	<?php 
		$count_mem=mysqli_num_rows(mysqli_query($dbconfig,"SELECT * FROM users"));
		$count_groups=mysqli_num_rows(mysqli_query($dbconfig,"SELECT * FROM user_groups"));
		$count_posts=mysqli_num_rows(mysqli_query($dbconfig,"SELECT * FROM posts"));
		$count_friends=mysqli_num_rows(mysqli_query($dbconfig,"SELECT * FROM my_friends WHERE userID=".$userid." or friendWith=".$userid." "));
		$count_mem=mysqli_num_rows(mysqli_query($dbconfig,"SELECT * FROM users"));
		?>
    
        <ul class="listing">
          <li class="subitem">
          <span class="full">
          <i class="icon-group"></i> Members <small class="floatright"><?php echo $count_mem; ?></small></li>
          </span>
          <li class="subitem"><i class="icon-pencil"></i> Posts <small class="floatright"><?php echo $count_posts; ?></small></li>
          <li class="subitem"><i class="icon-group"></i> Groups <small class="floatright"><?php echo $count_groups; ?></small></li>
          <li class="subitem"><i class="icon-user"></i> Friends <small class="floatright"><?php echo $count_friends; ?></small></li>
        </ul>
          <script>
          	/*var windw = this;

$.fn.followTo = function ( pos ) {
    var $this = this,
        $window = $(windw);
    
    $window.scroll(function(e){
        if ($window.scrollTop() > pos) {
            $this.css({
                
				 position: 'fixed',
				
				
                top: pos
            });
        } else {
            $this.css({
				position: 'absolute',
                right:0,
                top: 68
            });
        }
    });
};

$('.mydiv').followTo(1);*/
          </script>
          <!----> 
          <script type="text/javascript" src="js/jquery-ui.min.js"></script>
          <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
          <!--<script type='text/javascript'>//<![CDATA[ 
					$(window).load(function(){
					 $( "#slider-range" ).slider({
								range: true,
								min: 0,
								max: 400000,
								values: [ 8500, 350000 ],
								slide: function( event, ui ) {  $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
								}
					 });
					$( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) + " - $" + $( "#slider-range" ).slider( "values", 1 ) );

					});//]]>  

					</script>--> 
                    
       </div><div class="div-title"></div>
        
    	<!--Online Members-->
        <div class="white-area"><h5>Active</h5></div>
        <div class="profile_container scroll1">
            <ul class="listing">
            <?php 
			$sql_online=mysqli_query($dbconfig,"SELECT (time),t.* FROM ( (SELECT $name,userImg,u.userID,session_time AS time FROM user_session AS s 
				LEFT JOIN users AS u ON s.userID=u.userID 
                WHERE s.userID!='".$userid."' ORDER BY session_time DESC)
				UNION
				(SELECT $name,userImg,u.userID,activeTime as time FROM user_active AS a LEFT JOIN users AS u ON a.userID=u.userID 
                WHERE a.userID!='".$userid."' ORDER BY activeTime DESC LIMIT 7)) AS t ORDER BY time DESC ") or die(mysqli_error($dbconfig));
                $count_online=mysqli_num_rows($sql_online);
                if($count_online==0){echo '<small class="grey" style="padding:5px;">0 user online</small>';}else {
                while($online_user=mysqli_fetch_assoc($sql_online)){
			?>
            <a href="message/<?php echo $online_user['userID']; ?>" class="grey">
              <li class="subitem_grey" style="padding:5px; "> 
                    <img src="<?php if($online_user['userImg']==''){echo 'images/default.jpg';}else {
                    echo 'uploads/'.$online_user['userImg']; } ?>" alt="User Avatar" class="recent_chat">
                  <small class="" style="margin-left: 5px;"> 
				    <?php echo $online_user['name']; ?>
                  </small>
                  <small class="" style="float:right; margin-top:8px;">
                   <?php 
				   //for online and last active
					$sql_session=mysqli_query($dbconfig,"SELECT * FROM user_session WHERE userID='".$online_user['userID']."'");
					$check_active=mysqli_num_rows($sql_session);
					$sql_active=mysqli_query($dbconfig,"SELECT * FROM user_active WHERE userID='".$online_user['userID']."' ");
					$row_active=mysqli_fetch_assoc($sql_active);
				   if($check_active==true){echo '<small class="btn btn-success btn-xs btn-circle"></small>';}
			  else {
		 	  echo "" . humanTiming( $row_active['activeTime'] ). ""; }?>
                  </small>
              </li>
              </a>  
              <?php }} ?>
             </ul> 
        </div><div class="div-title">
        
        <!--Newest Members-->
 		<small class="floatright" style="margin-top:-5px;"> <!--<a href="#">View All</a>--></small></div>
        <div class="white-area"><h5>Newest Members</h5></div>
        <div class="profile_container scroll1">
            <ul class="listing">
            <?php 
            $sql_newest_mem=mysqli_query($dbconfig,"SELECT *,$name FROM users WHERE users.userID!='".$userid."'
            ORDER BY userID DESC LIMIT 10");
            while($row_newest_mem=mysqli_fetch_assoc($sql_newest_mem)){
            ?>
            <a href="<?php if($row_newest_mem['webName']==''){echo 'user/'.$row_newest_mem["userID"].'';}else{ echo 'user/'.$row_newest_mem["webName"].'';}  ?>" class="grey">
              <li class="subitem_grey" style="padding:5px; "> 
                    <img src="<?php if($row_newest_mem['userImg']==''){echo 'images/default.jpg';}else {
                    echo 'uploads/'.$row_newest_mem['userImg']; } ?>" alt="User Avatar" class="recent_chat">
                  <small class="" style="margin-left: 5px;"> 
				    <?php echo $row_newest_mem['name']; ?>
                    
                  </small>
                  <small class="" style="float:right; margin-top:8px;">
                   <?php 
			 	  echo "Join " . humanTiming( $row_newest_mem['createTime'] ). ""; ?>
                  </small>
              </li>
              </a>  
              <?php }?>
             </ul> 
        </div> <div class="div-title"></div>
        
        <!--Copyright-->
        <div class="white-area"><h5>Copyright</h5></div>
        <div class="profile_container">
            <ul class="cute">
            	<p><li> <small class="grey1"> Copyright &copy; <?php echo date("Y"); ?>  All rights  Reserved <br /> 
                Developed by <a href="http://facebook.com/abhishburk" target="target_blank">Abhishek Burkule</a></small></li></p>
            </ul>
        </div><div class="div-title"></div>	   
    

    
</div><!--end col-md-3-->