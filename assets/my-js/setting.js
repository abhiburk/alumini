/*Click Edit*/
$(document).ready(function(e) {
$(document).on("click", ".click_edit", function (e) {
var id=this.rel;	
$(".show"+id).toggle();	
$(".hide"+id).toggleClass("display_none");	
});
});

/* for change password */
$(document).ready(function(e) {
	$(document).on("click", ".click_change_password", function (e) {
		$("#change_message").html('Loading ...');
		e.preventDefault();		
		var formData= $(this).closest('form').serialize();
		console.log(formData);
		$.ajax({
		type: "POST",
		url: "manipulates/manipulate.php",
		data:formData ,
		success: function (response) {
		$(".click_change_password").css({"pointer-events":"","cursor":"","opacity":""});
		//document.getElementById("change_message").innerHTML=response;
		if(response=='true'){
		$("#change_message").html('<b style="color:green;font-size: 12px;">Your password has been updated successfully</b>');
		}else if(response=='false'){
			$("#change_message").html('<b style="color:red;font-size: 12px;">Failed to update password, try again</b>');	
			}else if(response=='notmatch'){
				$("#change_message").html('<b style="color:red;font-size: 12px;">New Password doesnt match, please try again.</b>');	
				}else if(response=='oldpass'){
				$("#change_message").html('<b style="color:red;font-size: 12px;">Incorrect Old Password.</b>');	
				}else if(response=='lenght'){
				$("#change_message").html('<b style="color:red;font-size: 12px;">* Entered password must be 8 or more then 8 characters.</b>');	
				}else if(response=='field'){
				$("#change_message").html('<b style="color:red;font-size: 12px;">* Fields cannot be empty.</b>');	
				}
		}
		}); 
	}); 
});

/* for save social connection */
$(document).ready(function(e) {
	$(document).on("click", ".click_social_con", function (e) {
		$("#social_message").html('Loading ...');
		e.preventDefault();		
		var formData= $(this).closest('form').serialize();
		console.log(formData);
		$.ajax({
		type: "POST",
		url: "manipulates/manipulate.php",
		data:formData ,
		success: function (response) {
		$(".click_change_password").css({"pointer-events":"","cursor":"","opacity":""});
		//document.getElementById("change_message").innerHTML=response;
		if(response=='true'){
		$("#social_message").html('<b style="color:green;font-size: 12px;">Profile Settings Updated</b>');
		}else if(response=='false'){
			$("#social_message").html('<b style="color:red;font-size: 12px;">Failed to update, try again</b>');	
			}
		}
		});
	}); 
});
