/* for delete group chat*/
$(document).ready(function(){
	$(document).on("click", ".delete_group_chat", function (e) {
		var isConfirm = window.confirm('Are You Sure Want To Delete This Chat ?');
		if(isConfirm != true){
			return false;	
		}
		var gid = this.rel;
		$("#loading"+gid).html('<img src="images/spinner.gif" style="width: 18px;">');
		var data_string = 'gid='+ gid ;
		console.log(data_string);
		$.ajax({
			type: "POST",
			url: "manipulates/delete.php?xAction=del_group_chat",
			data:data_string ,
			success: function (response) {
			console.log(response);
			$("#loading"+gid).html('<i class="icon-remove"></i> Deleted, Refreshing...');
			document.getElementById("success").innerHTML=response; 
		}
		});
	 }); 
});

/* for delete group message*/
$(document).ready(function(){
	$(document).on("click", ".click_del_grp_msg", function (e) {	
		var isConfirm = window.confirm('Are You Sure Want To Delete This Message ?');
		if(isConfirm != true){
			return false;	
		}
		var gdstatusID = this.rel;
		var data_string = 'gdstatusID='+ gdstatusID ;
		console.log(data_string);
		$.ajax({
			type: "POST",
			url: "manipulates/delete.php?xAction=del_group_msg",
			data:data_string ,
			success: function (response) {
			console.log(response);
			document.getElementById("success").innerHTML=response; 
		}
		}); 
	}); 
});

/* for group discussion */
$(document).ready(function(){

	$(document).on("click", ".click_discussion", function (e) {
		e.preventDefault();
		var textLength = $("#textBox").val().length;
		if(textLength > 10000){
			alert("Message length cannot be more then 10000 Characters");
			return;
		}else{
			$('.click_discussion').val('Sending..');
			
			var formData= $(this).closest('form').serialize();
			console.log(formData);
			$.ajax({
			type: "POST",
			url: "manipulates/manipulate.php",
			data:formData ,
			success: function (response) {
			document.getElementById("group_msg").innerHTML=response;
			$('.click_discussion').val('Send');
			$('.scroll_msgs').scrollTop($('.scroll_msgs')[0].scrollHeight);
			$("#textBox").val('');
			}
			});
	     } 
	}); 
	
});
