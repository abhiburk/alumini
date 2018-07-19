/* for message */
$(document).ready(function(){

	$(document).on("click", ".click_send_msg", function (e) {
		e.preventDefault();
		var textLength = $("#textBox").val().length;
		if(textLength > 10000){
			alert("Message length cannot be more then 10000 Characters");
			return;
		}else{
			$('.click_send_msg').val('Sending..');
			
			var formData= $(this).closest('form').serialize();
			console.log(formData);
			$.ajax({
			type: "POST",
			url: "manipulates/manipulate.php",
			data:formData ,
			success: function (response) {
			document.getElementById("msg_chat").innerHTML=response;
			$('.click_send_msg').val('Send');
			$('.scroll_msgs').scrollTop($('.scroll_msgs')[0].scrollHeight);
			$("#textBox").val('');
			}
			});
	     } 
	}); 
	
});

/* for delete whole chat*/
$(document).ready(function(){
	$(document).on("click", ".delete_chat", function (e) {
		var isConfirm = window.confirm('Are You Sure Want To Delete This Chat ?');
		if(isConfirm != true){
			return false;	
		}
		var uID = this.rel;
		$("#loading"+uID).html('<img src="images/spinner.gif" style="width: 20px;">');
		var data_string = 'uID='+ uID ;
		console.log(data_string);
		$.ajax({
		type: "POST",
		url: "manipulates/delete.php?xAction=delete_chat",
		data:data_string ,
		success: function (response) {
			$("#loading"+uID).html('<i class="icon-remove"></i> Deleted, Refreshing chats ...');			
			console.log(response);
			document.getElementById("success").innerHTML=response; 
		}
		}); 
	});  
});

//(function poll() {
//		//initially load all msg counts
//		$.ajax({ url: "manipulates/msg_count.php", success: function(data) {
//           document.getElementById("msg_count").innerHTML=data; 
//        }, dataType: "json", complete: poll });
//	   
//   setTimeout(function() {
//       $.ajax({ url: "manipulates/msg_count.php", success: function(data) {
//           document.getElementById("msg_count").innerHTML=data; 
//       }, dataType: "json", complete: poll });
//    }, 30000);
//	
//})();

/* for delete message*/
$(document).ready(function(){
	$(document).on("click", ".click_del_msg", function (e) {
		var isConfirm = window.confirm('Are You Sure Want To Delete This Message ?');
		if(isConfirm != true){
			return false;	
		}
		var msgID = this.rel;
		var data_string = 'msgID='+ msgID ;
		console.log(data_string);
		$.ajax({
		type: "POST",
		url: "manipulates/delete.php?xAction=del_msg",
		data:data_string ,
		success: function (response) {
		console.log(response);
		document.getElementById("success").innerHTML=response; 
		}
		}); 
	}); 
});