


/* for answer up vote */
$(document).ready(function(){
$(document).on("click", ".click_accept_answer", function(e) {
	var isConfirm = window.confirm('Once you accept this as answer you cannot make any changes later.');
if(isConfirm != true){
	return false;	
}
	var fqID = this.rel;
	var answerID = $(this).attr("data-answerID");
	var data_string = 'fqID='+ fqID+ '&answerID='+ answerID ;
	
	$.ajax({
		type: "POST",
		url: "manipulates/manipulate.php?xAction=accept_answer",
		data:data_string ,
		success: function (response) {
		//console.log(response);
			if(response=="true"){
				$("#show_accepted"+answerID).css({"color":"#08ba08"});
			}else if(response=="yourself"){	
				$('#success').html('<div class="floating_message_red"><h5> Cannot Vote to your own question</h5></div>');
			}else{
				$('#success').html('<div class="floating_message_red"><h5> Already Accepted</h5></div>');
				$("#show_accepted"+answerID).css({"color":"#8c8c8c"});
			 }
		}
	 }); 
 });
});




