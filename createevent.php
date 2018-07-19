<?php include 'config.php'; 

$view = isset($_REQUEST['view']) ? htmlentities($_REQUEST['view']) : '';
$eid = isset($_REQUEST['eid']) ? htmlentities($_REQUEST['eid']) : '';
$menu = isset($_REQUEST['menu']) ? htmlentities($_REQUEST['menu']) : '';

$sql_event=mysqli_query($dbconfig,"SELECT * FROM user_events WHERE eventID='".$eid."' AND userID='".$userid."'") or die(mysqli_error($dbconfig));
$row_event=mysqli_fetch_assoc($sql_event);
$eventid=$row_event['eventID'];
if($view=='editevent'){
	if($eventid==''){
		include 'includes/error.php';	
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Create Event <?php include 'includes/title.php'; ?></title>
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
	<?php include 'includes/left_panel.php'; ?>
    
    <div class="col-md-4 grid_2">
    
    	<?php if($view=='editevent'){ ?>
            <div class="white-area"><h5>Edit</h5></div>
            <div class="hire-me">
                <ul class="cute">
                  <form method="POST">
                  <input type="hidden" name="xAction" value="update_event">
                  <input type="hidden" class="eid" name="eid" value="<?php echo $eventid; ?>">   	
                  <li> <input type="text" name="ename" class="form-control-search" value="<?php echo $row_event['eventName']; ?>"  /></li>
                  <hr>
                  <li><input type="text" name="elocation" class="form-control-search" value="<?php echo $row_event['eventLocation']; ?>" /></li> 
                  <hr>
        
                  <!--Event Date-->
                  <li> 
                   <label class="grey">Event Date</label>
                   <br/>
                        <select name="eventDay" class='form-control1' required>
                          <option value="">Date</option>
                              <?php $k=0; 
                              for($i=1;$i<=31;$i++) { ?>
                              <option value="<?php if($i<=9) echo $k; echo $i ?>"
                              <?php if(substr($row_event['eventDate'],8,6) == $k.''.$i)
                              { echo 'selected';} ?>>
                              <?php if($i<=9) echo $k; echo $i;}  ?>
                          </option>
                          </option>
                        </select>
                        <select name="eventMonth" class='form-control1' required>
                          <option value="01"<?php if(substr($row_event['eventDate'],5,2) == '01'){ echo 'selected';};?>>January</option>
                          <option value="02"<?php if(substr($row_event['eventDate'],5,2) == '02'){ echo 'selected';};?>>February</option>
                          <option value="03"<?php if(substr($row_event['eventDate'],5,2) == '03'){ echo 'selected';};?>>March</option>
                          <option value="04"<?php if(substr($row_event['eventDate'],5,2) == '04'){ echo 'selected';};?>>April</option>
                          <option value="05"<?php if(substr($row_event['eventDate'],5,2) == '05'){ echo 'selected';};?>>May</option>
                          <option value="06"<?php if(substr($row_event['eventDate'],5,2) == '06'){ echo 'selected';};?>>June</option>
                          <option value="07"<?php if(substr($row_event['eventDate'],5,2) == '07'){ echo 'selected';};?>>July</option>
                          <option value="08"<?php if(substr($row_event['eventDate'],5,2) == '08'){ echo 'selected';};?>>August</option>
                          <option value="09"<?php if(substr($row_event['eventDate'],5,2) == '09'){ echo 'selected';};?>>September</option>
                          <option value="10"<?php if(substr($row_event['eventDate'],5,2) == '10'){ echo 'selected';};?>>October</option>
                          <option value="11"<?php if(substr($row_event['eventDate'],5,2) == '11'){ echo 'selected';};?>>November</option>
                          <option value="12"<?php if(substr($row_event['eventDate'],5,2) == '12'){ echo 'selected';};?>>December</option>
                        </select>
                        <select name="eventYear" class='form-control1' required> 
                          <option  value="">Year</option>
                          <?php for($i=2017;$i<=2025;$i++)
                            { echo "<option value=".$i." " ?>
                            <?php if(substr($row_event['eventDate'],0,4) == $i)
                            { echo 'selected';} ?>> <?php echo  $i;} ?>
                          </option>
                        </select>
                  </li>
        
                  <!--Event Time-->
                  <li> 
                      <label class="grey">Event Time</label><br>
                      <select name="hour" class="form-control1" required>
                        <option  value="">Hour</option>
                        <?php $k=0; 
                              for($i=1;$i<=12;$i++) { ?>
                              <option value="<?php if($i<=9) echo $k; echo $i ?>"
                              <?php if(substr($row_event['eventTime'],0,2) == $k.''.$i)
                              { echo 'selected';} ?>>
                              <?php if($i<=9) echo $k; echo $i;}?>
                      </select>
                      
                       <select name="minute" class="form-control1" required>
                        <option  value="">Minute</option>
                            <?php $k=0; 						  
                              for($i=0;$i<=60;$i++) {?>
                              <option value="<?php if($i<=9) echo $k; echo $i ?>"<?php if(substr($row_event['eventTime'],3,2) == $k.''.$i)
                            { echo 'selected';} ?>>
                              <?php if($i<=9) echo $k; echo $i; } ?>
                        </option>
                      </select> 
                      <select name="mode" class="form-control1" required>
                       <option  value="">Mode</option>
                        <option value="pm"<?php if(date('a',strtotime($row_event['eventTime']))== 'pm' )
                            { echo 'selected';} ?>>PM</option>
                        <option value="am"<?php if(date('a',strtotime($row_event['eventTime']))== 'am' )
                            { echo 'selected';} ?>>AM</option>
                      </select>  
                  </li>
                  
                  <li><label class="grey">Event Details</label><br>
                  <textarea name="edetails" class="form-control"><?php echo $row_event['eventDetails']; ?></textarea></li>
                  <li><input type="submit" class="btn btn-primary btn-sm search_btn form-control click_update_event" value="Save" /></li>
                </form>
                </ul>
            </div> 
            
            <?php }else if($view=='event') { // create event form ?>
                <div class="white-area"><h5>Create New Event</h5></div>
            <div class="hire-me">
                
                <ul class="cute">
                <form method="POST">
                <input type="hidden" name="xAction" value="create_event">  	
                  <li> <input type="text" name="ename" class="form-control-search" placeholder="Event Name" required /></li>
                  <hr>
                  <li><input type="text" name="elocation" class="form-control-search" placeholder="Event Location" required/></li> 
                  <hr>
        
                  <!--Event Date-->
                  <li> 
                   <label class="grey">Event Date</label>
                 
                   <br/>
                        <?php $day=date(('d')); ?>
                        <select name="eventDay" class='form-control1' required>
                               <?php $k=0; 						  
                              for($i=1;$i<=31;$i++) {?>
                              <option value="<?php if($i<=9){echo $k;}echo $i; ?>"<?php if($day==$k.''.$i){echo 'selected';} ?>>
                              <?php if($i<=9){ echo $k;} echo $i;} ?>
                          </option>
                        </select>
                         <?php $month=date(('m')); ?>
                        <select name="eventMonth" class='form-control1' required>
                          <option value="01"<?php if($month=='01'){echo 'selected';} ?>> January		</option>
                          <option value="02"<?php if($month=='02'){echo 'selected';} ?>> February	</option>
                          <option value="03"<?php if($month=='03'){echo 'selected';} ?>> March		</option>
                          <option value="04"<?php if($month=='04'){echo 'selected';} ?>> April		</option>
                          <option value="05"<?php if($month=='05'){echo 'selected';} ?>> May			</option>
                          <option value="06"<?php if($month=='06'){echo 'selected';} ?>> June		</option>
                          <option value="07"<?php if($month=='07'){echo 'selected';} ?>> July		</option>
                          <option value="08"<?php if($month=='08'){echo 'selected';} ?>> August		</option>
                          <option value="09"<?php if($month=='09'){echo 'selected';} ?>> September	</option>
                          <option value="10"<?php if($month=='10'){echo 'selected';} ?>> October		</option>
                          <option value="11"<?php if($month=='11'){echo 'selected';} ?>> November	</option>
                          <option value="12"<?php if($month=='12'){echo 'selected';} ?>> December	</option>
                        </select>
                        <?php $year=date(('Y')); ?>
                        <select name="eventYear" class='form-control1' required> 
                            <?php for($i=2017;$i<=2050;$i++) { ?>
                          <option value="<?php echo $i; ?>" <?php if($year==$i){echo 'selected';} ?>>
                           <?php echo $i; } ?>
                          </option>
                        </select>
                  </li>
                                
                  <!--Event Time-->
                  <li> 
                    <?php $hour=date(('h'));  ?>
                      <label class="grey">Event Time</label><br>
                      <select name="hour" class="form-control1" required>
                            <?php $k=0; 						  
                              for($i=1;$i<=12;$i++) {?>
                              <option value="<?php if($i<=9){echo $k;}echo $i; ?>"<?php if($hour==$k.''.$i){echo 'selected';} ?>>
                              <?php if($i<=9){ echo $k;} echo $i ?>
                              <?php } ?>
                        </option>
                      </select>
                      <?php $min=date(('i')); ?>
                       <select name="minute" class="form-control1" required>
                            <?php $k=0; 						  
                              for($i=0;$i<=60;$i++) {?>
                             <option value="<?php if($i<=9){echo $k;}echo $i; ?>"<?php if($min==$k.''.$i){echo 'selected';} ?>>
                              <?php if($i<=9) echo $k; echo $i ?>
                              <?php } ?>
                             </option>
                      </select> 
                      <?php $mode=date(('A')); ?>
                      <select name="mode" class="form-control1" required>
                        <option value="PM"<?php if($mode=='PM'){echo 'selected';} ?>>PM</option>
                        <option value="AM"<?php if($mode=='AM'){echo 'selected';} ?>>AM</option>
                      </select>  
                  </li>
                  
                  <li><label class="grey">Event Details</label><br>
                  <textarea name="edetails" class="form-control" placeholder="Event Details"></textarea></li>
                  <li><input type="submit" class="btn btn-primary btn-sm search_btn form-control click_create_event" value="Save & Continue" /></li>
                </form>
                </ul>
            </div>
        
        <?php } ?>

		<?php if($menu=='upcoming') { ?>   
        	<?php 
				$sql_event=mysqli_query($dbconfig,"SELECT e.eventID AS id,e.eventName as name,e.eventImg as img,e.eventDate as date,'user_events' AS comes_from
				FROM user_events AS e 
				WHERE MONTH(eventDate) = MONTH(NOW()) 
				AND DAY(eventDate) BETWEEN DAY(NOW()) AND (DAY(NOW()) + 7)
				
				UNION
				  
				SELECT u.userID as id,CONCAT(firstName,' ',lastName) as name,u.userImg as img,birthday as date,'users' AS comes_from 
				FROM users AS u
				WHERE MONTH(birthday) = MONTH(NOW()) 
				AND DAY(birthday) BETWEEN DAY(NOW()) AND (DAY(NOW()) + 7)
				ORDER BY day(date) ASC ") or die (mysqli_error($dbconfig));
                $check_event=mysqli_num_rows($sql_event);
				$check_event = isset($_REQUEST['check_event']) ? htmlentities($_REQUEST['check_event']) : '';
			?> 
            
            <div class="white-area"><h5>Upcoming Events (<?php echo $check_event; ?>)</h5></div>
            <div class="profile_container <?php if($check_event>10){echo 'scroll';} ?>">
                <ul class="listing">
                <?php 
				$curr_day=date("n-j"); //n stand for months without leading zeros and j for days without leading zeros
				$tomorrow=date("n-j",strtotime('+1 days'));
				$twodays=date("n-j",strtotime('+2 days'));
				$threedays=date("n-j",strtotime('+3 days'));
				$next_7_day=date("n-j",strtotime('+7 days'));
				
                if($check_event==0){echo '<h5 class="invite1 grey1">No event available</h5>';}else{
                while($row_event=mysqli_fetch_assoc($sql_event)){
					if($row_event['comes_from']=='user_events'){
                ?>
                  <a href="event/<?php echo $row_event['id']; ?>">
				  <?php }else { ?>
                  <a href="user/<?php echo $row_event['id']; ?>">
				  <?php } ?>
                      <li class="subitem_grey" style="padding:5px; "> 
                            <img src="<?php if($row_event['img']==''){echo 'images/event.jpg';}else {
                            echo 'uploads/	'.$row_event['img']; } ?>" alt="User Avatar" class="recent_chat">
                          <small id="break_inline"> 
                            <b><?php echo $row_event['name']; ?></b>
                            <?php if($row_event['comes_from']=='users'){echo '<i class="icon-gift"></i>'; }else {echo '<i class="icon-calendar"></i>';} ?>
                          </small>
                          <small id="right_btn">
                           <?php if(date("n-j",strtotime($row_event['date']))==$curr_day){echo '<b>Today</b>';}else if(date("n-j",strtotime($row_event['date']))==$tomorrow){echo 'Tomorrow';} 
							else if(date("n-j",strtotime($row_event['date']))==$twodays){echo date("l",strtotime('+2 days'));}
							else if(date("n-j",strtotime($row_event['date']))==$threedays){echo date("l",strtotime('+3 days'));}else {echo date('d-F-Y',strtotime($row_event['date']));} ?> 
                         </small>
                      </li>
                  </a> 
                 <?php }} ?>
                 
                 </ul> 
            </div>
			
		<?php } ?>
		
        <?php if($menu=='invites') { ?>   
			<?php 
            $sql_event=mysqli_query($dbconfig,"SELECT *,CONCAT(firstName,' ',lastName) AS name 
            FROM user_events AS e LEFT JOIN invitation AS i ON e.eventID=i.referenceID
            LEFT JOIN users AS u ON u.userID=i.userID
            WHERE i.inviteTo='".$userid."' AND type='event.invite' ");
            $check_event=mysqli_num_rows($sql_event);
			$check_event = isset($check_event) ? htmlentities($check_event) : '';
            ?> 
            <div class="white-area"><h5>Event Invites (<?php echo $check_event; ?>)</h5></div>
            <div class="profile_container <?php if($check_event>10){echo 'scroll';} ?>">
                <ul class="listing">
                <?php 
                if($check_event==0){echo '<h5 class="invite1 grey1">No event available</h5>';}else{
                while($row_event=mysqli_fetch_assoc($sql_event)){
                ?>
                  <a href="event/<?php echo $row_event['eventID']; ?>">
                      <li class="subitem_grey" style="padding:5px; "> 
                            <img src="<?php if($row_event['eventImg']==''){echo 'images/event.jpg';}else {
                            echo 'uploads/	'.$row_event['eventImg']; } ?>" alt="User Avatar" class="recent_chat">
                          <small id="break_inline"> 
                            <b><?php echo $row_event['eventName']; ?></b>
                          </small>
                          <small id="right_btn">
                            Invited by <?php echo $row_event['name']; ?> 
                          </small>
                      </li>
                  </a> 
                 <?php }} ?>
                 </ul> 
            </div>
			
		<?php } ?>
        
        <?php if($menu=='myevents') { ?>    
        	<?php 
			$sql_event=mysqli_query($dbconfig,"SELECT * FROM user_events WHERE userID='".$userid."' ");
            $check_event=mysqli_num_rows($sql_event);
			$check_event = isset($check_event) ? htmlentities($check_event) : '';
			?>
            <div class="white-area"><h5>My Events (<?php echo $check_event; ?>)</h5></div>
            <div class="profile_container <?php if($check_event>10){echo 'scroll';} ?>">
                <ul class="listing">
                <?php 
                if($check_event==0){echo '<h5 class="invite1 grey1">No event available</h5>';}else{
                while($row_event=mysqli_fetch_assoc($sql_event)){
                    
                    $sql_count=mysqli_query($dbconfig,"SELECT userID FROM event_status WHERE eventID='".$row_event['eventID']."'");
                    $count_members=mysqli_num_rows($sql_count);
					$count_members = isset($count_members) ? htmlentities($count_members) : '';
                ?>
                  <a href="event/<?php echo $row_event['eventID']; ?>">
                      <li class="subitem_grey" style="padding:5px; "> 
                            <img src="<?php if($row_event['eventImg']==''){echo 'images/event.jpg';}else {
                            echo 'uploads/	'.$row_event['eventImg']; } ?>" alt="User Avatar" class="recent_chat">
                          <small id="break_inline"> 
                            <b><?php echo $row_event['eventName']; ?></b>
                          </small>
                          <small id="right_btn">
                            <?php echo $count_members; ?> Attending
                          </small>
                      </li>
                  </a> 
                 <?php }} ?>
                 </ul> 
            </div>
			
		<?php } ?>
        
        <?php if($menu=='declined') { ?>    
        	<?php 
			$sql_event=mysqli_query($dbconfig,"SELECT * FROM user_events AS e LEFT JOIN event_status USING (eventID)
			WHERE e.userID='".$userid."' AND status='Declined' ");
            $check_event=mysqli_num_rows($sql_event);
			$check_event = isset($check_event) ? htmlentities($check_event) : '';
			?>
            <div class="white-area"><h5>Declined Events (<?php echo $check_event; ?>)</h5></div>
            <div class="profile_container <?php if($check_event>10){echo 'scroll';} ?>">
                <ul class="listing">
                <?php 
                if($check_event==0){echo '<h5 class="invite1 grey1">No event available</h5>';}else{
                while($row_event=mysqli_fetch_assoc($sql_event)){
                    
                    $sql_count=mysqli_query($dbconfig,"SELECT userID FROM event_status WHERE eventID='".$row_event['eventID']."'");
                    $count_members=mysqli_num_rows($sql_count);
					$count_members = isset($count_members) ? htmlentities($count_members) : '';
                ?>
                  <a href="event/<?php echo $row_event['eventID']; ?>">
                      <li class="subitem_grey" style="padding:5px; "> 
                            <img src="<?php if($row_event['eventImg']==''){echo 'images/event.jpg';}else {
                            echo 'uploads/	'.$row_event['eventImg']; } ?>" alt="User Avatar" class="recent_chat">
                          <small id="break_inline"> 
                            <b><?php echo $row_event['eventName']; ?></b>
                          </small>
                          <small id="right_btn">
                            <?php echo $count_members; ?> Attending
                          </small>
                      </li>
                  </a> 
                 <?php }} ?>
                 </ul> 
            </div>
			
		<?php } ?>
        
        
        <?php if($menu=='pastevent') { ?>    
        	<?php 
			$sql_event=mysqli_query($dbconfig,"SELECT * FROM user_events AS e
			WHERE e.userID='".$userid."' AND eventDate < DATE(NOW())  ");
            $check_event=mysqli_num_rows($sql_event);
			$check_event = isset($check_event) ? htmlentities($check_event) : '';
			?>
            <div class="white-area"><h5>Past Events (<?php echo $check_event; ?>)</h5></div>
            <div class="profile_container <?php if($check_event>10){echo 'scroll';} ?>">
                <ul class="listing">
                <?php 
                if($check_event==0){echo '<h5 class="invite1 grey1">No event available</h5>';}else{
                while($row_event=mysqli_fetch_assoc($sql_event)){
                    
                    $sql_count=mysqli_query($dbconfig,"SELECT userID FROM event_status WHERE eventID='".$row_event['eventID']."'");
                    $count_members=mysqli_num_rows($sql_count);
					$count_members = isset($count_members) ? htmlentities($count_members) : '';

                ?>
                  <a href="event/<?php echo $row_event['eventID']; ?>">
                      <li class="subitem_grey" style="padding:5px; "> 
                            <img src="<?php if($row_event['eventImg']==''){echo 'images/event.jpg';}else {
                            echo 'uploads/	'.$row_event['eventImg']; } ?>" alt="User Avatar" class="recent_chat">
                          <small id="break_inline"> 
                            <?php echo $row_event['eventName']; ?>
                          </small>
                          <small id="right_btn">
                            <?php echo $count_members; ?> Attended
                          </small>
                      </li>
                  </a> 
                 <?php }} ?>
                 </ul> 
            </div>
			
		<?php } ?>
        
		<?php if($menu=='birthday') { ?>   
        	<?php 
			$sql_event=mysqli_query($dbconfig,"SELECT u.userID as id,CONCAT(firstName,' ',lastName) as name,u.userImg as img,birthday as date,'users' AS comes_from 
				FROM users AS u
				WHERE MONTH(birthday) = MONTH(NOW()) 
				AND DAY(birthday) BETWEEN DAY(NOW()) AND (DAY(NOW()) + 7)
				ORDER BY day(date) ASC ") or die (mysqli_error($dbconfig));
                $check_event=mysqli_num_rows($sql_event);
				$check_event = isset($check_event) ? htmlentities($check_event) : '';
			?> 
            
            <div class="white-area"><h5>Upcoming Birthdays (<?php echo $check_event; ?>)</h5></div>
            <div class="profile_container <?php if($check_event>10){echo 'scroll';} ?>">
                <ul class="listing">
                <?php 
				$curr_day=date("n-j"); //n stand for months without leading zeros and j for days without leading zeros
				$tomorrow=date("n-j",strtotime('+1 days'));
				$twodays=date("n-j",strtotime('+2 days'));
				$next_7_day=date("n-j",strtotime('+7 days'));

                if($check_event==0){echo '<h5 class="invite1 grey1">No birthdays available</h5>';}else{
                while($row_event=mysqli_fetch_assoc($sql_event)){
                ?>
                  <a href="user/<?php echo $row_event['id']; ?>">
                      <li class="subitem_grey" style="padding:5px; "> 
                            <img src="<?php if($row_event['img']==''){echo 'images/event.jpg';}else {
                            echo 'uploads/	'.$row_event['img']; } ?>" alt="User Avatar" class="recent_chat">
                          <small id="break_inline"> 
                            <b><?php echo $row_event['name']; ?></b>
                            <i class="icon-gift"></i>
                          </small>
                          <small id="right_btn">
                            <?php if(date("n-j",strtotime($row_event['date']))==$curr_day){echo '<b>Today</b>';}else if(date("n-j",strtotime($row_event['date']))==$tomorrow){echo 'Tomorrow';} 
							else if(date("n-j",strtotime($row_event['date']))==$twodays){echo date("l",strtotime('+2 days'));}else {echo $row_event['date'];} ?> 
                         </small>
                      </li>
                  </a> 
                 <?php }} ?>
                 
                 </ul> 
            </div>
			
		<?php } ?>
        
    </div>
    
    <div class="col-md-3 grid_2">
    	<div class="white-area"><h5>Menu</h5></div>
        <div class="profile_container">
            <ul class="cute">
            	<li><a href="event/upcoming"><i class="icon-calendar"></i> Upcoming Events</li></a>
                <li><a href="event/invites"><i class="icon-envelope-alt "></i> Event Invites</li></a>
                <li><a href="event/myevents"><i class="icon-home"></i> My Events</li></a>
                <li><a href="event/declined"><i class="icon-remove"></i> Declined Events</li></a>
                <li><a href="event/pastevent"><i class="icon-time"></i> Past Events</li></a>
                <li><a href="event/birthday"><i class="icon-gift"></i> Birthday</li></a>
            </ul>
        </div>
        <div class="div-title"></div>
    </div>
   
    <?php include 'includes/right_panel.php'; ?>

<!--Container Ends Here-->
<div class="clearfix"></div>
</div>
<script src="assets/js/myscript.js"></script>
<script src="assets/my-js/event.js"></script>
</div>
</body>
</html>