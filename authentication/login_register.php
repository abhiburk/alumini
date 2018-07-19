
<!--Login Form-->
<div class="col-md-3 grid_2 flow">
  <div class="hide_login">
   <div class="white-area "><h5>Member Login</h5></div>
    <div class="hire-me hire-me-2">
      <div class="project">
      <form method="post">	
        <input type="text" class="form-control" name="userEmail" placeholder="Email-ID" required>
        <input type="password" class="form-control" name="userPass" placeholder="Password" required>
        <input type="submit" class="text btn btn-info btn-sm floatright click_login"  value="Login">
      </form> <span id="message"></span><br>
      
      <!--Forgot Password Form-->
      <h5><a href="javascript:void(0);" class="click_register_login">Register</a> | 
      <a href="javascript:void(0);" class="click_forgot">Forgot Password ?</a></h5>
      <div class="hide_forgot" id="scroll_for">  
      <form method="post">	  
        <input type="text" class="form-control" name="userEmail" placeholder="Email-ID" required>
        <input type="submit" class="text btn btn-info btn-sm floatright click_reset"  value="Reset">
      </form> <span id="message_forgot"></span><br> 
      </div>
     <!--Forgot Password End-->
     
      </div>
    </div>
  </div> 
</div>   
<!--Login Form- End->
    
<!--Register Form-->
<div class="col-md-3 grid_2 flow">
  <div class="hide_register"> 
   <div class="white-area "><h5>Member Signup</h5></div>
    <div class="hire-me hire-me-2">
      <div class="project">
      	<form method="post">
         <input type="text" class="form-control" name="firstName" placeholder="First Name" value="<?php echo $_SESSION['firstName'];?>" required>
         <input type="text" class="form-control" name="lastName" placeholder="Last Name" value="<?php echo $_SESSION['lastName'];?>" required>
         <input type="text" class="form-control" name="userEmail" placeholder="Email-ID" value="<?php echo $_SESSION['userEmail'];?>" required>
         <input type="password" class="form-control" name="userPass" placeholder="Password" required>
         <h6>Birthday</h6>
         <select name="day" class='form-control1' required>
              <option value="">Date</option>
                  <?php $k=0; 
                  for($i=1;$i<=31;$i++) {?>
                  <option value="<?php if($i<=9) {echo $k;} echo $i; ?>"<?php if($_SESSION['day']== $k.''.$i){ echo 'selected';} ?>>
                  <?php if($i<=9) echo $k; echo $i ; } ?>
              </option>
          </select>

          <select name="month" class='form-control1' required>
              <option value="">Of</option>
              <option value="01"<?php if($_SESSION['month'] == '01'){ echo 'selected';};?>> January		</option>
              <option value="02"<?php if($_SESSION['month'] == '02'){ echo 'selected';};?>> February	</option>
              <option value="03"<?php if($_SESSION['month'] == '03'){ echo 'selected';};?>> March		</option>
              <option value="04"<?php if($_SESSION['month'] == '04'){ echo 'selected';};?>> April		</option>
              <option value="05"<?php if($_SESSION['month'] == '05'){ echo 'selected';};?>> May			</option>
              <option value="06"<?php if($_SESSION['month'] == '06'){ echo 'selected';};?>> June		</option>
              <option value="07"<?php if($_SESSION['month'] == '07'){ echo 'selected';};?>> July		</option>
              <option value="08"<?php if($_SESSION['month'] == '08'){ echo 'selected';};?>> August		</option>
              <option value="09"<?php if($_SESSION['month'] == '09'){ echo 'selected';};?>> September	</option>
              <option value="10"<?php if($_SESSION['month'] == '10'){ echo 'selected';};?>> October		</option>
              <option value="11"<?php if($_SESSION['month'] == '11'){ echo 'selected';};?>> November	</option>
              <option value="12"<?php if($_SESSION['month'] == '12'){ echo 'selected';};?>> December	</option>
          </select>
          <select name="year" class='form-control1' required> 
              <option  value="">Birth</option><option
                <?php for($i=1950;$i<=2016;$i++) { ?>
              <option value="<?php echo $i; ?>"<?php if($_SESSION['year'] == $i){ echo 'selected';};?> >
               <?php echo  $i ?>
               <?php } ?>
              </option>
          </select><br/>
         <span class="radio_gender"> 
          <input type="radio" name="gender" value="Female"<?php if($_SESSION['gender'] == 'Female'){ echo 'checked';}?> class="form-control "> 
          <span class="radio_sub_gender">Female</span>
          <input type="radio" name="gender" value="Male"<?php if($_SESSION['gender'] == 'Male'){ echo 'checked';}?> class="form-control radio_sub_gender"> 			  		  <span class="radio_sub_gender">Male</span>
         </span><span id="error"></span><br/>
        <input type="submit" class="text btn btn-success click_signup"  value="Create Account">
       </form> 
        <br/>
        <h5><a href="javascript:void(0);" class="click_register_login ">Already have account ? Login Here</a> </h5>
      </div>
    </div>
  </div>
</div>  
<!--Register Form -->
  
  <!--JS For Hiding and Showing Login & Register Forms -->
  <script>
  $(document).ready(function(){
	  <?php if($_SESSION['firstName']==true) { ?>
	  $(".hide_register").show();
	  $(".hide_login").hide();
	  $(".hide_on_register").hide();
	  $(".click_register_login").click(function() {
	  $('html, body').animate({
        scrollTop: $(".hide_login").offset().top
      }, 2000);	  
  	  $(".hide_login").toggle(500);
	  $(".hide_register").toggle(500);
	  $(".hide_on_register").toggle(500);
	  });
	  <?php }else { ?>
	  $(".hide_register").hide();
	  $(".click_register_login").click(function() {
	  $('html, body').animate({
      scrollTop: $(".col-md-3").offset().top
      }, 2000);
  	  $(".hide_login").toggle(500);
	  $(".hide_register").toggle(500);
	  $(".hide_on_register").toggle(500);
  	  }); <?php } ?>
  });
  </script>
  <!--JS For Hiding and Showing Forgot -->
  <script>
  $(document).ready(function(){
	  $(".hide_forgot").hide();
	  $(".click_forgot").click(function() {
	  $('html, body').animate({
      scrollTop: $("#scroll_for").offset().top
      }, 2000);	  
  	  $(".hide_forgot").toggle(500);
  	  });
  });
  </script>
  