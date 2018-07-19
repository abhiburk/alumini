/* for email verification */
$(document).ready(function(){
	$(document).on("click", ".click_confirm_verification", function(e) {
		e.preventDefault();
		$('.click_confirm_verification').val('Verifying ...');
		var formData= $(this).closest('form').serialize();
		console.log(formData);
		$(".click_confirm_verification").css({"pointer-events":"none","cursor":"not-allowed","opacity":"0.3"});
		$.ajax({
			type: "POST",
			url: "manipulates/manipulate.php",
			data:formData ,
			success: function (response) {
				console.log(response);
				if(response=="true" ){
				setTimeout(function()
				{ window.location=("step/1");
				$('.click_confirm_verification').val('Success ...'); }, 2000);
				}else{
					$('.click_confirm_verification').val('Verify Account');
					$(".click_confirm_verification").css({"pointer-events":"","cursor":"","opacity":""});
					document.getElementById("message_verified").innerHTML=response; 
					}
			}
		}); 
	});
});

/* for forgot password authentication */
$(document).ready(function(){
	$(document).on("click", ".click_reset", function(e) {
		e.preventDefault();
		$('.click_reset').val('Authenticating...');
		var formData= $(this).closest('form').serialize();
		
		$(".click_reset").css({"pointer-events":"none","cursor":"not-allowed","opacity":"0.3"});
		$.ajax({
			type: "POST",
			url: "authentication/sendforgot.php",
			data:formData ,
			success: function (response) {
				console.log(response);
				if(response=="sent"){
				setTimeout(function()
				{  
				  $('.click_reset').val('Sending ...'); }, 2000);
				  document.getElementById("message_forgot").innerHTML=response;
				}else{
					document.getElementById("message_forgot").innerHTML=response; 
					$('.click_reset').val('Reset');
					$(".click_reset").css({"pointer-events":"","cursor":"","opacity":""});
					
					}
			}
		}); 
	});
});

/* for forgot form  (not used)*/
$(document).ready(function(){
	$(document).on("click", ".click_forgot", function(e) {
		$('#loading').html('Loading...');
		$("#login").css({"display":"none"});
		setTimeout(function()
				{ $("#forgot").show("slide",{direction:"left"},500);
				$('#loading').html(''); }, 1000);
	});
});

/* for signup authentication */
$(document).ready(function(){
	$(document).on("click", ".click_signup", function(e) {
		e.preventDefault();
		$('.click_signup').val('Authenticating...');
		var formData= $(this).closest('form').serialize();
		
		$(".click_signup").css({"pointer-events":"none","cursor":"not-allowed","opacity":"0.3"});
		$.ajax({
			type: "POST",
			url: "authentication/checkregister.php",
			data:formData ,
			success: function (response) {
				console.log(formData);
				if(response=="true"){
				//$("success").html("<div class='floating_message_red'>Account Successfully Created </div>");
				setTimeout(function()
				{ window.location=("verify.php?sent=1");
				$('.click_signup').val('Registering You ...'); }, 3000);
				}else{
					$('.click_signup').val('Create Account');
					$(".click_signup").css({"pointer-events":"","cursor":"","opacity":""});
					document.getElementById("message_signup").innerHTML=response; 
					}
			}
		}); 
	});
});

/* for login authentication */
$(document).ready(function(){
	$(document).on("click", ".click_login", function(e) {
		e.preventDefault();
		$('.click_login').val('Authenticating ...');
		var formData= $(this).closest('form').serialize();
		console.log(formData);
		$(".click_login").css({"pointer-events":"none","cursor":"not-allowed","opacity":"0.3"});
		$.ajax({
			type: "POST",
			url: "authentication/checklogin.php",
			data:formData ,
			success: function (response) {
				if(response=="true" ){
				setTimeout(function()
				{ window.location=("home.php");$('.click_login').val('Signing In ...'); }, 1000);
				}else if(response=="unvarified"){
				   window.location=("verify.php?unvarified=1");
				}else{
					$('.click_login').val('Login');
					$(".click_login").css({"pointer-events":"","cursor":"","opacity":""});
					document.getElementById("message_login").innerHTML=response; 
					}
			}
		}); 
	});
});